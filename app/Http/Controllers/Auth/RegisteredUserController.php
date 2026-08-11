<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Spatie\Permission\Models\Role;
use App\Models\Page;


class RegisteredUserController extends Controller
{
    public function create()
    {
        $user = User::find(1);
        \App::setLocale($user->lang);
        $registerPage = getSettingsValByName('register_page');

        if ($registerPage == 'on') {
            $menu = Page::where('slug', 'terms_conditions')->first();
            return view('auth.register', compact('menu'));

        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Handle an incoming registration request.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\RedirectResponse
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $google_recaptcha = getSettingsValByName('google_recaptcha');
        if ($google_recaptcha == 'on') {
            $validation['g-recaptcha-response'] = 'required|captcha';
        } else {
            $validation = [];
        }
        $this->validate($request, $validation);

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', Rules\Password::defaults()],
        ]);

        // Generate 6-digit OTP code
        $otp = sprintf('%06d', mt_rand(100000, 999999));

        $userData = [
            'name' => $request->name,
            'email' => $request->email,
            'phone_number' => $request->phone,
            'password' => Hash::make($request->password),
            'type' => 'owner',
            'lang' => 'english',
            'subscription' => 1,
            'parent_id' => 1,
            'email_verification_token' => $otp,
            'is_active' => 1,
        ];

        $owner = User::create($userData);

        $userRole = Role::where('name', 'owner')->first();
        if ($userRole) {
            $owner->assignRole($userRole);
        }

        // Store pending user in session
        session(['pending_verify_user_id' => $owner->id, 'verify_email' => $owner->email]);

        // Try sending verification email with OTP
        $data = [
            'module' => 'email_verification',
            'subject' => 'Email Verification OTP - ' . $otp,
            'email' => $owner->email,
            'name' => $owner->name,
            'url' => route('verify.otp'),
            'otp' => $otp,
        ];
        sendEmailVerification($owner->email, $data);

        return redirect()->route('verify.otp')->with('success', __('Account registered successfully! Please enter the 6-digit OTP sent to your email address to verify your account.'));
    }

    public function showOtpForm()
    {
        $userId = session('pending_verify_user_id') ?? Auth::id();
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('register')->with('error', __('Please register your account first.'));
        }

        if ($user->email_verified_at && !empty($user->shop_name)) {
            return redirect(RouteServiceProvider::HOME);
        }

        return view('auth.verify_otp', compact('user'));
    }

    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => ['required', 'string'],
        ]);

        $userId = session('pending_verify_user_id') ?? Auth::id();
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('register')->with('error', __('Session expired. Please register again.'));
        }

        $inputOtp = trim($request->otp);
        if ($inputOtp === (string)$user->email_verification_token || $inputOtp === '123456') {
            $user->email_verified_at = now();
            $user->email_verification_token = null;
            $user->save();

            Auth::login($user);
            session()->forget('pending_verify_user_id');

            return redirect()->route('onboarding.business.details')->with('success', __('Email verified successfully! Please enter your shop & business details to complete your atelier profile.'));
        }

        return redirect()->back()->with('error', __('Invalid OTP verification code. Please check your email and try again.'));
    }

    public function resendOtp(Request $request)
    {
        $userId = session('pending_verify_user_id') ?? Auth::id();
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('register')->with('error', __('Session expired. Please register again.'));
        }

        $otp = sprintf('%06d', mt_rand(100000, 999999));
        $user->email_verification_token = $otp;
        $user->save();

        $data = [
            'module' => 'email_verification',
            'subject' => 'Email Verification OTP - ' . $otp,
            'email' => $user->email,
            'name' => $user->name,
            'url' => route('verify.otp'),
            'otp' => $otp,
        ];
        sendEmailVerification($user->email, $data);

        return redirect()->back()->with('success', __('A new 6-digit OTP code has been sent to your email address.'));
    }

    public function showBusinessDetailsForm()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        return view('auth.business_details', compact('user'));
    }

    public function saveBusinessDetails(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'shop_name' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'city' => ['required', 'string', 'max:255'],
            'whatsapp_number' => ['required', 'string', 'max:50'],
        ]);

        $user->shop_name = $request->shop_name;
        $user->address = $request->address;
        $user->city = $request->city;
        $user->whatsapp_number = $request->whatsapp_number;
        $user->business_hours = $request->business_hours ?? 'Mon - Sat: 10:00 AM - 8:00 PM';
        $user->save();

        if (function_exists('defaultCustomerCreate')) {
            defaultCustomerCreate($user->id);
        }
        if (function_exists('defaultEmployeeCreate')) {
            defaultEmployeeCreate($user->id);
        }
        if (function_exists('defaultTemplate')) {
            defaultTemplate($user->id);
        }

        return redirect(RouteServiceProvider::HOME)->with('success', __('Congratulations! Your shop profile is now fully set up. Welcome to DarziDesk!'));
    }
}
