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
    <meta name="description" content="About DarziDesk - Premier Tailoring Management System (TMS) built for boutiques, master tailors, and bespoke garment ateliers.">

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
            max-width: 720px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* ── Stat Grid ── */
        .about-grid {
            max-width: 1200px;
            margin: -45px auto 60px;
            padding: 0 24px;
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
            position: relative;
            z-index: 10;
        }
        .stat-card {
            background: var(--card-bg);
            border-radius: 20px;
            padding: 36px 28px;
            border: 1px solid var(--card-border);
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
            transition: all 0.3s ease;
        }
        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 15px 35px rgba(217, 164, 65, 0.2);
            border-color: var(--primary-gold);
        }
        .stat-card .stat-number {
            font-size: 44px;
            font-weight: 800;
            color: var(--primary-light-gold);
            line-height: 1;
            margin-bottom: 10px;
            font-family: var(--font-code);
        }
        .stat-card .stat-label {
            font-size: 13px;
            font-weight: 700;
            color: var(--text-white);
            text-transform: uppercase;
            letter-spacing: 0.06em;
        }

        /* ── Main Content ── */
        .content-wrap {
            max-width: 1200px;
            margin: 0 auto 80px;
            padding: 0 24px;
        }
        .main-card {
            background: var(--card-bg);
            border-radius: 24px;
            padding: 52px;
            border: 1px solid var(--card-border);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
        }

        .feature-box-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 24px;
            margin-top: 36px;
        }
        .feature-box {
            background: var(--inner-bg);
            border-radius: 16px;
            padding: 28px;
            border: 1px solid var(--card-border);
            transition: all 0.25s ease;
        }
        .feature-box:hover {
            border-color: var(--primary-gold);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        }
        .feature-box i {
            font-size: 32px;
            color: var(--primary-light-gold);
            margin-bottom: 14px;
            display: block;
        }
        .feature-box h4 {
            font-size: 19px;
            font-weight: 700;
            color: var(--text-white);
            margin: 0 0 10px;
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
                <li><a href="{{ route('about.us') }}" style="color: var(--primary-light-gold); font-weight: 700;">{{ __('About Us') }}</a></li>
                <li><a href="{{ route('privacy.policy') }}">{{ __('Privacy Policy') }}</a></li>
                <li><a href="{{ route('terms.conditions') }}">{{ __('Terms & Services') }}</a></li>
                <li><a class="btn-login-outline" href="{{ route('login') }}">{{ __('Partner Login') }}</a></li>
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
            <h2 style="font-size: 30px; font-weight: 800; color: var(--text-white); margin-top: 0;">{{ __('Our Mission') }}</h2>
            <p style="font-size: 16.5px; color: var(--text-body); line-height: 1.75; margin-bottom: 18px;">
                {{ __('For generations, tailoring has been an integral artform defined by precision, personal care, and meticulous craftsmanship. However, traditional paper measurement registers, misplaced order slips, and manual worker tracking often lead to delays and fitting errors.') }}
            </p>
            <p style="font-size: 16.5px; color: var(--text-body); line-height: 1.75;">
                {{ __('DarziDesk bridges traditional artistry with modern digital efficiency. We provide boutique owners, master tailors, cutters, and clients with a unified platform to manage orders seamlessly from fabric receipt to final delivery.') }}
            </p>

            <h3 style="font-size: 24px; font-weight: 800; color: var(--text-white); margin-top: 44px; margin-bottom: 16px;">{{ __('Core Capabilities') }}</h3>
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
