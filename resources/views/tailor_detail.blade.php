@php
    $settings = settings();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $tailor['shop_name'] }} - {{ !empty($settings['app_name']) ? $settings['app_name'] : env('APP_NAME') }}</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="{{ $tailor['owner_name'] }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="{{ $tailor['shop_name'] }} - Master bespoke tailoring atelier in {{ $tailor['location'] }}. Book fitting consultations, suit alterations, and custom handcrafted menswear.">

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

        body.tailor-detail-page {
            font-family: var(--font-main);
            background: var(--app-bg);
            color: var(--text-body);
            margin: 0;
            padding: 0;
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

        /* ── Hero Banner Section ── */
        .tailor-hero {
            position: relative;
            padding: 140px 24px 75px;
            background-size: cover;
            background-position: center;
            color: #ffffff;
            text-align: center;
            overflow: hidden;
            border-bottom: 1px solid var(--card-border);
        }
        .tailor-hero .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--gold-light-bg);
            backdrop-filter: blur(10px);
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

        /* ── Hero Partner Companies Banner ── */
        .hero-partner-banner {
            max-width: 1050px;
            margin: 28px auto 0;
            padding: 20px 24px;
            background: rgba(11, 34, 57, 0.85);
            backdrop-filter: blur(16px);
            border: 1px solid var(--card-border);
            border-radius: 20px;
            text-align: center;
            box-shadow: 0 12px 35px rgba(0, 0, 0, 0.4);
        }
        .hero-partner-banner .partner-title {
            display: inline-block;
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.12em;
            color: var(--primary-light-gold);
            margin-bottom: 14px;
        }
        .partner-logos-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            flex-wrap: wrap;
        }
        .partner-brand-pill {
            display: flex;
            align-items: center;
            gap: 10px;
            background: var(--inner-bg);
            border: 1px solid var(--card-border);
            padding: 8px 16px;
            border-radius: 50px;
            transition: all 0.25s ease;
        }
        .partner-brand-pill:hover {
            background: var(--card-bg);
            border-color: var(--primary-gold);
            transform: translateY(-2px);
            box-shadow: 0 4px 14px rgba(217, 164, 65, 0.2);
        }
        .partner-brand-pill .partner-icon {
            font-size: 18px;
            color: var(--primary-light-gold);
        }
        .partner-brand-pill .partner-text {
            text-align: left;
        }
        .partner-brand-pill .p-name {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--text-white);
            line-height: 1.2;
        }
        .partner-brand-pill .p-tag {
            display: block;
            font-size: 10.5px;
            color: var(--text-muted);
        }

        /* ── Centered Overlap Card ── */
        .profile-overlap-card {
            max-width: 1100px;
            margin: -45px auto 40px;
            padding: 0 24px;
            position: relative;
            z-index: 10;
            text-align: center;
        }
        .avatar-circle {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: var(--card-bg);
            margin: 0 auto 16px;
            padding: 4px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.5);
            border: 3px solid var(--primary-gold);
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
        }
        .avatar-circle img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .shop-title {
            font-size: clamp(26px, 3.5vw, 40px);
            font-weight: 800;
            color: var(--text-white);
            margin: 0 0 6px;
            letter-spacing: -0.02em;
        }
        .shop-subtitle {
            font-size: 16px;
            color: var(--text-muted);
            margin-bottom: 14px;
            font-weight: 500;
        }
        .rating-badge-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            margin-bottom: 28px;
            flex-wrap: wrap;
        }
        .verified-badge {
            background: var(--gold-light-bg);
            color: var(--primary-light-gold);
            border: 1px solid var(--gold-border);
            padding: 5px 14px;
            border-radius: 50px;
            font-size: 12.5px;
            font-weight: 700;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }
        .star-rating {
            color: var(--primary-light-gold);
            font-weight: 700;
            font-size: 14.5px;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        /* ── Stat Pills Grid ── */
        .stat-pills-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            max-width: 900px;
            margin: 0 auto 32px;
        }
        .stat-pill {
            background: var(--card-bg);
            border-radius: 18px;
            padding: 20px 16px;
            border: 1px solid var(--card-border);
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
            text-align: center;
            transition: all 0.25s ease;
        }
        .stat-pill:hover {
            border-color: var(--primary-gold);
            transform: translateY(-2px);
        }
        .stat-pill .label {
            font-size: 11px;
            font-weight: 800;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 4px;
        }
        .stat-pill .value {
            font-size: 20px;
            font-weight: 800;
            color: var(--primary-light-gold);
            font-family: var(--font-code);
        }

        /* ── Primary Action Buttons ── */
        .action-buttons-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 14px;
            max-width: 750px;
            margin: 0 auto 40px;
            flex-wrap: wrap;
        }
        .btn-book-now {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            height: 48px;
            padding: 0 32px;
            background: linear-gradient(135deg, #D9A441 0%, #F4C861 100%);
            color: #03111F !important;
            font-weight: 800;
            font-size: 15px;
            border-radius: 9999px;
            border: none;
            cursor: pointer;
            text-decoration: none;
            box-shadow: 0 6px 20px rgba(217, 164, 65, 0.3);
            transition: all 0.3s ease;
        }
        .btn-book-now:hover {
            background: linear-gradient(135deg, #F4C861 0%, #FFE596 100%);
            box-shadow: 0 10px 28px rgba(217, 164, 65, 0.45);
            transform: translateY(-2px);
        }
        .btn-whatsapp {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            height: 48px;
            padding: 0 28px;
            background: #25D366;
            color: #ffffff !important;
            font-weight: 700;
            font-size: 15px;
            border-radius: 9999px;
            text-decoration: none;
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.3);
            transition: all 0.25s ease;
            border: none;
        }
        .btn-whatsapp:hover {
            background: #1da851;
            transform: translateY(-2px);
            box-shadow: 0 10px 28px rgba(37, 211, 102, 0.45);
        }
        .btn-call {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            height: 48px;
            padding: 0 26px;
            background: rgba(11, 34, 57, 0.6);
            color: var(--primary-light-gold) !important;
            border: 1.5px solid var(--primary-gold);
            font-weight: 700;
            font-size: 15px;
            border-radius: 9999px;
            text-decoration: none;
            transition: all 0.25s ease;
        }
        .btn-call:hover {
            background: var(--gold-light-bg);
            color: var(--text-white) !important;
            border-color: var(--primary-light-gold);
            box-shadow: 0 6px 20px rgba(217, 164, 65, 0.2);
            transform: translateY(-2px);
        }

        /* ── Main Details Layout Grid ── */
        .details-layout {
            max-width: 1150px;
            margin: 0 auto 80px;
            padding: 0 24px;
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 32px;
        }

        .content-card {
            background: var(--card-bg);
            border-radius: 24px;
            padding: 32px;
            border: 1px solid var(--card-border);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
            margin-bottom: 28px;
        }
        .content-card h3 {
            font-size: 20px;
            font-weight: 800;
            color: var(--text-white);
            margin: 0 0 20px;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .content-card h3 i {
            color: var(--primary-light-gold);
            background: var(--inner-bg);
            border: 1px solid var(--card-border);
            width: 38px;
            height: 38px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        /* ── Service List Items ── */
        .service-list {
            display: flex;
            flex-direction: column;
            gap: 16px;
        }
        .service-item {
            background: var(--inner-bg);
            border-radius: 16px;
            padding: 20px 24px;
            border: 1px solid var(--card-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            transition: all 0.25s ease;
        }
        .service-item:hover {
            border-color: var(--primary-gold);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.25);
        }
        .service-info h5 {
            font-size: 16px;
            font-weight: 700;
            color: var(--text-white);
            margin: 0 0 4px;
        }
        .service-info p {
            font-size: 13.5px;
            color: var(--text-muted);
            margin: 0 0 8px;
            line-height: 1.45;
        }
        .service-meta {
            font-size: 12px;
            font-weight: 700;
            color: var(--primary-light-gold);
            text-transform: uppercase;
            letter-spacing: 0.05em;
            display: inline-flex;
            align-items: center;
        }
        .service-price-box {
            text-align: right;
            flex-shrink: 0;
        }
        .service-price {
            font-size: 20px;
            font-weight: 800;
            color: var(--primary-light-gold);
            font-family: var(--font-code);
            display: block;
            margin-bottom: 8px;
        }

        /* ── Fabric Grid ── */
        .fabric-badge-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 14px;
        }
        .fabric-card {
            background: var(--inner-bg);
            border-radius: 14px;
            padding: 16px;
            border: 1px solid var(--card-border);
            transition: all 0.2s ease;
        }
        .fabric-card:hover {
            border-color: var(--primary-gold);
        }
        .fabric-card strong {
            display: block;
            font-size: 14px;
            color: var(--text-white);
            margin-bottom: 2px;
            font-weight: 700;
        }
        .fabric-card span {
            font-size: 12px;
            color: var(--text-muted);
        }

        /* ── Reviews ── */
        .review-card {
            background: var(--inner-bg);
            border-radius: 16px;
            padding: 20px;
            margin-bottom: 16px;
            border: 1px solid var(--card-border);
        }
        .review-card:last-child {
            margin-bottom: 0;
        }
        .review-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 10px;
        }
        .reviewer-name {
            font-weight: 700;
            font-size: 15px;
            color: var(--text-white);
        }
        .reviewer-role {
            font-size: 12px;
            color: var(--text-muted);
            display: block;
        }

        /* ── Custom Modal ── */
        .modal-custom {
            display: none;
            position: fixed;
            inset: 0;
            z-index: 2000;
            background: rgba(3, 17, 31, 0.85);
            backdrop-filter: blur(12px);
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .modal-custom.active {
            display: flex;
        }
        .modal-content-box {
            background: var(--card-bg);
            border-radius: 24px;
            border: 1px solid var(--card-border);
            max-width: 520px;
            width: 100%;
            padding: 36px;
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.6);
            position: relative;
            max-height: 90vh;
            overflow-y: auto;
            color: var(--text-body);
        }
        .modal-close {
            position: absolute;
            top: 20px;
            right: 20px;
            background: var(--inner-bg);
            border: 1px solid var(--card-border);
            width: 36px;
            height: 36px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 20px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            transition: all 0.2s ease;
        }
        .modal-close:hover {
            color: var(--text-white);
            border-color: var(--primary-gold);
        }

        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            font-weight: 700;
            font-size: 13.5px;
            color: var(--text-body);
            margin-bottom: 6px;
        }
        .form-control {
            width: 100%;
            padding: 12px 16px;
            font-size: 14.5px;
            border-radius: 10px;
            border: 1px solid var(--card-border) !important;
            background: var(--inner-bg) !important;
            color: var(--text-white) !important;
            box-sizing: border-box;
            font-family: inherit;
        }
        .form-control:focus {
            outline: none;
            border-color: var(--primary-gold) !important;
            box-shadow: 0 0 0 3px rgba(217, 164, 65, 0.25) !important;
        }
        .form-control::placeholder {
            color: var(--text-muted) !important;
            opacity: 0.8;
        }

        .alert-flash-success {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.4);
            color: #34D399;
            padding: 16px 20px;
            border-radius: 12px;
            margin-bottom: 24px;
            font-size: 14.5px;
            font-weight: 600;
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
            transition: color 0.2s ease;
        }
        .policy-footer a:hover {
            color: #FFE596;
        }

        @media (max-width: 991px) {
            .stat-pills-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .details-layout {
                grid-template-columns: 1fr;
            }
            .fabric-badge-grid {
                grid-template-columns: 1fr;
            }
            .service-item {
                flex-direction: column;
                align-items: flex-start;
            }
            .service-price-box {
                text-align: left;
                width: 100%;
            }
        }
    </style>
</head>

<body class="tailor-detail-page">

    <!-- [ Top Header Navbar ] -->
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
                <li><a class="btn-login-outline" href="{{ route('login') }}">{{ __('Partner Login') }}</a></li>
                <li><a class="btn-cta" href="{{ route('register') }}">{{ __('Get Started') }}</a></li>
            </ul>
        </div>
    </nav>

    <!-- [ Hero Banner ] -->
    <section class="tailor-hero" style="background: linear-gradient(180deg, rgba(3, 17, 31, 0.82) 0%, rgba(11, 34, 57, 0.95) 100%), url('{{ $tailor['banner_image'] ?? $tailor['cover_image'] }}') center/cover no-repeat;">
        <div class="hero-badge">
            <i class="ti ti-scissors me-1"></i>
            {{ __('Bespoke Studio & Master Atelier') }}
        </div>
        <h1 style="font-size: clamp(32px, 4.5vw, 52px); font-weight: 800; margin: 0 0 12px; color: #ffffff; text-shadow: 0 2px 14px rgba(0,0,0,0.5);">
            {{ $tailor['shop_name'] }}
        </h1>
        <p style="font-size: 19px; color: var(--text-body); max-width: 650px; margin: 0 auto; font-weight: 500;">
            {{ $tailor['owner_name'] }} &nbsp;·&nbsp; {{ $tailor['location'] }}
        </p>

        <!-- [ Certified Textile Mill & Brand Partner Companies Banner ] -->
        @if(!empty($tailor['company_partners']))
            <div class="hero-partner-banner">
                <span class="partner-title"><i class="ti ti-certificate me-1"></i> {{ __('Official Partner Mills & Certified Brands') }}</span>
                <div class="partner-logos-row">
                    @foreach($tailor['company_partners'] as $partner)
                        <div class="partner-brand-pill">
                            <i class="ti {{ $partner['icon'] ?? 'ti-building' }} partner-icon"></i>
                            <div class="partner-text">
                                <span class="p-name">{{ $partner['name'] }}</span>
                                <span class="p-tag">{{ $partner['country'] }} &bull; {{ $partner['tag'] }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>

    <!-- [ Centered Studio Profile Card ] -->
    <div class="profile-overlap-card">
        <div class="avatar-circle">
            <img src="{{ $tailor['avatar_image'] }}" alt="{{ $tailor['shop_name'] }} Logo" />
        </div>

        <div class="rating-badge-row">
            <span class="verified-badge">
                <i class="ti ti-discount-check-filled"></i> {{ __('Verified Master Artisan') }}
            </span>
            <span class="star-rating">
                <i class="ti ti-star-filled"></i> {{ $tailor['rating'] }} ({{ $tailor['reviews_count'] }} {{ __('verified reviews') }})
            </span>
        </div>

        <!-- Stat Pills Row -->
        <div class="stat-pills-grid">
            <div class="stat-pill">
                <div class="label">{{ __('Experience') }}</div>
                <div class="value">{{ $tailor['experience'] }}</div>
            </div>
            <div class="stat-pill">
                <div class="label">{{ __('Orders Completed') }}</div>
                <div class="value">{{ $tailor['orders_completed'] }}</div>
            </div>
            <div class="stat-pill">
                <div class="label">{{ __('Response Time') }}</div>
                <div class="value">{{ $tailor['response_time'] }}</div>
            </div>
            <div class="stat-pill">
                <div class="label">{{ __('Fitting Accuracy') }}</div>
                <div class="value">{{ $tailor['fitting_accuracy'] }}</div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="action-buttons-row">
            <button class="btn-book-now" onclick="openBookingModal()">
                <i class="ti ti-calendar-event"></i> {{ __('Book Fitting Consultation') }}
            </button>
            <a href="https://wa.me/{{ preg_replace('/[^0-9+]/', '', $tailor['whatsapp']) }}?text=Hello,%20I%20would%20like%20to%20inquire%20about%20bespoke%20tailoring%20consultations." target="_blank" class="btn-whatsapp">
                <i class="ti ti-brand-whatsapp"></i> {{ __('WhatsApp Inquiry') }}
            </a>
            <a href="tel:{{ $tailor['phone'] }}" class="btn-call">
                <i class="ti ti-phone"></i> {{ __('Call Studio') }}
            </a>
        </div>
    </div>

    <!-- [ Main Content Details Layout Grid ] -->
    <div class="details-layout">
        <!-- Left Main Column -->
        <div class="left-col">

            @if (session('success'))
                <div class="alert-flash-success">
                    <i class="ti ti-circle-check me-2"></i> {{ session('success') }}
                </div>
            @endif

            <!-- About Studio Bio Card -->
            <div class="content-card">
                <h3><i class="ti ti-building-store"></i> {{ __('About Atelier & Master Tailor') }}</h3>
                <p style="font-size: 16px; color: var(--text-body); line-height: 1.75; margin: 0;">
                    {{ $tailor['bio'] }}
                </p>
                <div style="margin-top: 20px; display: flex; flex-wrap: wrap; gap: 8px;">
                    @foreach($tailor['specialties'] as $spec)
                        <span style="background: var(--gold-light-bg); color: var(--primary-light-gold); border: 1px solid var(--gold-border); padding: 6px 14px; border-radius: 50px; font-size: 13px; font-weight: 700;">
                            #{{ $spec }}
                        </span>
                    @endforeach
                </div>
            </div>

            <!-- Master Craftsmanship & Guarantees Card -->
            @if(!empty($tailor['craftsmanship_guarantees']))
                <div class="content-card">
                    <h3><i class="ti ti-shield-check"></i> {{ __('Master Craftsmanship & Guarantees') }}</h3>
                    <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 16px;">
                        @foreach($tailor['craftsmanship_guarantees'] as $guarantee)
                            <div style="background: var(--inner-bg); padding: 18px; border-radius: 16px; border: 1px solid var(--card-border);">
                                <div style="font-weight: 700; font-size: 15px; color: var(--text-white); margin-bottom: 6px; display: flex; align-items: center; gap: 8px;">
                                    <i class="ti ti-check-circle" style="color: var(--primary-light-gold); font-size: 18px;"></i>
                                    {{ $guarantee['title'] }}
                                </div>
                                <div style="font-size: 13px; color: var(--text-muted); line-height: 1.5;">
                                    {{ $guarantee['desc'] }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Bespoke Services Catalog Card -->
            <div class="content-card">
                <h3><i class="ti ti-scissors"></i> {{ __('Bespoke Services & Pricing') }}</h3>
                <div class="service-list">
                    @foreach($tailor['services'] as $service)
                        <div class="service-item">
                            <div class="service-info">
                                <h5>{{ $service['name'] }}</h5>
                                <p>{{ $service['desc'] }}</p>
                                <span class="service-meta"><i class="ti ti-clock me-1"></i> {{ $service['time'] }}</span>
                            </div>
                            <div class="service-price-box">
                                <span class="service-price">{{ $service['price'] }}</span>
                                <button class="btn-book-now" style="height: 38px; padding: 0 20px; font-size: 13px; font-weight: 700;" onclick="openBookingModal('{{ $service['name'] }}')">
                                    {{ __('Book Service') }}
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Verified Client Reviews Card -->
            <div class="content-card">
                <h3><i class="ti ti-star"></i> {{ __('Verified Client Reviews') }}</h3>
                @foreach($tailor['reviews'] as $rev)
                    <div class="review-card">
                        <div class="review-header">
                            <div>
                                <span class="reviewer-name">{{ $rev['name'] }}</span>
                                <span class="reviewer-role">{{ $rev['role'] }}</span>
                            </div>
                            <div class="star-rating">
                                <i class="ti ti-star-filled"></i> {{ $rev['rating'] }}.0
                            </div>
                        </div>
                        <p style="font-size: 14.5px; color: var(--text-body); margin: 0; font-style: italic;">
                            "{{ $rev['text'] }}"
                        </p>
                    </div>
                @endforeach
            </div>

        </div>

        <!-- Right Sidebar Column -->
        <div class="right-col">

            <!-- Authenticated Fabrics Card -->
            <div class="content-card">
                <h3><i class="ti ti-shirt"></i> {{ __('Authenticated Fabrics') }}</h3>
                <p style="font-size: 13.5px; color: var(--text-muted); margin-bottom: 16px;">
                    {{ __('Hand-selected textiles from prestigious global mills available in studio:') }}
                </p>
                <div class="fabric-badge-grid">
                    @foreach($tailor['fabrics'] as $fab)
                        <div class="fabric-card">
                            <strong>{{ $fab['name'] }}</strong>
                            <span>{{ $fab['mill'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Studio Amenities Card -->
            @if(!empty($tailor['amenities']))
                <div class="content-card">
                    <h3><i class="ti ti-sparkles"></i> {{ __('Studio Amenities') }}</h3>
                    <ul style="list-style: none; padding: 0; margin: 0; display: flex; flex-direction: column; gap: 12px;">
                        @foreach($tailor['amenities'] as $amenity)
                            <li style="font-size: 14px; font-weight: 600; color: var(--text-body); display: flex; align-items: center; gap: 10px;">
                                <i class="ti ti-circle-check-filled" style="color: var(--primary-light-gold); font-size: 16px;"></i> {{ $amenity }}
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <!-- Languages & Payment Methods Card -->
            @if(!empty($tailor['languages']) || !empty($tailor['payment_methods']))
                <div class="content-card">
                    <h3><i class="ti ti-world"></i> {{ __('Languages & Payment') }}</h3>
                    @if(!empty($tailor['languages']))
                        <div style="margin-bottom: 18px;">
                            <span style="font-size: 12px; font-weight: 800; text-transform: uppercase; color: var(--text-muted); display: block; margin-bottom: 8px;">{{ __('Languages Spoken') }}</span>
                            <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                                @foreach($tailor['languages'] as $lang)
                                    <span style="background: var(--inner-bg); border: 1px solid var(--card-border); padding: 4px 12px; border-radius: 50px; font-size: 12.5px; font-weight: 600; color: var(--text-body);">
                                        {{ $lang }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif

                    @if(!empty($tailor['payment_methods']))
                        <div>
                            <span style="font-size: 12px; font-weight: 800; text-transform: uppercase; color: var(--text-muted); display: block; margin-bottom: 8px;">{{ __('Accepted Payment Options') }}</span>
                            <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                                @foreach($tailor['payment_methods'] as $pm)
                                    <span style="background: var(--gold-light-bg); color: var(--primary-light-gold); border: 1px solid var(--gold-border); padding: 4px 12px; border-radius: 50px; font-size: 12.5px; font-weight: 700;">
                                        <i class="ti ti-credit-card me-1"></i> {{ $pm }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            @endif

            <!-- Studio Location Card -->
            <div class="content-card">
                <h3><i class="ti ti-map-pin"></i> {{ __('Studio Location') }}</h3>
                <p style="font-size: 14.5px; color: var(--text-white); font-weight: 600; margin-bottom: 6px;">
                    {{ $tailor['address'] }}
                </p>
                <p style="font-size: 13.5px; color: var(--text-muted); margin-bottom: 18px;">
                    <i class="ti ti-clock me-1" style="color: var(--primary-light-gold);"></i> Mon - Sat: 10:00 AM - 8:00 PM<br>
                    <i class="ti ti-circle-x me-1"></i> Sunday: Closed (Appointment Only)
                </p>
                <a href="https://maps.google.com/?q={{ urlencode($tailor['address']) }}" target="_blank" class="btn-call" style="width: 100%; text-align: center; justify-content: center; height: 44px;">
                    <i class="ti ti-location"></i> {{ __('Open in Google Maps') }}
                </a>
            </div>

        </div>
    </div>

    <!-- Booking Modal -->
    <div class="modal-custom" id="bookingModal">
        <div class="modal-content-box">
            <button class="modal-close" onclick="closeBookingModal()">&times;</button>
            <h3 style="font-size: 22px; font-weight: 800; color: var(--text-white); margin-top: 0; margin-bottom: 6px;">
                <i class="ti ti-calendar me-1" style="color: var(--primary-light-gold);"></i> {{ __('Book Fitting Appointment') }}
            </h3>
            <p style="color: var(--text-muted); font-size: 14px; margin-bottom: 24px;">
                {{ __('Schedule a bespoke consultation with ') }} <strong style="color: var(--text-white);">{{ $tailor['owner_name'] }}</strong>
            </p>

            <form action="{{ route('tailor.book.appointment', $tailor['id']) }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="customer_name">{{ __('Your Full Name') }} <span style="color: #EF4444;">*</span></label>
                    <input type="text" name="customer_name" id="customer_name" class="form-control" placeholder="e.g. Jameson Aris" required />
                </div>

                <div class="form-group">
                    <label for="email">{{ __('Email Address') }} <span style="color: #EF4444;">*</span></label>
                    <input type="email" name="email" id="email" class="form-control" placeholder="name@domain.com" required />
                </div>

                <div class="form-group">
                    <label for="phone">{{ __('Mobile Phone / WhatsApp') }} <span style="color: #EF4444;">*</span></label>
                    <input type="tel" name="phone" id="phone" class="form-control" placeholder="+44 20 7946 0912" required />
                </div>

                <div class="form-group">
                    <label for="appointment_date">{{ __('Preferred Appointment Date') }} <span style="color: #EF4444;">*</span></label>
                    <input type="date" name="appointment_date" id="appointment_date" class="form-control" min="{{ date('Y-m-d') }}" required />
                </div>

                <div class="form-group">
                    <label for="service_type">{{ __('Select Service') }} <span style="color: #EF4444;">*</span></label>
                    <select name="service_type" id="service_type" class="form-control" required>
                        @foreach($tailor['services'] as $srv)
                            <option value="{{ $srv['name'] }}">{{ $srv['name'] }} ({{ $srv['price'] }})</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn-book-now" style="width: 100%; justify-content: center; margin-top: 8px;">
                    <i class="ti ti-check me-1"></i> {{ __('Confirm Appointment Booking') }}
                </button>
            </form>
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

    <script>
        function openBookingModal(serviceName = null) {
            if (serviceName) {
                const select = document.getElementById('service_type');
                if (select) {
                    for (let i = 0; i < select.options.length; i++) {
                        if (select.options[i].value.includes(serviceName)) {
                            select.selectedIndex = i;
                            break;
                        }
                    }
                }
            }
            document.getElementById('bookingModal').classList.add('active');
        }

        function closeBookingModal() {
            document.getElementById('bookingModal').classList.remove('active');
        }
    </script>

</body>
</html>
