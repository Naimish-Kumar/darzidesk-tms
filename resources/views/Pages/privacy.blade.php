@php
    $settings = settings();
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ __('Privacy Policy') }} - {{ !empty($settings['app_name']) ? $settings['app_name'] : env('APP_NAME') }}</title>

    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="author" content="{{ !empty($settings['app_name']) ? $settings['app_name'] : env('APP_NAME') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="description" content="DarziDesk Privacy Policy - Understanding how we protect your personal data, body measurement records, and account information.">

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
                <li><a href="{{ route('privacy.policy') }}" style="color: var(--brand-primary); font-weight: 700;">{{ __('Privacy Policy') }}</a></li>
                <li><a href="{{ route('terms.conditions') }}">{{ __('Terms & Services') }}</a></li>
                <li><a href="{{ route('login') }}">{{ __('Login') }}</a></li>
                <li><a class="btn-cta" href="{{ route('register') }}">{{ __('Get Started') }}</a></li>
            </ul>

        </div>
    </nav>

    <!-- [ Hero ] -->
    <section class="policy-hero">
        <div class="hero-badge">
            <i class="ti ti-shield-lock me-1"></i>
            {{ __('Data Protection & Privacy') }}
        </div>
        <h1>{{ __('Privacy Policy') }}</h1>
        <p>{{ __('At DarziDesk, we protect your personal information, customer body measurement records, and shop data with enterprise-grade security.') }}</p>
    </section>

    <!-- [ Content Container ] -->
    <div class="policy-container">
        <!-- Sidebar Navigation -->
        <aside class="toc-sidebar">
            <h4>{{ __('On this page') }}</h4>
            <ul>
                <li><a href="#section-1"><i class="ti ti-info-circle me-1"></i> {{ __('1. Info We Collect') }}</a></li>
                <li><a href="#section-2"><i class="ti ti-ruler-2 me-1"></i> {{ __('2. Measurement Privacy') }}</a></li>
                <li><a href="#section-3"><i class="ti ti-cpu me-1"></i> {{ __('3. How We Use Data') }}</a></li>
                <li><a href="#section-4"><i class="ti ti-share me-1"></i> {{ __('4. Data Sharing') }}</a></li>
                <li><a href="#section-5"><i class="ti ti-lock me-1"></i> {{ __('5. Data Security') }}</a></li>
                <li><a href="#section-6"><i class="ti ti-trash me-1"></i> {{ __('6. Your Rights & Deletion') }}</a></li>
                <li><a href="#section-7"><i class="ti ti-mail me-1"></i> {{ __('7. Contact DPO') }}</a></li>
            </ul>
        </aside>

        <!-- Main Document Body -->
        <main class="policy-content-card">
            <div class="policy-section" id="section-1">
                <h2><i class="ti ti-info-circle"></i> {{ __('1. Information We Collect') }}</h2>
                <p>{{ __('DarziDesk collects essential information necessary to provide specialized Tailoring Management System (TMS) software services to boutique owners, tailors, master cutters, and customers.') }}</p>
                <ul>
                    <li>{{ __('Account Data: Owner name, business name, phone number, email address, and login credentials.') }}</li>
                    <li>{{ __('Boutique & Staff Profile: Branch locations, assigned roles (master tailor, cutter, helper), and worker pay rates.') }}</li>
                    <li>{{ __('Customer Order Information: Customer name, phone number, delivery address, order items, fabric notes, and billing history.') }}</li>
                    <li>{{ __('Telemetry & Technical Logs: Device IP, browser version, operating system details, and session tokens for security.') }}</li>
                </ul>
            </div>

            <div class="policy-section" id="section-2">
                <h2><i class="ti ti-ruler-2"></i> {{ __('2. Body Measurement & Fitting Confidentiality') }}</h2>
                <p>{{ __('We understand that body measurements (chest, waist, shoulder, inseam, posture notes) and fitting reference photos represent deeply personal information.') }}</p>
                <div class="highlight-box">
                    <p><i class="ti ti-check me-2"></i> {{ __('Strict Multi-Tenant Isolation: Body measurement logs are strictly partitioned by shop account ID and are NEVER accessible outside your authorized studio staff.') }}</p>
                </div>
                <p>{{ __('Fitting photographs uploaded during production stages are encrypted in storage and accessible only by authorized cutters and tailors assigned to the order.') }}</p>
            </div>

            <div class="policy-section" id="section-3">
                <h2><i class="ti ti-cpu"></i> {{ __('3. How We Use Your Data') }}</h2>
                <p>{{ __('Your data is strictly utilized to operate and improve the DarziDesk platform:') }}</p>
                <ul>
                    <li>{{ __('Managing production Kanban boards and worker assignment stages.') }}</li>
                    <li>{{ __('Generating GST-compliant invoices, thermal print receipts, and digital QR tracking cards.') }}</li>
                    <li>{{ __('Sending automated order status alerts via SMS, WhatsApp, and Email.') }}</li>
                    <li>{{ __('Providing analytics on sales income, fabric inventory restocks, and worker payouts.') }}</li>
                </ul>
            </div>

            <div class="policy-section" id="section-4">
                <h2><i class="ti ti-share"></i> {{ __('4. Data Sharing & Third-Party Processors') }}</h2>
                <p>{{ __('DarziDesk NEVER sells, rents, or monetizes your personal data or customer records. We share data only with verified infrastructure providers strictly necessary to execute system functions:') }}</p>
                <ul>
                    <li><strong>{{ __('Payment Gateways') }}</strong>: Stripe, Razorpay, PayPal, and Paystack for subscription & invoice payments.</li>
                    <li><strong>{{ __('Messaging Providers') }}</strong>: Twilio and WhatsApp Business API for dispatching order ready alerts.</li>
                    <li><strong>{{ __('Cloud Hosting') }}</strong>: Encrypted database hosting on high-security cloud servers.</li>
                </ul>
            </div>

            <div class="policy-section" id="section-5">
                <h2><i class="ti ti-lock"></i> {{ __('5. Data Security & Storage') }}</h2>
                <p>{{ __('We employ AES-256 encryption at rest and TLS 1.3 encryption in transit for all network communication. Regular database backups, role-based access control (RBAC), and automated vulnerability scans are active across our infrastructure.') }}</p>
            </div>

            <div class="policy-section" id="section-6">
                <h2><i class="ti ti-trash"></i> {{ __('6. Your Rights & Account Deletion') }}</h2>
                <p>{{ __('You have full rights to access, export, modify, or delete your account and personal records at any time.') }}</p>
                <div class="highlight-box">
                    <p><i class="ti ti-link me-2"></i> {{ __('Need to delete your account? You can submit an account deletion request directly through our dedicated web portal at ') }}<a href="{{ route('delete.account') }}" style="color: var(--brand-primary); font-weight: 700;">{{ __('Delete Account Page') }}</a> {{ __('or via the mobile app settings.') }}</p>
                </div>
            </div>

            <div class="policy-section" id="section-7">
                <h2><i class="ti ti-mail"></i> {{ __('7. Contact Data Protection Officer (DPO)') }}</h2>
                <p>{{ __('If you have questions regarding this Privacy Policy or wish to exercise your data privacy rights, please reach out to our dedicated DPO:') }}</p>
                <p><strong>Email</strong>: privacy@darzidesk.shop | support@darzidesk.shop<br>
                <strong>Company</strong>: {{ $settings['company_name'] ?? 'DarziDesk Technologies' }}<br>
                <strong>Last Updated</strong>: {{ date('F d, Y') }}</p>
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
