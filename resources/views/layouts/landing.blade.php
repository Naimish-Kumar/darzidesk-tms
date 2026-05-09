@php
    $profile = asset(Storage::url('upload/profile'));
    $settings = settings();
    $copyright = getSettingsValByName('copyright');
    $user = \App\Models\User::find(1);
    \App::setLocale($user->lang);
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }}</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />

    <meta name="author" content="{{ !empty($settings['app_name']) ? $settings['app_name'] : env('APP_NAME') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ !empty($settings['app_name']) ? $settings['app_name'] : env('APP_NAME') }} - @yield('page-title') </title>

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
    @if (!empty($settings['custom_color']) && $settings['color_type'] == 'custom')
        <link rel="stylesheet" id="Pstylesheet" href="{{ asset('assets/css/custom-color.css') }}" />
        <script src="{{ asset('js/theme-pre-color.js') }}"></script>
    @else
        <link rel="stylesheet" id="Pstylesheet" href="{{ asset('assets/css/style-preset.css') }}" />
    @endif
    <link rel="stylesheet" href="{{ asset('assets/css/landing.css') }}" />
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
</head>

<body class="landing-page"
    data-pc-preset="{{ !empty($settings['color_type']) && $settings['color_type'] == 'custom' ? 'custom' : $settings['accent_color'] }}"
    data-pc-sidebar-theme="light" data-pc-sidebar-caption="{{ $settings['sidebar_caption'] }}"
    data-pc-direction="{{ $settings['theme_layout'] }}" data-pc-theme="{{ $settings['theme_mode'] }}">


    <nav class="navbar navbar-expand-md navbar-light default">
        <div class="container">
            <a class="navbar-brand landing-logo" href="#">
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
                        <a class="nav-link active" href="#home">{{ __('Home') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#pricing">{{ __('Pricing') }}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#features">{{ __('Features') }}</a>
                    </li>
                    @php
                        $HomePage = App\Models\HomePage::where('section', 'Section 0')->first();
                    @endphp
                    @if (!empty($HomePage->content_value))
                        @php
                            $HomePage = json_decode($HomePage->content_value, true);
                            $active_menus = !empty($HomePage['menu_pages']) ? $HomePage['menu_pages'] : [];
                        @endphp
                        @foreach ($menus as $menu)
                            @if (in_array($menu->id, $active_menus))
                                <li class="nav-item">
                                    <a class="nav-link mb-2"
                                        href="{{ route('page', $menu->slug) }}">{{ $menu->title }}</a>
                                </li>
                            @endif
                        @endforeach
                    @endif
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('blog.index') }}">{{ __('Blog') }}</a>
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
    <!-- [ Nav ] start -->
    <!-- [ Header ] start -->
    @php
        $Section_1 = App\Models\HomePage::where('section', 'Section 1')->first();
        $Section_1_content_value = !empty($Section_1->content_value)
            ? json_decode($Section_1->content_value, true)
            : [];
    @endphp
    @if (empty($Section_1_content_value['section_enabled']) || $Section_1_content_value['section_enabled'] == 'active')
        <header id="home">
            <div class="container">
                <div class="row align-items-center justify-content-between">
                    <div class="col-lg-6 col-xl-6">
                        <h1 class="mt-sm-3 mb-sm-4 f-w-600 wow fadeInUp" data-wow-delay="0.2s">
                            @if (!empty($Section_1_content_value['title']))
                                {{ $Section_1_content_value['title'] }}
                            @else
                                {{ __('DarziDesk - Premium Tailoring Management Software') }}
                            @endif
                        </h1>
                        <h4 class="mb-sm-4 text-muted wow fadeInUp" data-wow-delay="0.4s">
                            @if (!empty($Section_1_content_value['sub_title']))
                                {{ $Section_1_content_value['sub_title'] }}
                            @else
                                {{ __('DarziDesk helps boutiques and tailors manage orders, measurements, and staff with ease. Streamline your tailoring business today with our digital solution.') }}
                            @endif
                        </h4>
                        @php
                            $Section_1_btn_link = !empty($Section_1_content_value['btn_link'])
                                ? $Section_1_content_value['btn_link']
                                : '#';
                        @endphp
                        <div class="my-3 my-xl-5 wow fadeInUp" data-wow-delay="0.6s">
                            @php
                                $sec1_url = $Section_1_btn_link;
                                if (in_array($Section_1_btn_link, ['#', ''])) {
                                    $sec1_url = route('register');
                                }
                            @endphp
                            <a href="{{ $sec1_url }}" class="btn btn-secondary me-2">
                                @if (!empty($Section_1_content_value['btn_name']))
                                    {{ $Section_1_content_value['btn_name'] }}
                                @else
                                    {{ __('Get Started') }}
                                @endif
                            </a>

                        </div>
                        <div class="mb-4 mb-lg-0 d-inline-flex align-items-center wow fadeInUp" data-wow-delay="0.8s">
                            <div class="flex-shrink-0">
                                <div class="avtar avtar-l bg-light-secondary text-secondary">
                                    @if (!empty($Section_1_content_value['section_footer_image_path']))
                                        <img src="{{ asset(Storage::url($Section_1_content_value['section_footer_image_path'])) }}"
                                            alt="user-image" class="img-fluid wid-80" />
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" width="40" height="32"
                                            class="d-block" viewBox="0 0 118 94" role="img">
                                            <path fill-rule="evenodd" clip-rule="evenodd"
                                                d="M24.509 0c-6.733 0-11.715 5.893-11.492 12.284.214 6.14-.064 14.092-2.066 20.577C8.943 39.365 5.547 43.485 0 44.014v5.972c5.547.529 8.943 4.649 10.951 11.153 2.002 6.485 2.28 14.437 2.066 20.577C12.794 88.106 17.776 94 24.51 94H93.5c6.733 0 11.714-5.893 11.491-12.284-.214-6.14.064-14.092 2.066-20.577 2.009-6.504 5.396-10.624 10.943-11.153v-5.972c-5.547-.529-8.934-4.649-10.943-11.153-2.002-6.484-2.28-14.437-2.066-20.577C105.214 5.894 100.233 0 93.5 0H24.508zM80 57.863C80 66.663 73.436 72 62.543 72H44a2 2 0 01-2-2V24a2 2 0 012-2h18.437c9.083 0 15.044 4.92 15.044 12.474 0 5.302-4.01 10.049-9.119 10.88v.277C75.317 46.394 80 51.21 80 57.863zM60.521 28.34H49.948v14.934h8.905c6.884 0 10.68-2.772 10.68-7.727 0-4.643-3.264-7.207-9.012-7.207zM49.948 49.2v16.458H60.91c7.167 0 10.964-2.876 10.964-8.281 0-5.406-3.903-8.178-11.425-8.178H49.948z"
                                                fill="currentColor"></path>
                                        </svg>
                                    @endif
                                </div>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h5 class="mb-0 text-start">
                                    @if (!empty($Section_1_content_value['section_footer_text']))
                                        {{ $Section_1_content_value['section_footer_text'] }}
                                    @else
                                        {{ __('Manage your business efficiently with our all-in-one solution designed for
                                                                                performance, security, and scalability.') }}
                                    @endif
                                </h5>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="hero-image">
                            @if (!empty($Section_1_content_value['section_main_image_path']))
                                <img src="{{ asset(Storage::url($Section_1_content_value['section_main_image_path'])) }}"
                                    alt="user-image" class="img-fluid" />
                            @else
                                <img src="assets/images/landing/img-header-main.svg" alt="image"
                                    class="img-fluid img-bg wow fadeInUp" data-wow-delay="0.5s" />
                                <div class="img-widget-1">
                                    <img src="assets/images/landing/img-widget-1.svg" alt="image"
                                        class="img-fluid wow fadeInDown" data-wow-delay="0.6s" />
                                </div>
                                <div class="img-widget-2">
                                    <img src="assets/images/landing/img-widget-2.svg" alt="image"
                                        class="img-fluid wow fadeInDown" data-wow-delay="0.7s" />
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </header>
    @endif
    <!-- [ Header ] End -->
    <!-- [ section ] start -->
    @php
        $Section_2 = App\Models\HomePage::where('section', 'Section 2')->first();
        $Section_2_content_value = !empty($Section_2->content_value)
            ? json_decode($Section_2->content_value, true)
            : [];
    @endphp
    @if (empty($Section_2_content_value['section_enabled']) || $Section_2_content_value['section_enabled'] == 'active')
        <section>
            <div class="container">
                <div class="row g-4">
                    <div class="col-md-6 col-lg-4">
                        <div class="card feature-card mb-0 bg-secondary">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-l">
                                            <img src="{{ !empty($Section_2_content_value['box_image_1_path']) ? asset(Storage::url($Section_2_content_value['box_image_1_path'])) : 'assets/images/landing/img-feature-1.svg' }}"
                                                alt="img" class="img-fluid" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3 text-end">
                                        <span
                                            class="h1 mb-0 d-block fw-semibold">{{ !empty($Section_2_content_value['Box1_number']) ? $Section_2_content_value['Box1_number'] : '500+' }}</span>
                                        <span
                                            class="h5 mb-0 d-block">{{ !empty($Section_2_content_value['Box1_title']) ? $Section_2_content_value['Box1_title'] : 'Customers' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card feature-card mb-0 bg-blue-200">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-l">
                                            <img src="{{ !empty($Section_2_content_value['box_image_2_path']) ? asset(Storage::url($Section_2_content_value['box_image_2_path'])) : 'assets/images/landing/img-feature-2.svg' }}"
                                                alt="img" class="img-fluid" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3 text-end">
                                        <span
                                            class="h1 mb-0 d-block fw-semibold">{{ !empty($Section_2_content_value['Box2_number']) ? $Section_2_content_value['Box2_number'] : '4+' }}</span>
                                        <span
                                            class="h5 mb-0 d-block">{{ !empty($Section_2_content_value['Box2_title']) ? $Section_2_content_value['Box2_title'] : 'Subscription Plan' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 col-lg-4">
                        <div class="card feature-card mb-0 bg-purple-200">
                            <div class="card-body">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <div class="avtar avtar-l">
                                            <img src="{{ !empty($Section_2_content_value['box_image_3_path']) ? asset(Storage::url($Section_2_content_value['box_image_3_path'])) : 'assets/images/landing/img-feature-3.svg' }}"
                                                alt="img" class="img-fluid" />
                                        </div>
                                    </div>
                                    <div class="flex-grow-1 ms-3 text-end">
                                        <span
                                            class="h1 mb-0 d-block fw-semibold">{{ !empty($Section_2_content_value['Box3_number']) ? $Section_2_content_value['Box3_number'] : '11+' }}</span>
                                        <span
                                            class="h5 mb-0 d-block">{{ !empty($Section_2_content_value['Box3_title']) ? $Section_2_content_value['Box3_title'] : 'Language' }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- [ section ] End -->
    <!-- [ section ] start -->
    @php
        $Section_3 = App\Models\HomePage::where('section', 'Section 3')->first();
        $Section_3_content_value = !empty($Section_3->content_value)
            ? json_decode($Section_3->content_value, true)
            : [];
    @endphp
    @if (empty($Section_3_content_value['section_enabled']) || $Section_3_content_value['section_enabled'] == 'active')
        <section class="bg-body">
            <div class="container">
                @for ($is3 = 1; $is3 <= 2; $is3++)
                    <div class="row align-items-center g-4">
                        @if ($is3 % 2 != 0)
                            <div class="col-md-6 text-center mb-md-5">
                                @if (!empty($Section_3_content_value['Box' . $is3 . '_image_path']))
                                    <img src="{{ asset(Storage::url($Section_3_content_value['Box' . $is3 . '_image_path'])) }}"
                                        alt="img" class="img-fluid w-75" />
                                @else
                                    <img src="{{ asset('storage/homepage/img-customize-1.svg') }}"
                                        alt="Customize Image" class="img-fluid w-75">
                                @endif
                            </div>
                        @endif
                        <div class="col-md-6">
                            <h2 class="h1">
                                {{ !empty($Section_3_content_value['Box' . $is3 . '_title']) ? $Section_3_content_value['Box' . $is3 . '_title'] : 'Empower Your Business to Thrive with Us' }}
                            </h2>
                            <p class="text-lg w-75 my-3 my-md-4">
                                {{ !empty($Section_3_content_value['Box' . $is3 . '_title']) ? $Section_3_content_value['Box' . $is3 . '_info'] : 'Unlock growth, streamline operations, and achieve success with our innovative solutions.' }}
                            </p>
                            <ul class="list-unstyled customize-list">
                                @if (!empty($Section_3_content_value['Box' . $is3 . '_list']))
                                    @foreach ($Section_3_content_value['Box' . $is3 . '_list'] as $box_item)
                                        <li><i class="ti ti-circle-check f-20 text-secondary"></i> {{ $box_item }}
                                        </li>
                                    @endforeach
                                @else
                                    <li>
                                        <i class="ti ti-circle-check f-20 text-secondary"></i>
                                        {{ __('Simplify and automate your business processes for maximum efficiency.') }}
                                    </li>
                                    <li>
                                        <i class="ti ti-circle-check f-20 text-secondary"></i>
                                        {{ __('Receive tailored strategies to meet business needs and unlock potential.') }}
                                    </li>
                                    <li>
                                        <i class="ti ti-circle-check f-20 text-secondary"></i>
                                        {{ __('Grow confidently with flexible solutions that adapt to your business needs.') }}
                                    </li>
                                    <li>
                                        <i class="ti ti-circle-check f-20 text-secondary"></i>
                                        {{ __('Make smarter decisions with real-time analytics and performance tracking.') }}
                                    </li>
                                    <li>
                                        <i class="ti ti-circle-check f-20 text-secondary"></i>
                                        {{ __(' Rely on 24/7 expert assistance to keep your business running smoothly.') }}
                                    </li>
                                @endif
                            </ul>
                        </div>
                        @if ($is3 % 2 == 0)
                            <div class="col-md-6 text-center mb-md-5">
                                @if (!empty($Section_3_content_value['Box' . $is3 . '_image_path']))
                                    <img src="{{ asset(Storage::url($Section_3_content_value['Box' . $is3 . '_image_path'])) }}"
                                        alt="img" class="img-fluid w-75" />
                                @else
                                    <img src="{{ asset('storage/homepage/img-customize-2.svg') }}"
                                        alt="Customize Image" class="img-fluid w-75">
                                @endif
                            </div>
                        @endif
                    </div>
                @endfor
            </div>
        </section>
    @endif
    <!-- [ section ] End -->
    <!-- [ section ] start -->
    @php
        $Section_4 = App\Models\HomePage::where('section', 'Section 4')->first();
        $Section_4_content_value = !empty($Section_4->content_value)
            ? json_decode($Section_4->content_value, true)
            : [];
    @endphp
    @if (empty($Section_4_content_value['section_enabled']) || $Section_4_content_value['section_enabled'] == 'active')
        <section>
            <div class="container">
                <div class="row justify-content-center title">
                    <div class="col-md-9 col-lg-6 text-center">
                        <h2 class="h1">
                            {{ !empty($Section_4_content_value['Sec4_title']) ? $Section_4_content_value['Sec4_title'] : 'What does Smartweb offer?' }}
                        </h2>
                        <p class="text-lg">
                            {{ !empty($Section_4_content_value['Sec4_info']) ? $Section_4_content_value['Sec4_info'] : 'Smartweb is a reliable choice for your admin panel needs, offering a wide range of features to easily manage your backend panel' }}
                        </p>
                    </div>
                </div>
                <div class="row g-4 text-center">
                    @php
                        $is4_check = 0;
                    @endphp
                    @for ($is4 = 1; $is4 <= 6; $is4++)
                        @if (
                            !empty($Section_4_content_value['Sec4_box' . $is4 . '_enabled']) &&
                                $Section_4_content_value['Sec4_box' . $is4 . '_enabled'] == 'active')
                            @php
                                $is4_check++;
                            @endphp
                            <div class="col-md-6 col-xl-4">
                                @if (!empty($Section_4_content_value['Sec4_box' . $is4 . '_image_path']))
                                    <img src="{{ asset(Storage::url($Section_4_content_value['Sec4_box' . $is4 . '_image_path'])) }}"
                                        alt="img" class="img-fluid" />
                                @else
                                    <img src="assets/images/landing/img-design-1.svg" alt="img"
                                        class="img-fluid" />
                                @endif
                                <h3 class="my-4 fw-semibold">
                                    {{ !empty($Section_4_content_value['Sec4_box' . $is4 . '_title']) ? $Section_4_content_value['Sec4_box' . $is4 . '_title'] : 'What Our Software Offers' }}
                                </h3>
                                <p>
                                    {{ !empty($Section_4_content_value['Sec4_box' . $is4 . '_info']) ? $Section_4_content_value['Sec4_box' . $is4 . '_info'] : 'Our software provides powerful, scalable solutions designed to streamline your business operations.' }}
                                </p>
                            </div>
                        @endif
                    @endfor

                    @if ($is4_check == 0)
                        <div class="col-md-6 col-xl-4">
                            <img src="assets/images/landing/img-design-1.svg" alt="img" class="img-fluid" />
                            <h3 class="my-4 fw-semibold">{{ __('User-Friendly Interface') }}</h3>
                            <p>
                                {{ __('Simplify operations with an intuitive and easy-to-use platform.') }}
                            </p>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <img src="assets/images/landing/img-design-2.svg" alt="img" class="img-fluid" />
                            <h3 class="my-4 fw-semibold">{{ __('End-to-End Automation') }}</h3>
                            <p>
                                {{ __('Automate repetitive tasks to save time and increase efficiency.') }}
                            </p>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <img src="assets/images/landing/img-design-3.svg" alt="img" class="img-fluid" />
                            <h3 class="my-4 fw-semibold">Customizable Solutions</h3>
                            <p>
                                {{ __('Tailor features to fit your unique business needs and workflows.') }}
                            </p>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <img src="assets/images/landing/img-design-4.svg" alt="img" class="img-fluid" />
                            <h3 class="my-4 fw-semibold">Scalable Features</h3>
                            <p>
                                {{ __('Grow your business with flexible solutions that scale with you.') }}
                            </p>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <img src="assets/images/landing/img-design-5.svg" alt="img" class="img-fluid" />
                            <h3 class="my-4 fw-semibold">{{ __('Enhanced Security') }}</h3>
                            <p>
                                {{ __('Protect your data with advanced encryption and security protocols.') }}
                            </p>
                        </div>
                        <div class="col-md-6 col-xl-4">
                            <img src="assets/images/landing/img-design-6.svg" alt="img" class="img-fluid" />
                            <h3 class="my-4 fw-semibold">{{ __('Real-Time Analytics') }}</h3>
                            <p>
                                {{ __('Gain actionable insights with live data tracking and reporting.') }}
                            </p>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif

    <!-- [ section ] End -->
    @php
        $Section_5 = App\Models\HomePage::where('section', 'Section 5')->first();
        $Section_5_content_value = !empty($Section_5->content_value)
            ? json_decode($Section_5->content_value, true)
            : [];
    @endphp
    @if ($settings['pricing_feature'] == 'on')
        @if (empty($Section_5_content_value['section_enabled']) || $Section_5_content_value['section_enabled'] == 'active')
            <section class="bg-body pricingpricing" id="pricing" style="padding: 100px 0; background: linear-gradient(180deg, rgba(255,255,255,0) 0%, rgba(var(--primary-rgb), 0.03) 100%);">
                <div class="container">
                    <div class="row justify-content-center title mb-5">
                        <div class="col-md-9 col-lg-6 text-center">
                            <span class="badge bg-light-primary text-primary text-uppercase fw-bold px-3 py-2 mb-3" style="letter-spacing: 1px;">{{ __('Pricing Plans') }}</span>
                            <h2 class="h1 fw-bold mb-3">
                                {{ !empty($Section_5_content_value['Sec5_title']) ? $Section_5_content_value['Sec5_title'] : __('Flexible Pricing for Everyone') }}
                            </h2>
                            <p class="text-muted text-lg">
                                {{ !empty($Section_5_content_value['Sec5_info']) ? $Section_5_content_value['Sec5_info'] : __('Choose a plan that fits your business needs. Transparent pricing with no hidden fees.') }}
                            </p>
                        </div>
                    </div>
                    <div class="row g-4 justify-content-center">
                        @foreach ($subscriptions as $subscription)
                            <div class="col-md-6 col-lg-4">
                                <div class="card pricing-card h-100 border-0 shadow-lg" style="border-radius: 24px; transition: transform 0.3s ease; overflow: hidden;">
                                    <div class="card-body p-5">
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <h3 class="fw-bold mb-0">{{ $subscription->title }}</h3>
                                            @if($loop->iteration == 2)
                                                <span class="badge bg-primary text-white px-3 py-2 rounded-pill small">{{ __('Popular') }}</span>
                                            @endif
                                        </div>
                                        
                                        <div class="mb-4">
                                            <div class="d-flex align-items-baseline flex-wrap">
                                                <h2 class="display-5 fw-bold text-primary mb-0">{{ dynamicPrice($subscription->package_amount) }}</h2>
                                                <span class="text-muted ms-2">/ {{ ucfirst($subscription->interval) }}</span>
                                            </div>
                                            @if(session('geo_location') && session('geo_location')['currency'] != (subscriptionPaymentSettings()['CURRENCY'] ?? 'USD'))
                                                <small class="text-muted d-block mt-1" style="font-size: 0.85rem;">(≈ {{ priceFormat($subscription->package_amount) }})</small>
                                            @endif
                                        </div>

                                        <p class="text-muted mb-4 small">{{ __('Unlock advanced features to scale your business efficiency.') }}</p>

                                        <ul class="list-unstyled mb-5">
                                            <li class="mb-3 d-flex align-items-center">
                                                <i class="ti ti-circle-check text-primary f-20 me-2"></i>
                                                <span><strong>{{ $subscription->user_limit }}</strong> {{ __('User Limit') }}</span>
                                            </li>
                                            <li class="mb-3 d-flex align-items-center">
                                                <i class="ti ti-circle-check text-primary f-20 me-2"></i>
                                                <span><strong>{{ $subscription->customer_limit }}</strong> {{ __('Customer Limit') }}</span>
                                            </li>
                                            <li class="mb-3 d-flex align-items-center">
                                                <i class="ti ti-circle-check text-primary f-20 me-2"></i>
                                                <span><strong>{{ $subscription->cloth_type_limit }}</strong> {{ __('Cloth Type Limit') }}</span>
                                            </li>
                                            <li class="mb-3 d-flex align-items-center {{ $subscription->enabled_logged_history ? '' : 'text-muted opacity-50' }}">
                                                <i class="ti {{ $subscription->enabled_logged_history ? 'ti-circle-check text-primary' : 'ti-circle-x text-danger' }} f-20 me-2"></i>
                                                <span class="{{ $subscription->enabled_logged_history ? '' : 'text-decoration-line-through' }}">{{ __('Logged History') }}</span>
                                            </li>
                                            <li class="mb-0 d-flex align-items-center {{ $subscription->couponCheck() > 0 ? '' : 'text-muted opacity-50' }}">
                                                <i class="ti {{ $subscription->couponCheck() > 0 ? 'ti-circle-check text-primary' : 'ti-circle-x text-danger' }} f-20 me-2"></i>
                                                <span class="{{ $subscription->couponCheck() > 0 ? '' : 'text-decoration-line-through' }}">{{ __('Coupons Support') }}</span>
                                            </li>
                                        </ul>

                                        <a class="btn {{ $loop->iteration == 2 ? 'btn-primary' : 'btn-outline-primary' }} w-100 py-3 fw-bold rounded-pill shadow-sm"
                                            href="{{ route('register') }}">
                                            {{ __('Get Started Now') }} <i class="ti ti-arrow-right ms-2"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </section>
        @endif
    @endif
    <!-- [ section ] start -->

    @php
        $Section_6 = App\Models\HomePage::where('section', 'Section 6')->first();
        $Section_6_content_value = !empty($Section_6->content_value)
            ? json_decode($Section_6->content_value, true)
            : [];
    @endphp
    @if (empty($Section_6_content_value['section_enabled']) || $Section_6_content_value['section_enabled'] == 'active')
        <section class="application-slider" id="features">
            <div class="container">
                <div class="row justify-content-center title">
                    <div class="col-md-9 col-lg-6 text-center">
                        <h2 class="h1">
                            {{ !empty($Section_6_content_value['Sec6_title']) ? $Section_6_content_value['Sec6_title'] : 'Explore Concenputal Apps' }}
                        </h2>
                        <p class="text-lg">
                            {{ !empty($Section_6_content_value['Sec6_info']) ? $Section_6_content_value['Sec6_info'] : 'Smartweb has conceptul working apps like Chat, Inbox, E-commerce, Invoice, Kanban, and Calendar' }}
                        </p>
                    </div>
                </div>
                <div class="row text-center justify-content-center">
                    <div class="col-11 col-md-9 col-lg-7 position-relative">
                        <div class="swiper app-slider">
                            <div class="swiper-wrapper">
                                @if (!empty($Section_6_content_value['Sec6_Box_title']))
                                    @foreach ($Section_6_content_value['Sec6_Box_title'] as $s6_key => $s6_item)
                                        <div class="swiper-slide">
                                            @if (!empty($Section_6_content_value['Sec6_box' . $s6_key . '_image_path']))
                                                <img src="{{ asset(Storage::url($Section_6_content_value['Sec6_box' . $s6_key . '_image_path'])) }}"
                                                    alt="img" class="img-fluid" />
                                            @else
                                                <img src="assets/images/landing/slider-light-1.png" alt="images"
                                                    class="img-fluid" />
                                            @endif
                                            <h3> {{ $s6_item }} <i class="ti ti-link"></i> </h3>
                                            <p>{{ $Section_6_content_value['Sec6_Box_subtitle'][$s6_key] }}</p>
                                        </div>
                                    @endforeach
                                @else
                                    <div class="swiper-slide">
                                        <img src="assets/images/landing/slider-light-1.png" alt="images"
                                            class="img-fluid" />
                                        <h3>
                                            {{ __('Social Profile') }}
                                            <i class="ti ti-link"></i>
                                        </h3>
                                        <p>{{ __('Complete Social profile with all possible option') }}</p>
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="assets/images/landing/slider-light-2.png" alt="images"
                                            class="img-fluid" />
                                        <h3>
                                            {{ __('Mail/Message App') }}
                                            <i class="ti ti-link"></i>
                                        </h3>
                                        <p>{{ __('Complete Mail/Message App with all possible option') }}</p>
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="assets/images/landing/slider-light-3.png" alt="images"
                                            class="img-fluid" />
                                        <h3>
                                            {{ __('Mail/Message App') }}
                                            <i class="ti ti-link"></i>
                                        </h3>
                                        <p>{{ __('Complete Chat App with all possible option') }}</p>
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="assets/images/landing/slider-light-4.png" alt="images"
                                            class="img-fluid" />
                                        <h3>
                                            {{ __('Kanban App') }}
                                            <i class="ti ti-link"></i>
                                        </h3>
                                        <p>{{ __('Complete Kanban App with all possible option') }}</p>
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="assets/images/landing/slider-light-5.png" alt="images"
                                            class="img-fluid" />
                                        <h3>
                                            {{ __('Calendar App') }}
                                            <i class="ti ti-link"></i>
                                        </h3>
                                        <p>{{ __('Complete Calendar App with all possible option') }}</p>
                                    </div>
                                    <div class="swiper-slide">
                                        <img src="assets/images/landing/slider-light-6.png" alt="images"
                                            class="img-fluid" />
                                        <h3>
                                            {{ __('Ecommerce App') }}
                                            <i class="ti ti-link"></i>
                                        </h3>
                                        <p>{{ __('Complete Ecommerce App with all possible option') }}</p>
                                    </div>
                                @endif
                            </div>
                            <div class="swiper-button-next avtar">
                                <i class="ti ti-chevron-right"></i>
                            </div>
                            <div class="swiper-button-prev avtar">
                                <i class="ti ti-chevron-left"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- [ section ] End -->
    <!-- [ section ] start -->
    @php
        $Section_7 = App\Models\HomePage::where('section', 'Section 7')->first();
        $Section_7_content_value = !empty($Section_7->content_value)
            ? json_decode($Section_7->content_value, true)
            : [];
    @endphp

    @if (empty($Section_7_content_value['section_enabled']) || $Section_7_content_value['section_enabled'] == 'active')
        <style>
            .testimonials-section {
                position: relative;
                overflow: hidden;
            }
            .testimonials-slider {
                padding: 20px 0 60px;
                overflow: visible;
            }
            .testimonial-card {
                border-radius: 24px !important;
                background: #ffffff;
                transition: all 0.4s ease;
                border: 1px solid rgba(0,0,0,0.05) !important;
                height: 100%;
            }
            .testimonial-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 30px rgba(0,0,0,0.08) !important;
                border-color: var(--bs-primary) !important;
            }
            .quote-icon-bg {
                position: absolute;
                top: -5px;
                right: 15px;
                font-size: 6rem;
                color: rgba(var(--bs-primary-rgb), 0.05);
                line-height: 1;
                z-index: 0;
                pointer-events: none;
            }
            .avatar-wrapper {
                position: relative;
                display: inline-block;
            }
            .verified-badge {
                position: absolute;
                bottom: 0;
                right: 0;
                background: #28a745;
                color: white;
                width: 16px;
                height: 16px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 9px;
                border: 2px solid #fff;
            }
            .star-rating i {
                font-size: 0.8rem;
                margin-right: 2px;
            }
            .testimonial-text {
                font-size: 0.95rem;
                line-height: 1.6;
                font-style: italic;
                position: relative;
                z-index: 1;
            }
            .swiper-pagination-bullet-active {
                background: var(--bs-primary) !important;
            }
            .slider-nav {
                display: flex;
                gap: 10px;
                justify-content: center;
                margin-top: 20px;
            }
            .slider-nav .btn-nav {
                width: 45px;
                height: 45px;
                border-radius: 50%;
                background: #fff;
                border: 1px solid rgba(0,0,0,0.1);
                display: flex;
                align-items: center;
                justify-content: center;
                cursor: pointer;
                transition: all 0.3s ease;
                color: var(--bs-primary);
                box-shadow: 0 4px 10px rgba(0,0,0,0.05);
            }
            .slider-nav .btn-nav:hover {
                background: var(--bs-primary);
                color: #fff;
                transform: scale(1.1);
            }
            /* Swiper Grid specific styles */
            .testimonials-slider {
                height: 700px; /* Set a fixed height for grid to work correctly */
            }
            @media (max-width: 767px) {
                .testimonials-slider {
                    height: 900px;
                }
            }
            .testimonials-slider .swiper-slide {
                height: calc((100% - 30px) / 2) !important; /* Adjust height for 2 rows with gap */
                display: flex;
                flex-direction: column;
            }
            .testimonials-slider .testimonial-card {
                flex: 1;
            }
        </style>

        <section class="testimonials-section py-5 bg-light" id="testimonials">
            <div class="container py-5">
                <div class="row justify-content-center mb-4">
                    <div class="col-md-9 col-lg-7 text-center wow fadeInUp" data-wow-delay="0.2s">
                        <span class="badge bg-primary-soft text-primary px-3 py-2 rounded-pill mb-3 fw-bold text-uppercase" style="background: rgba(var(--bs-primary-rgb), 0.1); letter-spacing: 1px;">{{ !empty($Section_7_content_value['Sec7_tag']) ? $Section_7_content_value['Sec7_tag'] : __('Testimonials') }}</span>
                        <h2 class="display-5 fw-bold mb-3">
                            {{ !empty($Section_7_content_value['Sec7_title']) ? $Section_7_content_value['Sec7_title'] : __('What Our Customers Say About Us') }}
                        </h2>
                        <p class="text-muted lead px-lg-5">
                            {{ !empty($Section_7_content_value['Sec7_info']) ? $Section_7_content_value['Sec7_info'] : __('Join thousands of satisfied business owners who trust DarziDesk for their daily operations.') }}
                        </p>
                    </div>
                </div>
                
                <div class="swiper testimonials-slider wow fadeInUp" data-wow-delay="0.4s">
                    <div class="swiper-wrapper">
                        @for ($is7 = 1; $is7 <= 12; $is7++)
                            @php
                                $name_key = 'Sec7_box' . $is7 . '_name';
                                $tag_key = 'Sec7_box' . $is7 . '_tag';
                                $review_key = 'Sec7_box' . $is7 . '_review';
                                $img_key = 'Sec7_box' . $is7 . '_image_path';
                                
                                $name = !empty($Section_7_content_value[$name_key]) ? $Section_7_content_value[$name_key] : __('Tailor Master') . ' ' . $is7;
                                $tag = !empty($Section_7_content_value[$tag_key]) ? $Section_7_content_value[$tag_key] : __('Verified Business');
                                $review = !empty($Section_7_content_value[$review_key]) ? $Section_7_content_value[$review_key] : __('This software has completely transformed how we manage our tailoring business. Highly recommended!');
                                $image = !empty($Section_7_content_value[$img_key]) ? asset(Storage::url($Section_7_content_value[$img_key])) : asset('assets/images/user/avatar-1.jpg');
                            @endphp
                            <div class="swiper-slide h-auto">
                                <div class="card testimonial-card border-0 shadow-sm">
                                    <div class="card-body p-4 position-relative overflow-hidden">
                                        <div class="quote-icon-bg">
                                            <i class="ti ti-quote"></i>
                                        </div>
                                        
                                        <div class="d-flex align-items-center mb-3 position-relative">
                                            <div class="avatar-wrapper me-3">
                                                <img src="{{ $image }}" alt="{{ $name }}" class="rounded-circle shadow-sm" width="45" height="45" style="object-fit: cover; border: 2px solid #fff;">
                                                <div class="verified-badge">
                                                    <i class="ti ti-check"></i>
                                                </div>
                                            </div>
                                            <div>
                                                <h6 class="fw-bold mb-0">{{ $name }}</h6>
                                                <p class="text-primary small mb-0 fw-semibold opacity-75" style="font-size: 0.75rem;">{{ $tag }}</p>
                                            </div>
                                        </div>
                                        
                                        <div class="star-rating mb-2 position-relative">
                                            @for($i=1; $i<=5; $i++)
                                                <i class="ti ti-star-filled text-warning"></i>
                                            @endfor
                                        </div>
                                        
                                        <p class="testimonial-text text-muted mb-0">
                                            "{{ $review }}"
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endfor
                    </div>
                    <!-- Add Pagination -->
                    <div class="swiper-pagination"></div>
                </div>

                <!-- Custom Navigation -->
                <div class="slider-nav wow fadeInUp" data-wow-delay="0.6s">
                    <div class="btn-nav prev-testimonial">
                        <i class="ti ti-chevron-left f-20"></i>
                    </div>
                    <div class="btn-nav next-testimonial">
                        <i class="ti ti-chevron-right f-20"></i>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- [ section ] End -->
    <!-- [ section ] start -->
    @php
        $Section_8 = App\Models\HomePage::where('section', 'Section 8')->first();
        $Section_8_content_value = !empty($Section_8->content_value)
            ? json_decode($Section_8->content_value, true)
            : [];
    @endphp
    @if (empty($Section_8_content_value['section_enabled']) || $Section_8_content_value['section_enabled'] == 'active')
        <section class="bg-dark choose-section">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-9">
                        <div class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                <h2 class="mb-0 text-white">
                                    {{ !empty($Section_8_content_value['Sec8_title']) ? $Section_8_content_value['Sec8_title'] : 'Choose Smartweb for' }}
                                </h2>
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <div class="swiper choose-slider">
                                    <div class="swiper-wrapper">
                                        @for ($is8 = 1; $is8 <= 8; $is8++)
                                            <div class="swiper-slide">
                                                <h2>{{ !empty($Section_8_content_value['Sec8_box' . $is8 . '_info']) ? $Section_8_content_value['Sec8_box' . $is8 . '_info'] : 'Highly Responsive' }}
                                                </h2>
                                            </div>
                                        @endfor
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3 d-none d-md-block">
                        <img src="{{ asset('storage/upload/homepage/img-bg-hand.png') }}" alt="img"
                            class="img-fluid hand-img" />
                    </div>
                </div>
            </div>
        </section>
    @endif

    <!-- [ section ] End -->
    <!-- [ section ] start -->
    @php
        $Section_9 = App\Models\HomePage::where('section', 'Section 9')->first();
        $Section_9_content_value = !empty($Section_9->content_value)
            ? json_decode($Section_9->content_value, true)
            : [];
    @endphp
    @if (empty($Section_9_content_value['section_enabled']) || $Section_9_content_value['section_enabled'] == 'active')
        <section class="frameworks-section" id="faqs">
            <div class="container">
                <div class="row justify-content-center title">
                    <div class="col-md-9 col-lg-6 text-center">
                        <h2 class="h1">
                            {{ !empty($Section_9_content_value['Sec9_title']) ? $Section_9_content_value['Sec9_title'] : 'Frequently Asked Questions (FAQ)' }}
                        </h2>
                        <p class="text-lg">
                            {{ !empty($Section_9_content_value['Sec9_info']) ? $Section_9_content_value['Sec9_info'] : 'Please refer the Frequently ask question for your quick help' }}
                        </p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12">
                        <div class="accordion accordion-flush" id="accordionFlushExample">
                            @if (!empty($FAQs->toArray()))
                                @foreach ($FAQs as $FAQ_key => $FAQ)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="flush-{{ $FAQ->id }}">
                                            <button
                                                class="accordion-button {{ $FAQ_key == 0 ? '' : 'collapsed' }} text-muted"
                                                type="button" data-bs-toggle="collapse"
                                                data-bs-target="#flush-collapse-{{ $FAQ->id }}"
                                                aria-expanded="false" aria-controls="flush-collapseThree">
                                                <b>{{ $FAQ->question }}</b>
                                            </button>
                                        </h2>
                                        <div id="flush-collapse-{{ $FAQ->id }}"
                                            class="accordion-collapse collapse {{ $FAQ_key == 0 ? 'collapse show' : '' }}"
                                            aria-labelledby="flush-{{ $FAQ->id }}"
                                            data-bs-parent="#accordionFlushExample">
                                            <div class="accordion-body text-muted">{!! $FAQ->description !!}</div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingOne">
                                        <button class="accordion-button text-muted" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapseOne"
                                            aria-expanded="false">
                                            <b>{{ __('What features does your software offer?') }}</b>
                                        </button>
                                    </h2>
                                    <div id="flush-collapseOne" class="accordion-collapse collapse show"
                                        aria-labelledby="flush-headingOne" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body text-muted">
                                            {{ __('Our software provides a range of features including automation tools,
                                                                                                                                                                                real-time analytics, cloud-based access, secure data storage, seamless
                                                                                                                                                                                integrations, and customizable solutions tailored to your business needs.') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingTwo">
                                        <button class="accordion-button collapsed text-muted" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapseTwo"
                                            aria-expanded="false" aria-controls="flush-collapseTwo">
                                            <b>{{ __('Is your software easy to use?') }}</b>
                                        </button>
                                    </h2>
                                    <div id="flush-collapseTwo" class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingTwo" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body text-muted">
                                            {{ __('Yes! Our platform is designed to be user-friendly and intuitive, so your
                                                                                                                                                                                team can get started quickly without a steep learning curve.') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingThree">
                                        <button class="accordion-button collapsed text-muted" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapseThree"
                                            aria-expanded="false" aria-controls="flush-collapseThree">
                                            <b>{{ __('Can I integrate your software with my existing systems?') }}</b>
                                        </button>
                                    </h2>
                                    <div id="flush-collapseThree" class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingThree" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body text-muted">
                                            {{ __('Absolutely! Our software is built to easily integrate with your current
                                                                                                                                                                                tools and systems, making the transition seamless and efficient.') }}
                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="flush-headingfour">
                                        <button class="accordion-button collapsed text-muted" type="button"
                                            data-bs-toggle="collapse" data-bs-target="#flush-collapse-four"
                                            aria-expanded="false" aria-controls="flush-collapseThree">
                                            <b>{{ __('Is customer support available?') }}</b>
                                        </button>
                                    </h2>
                                    <div id="flush-collapse-four" class="accordion-collapse collapse"
                                        aria-labelledby="flush-headingfour" data-bs-parent="#accordionFlushExample">
                                        <div class="accordion-body text-muted">
                                            {{ __('Yes! We offer 24/7 customer support. Our dedicated team is ready to assist
                                                                                                                                                                                you with any questions or issues you may have.') }}
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif
    <!-- [ section ] End -->
    <!-- [ footer ] start -->
    <!-- [ Mobile App Section ] start -->
    <section class="bg-primary text-white py-5" style="background: linear-gradient(135deg, #40B0AC 0%, #2D8A87 100%) !important;">
        <div class="container text-center">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <h2 class="text-white mb-4 wow fadeInUp" data-wow-delay="0.2s">Manage Your Tailoring Business on the Go!</h2>
                    <p class="lead mb-5 wow fadeInUp" data-wow-delay="0.4s text-white-50">
                        Take the power of Darzidesk with you. Our new mobile app allows you to track orders, update measurements, and manage your staff anytime, anywhere.
                    </p>
                    <div class="d-flex justify-content-center gap-3 flex-wrap wow fadeInUp" data-wow-delay="0.6s">
                        <a href="{{ route('download.apk') }}" id="downloadApkBtn" class="btn btn-light btn-lg d-inline-flex align-items-center" style="border-radius: 12px; padding: 12px 24px;">
                            <i class="ti ti-brand-android me-2 f-30" style="color: #40B0AC;"></i>
                            <div class="text-start">
                                <small class="d-block lh-1 text-muted" style="font-size: 10px; text-transform: uppercase;">Download for</small>
                                <span class="fw-bold" style="color: #333;">Android (APK)</span>
                            </div>
                        </a>
                        <script>
                            document.getElementById('downloadApkBtn').addEventListener('click', function(e) {
                                const btn = this;
                                const originalContent = btn.innerHTML;
                                
                                // Show loading state briefly to confirm click
                                btn.style.pointerEvents = 'none';
                                btn.innerHTML = '<i class="ti ti-loader me-2 f-30 spin" style="color: #40B0AC;"></i> <div class="text-start"><small class="d-block lh-1 text-muted">Starting...</small><span class="fw-bold" style="color: #333;">Downloading App</span></div>';
                                
                                setTimeout(() => {
                                    btn.style.pointerEvents = 'auto';
                                    btn.innerHTML = originalContent;
                                }, 4000);
                            });
                        </script>
                        <a href="#" class="btn btn-outline-light btn-lg d-inline-flex align-items-center opacity-75" style="border-radius: 12px; padding: 12px 24px; pointer-events: none; border-style: dashed;">
                            <i class="ti ti-brand-apple me-2 f-30"></i>
                            <div class="text-start">
                                <small class="d-block lh-1" style="font-size: 10px; text-transform: uppercase;">Coming Soon on</small>
                                <span class="fw-bold">App Store</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- [ Mobile App Section ] end -->

    <footer class="bg-dark footer">
        @php
            $Section_10 = App\Models\HomePage::where('section', 'Section 10')->first();
            $Section_10_content_value = !empty($Section_10->content_value)
                ? json_decode($Section_10->content_value, true)
                : [];
        @endphp
        @if (empty($Section_10_content_value['section_enabled']) || $Section_10_content_value['section_enabled'] == 'active')
            <div class="container">
                <div class="row">
                    <div class="col-md-4 wow fadeInUp" data-wow-delay="0.2s">
                        <div class="landing-logo">
                            <img src="{{ asset(Storage::url('upload/logo/light_logo.png')) }}" alt="image"
                                class="img-fluid" />
                        </div>
                        <h4 class="my-3 text-white">
                            {{ !empty($Section_10_content_value['Sec10_title']) ? $Section_10_content_value['Sec10_title'] : 'About DarziDesk' }}
                        </h4>
                        <p class="mb-4 text-white text-opacity-75">
                            {!! !empty($Section_10_content_value['Sec10_info'])
                                ? $Section_10_content_value['Sec10_info']
                                : 'DarziDesk is a premium Tailoring Management Software designed specifically for Indian boutiques and tailors. We help you digitize your measurements, orders, and customer management to grow your business.' !!}
                        </p>
                    </div>
                    <div class="col-md-8">
                        <div class="row g-4">
                            @php
                                $footer_col = 0;
                                if ($settings['footer_column_1_enabled'] == 'active') {
                                    $footer_col = 12;
                                }
                                if ($settings['footer_column_2_enabled'] == 'active') {
                                    $footer_col = 6;
                                }
                                if ($settings['footer_column_3_enabled'] == 'active') {
                                    $footer_col = 4;
                                }
                                if ($settings['footer_column_4_enabled'] == 'active') {
                                    $footer_col = 3;
                                }
                            @endphp
                            @if ($footer_col > 0)
                                @if ($settings['footer_column_1_enabled'] == 'active')
                                    <div class="col-6 col-md-{{ $footer_col }} wow fadeInUp"
                                        data-wow-delay="0.6s">
                                        <h5 class="mb-3 mb-sm-4 text-white">{{ $settings['footer_column_1'] }}</h5>
                                        @php
                                            $active_footer_menu1 = !empty($settings['footer_column_1_pages'])
                                                ? json_decode($settings['footer_column_1_pages'], true)
                                                : [];
                                        @endphp
                                        <ul class="list-unstyled footer-link">
                                            @if (!empty($active_footer_menu1))
                                                @foreach ($menus as $menu)
                                                    @if (in_array($menu->id, $active_footer_menu1))
                                                        <li>
                                                            <a target="_blank"
                                                                href="{{ route('page', $menu->slug) }}">{{ $menu->title }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @else
                                                <li><a href="{{ route('blog.index') }}">{{ __('Blog') }}</a></li>
                                                <li><a href="{{ route('page', 'about_us') }}">{{ __('About Us') }}</a></li>
                                                <li><a href="#features">{{ __('Features') }}</a></li>
                                                <li><a href="#pricing">{{ __('Pricing') }}</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                                @if ($settings['footer_column_2_enabled'] == 'active')
                                    <div class="col-6 col-md-{{ $footer_col }} wow fadeInUp"
                                        data-wow-delay="0.6s">
                                        <h5 class="mb-3 mb-sm-4 text-white">{{ $settings['footer_column_2'] }}</h5>
                                        @php
                                            $active_footer_menu2 = !empty($settings['footer_column_2_pages'])
                                                ? json_decode($settings['footer_column_2_pages'], true)
                                                : [];
                                        @endphp
                                        <ul class="list-unstyled footer-link">
                                            @if (!empty($active_footer_menu2))
                                                @foreach ($menus as $menu)
                                                    @if (in_array($menu->id, $active_footer_menu2))
                                                        <li>
                                                            <a target="_blank"
                                                                href="{{ route('page', $menu->slug) }}">{{ $menu->title }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @else
                                                <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                                                <li><a href="{{ route('register') }}">{{ __('Register') }}</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                                @if ($settings['footer_column_3_enabled'] == 'active')
                                    <div class="col-6 col-md-{{ $footer_col }} wow fadeInUp"
                                        data-wow-delay="0.6s">
                                        <h5 class="mb-3 mb-sm-4 text-white">{{ $settings['footer_column_3'] }}</h5>
                                        @php
                                            $active_footer_menu3 = !empty($settings['footer_column_3_pages'])
                                                ? json_decode($settings['footer_column_3_pages'], true)
                                                : [];
                                        @endphp
                                        <ul class="list-unstyled footer-link">
                                            @if (!empty($active_footer_menu3))
                                                @foreach ($menus as $menu)
                                                    @if (in_array($menu->id, $active_footer_menu3))
                                                        <li>
                                                            <a target="_blank"
                                                                href="{{ route('page', $menu->slug) }}">{{ $menu->title }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @else
                                                <li><a href="#">{{ __('Documentation') }}</a></li>
                                                <li><a href="#">{{ __('Support') }}</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                                @if ($settings['footer_column_4_enabled'] == 'active')
                                    <div class="col-6 col-md-{{ $footer_col }} wow fadeInUp"
                                        data-wow-delay="0.6s">
                                        <h5 class="mb-3 mb-sm-4 text-white">{{ $settings['footer_column_4'] }}</h5>
                                        @php
                                            $active_footer_menu4 = !empty($settings['footer_column_4_pages'])
                                                ? json_decode($settings['footer_column_4_pages'], true)
                                                : [];
                                        @endphp
                                        <ul class="list-unstyled footer-link">
                                            @if (!empty($active_footer_menu4))
                                                @foreach ($menus as $menu)
                                                    @if (in_array($menu->id, $active_footer_menu4))
                                                        <li>
                                                            <a target="_blank"
                                                                href="{{ route('page', $menu->slug) }}">{{ $menu->title }}</a>
                                                        </li>
                                                    @endif
                                                @endforeach
                                            @else
                                                <li><a href="mailto:support@darzidesk.shop">{{ __('Email Us') }}</a></li>
                                            @endif
                                        </ul>
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <div class="sub-footer">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col my-1 wow fadeInUp" data-wow-delay="0.4s">
                        <p class="mb-0 text-white text-opacity-75">

                            @if (!empty($settings['copyright']))
                                {{ $settings['copyright'] }}
                            @else
                                {{ __('Copyright') }} {{ date('Y') }} {{ env('APP_NAME') }}
                            @endif
                        </p>
                    </div>
                    <div class="col-auto my-1">
                        <ul class="list-inline footer-sos-link mb-0">
                            <li class="list-inline-item wow fadeInUp" data-wow-delay="0.4s">
                                <a href="#" class="link-primary">
                                    <svg class="pc-icon">
                                        <use xlink:href="#custom-facebook"></use>
                                    </svg>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- [ footer ] End -->
    <!-- Required Js -->
    <script src="{{ asset('js/jquery.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/simplebar.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/js/fonts/custom-font.js') }}"></script>
    <script src="{{ asset('assets/js/pcoded.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/feather.min.js') }}"></script>

    <script>
        font_change('Roboto');
    </script>

    <!-- [Page Specific JS] start -->
    <script src="{{ asset('assets/js/plugins/wow.min.js') }}"></script>
    <script src="{{ asset('assets/js/plugins/swiper-bundle.js') }}"></script>
    <script>
        // Start [ Menu hide/show on scroll ]
        let ost = 0;
        document.addEventListener('scroll', function() {
            let cOst = document.documentElement.scrollTop;
            if (cOst == 0) {
                document.querySelector('.navbar').classList.add('top-nav-collapse');
            } else if (cOst > ost) {
                document.querySelector('.navbar').classList.add('top-nav-collapse');
                document.querySelector('.navbar').classList.remove('default');
            } else {
                document.querySelector('.navbar').classList.add('default');
                document.querySelector('.navbar').classList.remove('top-nav-collapse');
            }
            ost = cOst;
        });
        // End [ Menu hide/show on scroll ]
        var wow = new WOW({
            animateClass: 'animated'
        });
        wow.init();
        const app_Swiper = new Swiper('.app-slider', {
            loop: true,
            slidesPerView: '1.2',
            centeredSlides: true,
            spaceBetween: 20,
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
            }
        });
        const choose_Swiper = new Swiper('.choose-slider', {
            direction: 'vertical',
            loop: true,
            centeredSlides: true,
            slidesPerView: '4',
            autoplay: {
                delay: 2500,
                disableOnInteraction: false
            }
        });
        const frameworks_Swiper = new Swiper('.frameworks-slider', {
            loop: true,
            centeredSlides: true,
            spaceBetween: 24,
            slidesPerView: 2,
            pagination: {
                el: '.swiper-pagination',
                dynamicBullets: true,
                clickable: true
            },
            breakpoints: {
                640: {
                    slidesPerView: 2
                },
                768: {
                    slidesPerView: 4
                },
                1024: {
                    slidesPerView: 5
                }
            }
        });

        // Testimonials Slider (2 Rows)
        const testimonials_Swiper = new Swiper('.testimonials-slider', {
            slidesPerView: 1,
            grid: {
                rows: 2,
                fill: 'row',
            },
            spaceBetween: 30,
            autoplay: {
                delay: 3000,
                disableOnInteraction: false,
            },
            loop: false, // Swiper Grid does not support loop: true well, using autoplay instead
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: '.next-testimonial',
                prevEl: '.prev-testimonial',
            },
            breakpoints: {
                768: {
                    slidesPerView: 2,
                    grid: {
                        rows: 2,
                        fill: 'row',
                    },
                },
                1024: {
                    slidesPerView: 3,
                    grid: {
                        rows: 2,
                        fill: 'row',
                    },
                }
            }
        });
    </script>
    <!-- [Page Specific JS] end -->
</body>

</html>
