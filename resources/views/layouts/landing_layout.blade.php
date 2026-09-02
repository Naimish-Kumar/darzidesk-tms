@php
    $profile = asset(Storage::url('upload/profile'));
    $settings = settings();
    $copyright = getSettingsValByName('copyright');
    $user = \App\Models\User::find(1);
    if($user) {
        \App::setLocale($user->lang);
    }
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=AW-18210513455"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'AW-18210513455');
    </script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }} - @yield('page-title')</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="author" content="{{ !empty($settings['app_name']) ? $settings['app_name'] : env('APP_NAME') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="title" content="{{ $settings['meta_seo_title'] ?? 'DarziDesk - Tailor & Boutique Management System' }}">
    <meta name="keywords" content="{{ $settings['meta_seo_keyword'] ?? 'tailor software, darzi software, boutique management system, bespoke tailoring app, garment measurement software, POS tailoring' }}">
    <meta name="description" content="{{ $settings['meta_seo_description'] ?? 'DarziDesk is the ultimate enterprise Tailor Management System (TMS) for bespoke ateliers, custom fashion designers, suit makers, and alteration studios.' }}">

    <!-- Canonical URL -->
    <link rel="canonical" href="{{ url()->current() }}">

    <!-- OpenGraph Social Tags -->
    <meta property="og:type" content="website">
    <meta property="og:site_name" content="DarziDesk TMS">
    <meta property="og:locale" content="en_US">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="{{ $settings['meta_seo_title'] ?? 'DarziDesk - Tailor & Boutique Management System' }}">
    <meta property="og:description" content="{{ $settings['meta_seo_description'] ?? 'Streamline bespoke tailoring operations with digital garment measurement vault, production kanban, fabric stock ledger, POS billing, and SMS/WhatsApp notifications.' }}">
    <meta property="og:image" content="{{ asset(Storage::url('upload/seo')) . '/' . ($settings['meta_seo_image'] ?? '') }}">

    <!-- Twitter Card Meta Tags -->
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="{{ $settings['meta_seo_title'] ?? 'DarziDesk - Tailor & Boutique Management System' }}">
    <meta name="twitter:description" content="{{ $settings['meta_seo_description'] ?? 'All-in-one Tailor Management System (TMS) for bespoke ateliers, custom fashion designers, and garment alterations studios.' }}">
    <meta name="twitter:image" content="{{ asset(Storage::url('upload/seo')) . '/' . ($settings['meta_seo_image'] ?? '') }}">

    <!-- Schema.org JSON-LD Structured Data -->
    <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "SoftwareApplication",
      "name": "DarziDesk TMS",
      "operatingSystem": "Web, Android, iOS",
      "applicationCategory": "BusinessApplication",
      "aggregateRating": {
        "@type": "AggregateRating",
        "ratingValue": "4.9",
        "ratingCount": "1250"
      },
      "offers": {
        "@type": "Offer",
        "price": "0.00",
        "priceCurrency": "USD"
      },
      "description": "DarziDesk is an enterprise Tailor Management System (TMS) for bespoke ateliers, custom fashion designers, suit makers, and alteration studios."
    }
    </script>

    <link rel="icon" href="{{ asset(Storage::url('upload/logo')) . '/' . ($settings['company_favicon'] ?? '') }}"
        type="image/x-icon" />
    <link href="{{ asset('assets/css/plugins/animate.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/css/plugins/swiper-bundle.css') }}" rel="stylesheet" />
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap"
        id="main-font-link" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/phosphor/duotone/style.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/feather.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/material.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/owl.carousel.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" id="main-style-link" />
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}" />
    <link href="{{ asset('css/custom.css') }}?v={{ file_exists(public_path('css/custom.css')) ? filemtime(public_path('css/custom.css')) : time() }}" rel="stylesheet">
    @stack('css')
</head>

<body class="landing-page"
    data-pc-preset="{{ !empty($settings['accent_color']) ? $settings['accent_color'] : 'preset-1' }}"
    data-pc-sidebar-theme="light" data-pc-sidebar-caption="true"
    data-pc-direction="ltr" data-pc-theme="light">


    <nav class="navbar navbar-expand-md navbar-light default">
        <div class="container">
            <a class="navbar-brand landing-logo" href="{{ route('home') }}">
                <img src="{{ asset(Storage::url('upload/logo/landing_logo.png')) }}" alt="logo"
                    class="img-fluid " />
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link active" href="{{ route('home') }}#home">{{ __('Home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#pricing">{{ __('Pricing') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#features">{{ __('Features') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('about.us') }}">{{ __('About Us') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('privacy.policy') }}">{{ __('Privacy Policy') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('terms.conditions') }}">{{ __('Terms & Services') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link me-2" href="{{ route('login') }}">{{ __('Login') }}</a>
                    </li>

                    <li class="nav-item">
                        <a class="btn btn-secondary" href="{{ route('register') }}">
                            {{ __('Get Started') }}
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="main-content">
        @yield('content')
    </div>

    <!-- Footer -->
    <footer class="footer bg-dark py-4 text-white">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center text-md-start mb-2 mb-md-0">
                    <p class="mb-0 text-white-50">{{ $copyright ?? '© ' . date('Y') . ' DarziDesk. All rights reserved.' }}</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="{{ route('about.us') }}" class="text-white-50 me-3 text-decoration-none small">{{ __('About Us') }}</a>
                    <a href="{{ route('privacy.policy') }}" class="text-white-50 me-3 text-decoration-none small">{{ __('Privacy Policy') }}</a>
                    <a href="{{ route('terms.conditions') }}" class="text-white-50 text-decoration-none small">{{ __('Terms & Services') }}</a>
                </div>
            </div>
        </div>
    </footer>


    <script src="{{ asset('assets/js/plugins/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/swiper-bundle.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/owl.carousel.min.js') }}"></script>
    <script src="{{ asset('assets/js/landing.js') }}"></script>
    @stack('scripts')
</body>
</html>
