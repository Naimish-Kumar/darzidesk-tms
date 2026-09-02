<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Socialite\Facades\Socialite;
use Spatie\Permission\Models\Role;

class GoogleAuthController extends Controller
{
    /**
     * Dynamically initialize Google OAuth configuration from SuperAdmin database settings or env.
     *
     * @return bool
     */
    protected function initGoogleConfig(): bool
    {
        $clientId = function_exists('getSettingsValByName') ? getSettingsValByName('google_client_id') : null;
        if (empty($clientId)) {
            $clientId = config('services.google.client_id');
        }

        $clientSecret = function_exists('getSettingsValByName') ? getSettingsValByName('google_client_secret') : null;
        if (empty($clientSecret)) {
            $clientSecret = config('services.google.client_secret');
        }

        $redirectUri = function_exists('getSettingsValByName') ? getSettingsValByName('google_redirect_uri') : null;
        if (empty($redirectUri)) {
            $redirectUri = config('services.google.redirect') ?: url('/auth/google/callback');
        }

        if (empty($clientId) || empty($clientSecret)) {
            return false;
        }

        config([
            'services.google.client_id' => $clientId,
            'services.google.client_secret' => $clientSecret,
            'services.google.redirect' => $redirectUri,
        ]);

        return true;
    }

    /**
     * Redirect the user to the Google authentication page.
     *
     * @return \Illuminate\Http\RedirectResponse|\Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function redirectToGoogle()
    {
        $isConfigured = $this->initGoogleConfig();

        if (!$isConfigured) {
            return redirect()->route('login')->with(
                'error',
                __('Google Sign-In is not configured yet. Please set Google Client ID and Google Client Secret in Super Admin Settings > Google Sign-In (OAuth).')
            );
        }

        try {
            return Socialite::driver('google')->redirect();
        } catch (\Throwable $e) {
            Log::error('Google OAuth Redirect Error: ' . $e->getMessage());
            return redirect()->route('login')->with(
                'error',
                __('Unable to initialize Google Sign-In: :message', ['message' => $e->getMessage()])
            );
        }
    }

    /**
     * Obtain the user information from Google and log them in.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handleGoogleCallback(Request $request)
    {
        // Check for error query param (e.g. user cancelled consent)
        if ($request->has('error')) {
            $error = $request->get('error_description', $request->get('error'));
            Log::warning('Google OAuth callback error: ' . $error);
            return redirect()->route('login')->with(
                'error',
                __('Google sign-in was cancelled or encountered an error. Please try again.')
            );
        }

        $this->initGoogleConfig();

        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Throwable $e) {
            Log::error('Google OAuth Callback Exception: ' . $e->getMessage());
            return redirect()->route('login')->with(
                'error',
                __('Authentication with Google failed. Please log in using your email and password or try again.')
            );
        }

        $googleId = $googleUser->getId();
        $email = $googleUser->getEmail();
        $name = $googleUser->getName() ?? $googleUser->getNickname() ?? 'Atelier Artisan';
        $avatar = $googleUser->getAvatar();

        if (empty($email)) {
            return redirect()->route('login')->with(
                'error',
                __('Google did not provide an email address for your account. Please use standard email registration.')
            );
        }

        // Find user by Google ID or by Email
        $user = User::where('google_id', $googleId)->first();

        if (!$user) {
            $user = User::where('email', $email)->first();
        }

        if ($user) {
            // Update existing user with Google ID and verified email
            $dirty = false;
            if (empty($user->google_id)) {
                $user->google_id = $googleId;
                $dirty = true;
            }
            if (empty($user->avatar) && !empty($avatar)) {
                $user->avatar = $avatar;
                $dirty = true;
            }
            if (empty($user->email_verified_at)) {
                $user->email_verified_at = now();
                $dirty = true;
            }
            if ($dirty) {
                $user->save();
            }
        } else {
            // Create a brand new atelier owner user
            $user = User::create([
                'name' => $name,
                'email' => $email,
                'google_id' => $googleId,
                'avatar' => $avatar,
                'password' => Hash::make(Str::random(32)),
                'type' => 'owner',
                'lang' => 'english',
                'subscription' => 1,
                'parent_id' => 1,
                'is_active' => 1,
                'email_verified_at' => now(),
            ]);

            $ownerRole = Role::where('name', 'owner')->first();
            if ($ownerRole) {
                $user->assignRole($ownerRole);
            }
        }

        // Verify account is active
        if (isset($user->is_active) && $user->is_active == 0) {
            return redirect()->route('login')->with(
                'error',
                __('Your account is temporarily inactive. Please contact your administrator to reactivate your account.')
            );
        }

        // Log the user into the application
        Auth::login($user, true);
        $request->session()->regenerate();

        if (function_exists('userLoggedHistory')) {
            userLoggedHistory();
        }

        // Handle owner onboarding redirect if needed
        if ($user->type === 'owner') {
            if (empty($user->shop_name)) {
                return redirect()->route('onboarding.business.details')->with(
                    'info',
                    __('Please complete your shop & business profile to activate your atelier dashboard.')
                );
            }

            if ($user->subscription_expire_date !== null && date('Y-m-d') > $user->subscription_expire_date) {
                if (function_exists('assignSubscription')) {
                    assignSubscription(1);
                }
                return redirect()->intended(RouteServiceProvider::HOME)->with(
                    'error',
                    __('Your subscription has ended, and access to premium features is now restricted. Please renew your plan.')
                );
            }
        }

        return redirect()->intended(RouteServiceProvider::HOME)->with(
            'success',
            __('Welcome back, :name! Signed in via Google successfully.', ['name' => $user->name])
        );
    }
}
