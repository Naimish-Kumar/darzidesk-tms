<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Models\LoggedHistory;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticatedSessionController extends Controller
{
    public function create()
    {
        if (function_exists('setup') && !file_exists(setup())) {
            header('location:install');
            die;
        }

        $user = \App\Models\User::find(1);
        if ($user && !empty($user->lang)) {
            \App::setLocale($user->lang);
        }

        return view('auth.login');
    }

    public function store(LoginRequest $request)
    {
        $google_recaptcha = function_exists('getSettingsValByName') ? getSettingsValByName('google_recaptcha') : 'off';
        if ($google_recaptcha == 'on') {
            $validation['g-recaptcha-response'] = 'required|captcha';
        } else {
            $validation = [];
        }
        if (!empty($validation)) {
            $this->validate($request, $validation);
        }

        $request->authenticate();
        $request->session()->regenerate();
        $loginUser = Auth::user();

        if (isset($loginUser->is_active) && $loginUser->is_active == 0) {
            auth()->logout();
            return redirect()->route('login')->with('error', __('Your account is temporarily inactive. Please contact your administrator to reactivate your account.'));
        }

        if ($loginUser->type == 'owner') {
            if (empty($loginUser->email_verified_at)) {
                session(['pending_verify_user_id' => $loginUser->id, 'verify_email' => $loginUser->email]);
                return redirect()->route('verify.otp')->with('error', __('Verification required: Please enter your 6-digit OTP code to verify your account.'));
            }

            if (empty($loginUser->shop_name)) {
                return redirect()->route('onboarding.business.details')->with('info', __('Please complete your shop & business profile to activate your dashboard.'));
            }

            if ($loginUser->subscription_expire_date != null && date('Y-m-d') > $loginUser->subscription_expire_date) {
                if (function_exists('assignSubscription')) {
                    assignSubscription(1);
                }
                return redirect()->intended(RouteServiceProvider::HOME)->with('error', __('Your subscription has ended, and access to premium features is now restricted. To continue using our services without interruption, please renew your plan or upgrade to a higher-tier package.'));
            }
        }

        if (function_exists('userLoggedHistory')) {
            userLoggedHistory();
        }

        return redirect()->intended(RouteServiceProvider::HOME);
    }

    public function destroy(Request $request)
    {
        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
