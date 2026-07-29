<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Business Profile - {{ env('APP_NAME', 'DarziDesk') }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    <style>
        :root {
            --primary-teal: #006A67;
            --accent-teal: #26A69A;
            --vibrant-teal: #3AAFA9;
            --dark-navy: #0B1C30;
            --bg-light: #F4F7F9;
            --card-border: #E2E8F0;
            --text-dark: #1E293B;
            --text-muted: #64748B;
            --font-main: 'Hanken Grotesk', sans-serif;
            --font-code: 'JetBrains Mono', monospace;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-main);
            background: var(--bg-light);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar Navigation */
        .sidebar {
            width: 240px;
            background: #FFFFFF;
            border-right: 1px solid var(--card-border);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 24px 16px;
            position: fixed;
            top: 0;
            bottom: 0;
            left: 0;
            z-index: 100;
        }

        .brand-box { margin-bottom: 24px; }
        .brand-box span { font-size: 9px; font-weight: 800; letter-spacing: 1.5px; color: var(--text-muted); display: block; margin-top: 2px; }

        .nav-list { list-style: none; }
        .nav-item { margin-bottom: 4px; }

        .nav-link {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 12px;
            border-radius: 10px;
            font-size: 13.5px;
            font-weight: 600;
            color: var(--text-dark);
            text-decoration: none;
            transition: all 0.2s;
        }

        .nav-link.active {
            background: var(--accent-teal);
            color: #FFFFFF;
        }

        .nav-link:hover:not(.active) { background: #F1F5F9; }

        .user-pill {
            background: #EBF3FA;
            border-radius: 12px;
            padding: 10px 12px;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 16px;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            background: #4FD1C5;
            color: #FFFFFF;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .user-info h5 { font-size: 13px; font-weight: 700; }
        .user-info p { font-size: 10px; font-weight: 800; color: var(--primary-teal); letter-spacing: 0.5px; }

        /* Main Content Wrapper */
        .main-wrapper {
            margin-left: 240px;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        /* Top Bar Header */
        .top-header {
            height: 64px;
            background: #FFFFFF;
            border-bottom: 1px solid var(--card-border);
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 28px;
            position: sticky;
            top: 0;
            z-index: 90;
        }

        .header-title-section {
            display: flex;
            align-items: center;
            gap: 28px;
        }

        .header-title-section h3 {
            font-size: 18px;
            font-weight: 800;
        }

        .header-tabs {
            display: flex;
            gap: 20px;
            font-size: 13.5px;
            font-weight: 600;
        }

        .header-tab {
            color: var(--text-muted);
            text-decoration: none;
            padding-bottom: 4px;
            border-bottom: 2px solid transparent;
        }

        .header-tab.active {
            color: var(--primary-teal);
            border-bottom-color: var(--primary-teal);
            font-weight: 700;
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .search-input {
            background: #F1F5F9;
            border-radius: 20px;
            padding: 6px 14px;
            display: flex;
            align-items: center;
            gap: 8px;
            width: 220px;
        }

        .search-input input {
            border: none;
            background: transparent;
            outline: none;
            font-family: var(--font-main);
            font-size: 12.5px;
            width: 100%;
        }

        .btn-save {
            background: var(--primary-teal);
            color: #FFFFFF;
            border: none;
            padding: 8px 18px;
            border-radius: 20px;
            font-family: var(--font-main);
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            transition: background 0.2s;
        }

        .btn-save:hover { background: #004D4B; }

        .content-area {
            padding: 28px;
            max-width: 1200px;
        }

        .brand-identity-card {
            background: #FFFFFF;
            border: 1px solid var(--card-border);
            border-radius: 18px;
            padding: 24px;
            display: flex;
            gap: 24px;
            margin-bottom: 24px;
        }

        .logo-upload-box {
            width: 140px;
            height: 140px;
            background: #EBF3FA;
            border-radius: 16px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #718096;
            position: relative;
            cursor: pointer;
            border: 2px dashed #CBD5E1;
        }

        .logo-upload-box span { font-size: 32px; margin-bottom: 6px; }
        .logo-upload-box p { font-size: 10px; font-weight: 800; letter-spacing: 0.5px; }

        .edit-badge {
            position: absolute;
            bottom: -6px;
            right: -6px;
            width: 28px;
            height: 28px;
            background: #FFFFFF;
            border: 1px solid var(--card-border);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 2px 6px rgba(0,0,0,0.1);
            color: var(--text-dark);
        }

        .brand-info-side { flex: 1; }

        .lbl-sub {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1px;
            color: var(--text-muted);
            margin-bottom: 4px;
        }

        .brand-title-text {
            font-size: 28px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 12px;
        }

        .brand-slogan {
            font-size: 14.5px;
            color: var(--text-muted);
            font-style: italic;
            margin-bottom: 18px;
        }

        .badges-row { display: flex; gap: 8px; }

        .badge-pill {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.6px;
            padding: 4px 10px;
            border-radius: 6px;
        }

        .badge-teal { background: #E6FFFA; color: var(--primary-teal); }
        .badge-grey { background: #EDF2F7; color: #4A5568; }
        .badge-green { background: #F0FFF4; color: #2F855A; }

        .grid-2col {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 20px;
            margin-bottom: 24px;
        }

        .card-box {
            background: #FFFFFF;
            border: 1px solid var(--card-border);
            border-radius: 16px;
            padding: 24px;
        }

        .card-box-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }

        .card-box-title {
            font-size: 15px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .char-counter { font-size: 11px; color: var(--text-muted); }

        .bio-textarea {
            width: 100%;
            height: 120px;
            background: #F8FAFC;
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 14px;
            font-family: var(--font-main);
            font-size: 13px;
            line-height: 1.5;
            color: var(--text-dark);
            outline: none;
            resize: none;
            margin-bottom: 12px;
        }

        .btn-ai-polish {
            color: var(--primary-teal);
            font-size: 12.5px;
            font-weight: 700;
            background: transparent;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .quick-contact-card {
            background: #26A69A;
            color: #FFFFFF;
            border-radius: 16px;
            padding: 24px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .quick-contact-card h4 {
            font-size: 15px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 18px;
        }

        .contact-list {
            display: flex;
            flex-direction: column;
            gap: 12px;
            margin-bottom: 20px;
        }

        .contact-item {
            background: rgba(255, 255, 255, 0.15);
            padding: 10px 12px;
            border-radius: 8px;
            font-family: var(--font-code);
            font-size: 12px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-visibility {
            background: #FFFFFF;
            color: var(--primary-teal);
            border: none;
            padding: 10px;
            border-radius: 10px;
            font-family: var(--font-main);
            font-size: 12.5px;
            font-weight: 800;
            cursor: pointer;
            text-align: center;
        }

        .social-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin-bottom: 16px;
        }

        .social-item {
            border: 1px solid var(--card-border);
            border-radius: 10px;
            padding: 10px 14px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 13px;
            font-weight: 600;
        }

        .social-left {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .btn-add-platform {
            color: var(--primary-teal);
            font-size: 12px;
            font-weight: 800;
            background: transparent;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .specialties-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
        }

        .specialty-card {
            background: #F8FAFC;
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 14px;
        }

        .specialty-icon {
            width: 34px;
            height: 34px;
            background: #E6FFFA;
            color: var(--primary-teal);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            margin-bottom: 10px;
        }

        .specialty-card h5 {
            font-size: 13.5px;
            font-weight: 700;
            margin-bottom: 4px;
        }

        .specialty-card p {
            font-size: 11.5px;
            color: var(--text-muted);
            line-height: 1.4;
        }

        .marketplace-banner {
            background: #0B1C30;
            color: #FFFFFF;
            border-radius: 18px;
            padding: 32px 36px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 24px;
        }

        .banner-left-text .lbl-tag {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.5px;
            color: #26A69A;
            margin-bottom: 6px;
        }

        .banner-left-text h2 {
            font-size: 26px;
            font-weight: 800;
            margin-bottom: 8px;
        }

        .banner-left-text p {
            font-size: 13.5px;
            color: rgba(255, 255, 255, 0.75);
            max-width: 500px;
        }

        .banner-left-text p strong { color: #FFFFFF; }

        .btn-preview-storefront {
            background: #B2F5EA;
            color: #004D4B;
            border: none;
            padding: 14px 24px;
            border-radius: 30px;
            font-family: var(--font-main);
            font-size: 13.5px;
            font-weight: 800;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .btn-preview-storefront:hover { transform: scale(1.03); }

        .footer-stats-bar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #FFFFFF;
            border: 1px solid var(--card-border);
            border-radius: 14px;
            padding: 16px 24px;
            font-size: 12.5px;
        }

        .stat-item {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .stat-lbl {
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 0.8px;
            color: var(--text-muted);
        }

        .stat-val { font-size: 16px; font-weight: 800; }

        .stat-bar-bg {
            width: 100px;
            height: 6px;
            background: #E2E8F0;
            border-radius: 3px;
            overflow: hidden;
            margin-left: 8px;
        }

        .stat-bar-fill {
            height: 100%;
            background: var(--primary-teal);
        }

        .sync-status {
            font-size: 11.5px;
            color: var(--text-muted);
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .dot-online {
            width: 8px;
            height: 8px;
            background: #38A169;
            border-radius: 50%;
        }
    </style>
</head>
<body>

    <!-- Left Sidebar -->
    <aside class="sidebar">
        <div>
            <div class="brand-box">
                <img src="{{ asset('assets/images/logo_wide.png') }}" alt="DarziDesk" style="height: 32px;">
                <span>MASTER TAILOR WORKSPACE</span>
            </div>

            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <span class="material-symbols-outlined">dashboard</span>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('orders.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">shopping_bag</span>
                        Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profile.show') }}" class="nav-link active">
                        <span class="material-symbols-outlined">storefront</span>
                        Business Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="material-symbols-outlined">account_tree</span>
                        Branch Management
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="material-symbols-outlined">verified_user</span>
                        Roles & Permissions
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="material-symbols-outlined">receipt_long</span>
                        Billing
                    </a>
                </li>
            </ul>
        </div>

        <div>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="material-symbols-outlined">help</span>
                        Support
                    </a>
                </li>
            </ul>

            <div class="user-pill">
                <div class="user-avatar">JD</div>
                <div class="user-info">
                    <h5>Julian Darzi</h5>
                    <p>PREMIUM OWNER</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content Area -->
    <div class="main-wrapper">
        <!-- Top Bar Header -->
        <header class="top-header">
            <div class="header-title-section">
                <h3>Business Profile</h3>
                <div class="header-tabs">
                    <a href="#" class="header-tab active">Identity</a>
                    <a href="#" class="header-tab">Locations</a>
                    <a href="#" class="header-tab">Services</a>
                </div>
            </div>

            <div class="header-actions">
                <div class="search-input">
                    <span class="material-symbols-outlined" style="font-size: 16px; color: var(--text-muted);">search</span>
                    <input type="text" placeholder="Search settings...">
                </div>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">notifications</span>
                <button class="btn-save">Save Changes</button>
            </div>
        </header>

        <!-- Content Area Body -->
        <main class="content-area">

            <!-- Brand Identity Header Card -->
            <div class="brand-identity-card">
                <div class="logo-upload-box">
                    <span class="material-symbols-outlined">add_a_photo</span>
                    <p>UPLOAD LOGO</p>
                    <div class="edit-badge">
                        <span class="material-symbols-outlined" style="font-size: 14px;">edit</span>
                    </div>
                </div>

                <div class="brand-info-side">
                    <div class="lbl-sub">BRAND IDENTITY</div>
                    <div class="brand-title-text">The Gilded Needle</div>
                    <div class="lbl-sub">SLOGAN / VALUE PROPOSITION</div>
                    <div class="brand-slogan">Bespoke Elegance for the Modern Professional</div>

                    <div class="badges-row">
                        <span class="badge-pill badge-teal">PREMIUM PARTNER</span>
                        <span class="badge-pill badge-grey">VERIFIED BOUTIQUE</span>
                        <span class="badge-pill badge-green">TAILORING EXPERT</span>
                    </div>
                </div>
            </div>

            <!-- Middle Row Grid (2 Columns) -->
            <div class="grid-2col">
                <!-- Business Biography Box -->
                <div class="card-box">
                    <div class="card-box-header">
                        <div class="card-box-title">
                            <span class="material-symbols-outlined" style="color: var(--primary-teal);">auto_stories</span>
                            Business Biography
                        </div>
                        <span class="char-counter">420/1000 characters</span>
                    </div>

                    <textarea class="bio-textarea">Founded in 1984, The Gilded Needle represents a legacy of textile excellence. We specialize in contemporary interpretations of traditional silhouettes, ensuring every stitch tells a story of precision and passion. Our artisans utilize centuries-old techniques blended with modern pattern-cutting technology to deliver a fit that is second to none. Join us for a journey of personal style and mastercraft.</textarea>

                    <button class="btn-ai-polish">
                        <span class="material-symbols-outlined" style="font-size: 16px;">auto_awesome</span>
                        AI Polishing
                    </button>
                </div>

                <!-- Quick Contact Card (Vibrant Teal) -->
                <div class="quick-contact-card">
                    <div>
                        <h4>
                            <span class="material-symbols-outlined">description</span>
                            Quick Contact
                        </h4>

                        <div class="contact-list">
                            <div class="contact-item">
                                <span class="material-symbols-outlined" style="font-size: 16px;">mail</span>
                                hello@gildedneedle.com
                            </div>
                            <div class="contact-item">
                                <span class="material-symbols-outlined" style="font-size: 16px;">call</span>
                                +1 (555) 098-7654
                            </div>
                            <div class="contact-item">
                                <span class="material-symbols-outlined" style="font-size: 16px;">location_on</span>
                                Savile Row, London, UK
                            </div>
                        </div>
                    </div>

                    <button class="btn-visibility">Manage Contact Visibility</button>
                </div>
            </div>

            <!-- Lower Row Grid (Social Presence & Specialty Highlights) -->
            <div class="grid-2col">
                <!-- Social Presence -->
                <div class="card-box">
                    <div class="card-box-header">
                        <div class="card-box-title">
                            <span class="material-symbols-outlined" style="color: var(--primary-teal);">public</span>
                            Social Presence
                        </div>
                    </div>

                    <div class="social-list">
                        <div class="social-item">
                            <div class="social-left">
                                <span class="material-symbols-outlined" style="color: #E1306C;">photo_camera</span>
                                @thegildedneedle
                            </div>
                            <span class="material-symbols-outlined" style="color: var(--text-muted); font-size: 16px; cursor: grab;">drag_indicator</span>
                        </div>

                        <div class="social-item">
                            <div class="social-left">
                                <span class="material-symbols-outlined" style="color: #1877F2;">share</span>
                                Connect Facebook
                            </div>
                            <span class="material-symbols-outlined" style="color: var(--text-muted); font-size: 16px; cursor: grab;">drag_indicator</span>
                        </div>

                        <div class="social-item">
                            <div class="social-left">
                                <span class="material-symbols-outlined" style="color: #000000;">graphic_eq</span>
                                gildedneedle_tailors
                            </div>
                            <span class="material-symbols-outlined" style="color: var(--text-muted); font-size: 16px; cursor: grab;">drag_indicator</span>
                        </div>
                    </div>

                    <button class="btn-add-platform">
                        <span class="material-symbols-outlined" style="font-size: 16px;">add</span>
                        ADD PLATFORM
                    </button>
                </div>

                <!-- Service Specialty Highlights -->
                <div class="card-box">
                    <div class="card-box-header">
                        <div>
                            <div class="card-box-title">
                                <span class="material-symbols-outlined" style="color: var(--primary-teal);">check_circle</span>
                                Service Specialty Highlights
                            </div>
                            <div style="font-size:11.5px; color:var(--text-muted); margin-top:2px;">Selected services appear on your marketplace showcase.</div>
                        </div>
                        <button style="background:#4A5568; color:#FFF; border:none; padding:6px 12px; border-radius:12px; font-size:10px; font-weight:800; cursor:pointer;">UPDATE LIST</button>
                    </div>

                    <div class="specialties-grid">
                        <div class="specialty-card">
                            <div class="specialty-icon">
                                <span class="material-symbols-outlined">styler</span>
                            </div>
                            <h5>Bespoke Suitings</h5>
                            <p>Full measure-to-stitch service for formal attire.</p>
                        </div>

                        <div class="specialty-card">
                            <div class="specialty-icon">
                                <span class="material-symbols-outlined">content_cut</span>
                            </div>
                            <h5>Luxury Alterations</h5>
                            <p>Refitting of high-end vintage and heritage pieces.</p>
                        </div>

                        <div class="specialty-card">
                            <div class="specialty-icon">
                                <span class="material-symbols-outlined">checkroom</span>
                            </div>
                            <h5>Wedding Couture</h5>
                            <p>Exquisite custom dresses and traditional bridal wear.</p>
                        </div>

                        <div class="specialty-card">
                            <div class="specialty-icon">
                                <span class="material-symbols-outlined">corporate_fare</span>
                            </div>
                            <h5>Corporate Uniforms</h5>
                            <p>Standardized luxury branding for firm employees.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Dark Navy Live Marketplace Banner -->
            <div class="marketplace-banner">
                <div class="banner-left-text">
                    <div class="lbl-tag">LIVE MARKETPLACE VIEW</div>
                    <h2>See how customers find you.</h2>
                    <p>Your profile is currently ranked in the <strong>Top 5% of London Tailors</strong>. Higher profile completion leads to 40% more discovery bookings.</p>
                </div>

                <button class="btn-preview-storefront">
                    Preview Public Storefront
                    <span class="material-symbols-outlined" style="font-size: 16px;">open_in_new</span>
                </button>
            </div>

            <!-- Bottom Stats Footer Bar -->
            <div class="footer-stats-bar">
                <div class="stat-item">
                    <div>
                        <div class="stat-lbl">PROFILE STRENGTH</div>
                        <div style="display:flex; align-items:center;">
                            <span class="stat-val">88%</span>
                            <div class="stat-bar-bg">
                                <div class="stat-bar-fill" style="width: 88%;"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="stat-item">
                    <div>
                        <div class="stat-lbl">VIEWS (30D)</div>
                        <div class="stat-val">12,402</div>
                    </div>
                </div>

                <div class="stat-item">
                    <div>
                        <div class="stat-lbl">CONVERSION</div>
                        <div class="stat-val" style="color: #38A169;">4.8% ↑</div>
                    </div>
                </div>

                <div class="sync-status">
                    Last synced with Cloud Ledger: 2 mins ago
                    <div class="dot-online"></div>
                    <span style="font-weight:800; color:#2F855A;">ONLINE</span>
                </div>
            </div>

        </main>
    </div>

</body>
</html>
