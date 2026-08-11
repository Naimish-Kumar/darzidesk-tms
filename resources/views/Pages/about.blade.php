@php
    $settings = settings();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('About Us') }} - {{ !empty($settings['app_name']) ? $settings['app_name'] : env('APP_NAME') }}</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="{{ !empty($settings['app_name']) ? $settings['app_name'] : env('APP_NAME') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="About DarziDesk - India's premier Tailoring Management System (TMS) built for boutiques, tailors, and garment artisans.">

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
            transform: translateY(-1px);
        }

        .policy-hero {
            position: relative;
            padding: 150px 24px 85px;
            text-align: center;
            background: linear-gradient(135deg, #0B1C30 0%, #006A67 100%);
            color: #ffffff;
            overflow: hidden;
        }
        .policy-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -20%;
            width: 140%;
            height: 200%;
            background: radial-gradient(ellipse at 30% 50%, rgba(138, 244, 239, 0.15) 0%, transparent 60%);
            pointer-events: none;
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
            max-width: 720px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .about-grid {
            max-width: 1200px;
            margin: -40px auto 70px;
            padding: 0 24px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            position: relative;
            z-index: 10;
        }
        .stat-card {
            background: #ffffff;
            border-radius: 20px;
            padding: 36px 28px;
            border: 1px solid rgba(188, 201, 200, 0.5);
            text-align: center;
            box-shadow: 0 10px 30px rgba(11, 28, 48, 0.04);
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(0, 106, 103, 0.1);
            border-color: var(--brand-primary);
        }
        .stat-card .stat-number {
            font-size: 44px;
            font-weight: 800;
            color: var(--brand-primary);
            line-height: 1;
            margin-bottom: 10px;
            font-family: 'JetBrains Mono', monospace;
        }
        .stat-card .stat-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--brand-navy);
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        .content-wrap {
            max-width: 1200px;
            margin: 0 auto 80px;
            padding: 0 24px;
        }
        .main-card {
            background: #ffffff;
            border-radius: 24px;
            padding: 52px;
            border: 1px solid rgba(188, 201, 200, 0.5);
            box-shadow: 0 10px 30px rgba(11, 28, 48, 0.03);
        }

        .feature-box-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            margin-top: 36px;
        }
        .feature-box {
            background: var(--brand-primary-light);
            border-radius: 16px;
            padding: 28px;
            border: 1px solid rgba(0, 106, 103, 0.15);
            transition: all 0.2s ease;
        }
        .feature-box:hover {
            border-color: var(--brand-primary);
            transform: translateY(-2px);
        }
        .feature-box i {
            font-size: 32px;
            color: var(--brand-primary);
            margin-bottom: 14px;
            display: block;
        }
        .feature-box h4 {
            font-size: 19px;
            font-weight: 700;
            color: var(--brand-navy);
            margin: 0 0 10px;
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
            transition: color 0.2s ease;
        }
        .policy-footer a:hover {
            color: #8AF4EF;
        }

        @media (max-width: 991px) {
            .about-grid {
                grid-template-columns: 1fr;
            }
            .feature-box-grid {
                grid-template-columns: 1fr;
            }
            .main-card {
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
                <li><a href="{{ route('about.us') }}" style="color: var(--brand-primary); font-weight: 700;">{{ __('About Us') }}</a></li>
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
            <i class="ti ti-scissors me-1"></i>
            {{ __('Craftsmanship Meets Technology') }}
        </div>
        <h1>{{ __('Empowering India\'s Bespoke Tailors') }}</h1>
        <p>{{ __('DarziDesk is a premier Tailoring Management System (TMS) engineered specifically to digitize boutique workflows, master measurement records, and order tracking.') }}</p>
    </section>

    <!-- [ Stat Grid ] -->
    <div class="about-grid">
        <div class="stat-card">
            <div class="stat-number">500+</div>
            <div class="stat-label">{{ __('Active Boutiques & Studios') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">50,000+</div>
            <div class="stat-label">{{ __('Custom Garment Orders Processed') }}</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">99.8%</div>
            <div class="stat-label">{{ __('Fitting Accuracy Rate') }}</div>
        </div>
    </div>

    <!-- [ Main Content ] -->
    <div class="content-wrap">
        <div class="main-card">
            <h2 style="font-size: 30px; font-weight: 800; color: var(--brand-navy); margin-top: 0;">{{ __('Our Mission') }}</h2>
            <p style="font-size: 16.5px; color: var(--text-main); line-height: 1.75; margin-bottom: 18px;">
                {{ __('For generations, tailoring has been an integral artform defined by precision, personal care, and meticulous craftsmanship. However, traditional paper measurement registers, misplaced order slips, and manual worker tracking often lead to delays and fitting errors.') }}
            </p>
            <p style="font-size: 16.5px; color: var(--text-main); line-height: 1.75;">
                {{ __('DarziDesk bridges traditional artistry with modern digital efficiency. We provide boutique owners, master tailors, cutters, and clients with a unified platform to manage orders seamlessly from fabric receipt to final delivery.') }}
            </p>

            <h3 style="font-size: 24px; font-weight: 800; color: var(--brand-navy); margin-top: 44px; margin-bottom: 10px;">{{ __('Core Capabilities') }}</h3>
            <div class="feature-box-grid">
                <div class="feature-box">
                    <i class="ti ti-ruler-2"></i>
                    <h4>{{ __('Digital Measurement Vault') }}</h4>
                    <p style="margin:0; font-size:14.5px; color: var(--text-muted);">{{ __('Store comprehensive customer body measurements, posture notes, and style references permanently. Access instantly for repeat orders.') }}</p>
                </div>
                <div class="feature-box">
                    <i class="ti ti-layout-kanban"></i>
                    <h4>{{ __('Production Kanban Stages') }}</h4>
                    <p style="margin:0; font-size:14.5px; color: var(--text-muted);">{{ __('Track every garment status step-by-step: Cutting, Stitching, Embroidery, Buttoning, Quality Check, and Delivery.') }}</p>
                </div>
                <div class="feature-box">
                    <i class="ti ti-message-dots"></i>
                    <h4>{{ __('Automated Customer Alerts') }}</h4>
                    <p style="margin:0; font-size:14.5px; color: var(--text-muted);">{{ __('Keep customers informed with automatic WhatsApp & SMS notifications for fitting appointments and order completion.') }}</p>
                </div>
                <div class="feature-box">
                    <i class="ti ti-receipt"></i>
                    <h4>{{ __('POS, Invoicing & QR Receipts') }}</h4>
                    <p style="margin:0; font-size:14.5px; color: var(--text-muted);">{{ __('Generate GST invoices, thermal cloth tags, and digital QR tracking receipts for transparent self-service order lookup.') }}</p>
                </div>
            </div>
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
