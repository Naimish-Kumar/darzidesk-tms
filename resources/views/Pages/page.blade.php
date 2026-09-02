@php
    $routeName = \Request::route() ? \Request::route()->getName() : '';
    $routeParameters = request()->route()->parameters;
    $settings = settings();
    $user = \App\Models\User::find(1);
    \App::setLocale($user->lang);
    $menus = \App\Models\Page::where('enabled', 1)->get();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $page->title }} - {{ !empty($settings['app_name']) ? $settings['app_name'] : env('APP_NAME') }}</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="{{ !empty($settings['app_name']) ? $settings['app_name'] : env('APP_NAME') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="title" content="{{ $settings['meta_seo_title'] }}">
    <meta name="keywords" content="{{ $settings['meta_seo_keyword'] }}">
    <meta name="description" content="{{ $settings['meta_seo_description'] }}">

    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ env('APP_URL') }}">
    <meta property="og:title" content="{{ $settings['meta_seo_title'] }}">
    <meta property="og:description" content="{{ $settings['meta_seo_description'] }}">
    <meta property="og:image" content="{{ asset(Storage::url('upload/seo')) . '/' . $settings['meta_seo_image'] }}">

    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ env('APP_URL') }}">
    <meta property="twitter:title" content="{{ $settings['meta_seo_title'] }}">
    <meta property="twitter:description" content="{{ $settings['meta_seo_description'] }}">
    <meta property="twitter:image"
        content="{{ asset(Storage::url('upload/seo')) . '/' . $settings['meta_seo_image'] }}">

    <link rel="icon" href="{{ asset(Storage::url('upload/logo')) . '/' . $settings['company_favicon'] }}"
        type="image/x-icon" />
    <link href="{{ asset('assets/css/plugins/animate.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/phosphor/duotone/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('assets/css/style-preset.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">

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
            --page-primary: #D9A441;
            --page-primary-light: rgba(217, 164, 65, 0.15);
            --page-primary-dark: #F4C861;
            --page-text: #FFFFFF;
            --page-text-muted: #8FA1B5;
            --page-bg: #03111F;
            --page-card-bg: #0B2239;
            --page-border: #29435D;
        }

        * { box-sizing: border-box; }

        body.policy-page {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
            background: var(--page-bg);
            color: #D8E0E8;
            -webkit-font-smoothing: antialiased;
        }

        /* ── Navbar ── */
        .policy-navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            background: rgba(3, 17, 31, 0.92);
            backdrop-filter: blur(16px);
            -webkit-backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--card-border);
            box-shadow: 0 4px 25px rgba(0, 0, 0, 0.5);
            padding: 0 0;
            transition: all 0.3s ease;
        }
        .policy-navbar .navbar-inner {
            max-width: 1200px;
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
            color: #D8E0E8;
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            padding: 8px 16px;
            border-radius: 8px;
            transition: all 0.2s ease;
        }
        .policy-navbar .nav-links a:hover {
            background: var(--page-primary-light);
            color: var(--primary-light-gold);
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
            color: #FFFFFF !important;
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
        .policy-navbar .nav-toggle {
            display: none;
            background: none;
            border: none;
            cursor: pointer;
            padding: 8px;
        }
        .policy-navbar .nav-toggle span {
            display: block;
            width: 22px;
            height: 2px;
            background: var(--page-text);
            margin: 5px 0;
            border-radius: 2px;
            transition: 0.3s;
        }

        /* ── Hero Section ── */
        .policy-hero {
            position: relative;
            padding: 145px 24px 85px;
            text-align: center;
            overflow: hidden;
            background: linear-gradient(180deg, rgba(3, 17, 31, 0.95) 0%, rgba(11, 34, 57, 0.98) 100%);
            border-bottom: 1px solid var(--card-border);
        }
        .policy-hero::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -20%;
            width: 140%;
            height: 200%;
            background: radial-gradient(ellipse at 30% 50%, rgba(217, 164, 65, 0.12) 0%, transparent 60%);
            pointer-events: none;
        }
        .policy-hero .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: var(--gold-light-bg);
            border: 1px solid var(--gold-border);
            backdrop-filter: blur(10px);
            padding: 6px 18px;
            border-radius: 50px;
            font-size: 12.5px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--primary-light-gold);
            margin-bottom: 16px;
            animation: fadeInDown 0.6s ease;
        }
        .policy-hero .hero-badge i {
            font-size: 14px;
            color: rgba(255,255,255,0.7);
        }
        .policy-hero h1 {
            font-size: clamp(32px, 5vw, 52px);
            font-weight: 800;
            color: #fff;
            margin: 0 0 16px;
            letter-spacing: -0.02em;
            line-height: 1.15;
            animation: fadeInUp 0.6s ease;
        }
        .policy-hero .hero-subtitle {
            font-size: clamp(15px, 2vw, 18px);
            color: rgba(255,255,255,0.6);
            max-width: 560px;
            margin: 0 auto;
            line-height: 1.7;
            animation: fadeInUp 0.7s ease;
        }

        /* ── Content Layout ── */
        .policy-layout {
            max-width: 1200px;
            margin: -40px auto 0;
            padding: 0 24px 80px;
            position: relative;
            z-index: 10;
            display: grid;
            grid-template-columns: 260px 1fr;
            gap: 32px;
            align-items: start;
        }

        /* ── Sidebar ── */
        .policy-sidebar {
            position: sticky;
            top: 90px;
        }
        .policy-sidebar .sidebar-card {
            background: var(--page-card-bg);
            border-radius: 16px;
            border: 1px solid var(--page-border);
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.04);
        }
        .policy-sidebar .sidebar-card h4 {
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--page-text-muted);
            margin: 0 0 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--page-border);
        }
        .policy-sidebar .info-row {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 0;
            font-size: 13px;
            color: var(--page-text-muted);
        }
        .policy-sidebar .info-row i {
            font-size: 16px;
            color: var(--page-primary);
            width: 20px;
            text-align: center;
            flex-shrink: 0;
        }
        .policy-sidebar .info-row strong {
            color: var(--page-text);
            font-weight: 600;
        }
        .policy-sidebar .back-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 13px;
            font-weight: 600;
            color: var(--page-primary);
            text-decoration: none;
            margin-top: 20px;
            padding: 10px 16px;
            background: var(--page-primary-light);
            border-radius: 10px;
            width: 100%;
            justify-content: center;
            transition: all 0.2s ease;
        }
        .policy-sidebar .back-link:hover {
            background: var(--page-primary);
            color: #fff;
        }

        /* ── Main Content ── */
        .policy-content {
            background: var(--page-card-bg);
            border-radius: 20px;
            border: 1px solid var(--page-border);
            padding: 48px 56px;
            box-shadow: 0 1px 4px rgba(0,0,0,0.03), 0 8px 30px rgba(0,0,0,0.04);
            min-height: 400px;
        }
        .policy-content .ck-content,
        .policy-content .content-body {
            font-size: 15.5px;
            line-height: 1.85;
            color: #334155;
        }
        .policy-content h1, .policy-content h2, .policy-content h3,
        .policy-content h4, .policy-content h5, .policy-content h6 {
            color: var(--page-text);
            font-weight: 700;
            letter-spacing: -0.01em;
            margin-top: 2em;
            margin-bottom: 0.75em;
            line-height: 1.3;
        }
        .policy-content h1 { font-size: 28px; }
        .policy-content h2 {
            font-size: 22px;
            padding-bottom: 12px;
            border-bottom: 2px solid var(--page-primary-light);
        }
        .policy-content h3 { font-size: 18px; }
        .policy-content h4 { font-size: 16px; }
        .policy-content p { margin-bottom: 1.25em; }
        .policy-content ul, .policy-content ol {
            padding-left: 24px;
            margin-bottom: 1.25em;
        }
        .policy-content li {
            margin-bottom: 8px;
            padding-left: 4px;
        }
        .policy-content a {
            color: var(--page-primary);
            text-decoration: underline;
            text-underline-offset: 3px;
            font-weight: 500;
        }
        .policy-content a:hover {
            color: var(--page-primary-dark);
        }
        .policy-content blockquote {
            border-left: 4px solid var(--page-primary);
            background: var(--page-primary-light);
            padding: 16px 24px;
            margin: 1.5em 0;
            border-radius: 0 12px 12px 0;
            font-style: italic;
            color: var(--page-primary-dark);
        }
        .policy-content table {
            width: 100%;
            border-collapse: collapse;
            margin: 1.5em 0;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid var(--page-border);
        }
        .policy-content table th {
            background: var(--page-primary-light);
            font-weight: 600;
            text-align: left;
            padding: 12px 16px;
            font-size: 13px;
        }
        .policy-content table td {
            padding: 12px 16px;
            border-top: 1px solid var(--page-border);
            font-size: 14px;
        }
        .policy-content strong {
            color: var(--page-text);
            font-weight: 600;
        }
        .policy-content code {
            background: #f1f5f9;
            padding: 2px 8px;
            border-radius: 6px;
            font-size: 0.9em;
            color: #be185d;
        }
        .policy-content img {
            max-width: 100%;
            border-radius: 12px;
            margin: 1em 0;
        }

        /* ── Footer ── */
        .policy-footer {
            text-align: center;
            padding: 40px 24px;
            border-top: 1px solid var(--page-border);
            color: var(--page-text-muted);
            font-size: 13px;
        }
        .policy-footer a {
            color: var(--page-primary);
            text-decoration: none;
            font-weight: 500;
        }

        /* ── CKEditor Reset ── */
        .ck.ck-reset_all { display: none; }
        .ck .ck-widget:hover { outline-color: transparent; }
        .ck.ck-editor__main>.ck-editor__editable:not(.ck-focused) {
            border: 0; border-color: transparent; outline: 0;
        }
        .ck.ck-editor__main:focus-visible,
        .ck .ck-widget:hover { outline-color: transparent !important; }

        /* ── Animations ── */
        @keyframes fadeInUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeInDown {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-in {
            animation: fadeInUp 0.5s ease forwards;
        }

        /* ── Responsive ── */
        @media (max-width: 900px) {
            .policy-layout {
                grid-template-columns: 1fr;
                margin-top: -30px;
            }
            .policy-sidebar {
                position: static;
                order: -1;
            }
            .policy-content {
                padding: 32px 28px;
            }
        }
        @media (max-width: 640px) {
            .policy-hero { padding: 130px 20px 60px; }
            .policy-content { padding: 24px 20px; border-radius: 14px; }
            .policy-navbar .nav-links { display: none; }
            .policy-navbar .nav-toggle { display: block; }
            .policy-navbar .nav-links.active {
                display: flex;
                flex-direction: column;
                position: absolute;
                top: 100%;
                left: 0;
                right: 0;
                background: #fff;
                padding: 16px 24px;
                border-bottom: 1px solid var(--page-border);
                box-shadow: 0 8px 30px rgba(0,0,0,0.08);
            }
        }
    </style>
</head>

<body class="policy-page landing-page" data-pc-preset="{{ $settings['accent_color'] }}" data-pc-sidebar-theme="light"
    data-pc-sidebar-caption="{{ $settings['sidebar_caption'] }}" data-pc-direction="{{ $settings['theme_layout'] }}"
    data-pc-theme="{{ $settings['theme_mode'] }}">

    <!-- [ Pre-loader ] start -->
    <div class="loader-bg">
        <div class="loader-track">
            <div class="loader-fill"></div>
        </div>
    </div>
    <!-- [ Pre-loader ] End -->

    <!-- [ Navbar ] -->
    <nav class="policy-navbar">
        <div class="navbar-inner">
            <a class="brand-logo" href="{{ route('home') }}">
                <img src="{{ asset(Storage::url('upload/logo/logo.png')) }}" alt="logo" />
            </a>
            <button class="nav-toggle" onclick="document.querySelector('.nav-links').classList.toggle('active')">
                <span></span><span></span><span></span>
            </button>
            <ul class="nav-links">
                <li><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
                <li><a href="{{ route('about.us') }}">{{ __('About Us') }}</a></li>
                <li><a href="{{ route('privacy.policy') }}">{{ __('Privacy Policy') }}</a></li>
                <li><a href="{{ route('terms.conditions') }}">{{ __('Terms & Services') }}</a></li>
                <li><a href="{{ route('blog.index') }}">{{ __('Blog') }}</a></li>

                @php
                    $HomePage = App\Models\HomePage::where('section', 'Section 0')->first();
                @endphp
                @if (!empty($HomePage->content_value))
                    @php
                        $HomePageData = json_decode($HomePage->content_value, true);
                        $active_menus = !empty($HomePageData['menu_pages']) ? $HomePageData['menu_pages'] : [];
                    @endphp
                    @foreach ($menus as $menu)
                        @if (in_array($menu->id, $active_menus) && !in_array($menu->slug, ['about_us', 'privacy_policy', 'terms_conditions', 'delete_account']))
                            <li>
                                <a class="{{ !empty($routeParameters['slug']) && $menu->slug == $routeParameters['slug'] ? 'active' : '' }}"
                                   href="{{ route('page', $menu->slug) }}">{{ $menu->title }}</a>
                            </li>
                        @endif
                    @endforeach
                @endif
                <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                <li><a class="btn-cta" href="{{ route('register') }}">{{ __('Get Started') }}</a></li>
            </ul>
        </div>
    </nav>


    <!-- [ Hero ] -->
    <section class="policy-hero">
        <div class="hero-badge">
            <i class="ti ti-shield-check"></i>
            {{ __('Legal Document') }}
        </div>
        <h1>{{ $page->title }}</h1>
        <p class="hero-subtitle">
            {{ __('Please read this document carefully. Last updated on') }}
            {{ dateFormat($page->updated_at) }}.
        </p>
    </section>

    <!-- [ Content ] -->
    <div class="policy-layout">
        <!-- Sidebar -->
        <aside class="policy-sidebar animate-in">
            <div class="sidebar-card">
                <h4>{{ __('Document Info') }}</h4>
                <div class="info-row">
                    <i class="ti ti-calendar"></i>
                    <div>
                        <div style="font-size:11px;text-transform:uppercase;letter-spacing:0.05em;opacity:0.7;">{{ __('Last Updated') }}</div>
                        <strong>{{ dateFormat($page->updated_at) }}</strong>
                    </div>
                </div>
                <div class="info-row">
                    <i class="ti ti-building"></i>
                    <div>
                        <div style="font-size:11px;text-transform:uppercase;letter-spacing:0.05em;opacity:0.7;">{{ __('Company') }}</div>
                        <strong>{{ $settings['company_name'] ?? env('APP_NAME') }}</strong>
                    </div>
                </div>
                @if(!empty($settings['company_email']))
                <div class="info-row">
                    <i class="ti ti-mail"></i>
                    <div>
                        <div style="font-size:11px;text-transform:uppercase;letter-spacing:0.05em;opacity:0.7;">{{ __('Contact') }}</div>
                        <strong style="font-size:12px;">{{ $settings['company_email'] }}</strong>
                    </div>
                </div>
                @endif
            </div>
            <a href="{{ route('home') }}" class="back-link">
                <i class="ti ti-arrow-left"></i>
                {{ __('Back to Home') }}
            </a>
        </aside>

        <!-- Main Content -->
        <main class="policy-content animate-in" style="animation-delay: 0.1s;">
            <div class="content-body">
                {!! $page->content !!}
            </div>
        </main>
    </div>

    <!-- [ Footer ] -->
    <footer class="policy-footer">
        <p>&copy; {{ date('Y') }} {{ $settings['company_name'] ?? env('APP_NAME') }}. {{ __('All rights reserved.') }}
            &nbsp;·&nbsp;
            <a href="{{ route('home') }}">{{ __('Home') }}</a>
        </p>
    </footer>

    <!-- Required Js -->
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/ckeditor/classic/ckeditor.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>
    <script>
        // Smooth scroll reveal
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                }
            });
        }, { threshold: 0.1 });

        document.querySelectorAll('.animate-in').forEach(el => {
            observer.observe(el);
        });
    </script>
</body>

</html>
