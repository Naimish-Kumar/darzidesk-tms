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
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700;800&display=swap" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}" />
    <link href="{{ asset('css/custom.css') }}?v={{ file_exists(public_path('css/custom.css')) ? filemtime(public_path('css/custom.css')) : time() }}" rel="stylesheet">

    <style>
        :root {
            --app-bg: #03111F;
            --card-bg: #0B2239;
            --card-border: #29435D;
            --inner-bg: #102B45;
            --primary-gold: #D9A441;
            --primary-light-gold: #F4C861;
            --gold-light-bg: rgba(217, 164, 65, 0.15);
            --gold-border: rgba(217, 164, 65, 0.35);
            --text-white: #FFFFFF;
            --text-body: #D8E0E8;
            --text-muted: #8FA1B5;
            --font-main: 'Hanken Grotesk', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, sans-serif;
            --font-code: 'JetBrains Mono', monospace;
        }

        body.policy-page {
            font-family: var(--font-main);
            background: var(--app-bg);
            color: var(--text-body);
            margin: 0;
            line-height: 1.6;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Top Header Navbar ── */
        .policy-navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(3, 17, 31, 0.92);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--card-border);
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.5);
        }
        .policy-navbar .navbar-inner {
            max-width: 1280px;
            margin: 0 auto;
            padding: 14px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        .policy-navbar .brand-logo img {
            height: 40px;
            width: auto;
            max-width: 220px;
            object-fit: contain;
        }
        .policy-navbar .nav-links {
            display: flex;
            align-items: center;
            gap: 8px;
            list-style: none;
            margin: 0;
            padding: 0;
        }
        .policy-navbar .nav-links a {
            color: var(--text-body);
            text-decoration: none;
            font-size: 14px;
            font-weight: 600;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .policy-navbar .nav-links a:hover {
            color: var(--primary-light-gold);
            background: rgba(217, 164, 65, 0.08);
        }
        .policy-navbar .nav-links .btn-login-outline {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 40px;
            padding: 0 20px;
            background: rgba(11, 34, 57, 0.6);
            color: var(--primary-light-gold) !important;
            font-weight: 700;
            font-size: 13.5px;
            border-radius: 9999px;
            border: 1.5px solid var(--primary-gold);
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .policy-navbar .nav-links .btn-login-outline:hover {
            background: var(--gold-light-bg);
            color: var(--text-white) !important;
            border-color: var(--primary-light-gold);
            box-shadow: 0 4px 14px rgba(217, 164, 65, 0.25);
            transform: translateY(-1px);
        }
        .policy-navbar .nav-links .btn-cta {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            height: 40px;
            padding: 0 22px;
            background: linear-gradient(135deg, #D9A441 0%, #F4C861 100%);
            color: #03111F !important;
            font-weight: 700;
            font-size: 13.5px;
            border-radius: 9999px;
            border: none;
            box-shadow: 0 4px 14px rgba(217, 164, 65, 0.3);
            transition: all 0.3s ease;
            text-decoration: none;
        }
        .policy-navbar .nav-links .btn-cta:hover {
            background: linear-gradient(135deg, #F4C861 0%, #FFE596 100%);
            box-shadow: 0 6px 20px rgba(217, 164, 65, 0.45);
            transform: translateY(-1px);
        }

        /* ── Hero Section ── */
        .policy-hero {
            position: relative;
            padding: 145px 24px 85px;
            text-align: center;
            background: linear-gradient(180deg, rgba(3, 17, 31, 0.95) 0%, rgba(11, 34, 57, 0.98) 100%);
            color: #ffffff;
            overflow: hidden;
            border-bottom: 1px solid var(--card-border);
        }
        .policy-hero .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--gold-light-bg);
            border: 1px solid var(--gold-border);
            color: var(--primary-light-gold);
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 12.5px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            margin-bottom: 16px;
        }
        .policy-hero h1 {
            font-size: clamp(34px, 4.5vw, 54px);
            font-weight: 800;
            margin: 0 0 16px;
            color: var(--text-white);
            letter-spacing: -0.02em;
            text-shadow: 0 2px 14px rgba(0, 0, 0, 0.5);
        }
        .policy-hero p {
            color: var(--text-body);
            font-size: 18px;
            max-width: 680px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* ── Layout & Sidebar ── */
        .policy-container {
            max-width: 1200px;
            margin: -45px auto 80px;
            padding: 0 24px;
            display: grid;
            grid-template-columns: 280px 1fr;
            gap: 32px;
            position: relative;
            z-index: 10;
        }

        .toc-sidebar {
            position: sticky;
            top: 100px;
            align-self: start;
            background: var(--card-bg);
            border-radius: 20px;
            padding: 24px;
            border: 1px solid var(--card-border);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        }
        .toc-sidebar h4 {
            font-size: 12.5px;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--primary-light-gold);
            margin: 0 0 16px;
            font-weight: 800;
        }
        .toc-sidebar ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        .toc-sidebar li {
            margin-bottom: 6px;
        }
        .toc-sidebar a {
            color: var(--text-body);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            display: block;
            padding: 8px 12px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .toc-sidebar a:hover {
            background: rgba(217, 164, 65, 0.1);
            color: var(--primary-light-gold);
        }

        /* ── Content Card ── */
        .policy-content-card {
            background: var(--card-bg);
            border-radius: 24px;
            padding: 48px;
            border: 1px solid var(--card-border);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
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
            color: var(--text-white);
            margin: 0 0 16px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .policy-section h2 i {
            color: var(--primary-light-gold);
            background: var(--inner-bg);
            border: 1px solid var(--card-border);
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }
        .policy-section p {
            color: var(--text-body);
            font-size: 15.5px;
            line-height: 1.7;
            margin-bottom: 14px;
        }
        .policy-section ul {
            padding-left: 20px;
            margin-bottom: 16px;
        }
        .policy-section li {
            margin-bottom: 8px;
            font-size: 15px;
            color: var(--text-body);
            line-height: 1.6;
        }
        .policy-section strong {
            color: var(--text-white);
        }

        .highlight-box {
            background: var(--inner-bg);
            border: 1px solid var(--card-border);
            border-left: 4px solid var(--primary-gold);
            padding: 18px 22px;
            border-radius: 0 14px 14px 0;
            margin: 20px 0;
        }
        .highlight-box p {
            margin: 0;
            font-weight: 600;
            color: var(--text-white);
            font-size: 14.5px;
        }

        .policy-footer {
            background: var(--app-bg);
            color: var(--text-muted);
            padding: 45px 24px;
            text-align: center;
            font-size: 14px;
            border-top: 1px solid var(--card-border);
        }
        .policy-footer a {
            color: var(--primary-light-gold);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
        }
        .policy-footer a:hover {
            color: #FFE596;
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
                <li><a href="{{ route('terms.conditions') }}" style="color: var(--primary-light-gold); font-weight: 700;">{{ __('Terms & Services') }}</a></li>
                <li><a class="btn-login-outline" href="{{ route('login') }}">{{ __('Partner Login') }}</a></li>
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
                <li><a href="#term-1"><i class="ti ti-file-text me-1"></i> {{ __('1. Agreement Acceptance') }}</a></li>
                <li><a href="#term-2"><i class="ti ti-apps me-1"></i> {{ __('2. Platform Services') }}</a></li>
                <li><a href="#term-3"><i class="ti ti-user-check me-1"></i> {{ __('3. Account Responsibilities') }}</a></li>
                <li><a href="#term-4"><i class="ti ti-credit-card me-1"></i> {{ __('4. Subscriptions & Billing') }}</a></li>
                <li><a href="#term-5"><i class="ti ti-shield-check me-1"></i> {{ __('5. IP & Data Rights') }}</a></li>
                <li><a href="#term-6"><i class="ti ti-activity me-1"></i> {{ __('6. Service Availability') }}</a></li>
                <li><a href="#term-7"><i class="ti ti-scale me-1"></i> {{ __('7. Liability & Governing Law') }}</a></li>
            </ul>
        </aside>

        <!-- Main Document Body -->
        <main class="policy-content-card">
            <div class="policy-section" id="term-1">
                <h2><i class="ti ti-file-text"></i> {{ __('1. Agreement to Terms') }}</h2>
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
                    <p><i class="ti ti-shield-alert me-2" style="color: var(--primary-light-gold);"></i> {{ __('Un-authorized access or sharing of account credentials outside your registered boutique staff is strictly prohibited.') }}</p>
                </div>
            </div>

            <div class="policy-section" id="term-4">
                <h2><i class="ti ti-credit-card"></i> {{ __('4. Subscriptions, Payments & Billing') }}</h2>
                <p>{{ __('Subscription plans (Monthly, Quarterly, Annual) are billed in advance according to selected packages. All fees are in Indian Rupees (INR) or localized currency.') }}</p>
                <ul>
                    <li><strong>{{ __('Auto-Renewal') }}</strong>: {{ __('Subscriptions renew automatically unless cancelled prior to the renewal date.') }}</li>
                    <li><strong>{{ __('Refund Policy') }}</strong>: {{ __('Payments are non-refundable except where mandated by applicable consumer protection laws.') }}</li>
                    <li><strong>{{ __('Plan Upgrades') }}</strong>: {{ __('Upgrades take effect immediately with pro-rated billing calculation.') }}</li>
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
                <h2><i class="ti ti-scale"></i> {{ __('7. Limitation of Liability & Governing Law') }}</h2>
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
