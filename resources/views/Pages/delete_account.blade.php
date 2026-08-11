@php
    $settings = settings();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Delete Account & Data Rights') }} - {{ !empty($settings['app_name']) ? $settings['app_name'] : env('APP_NAME') }}</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="{{ !empty($settings['app_name']) ? $settings['app_name'] : env('APP_NAME') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="DarziDesk Account Deletion Portal - Google Play Console Compliant Account & Data Deletion Request Page.">

    <link rel="icon" href="{{ asset(Storage::url('upload/logo')) . '/' . ($settings['company_favicon'] ?? '') }}" type="image/x-icon" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500&display=swap" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

    <style>
        :root {
            --brand-primary: #006A67;
            --brand-primary-dark: #004D4B;
            --brand-primary-light: #E6F4F3;
            --brand-navy: #0B1C30;
            --brand-danger: #dc2626;
            --text-main: #0B1C30;
            --text-muted: #6D7978;
            --bg-canvas: #F8F9FF;
            --card-bg: #FFFFFF;
            --border-color: #BCC9C8;
        }

        body.policy-page {
            font-family: 'Hanken Grotesk', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--bg-canvas);
            color: var(--text-main);
            margin: 0;
            line-height: 1.6;
        }

        .policy-navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(255,255,255,0.94);
            backdrop-filter: blur(14px);
            border-bottom: 1px solid rgba(188, 201, 200, 0.4);
        }
        .policy-navbar .navbar-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .policy-navbar .brand-logo img {
            height: 36px;
            width: auto;
        }
        .policy-navbar .nav-links {
            display: flex;
            align-items: center;
            gap: 12px;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .policy-navbar .nav-links a {
            color: var(--text-main);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .policy-navbar .nav-links a:hover {
            background: var(--brand-primary-light);
            color: var(--brand-primary);
        }
        .policy-navbar .nav-links .btn-cta {
            background: var(--brand-primary);
            color: #ffffff !important;
            font-weight: 600;
            border-radius: 50px;
            padding: 9px 24px;
            transition: all 0.2s ease;
        }

        .policy-hero {
            position: relative;
            padding: 150px 24px 85px;
            text-align: center;
            background: linear-gradient(135deg, #0B1C30 0%, #7f1d1d 100%);
            color: #ffffff;
            overflow: hidden;
        }
        .policy-hero .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(239, 68, 68, 0.2);
            border: 1px solid rgba(239, 68, 68, 0.4);
            color: #fca5a5;
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 13px;
            font-weight: 600;
            letter-spacing: 0.05em;
            text-transform: uppercase;
            margin-bottom: 20px;
        }
        .policy-hero h1 {
            font-size: clamp(34px, 4.5vw, 54px);
            font-weight: 800;
            margin: 0 0 16px;
            color: #ffffff;
            letter-spacing: -0.02em;
        }
        .policy-hero p {
            color: rgba(255, 255, 255, 0.85);
            font-size: 18px;
            max-width: 680px;
            margin: 0 auto;
        }

        .delete-container {
            max-width: 1000px;
            margin: -40px auto 80px;
            padding: 0 24px;
            position: relative;
            z-index: 10;
        }

        .delete-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 48px;
            border: 1px solid rgba(188, 201, 200, 0.5);
            box-shadow: 0 10px 30px rgba(11, 28, 48, 0.03);
            margin-bottom: 32px;
        }

        .play-compliance-banner {
            background: var(--brand-primary-light);
            border: 1px solid rgba(0, 106, 103, 0.25);
            border-radius: 16px;
            padding: 20px 26px;
            display: flex;
            align-items: flex-start;
            gap: 16px;
            margin-bottom: 32px;
        }
        .play-compliance-banner i {
            font-size: 26px;
            color: var(--brand-primary);
            margin-top: 2px;
        }
        .play-compliance-banner p {
            margin: 0;
            font-size: 14.5px;
            color: var(--brand-navy);
        }

        .form-group {
            margin-bottom: 22px;
        }
        .form-group label {
            display: block;
            font-weight: 700;
            font-size: 14px;
            color: var(--brand-navy);
            margin-bottom: 8px;
        }
        .form-control {
            width: 100%;
            padding: 13px 18px;
            font-size: 15px;
            border-radius: 10px;
            border: 1px solid var(--border-color);
            background: #ffffff;
            box-sizing: border-box;
            font-family: inherit;
            transition: all 0.2s ease;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--brand-danger);
            box-shadow: 0 0 0 4px rgba(220, 38, 38, 0.12);
        }

        .form-check {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            margin: 24px 0;
        }
        .form-check input[type="checkbox"] {
            width: 18px;
            height: 18px;
            margin-top: 3px;
            accent-color: var(--brand-danger);
        }
        .form-check label {
            font-size: 14px;
            color: var(--text-main);
            line-height: 1.5;
            cursor: pointer;
        }

        .btn-delete-submit {
            background: var(--brand-danger);
            color: #ffffff;
            font-weight: 800;
            font-size: 16px;
            padding: 15px 32px;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            width: 100%;
            transition: all 0.2s ease;
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.25);
        }
        .btn-delete-submit:hover {
            background: #b91c1c;
            transform: translateY(-1px);
            box-shadow: 0 8px 25px rgba(220, 38, 38, 0.35);
        }

        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        .data-table th, .data-table td {
            padding: 14px 16px;
            text-align: left;
            border-bottom: 1px solid var(--border-color);
            font-size: 14.5px;
        }
        .data-table th {
            background: var(--brand-primary-light);
            font-weight: 700;
            color: var(--brand-navy);
        }

        .alert {
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 15px;
            font-weight: 500;
        }
        .alert-success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }
        .alert-danger {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }

        .policy-footer {
            background: var(--brand-navy);
            color: #94a3b8;
            padding: 45px 24px;
            text-align: center;
            font-size: 14px;
            border-top: 1px solid rgba(255,255,255,0.1);
        }
        .policy-footer a {
            color: #fca5a5;
            text-decoration: none;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .delete-card {
                padding: 28px;
            }
        }
    </style>
</head>

<body class="policy-page">

    <!-- [ Navbar ] -->
    <nav class="policy-navbar">
        <div class="navbar-inner">
            <a class="brand-logo" href="{{ route('home') }}">
                <img src="{{ asset('assets/images/logo_wide.png') }}" alt="DarziDesk Logo" />
            </a>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li><a href="{{ route('about.us') }}">{{ __('About Us') }}</a></li>
                <li><a href="{{ route('privacy.policy') }}">{{ __('Privacy Policy') }}</a></li>
                <li><a href="{{ route('terms.conditions') }}">{{ __('Terms & Services') }}</a></li>
                <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                <li><a class="btn-cta" href="{{ route('register') }}">{{ __('Get Started') }}</a></li>
            </ul>

        </div>
    </nav>

    <!-- [ Hero ] -->
    <section class="policy-hero">
        <div class="hero-badge">
            <i class="ti ti-trash me-1"></i>
            {{ __('Account & Data Deletion Portal') }}
        </div>
        <h1>{{ __('Request Account Deletion') }}</h1>
        <p>{{ __('In compliance with Google Play Console Developer Policies and global data privacy standards, DarziDesk users can submit an account and personal data deletion request below.') }}</p>
    </section>

    <!-- [ Content Container ] -->
    <div class="delete-container">

        <!-- Google Play Console Compliance Notice -->
        <div class="play-compliance-banner">
            <i class="ti ti-brand-google-play me-1"></i>
            <div>
                <strong style="font-size: 15.5px; display: block; margin-bottom: 2px;">{{ __('Google Play Console Policy Compliance Notice') }}</strong>
                <p>{{ __('This public webpage allows registered DarziDesk mobile app users (Boutique Owners, Staff, Tailors, and Customers) to submit a formal account deletion request without needing to open or reinstall the Android mobile app.') }}</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success">
                <i class="ti ti-circle-check me-2"></i> {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">
                <i class="ti ti-alert-triangle me-2"></i> {{ session('error') }}
            </div>
        @endif

        <!-- Deletion Request Form Card -->
        <div class="delete-card">
            <h2 style="font-size: 26px; font-weight: 800; color: var(--brand-navy); margin-top: 0; margin-bottom: 8px;">
                <i class="ti ti-user-x me-2" style="color: var(--brand-danger);"></i> {{ __('Account Deletion Form') }}
            </h2>
            <p style="color: var(--text-muted); font-size: 15px; margin-bottom: 24px;">
                {{ __('Please enter your registered DarziDesk account email address. Our privacy verification team will confirm your request and process data deletion.') }}
            </p>

            <form action="{{ route('delete.account.request') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="email">{{ __('Registered Email Address') }} <span style="color: var(--brand-danger);">*</span></label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="e.g. tailor@studio.com" value="{{ old('email') }}" required />
                </div>

                <div class="form-group">
                    <label for="phone">{{ __('Registered Mobile Phone Number (Optional)') }}</label>
                    <input type="text" name="phone" id="phone" class="form-control" placeholder="e.g. +91 9876543210" value="{{ old('phone') }}" />
                </div>

                <div class="form-group">
                    <label for="account_type">{{ __('Account Type') }} <span style="color: var(--brand-danger);">*</span></label>
                    <select name="account_type" id="account_type" class="form-control" required>
                        <option value="">{{ __('-- Select Account Type --') }}</option>
                        <option value="Boutique Owner" {{ old('account_type') == 'Boutique Owner' ? 'selected' : '' }}>{{ __('Boutique / Shop Owner') }}</option>
                        <option value="Tailor / Master" {{ old('account_type') == 'Tailor / Master' ? 'selected' : '' }}>{{ __('Tailor / Master Artisan') }}</option>
                        <option value="Customer" {{ old('account_type') == 'Customer' ? 'selected' : '' }}>{{ __('Retail Customer') }}</option>
                        <option value="Staff Worker" {{ old('account_type') == 'Staff Worker' ? 'selected' : '' }}>{{ __('Staff / Assistant') }}</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="reason">{{ __('Reason for Account Deletion (Optional)') }}</label>
                    <textarea name="reason" id="reason" rows="3" class="form-control" placeholder="{{ __('Let us know how we can improve or why you wish to close your account...') }}">{{ old('reason') }}</textarea>
                </div>

                <div class="form-check">
                    <input type="checkbox" name="confirm_deletion" id="confirm_deletion" value="1" required />
                    <label for="confirm_deletion">
                        <strong>{{ __('I confirm that I want my DarziDesk account and associated personal data deleted.') }}</strong><br>
                        <span style="font-size: 13px; color: var(--text-muted);">{{ __('I understand that after processing, I will lose access to my saved measurement records, order histories, and staff logs.') }}</span>
                    </label>
                </div>

                <button type="submit" class="btn-delete-submit">
                    <i class="ti ti-trash me-2"></i> {{ __('Submit Account Deletion Request') }}
                </button>
            </form>
        </div>

        <!-- Data Retention & Purge Details Table -->
        <div class="delete-card">
            <h3 style="font-size: 22px; font-weight: 800; color: var(--brand-navy); margin-top: 0;">
                <i class="ti ti-database-off me-2" style="color: var(--brand-primary);"></i> {{ __('Data Deletion & Statutory Retention Schedule') }}
            </h3>
            <p style="color: var(--text-muted); font-size: 14.5px;">
                {{ __('Google Play policies require clear details regarding what data is deleted versus retained upon account closure:') }}
            </p>

            <table class="data-table">
                <thead>
                    <tr>
                        <th>{{ __('Data Category') }}</th>
                        <th>{{ __('Action Taken') }}</th>
                        <th>{{ __('Timeline') }}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><strong>{{ __('Account Profile & Login') }}</strong><br><small>{{ __('Email, Password Hash, Phone, Name') }}</small></td>
                        <td><span style="color: var(--brand-danger); font-weight: 700;">{{ __('Permanently Deleted') }}</span></td>
                        <td>{{ __('Within 30 Days') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('Body Measurements & Photos') }}</strong><br><small>{{ __('Customer fit profiles, chest/waist logs') }}</small></td>
                        <td><span style="color: var(--brand-danger); font-weight: 700;">{{ __('Permanently Deleted') }}</span></td>
                        <td>{{ __('Within 30 Days') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('Order Notes & Kanbans') }}</strong><br><small>{{ __('Cutting notes, worker assignment logs') }}</small></td>
                        <td><span style="color: var(--brand-danger); font-weight: 700;">{{ __('Permanently Purged') }}</span></td>
                        <td>{{ __('Within 30 Days') }}</td>
                    </tr>
                    <tr>
                        <td><strong>{{ __('Tax & GST Invoices') }}</strong><br><small>{{ __('Issued payment receipts & accounting records') }}</small></td>
                        <td><span style="color: #d97706; font-weight: 700;">{{ __('Retained per Tax Law') }}</span></td>
                        <td>{{ __('Statutory Period (7 Years)') }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Alternative In-App Deletion Steps Card -->
        <div class="delete-card" style="background: var(--brand-primary-light); border-color: rgba(0, 106, 103, 0.2);">
            <h3 style="font-size: 19px; font-weight: 800; color: var(--brand-navy); margin-top: 0;">
                <i class="ti ti-device-mobile me-2" style="color: var(--brand-primary);"></i> {{ __('Option 2: Delete Account Directly via Mobile App') }}
            </h3>
            <ol style="padding-left: 20px; font-size: 15px; color: var(--text-main); margin-bottom: 0;">
                <li>{{ __('Open the DarziDesk Android or iOS app on your mobile device.') }}</li>
                <li>{{ __('Navigate to the ') }}<strong>{{ __('Profile / Settings') }}</strong> {{ __('tab at the bottom right.') }}</li>
                <li>{{ __('Scroll to the bottom under the ') }}<strong style="color: var(--brand-danger);">{{ __('Danger Zone') }}</strong> {{ __('section.') }}</li>
                <li>{{ __('Tap ') }}<strong>{{ __('Delete Account') }}</strong> {{ __('and confirm with your password or OTP.') }}</li>
            </ol>
        </div>

    </div>

    <!-- [ Footer ] -->
    <footer class="policy-footer">
        <p>&copy; {{ date('Y') }} {{ $settings['company_name'] ?? 'DarziDesk' }}. {{ __('All rights reserved.') }} &nbsp;|&nbsp; 
            <a href="{{ route('privacy.policy') }}">{{ __('Privacy Policy') }}</a> &nbsp;·&nbsp;
            <a href="{{ route('terms.conditions') }}">{{ __('Terms & Services') }}</a> &nbsp;·&nbsp;
            <a href="{{ route('about.us') }}">{{ __('About Us') }}</a>
        </p>
    </footer>

</body>
</html>
