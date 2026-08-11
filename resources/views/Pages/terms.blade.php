@php
    $settings = settings();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Terms & Services') }} - {{ !empty($settings['app_name']) ? $settings['app_name'] : env('APP_NAME') }}</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="{{ !empty($settings['app_name']) ? $settings['app_name'] : env('APP_NAME') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="DarziDesk Terms & Services - Terms of Use for our Tailoring Management System platform.">

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
        .policy-navbar .nav-links .btn-cta:hover {
            background: var(--brand-primary-dark);
        }

        .policy-hero {
            position: relative;
            padding: 150px 24px 85px;
            text-align: center;
            background: linear-gradient(135deg, #0B1C30 0%, #006A67 100%);
            color: #ffffff;
            overflow: hidden;
        }
        .policy-hero .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(138, 244, 239, 0.15);
            border: 1px solid rgba(138, 244, 239, 0.3);
            color: #8AF4EF;
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

        .policy-container {
            max-width: 1200px;
            margin: -40px auto 80px;
            padding: 0 24px;
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 40px;
            position: relative;
            z-index: 10;
        }

        .toc-sidebar {
            position: sticky;
            top: 100px;
            align-self: start;
            background: #ffffff;
            border-radius: 20px;
            padding: 24px;
            border: 1px solid rgba(188, 201, 200, 0.5);
            box-shadow: 0 10px 30px rgba(11, 28, 48, 0.03);
        }
        .toc-sidebar h4 {
            font-size: 13px;
            text-transform: uppercase;
            letter-spacing: 0.06em;
            color: var(--brand-navy);
            margin: 0 0 16px;
            font-weight: 700;
        }
        .toc-sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .toc-sidebar li {
            margin-bottom: 8px;
        }
        .toc-sidebar a {
            color: var(--text-main);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            display: block;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .toc-sidebar a:hover {
            background: var(--brand-primary-light);
            color: var(--brand-primary);
        }

        .policy-content-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 48px;
            border: 1px solid rgba(188, 201, 200, 0.5);
            box-shadow: 0 10px 30px rgba(11, 28, 48, 0.03);
        }

        .policy-section {
            margin-bottom: 40px;
            scroll-margin-top: 110px;
        }
        .policy-section:last-child {
            margin-bottom: 0;
        }
        .policy-section h2 {
            font-size: 22px;
            font-weight: 800;
            color: var(--brand-navy);
            margin: 0 0 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .policy-section h2 i {
            color: var(--brand-primary);
            background: var(--brand-primary-light);
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        .policy-section p {
            color: var(--text-main);
            font-size: 15.5px;
            margin-bottom: 14px;
        }
        .policy-section ul {
            padding-left: 20px;
            margin-bottom: 16px;
        }
        .policy-section li {
            margin-bottom: 8px;
            font-size: 15px;
            color: var(--text-main);
        }

        .highlight-box {
            background: var(--brand-primary-light);
            border-left: 4px solid var(--brand-primary);
            padding: 18px 22px;
            border-radius: 0 14px 14px 0;
            margin: 20px 0;
        }
        .highlight-box p {
            margin: 0;
            font-weight: 600;
            color: var(--brand-navy);
            font-size: 14.5px;
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
            color: #6CD7D3;
            text-decoration: none;
            font-weight: 500;
        }

        @media (max-width: 991px) {
            .policy-container {
                grid-template-columns: 1fr;
            }
            .toc-sidebar {
                display: none;
            }
            .policy-content-card {
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
                <li><a href="{{ route('terms.conditions') }}" style="color: var(--brand-primary); font-weight: 700;">{{ __('Terms & Services') }}</a></li>
                <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                <li><a class="btn-cta" href="{{ route('register') }}">{{ __('Get Started') }}</a></li>
            </ul>

        </div>
    </nav>

    <!-- [ Hero ] -->
    <section class="policy-hero">
        <div class="hero-badge">
            <i class="ti ti-file-text me-1"></i>
            {{ __('Service Agreement') }}
        </div>
        <h1>{{ __('Terms & Services') }}</h1>
        <p>{{ __('Please read these terms carefully before using the DarziDesk Tailoring Management System web and mobile applications.') }}</p>
    </section>

    <!-- [ Content Container ] -->
    <div class="policy-container">
        <!-- Sidebar Navigation -->
        <aside class="toc-sidebar">
            <h4>{{ __('Sections') }}</h4>
            <ul>
                <li><a href="#term-1"><i class="ti ti-checkup-list me-1"></i> {{ __('1. Agreement Acceptance') }}</a></li>
                <li><a href="#term-2"><i class="ti ti-apps me-1"></i> {{ __('2. Platform Services') }}</a></li>
                <li><a href="#term-3"><i class="ti ti-user-check me-1"></i> {{ __('3. Account Responsibilities') }}</a></li>
                <li><a href="#term-4"><i class="ti ti-credit-card me-1"></i> {{ __('4. Subscriptions & Billing') }}</a></li>
                <li><a href="#term-5"><i class="ti ti-shield-check me-1"></i> {{ __('5. IP & Data Rights') }}</a></li>
                <li><a href="#term-6"><i class="ti ti-activity me-1"></i> {{ __('6. Service Availability') }}</a></li>
                <li><a href="#term-7"><i class="ti ti-gavel me-1"></i> {{ __('7. Liability & Governing Law') }}</a></li>
            </ul>
        </aside>

        <!-- Main Document Body -->
        <main class="policy-content-card">
            <div class="policy-section" id="term-1">
                <h2><i class="ti ti-checkup-list"></i> {{ __('1. Agreement to Terms') }}</h2>
                <p>{{ __('By creating an account, accessing, or utilizing the DarziDesk platform (web software, customer tracking portal, or mobile app), you agree to be bound by these Terms & Services and our Privacy Policy. If you do not agree, you must cease using our services immediately.') }}</p>
            </div>

            <div class="policy-section" id="term-2">
                <h2><i class="ti ti-apps"></i> {{ __('2. Platform Service Scope') }}</h2>
                <p>{{ __('DarziDesk provides cloud-based Tailoring Management System (TMS) software designed for boutiques, custom tailors, and garment artisans. Our services include:') }}</p>
                <ul>
                    <li>{{ __('Digital body measurement recording and historical sizing logs.') }}</li>
                    <li>{{ __('Order tracking, production Kanban boards, and worker stage assignments.') }}</li>
                    <li>{{ __('GST invoice generation, receipt printing, and customer SMS/WhatsApp notifications.') }}</li>
                    <li>{{ __('Inventory management, cloth material restock alerts, and financial analytics.') }}</li>
                </ul>
            </div>

            <div class="policy-section" id="term-3">
                <h2><i class="ti ti-user-check"></i> {{ __('3. User Accounts & Security') }}</h2>
                <p>{{ __('Account creation requires accurate business and contact details. Account credentials must remain confidential. You are responsible for all activities occurring under your account or staff logins.') }}</p>
                <div class="highlight-box">
                    <p><i class="ti ti-shield-alert me-2"></i> {{ __('Un-authorized access or sharing of account credentials outside your registered boutique staff is strictly prohibited.') }}</p>
                </div>
            </div>

            <div class="policy-section" id="term-4">
                <h2><i class="ti ti-credit-card"></i> {{ __('4. Subscriptions, Payments & Billing') }}</h2>
                <p>{{ __('Subscription plans (Monthly, Quarterly, Annual) are billed in advance according to selected packages. All fees are in Indian Rupees (INR) or localized currency.') }}</p>
                <ul>
                    <li><strong>{{ __('Auto-Renewal') }}</strong>: Subscriptions renew automatically unless cancelled prior to the renewal date.</li>
                    <li><strong>{{ __('Refund Policy') }}</strong>: Payments are non-refundable except where mandated by applicable consumer protection laws.</li>
                    <li><strong>{{ __('Plan Upgrades') }}</strong>: Upgrades take effect immediately with pro-rated billing calculation.</li>
                </ul>
            </div>

            <div class="policy-section" id="term-5">
                <h2><i class="ti ti-shield-check"></i> {{ __('5. Intellectual Property & Data Ownership') }}</h2>
                <p>{{ __('All software code, branding, logos, and UI designs belong exclusively to DarziDesk. However, YOU maintain 100% ownership of your customer measurement data, order records, and business financials.') }}</p>
            </div>

            <div class="policy-section" id="term-6">
                <h2><i class="ti ti-activity"></i> {{ __('6. Service Availability & Maintenance') }}</h2>
                <p>{{ __('We target 99.9% operational uptime. Scheduled system maintenance will be conducted during off-peak hours with prior notification when possible.') }}</p>
            </div>

            <div class="policy-section" id="term-7">
                <h2><i class="ti ti-gavel"></i> {{ __('7. Limitation of Liability & Governing Law') }}</h2>
                <p>{{ __('DarziDesk shall not be liable for indirect, incidental, or consequential damages resulting from business interruptions or lost profits. These terms are governed by the laws of India, with exclusive jurisdiction in the courts of New Delhi, India.') }}</p>
            </div>
        </main>
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
