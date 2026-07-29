<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Onboarding - Step 2: Skills & Specialties - {{ env('APP_NAME', 'DarziDesk') }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    <style>
        :root {
            --primary-teal: #006A67;
            --accent-teal: #26A69A;
            --dark-navy: #0B1C30;
            --bg-light: #F4F7F9;
            --card-border: #E2E8F0;
            --text-dark: #1E293B;
            --text-muted: #64748B;
            --font-main: 'Hanken Grotesk', sans-serif;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: var(--font-main);
            background: var(--bg-light);
            color: var(--text-dark);
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 240px; background: #FFFFFF; border-right: 1px solid var(--card-border);
            display: flex; flex-direction: column; justify-content: space-between;
            padding: 24px 16px; position: fixed; top: 0; bottom: 0; left: 0; z-index: 100;
        }

        .brand-box h2 { font-size: 20px; font-weight: 800; color: var(--primary-teal); }
        .brand-box span { font-size: 9px; font-weight: 800; letter-spacing: 1.5px; color: var(--text-muted); display: block; margin-top: 2px; }

        .nav-list { list-style: none; margin-top: 28px; }
        .nav-item { margin-bottom: 4px; }

        .nav-link {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 12px; border-radius: 10px; font-size: 13.5px; font-weight: 600;
            color: var(--text-dark); text-decoration: none; transition: all 0.2s;
        }

        .nav-link.active { background: #E6FFFA; color: var(--primary-teal); font-weight: 700; border-left: 3px solid var(--primary-teal); }

        .main-wrapper { margin-left: 240px; flex: 1; display: flex; flex-direction: column; }

        .top-header {
            height: 64px; background: #FFFFFF; border-bottom: 1px solid var(--card-border);
            display: flex; align-items: center; justify-content: space-between; padding: 0 28px;
            position: sticky; top: 0; z-index: 90;
        }

        .header-title-links { display: flex; gap: 20px; font-size: 13px; font-weight: 600; }
        .header-title-links a { color: var(--text-muted); text-decoration: none; }
        .header-title-links a.active { color: var(--primary-teal); font-weight: 800; }

        .search-bar {
            background: #EBF3FA; border-radius: 20px; padding: 6px 14px;
            display: flex; align-items: center; gap: 8px; width: 220px;
        }

        .search-bar input { border: none; background: transparent; outline: none; font-family: var(--font-main); font-size: 12.5px; width: 100%; }

        .stepper-container {
            display: flex; align-items: center; justify-content: center;
            gap: 16px; padding: 28px 0 20px; max-width: 650px; margin: 0 auto;
        }

        .step-item { display: flex; flex-direction: column; align-items: center; gap: 6px; }

        .step-circle {
            width: 34px; height: 34px; border-radius: 50%; background: #CBD5E1; color: #FFF;
            font-size: 13px; font-weight: 800; display: flex; align-items: center; justify-content: center;
        }

        .step-circle.done { background: #10B981; }
        .step-circle.active { background: var(--primary-teal); }
        .step-lbl { font-size: 11.5px; font-weight: 700; color: var(--text-muted); }
        .step-lbl.active { color: var(--primary-teal); }

        .step-line { flex: 1; height: 2px; background: #CBD5E1; max-width: 100px; }

        .content-area { padding: 0 28px 40px; max-width: 950px; margin: 0 auto; width: 100%; }

        .form-card {
            background: #FFFFFF; border: 1px solid var(--card-border);
            border-radius: 18px; padding: 36px; margin-bottom: 24px;
        }

        .form-card-header h3 { font-size: 22px; font-weight: 800; margin-bottom: 6px; }
        .form-card-header p { font-size: 13.5px; color: var(--text-muted); margin-bottom: 28px; line-height: 1.5; }

        .section-label { font-size: 13.5px; font-weight: 800; margin-bottom: 14px; color: var(--text-dark); }

        .role-cards-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 32px; }

        .role-card-box {
            border: 2px solid var(--card-border); border-radius: 14px; padding: 20px 14px;
            text-align: center; cursor: pointer; transition: all 0.2s; position: relative;
            background: #FFFFFF; display: flex; flex-direction: column; align-items: center; justify-content: center;
        }

        .role-card-box.selected { border-color: var(--primary-teal); background: #E6FFFA; }

        .check-badge-top {
            position: absolute; top: 10px; right: 10px; width: 20px; height: 20px;
            background: var(--primary-teal); color: #FFF; border-radius: 50%; font-size: 12px;
            display: flex; align-items: center; justify-content: center;
        }

        .role-icon-circle {
            width: 44px; height: 44px; background: #CBD5E1; color: var(--text-dark);
            border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 10px;
        }

        .role-card-box.selected .role-icon-circle { background: var(--accent-teal); color: #FFF; }

        .role-name { font-size: 14px; font-weight: 800; margin-bottom: 2px; }
        .role-sub { font-size: 11px; color: var(--text-muted); }

        .specialties-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; margin-bottom: 32px; }

        .specialty-card {
            border: 1.5px solid var(--card-border); border-radius: 14px; overflow: hidden;
            background: #FFFFFF; cursor: pointer; transition: all 0.2s; position: relative;
        }

        .specialty-card.selected { border-color: var(--primary-teal); }

        .specialty-img { height: 120px; width: 100%; object-fit: cover; }

        .specialty-body { padding: 14px; display: flex; justify-content: space-between; align-items: flex-start; }

        .specialty-title { font-size: 13.5px; font-weight: 800; margin-bottom: 2px; }
        .specialty-sub { font-size: 11px; color: var(--text-muted); }

        .checkbox-custom {
            width: 20px; height: 20px; border: 2px solid var(--card-border); border-radius: 4px;
            display: flex; align-items: center; justify-content: center; accent-color: var(--primary-teal);
        }

        .specialty-card.selected .checkbox-custom {
            background: var(--primary-teal); border-color: var(--primary-teal); color: #FFF;
        }

        .form-actions { display: flex; align-items: center; justify-content: space-between; margin-top: 24px; }

        .btn-back-link { font-size: 13.5px; font-weight: 700; color: var(--text-dark); text-decoration: none; display: flex; align-items: center; gap: 6px; }

        .btn-save-next {
            background: var(--primary-teal); color: #FFF; border: none;
            padding: 12px 24px; border-radius: 10px; font-family: var(--font-main);
            font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 8px;
            cursor: pointer; text-decoration: none;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
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
                    <a href="{{ route('staff.index') }}" class="nav-link active">
                        <span class="material-symbols-outlined">group</span>
                        Staff
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('financials.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">payments</span>
                        Financials
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('branches.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">account_tree</span>
                        Branches
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Header -->
        <header class="top-header">
            <div class="header-title-links">
                <a href="#" class="active">Onboard Staff</a>
                <a href="#">Shop Performance</a>
                <a href="#">Live Production</a>
                <a href="#">Active Artisans</a>
            </div>

            <div style="display:flex; align-items:center; gap:14px;">
                <div class="search-bar">
                    <span class="material-symbols-outlined" style="font-size: 16px; color: var(--text-muted);">search</span>
                    <input type="text" placeholder="Search for talent...">
                </div>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">notifications</span>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">history</span>
                <span class="material-symbols-outlined" style="font-size: 24px; color: var(--text-muted); cursor: pointer;">account_circle</span>
            </div>
        </header>

        <!-- Stepper Header -->
        <div class="stepper-container">
            <div class="step-item">
                <div class="step-circle done">✓</div>
                <div class="step-lbl">1. Basic Info</div>
            </div>
            <div class="step-line"></div>
            <div class="step-item">
                <div class="step-circle active">2</div>
                <div class="step-lbl active">2. Skills & Specialties</div>
            </div>
            <div class="step-line"></div>
            <div class="step-item">
                <div class="step-circle">3</div>
                <div class="step-lbl">3. Payout & Security</div>
            </div>
        </div>

        <!-- Content Area -->
        <main class="content-area">
            <div class="form-card">
                <div class="form-card-header">
                    <h3>Define Expertise</h3>
                    <p>Tailor the artisan's profile to match their specific craft. This data helps our auto-allocation engine route the right orders to the right artisan.</p>
                </div>

                <!-- Primary Role Selection -->
                <div class="section-label">Primary Role</div>
                <div class="role-cards-grid">
                    <!-- Master Tailor (Selected) -->
                    <div class="role-card-box selected">
                        <div class="check-badge-top">✓</div>
                        <div class="role-icon-circle">
                            <span class="material-symbols-outlined">badge</span>
                        </div>
                        <div class="role-name">Master Tailor</div>
                        <div class="role-sub">Full construction</div>
                    </div>

                    <!-- Cutter -->
                    <div class="role-card-box">
                        <div class="role-icon-circle">
                            <span class="material-symbols-outlined">content_cut</span>
                        </div>
                        <div class="role-name">Cutter</div>
                        <div class="role-sub">Precision patterns</div>
                    </div>

                    <!-- Stitcher -->
                    <div class="role-card-box">
                        <div class="role-icon-circle">
                            <span class="material-symbols-outlined">precision_manufacturing</span>
                        </div>
                        <div class="role-name">Stitcher</div>
                        <div class="role-sub">High-speed assembly</div>
                    </div>

                    <!-- Finisher -->
                    <div class="role-card-box">
                        <div class="role-icon-circle">
                            <span class="material-symbols-outlined">draw</span>
                        </div>
                        <div class="role-name">Finisher</div>
                        <div class="role-sub">Detailing & Polish</div>
                    </div>
                </div>

                <!-- Artisan Specialties -->
                <div class="section-label">Artisan Specialties <span style="font-weight:400; color:var(--text-muted); font-size:12.5px;">(Select all that apply)</span></div>

                <div class="specialties-grid">
                    <!-- Card 1: Bespoke Suits (Checked) -->
                    <div class="specialty-card selected">
                        <img src="{{ asset('assets/images/bespoke_tailor_atelier_hero.jpg') }}" class="specialty-img" alt="Bespoke Suits">
                        <div class="specialty-body">
                            <div>
                                <div class="specialty-title">Bespoke Suits</div>
                                <div class="specialty-sub">Full canvas, pads, and linings</div>
                            </div>
                            <div class="checkbox-custom">✓</div>
                        </div>
                    </div>

                    <!-- Card 2: Traditional Wear (Unchecked) -->
                    <div class="specialty-card">
                        <img src="{{ asset('assets/images/hero_tailor_atelier.jpg') }}" class="specialty-img" alt="Traditional Wear">
                        <div class="specialty-body">
                            <div>
                                <div class="specialty-title">Traditional Wear</div>
                                <div class="specialty-sub">Sherwanis, Lehengas, Saris</div>
                            </div>
                            <div class="checkbox-custom"></div>
                        </div>
                    </div>

                    <!-- Card 3: Leather Work (Unchecked) -->
                    <div class="specialty-card">
                        <img src="{{ asset('assets/images/onboarding_tailor.jpg') }}" class="specialty-img" alt="Leather Work">
                        <div class="specialty-body">
                            <div>
                                <div class="specialty-title">Leather Work</div>
                                <div class="specialty-sub">Jackets, Bags, Upholstery</div>
                            </div>
                            <div class="checkbox-custom"></div>
                        </div>
                    </div>

                    <!-- Card 4: Embroidery (Checked) -->
                    <div class="specialty-card selected">
                        <img src="{{ asset('assets/images/onboarding_tailor_light.jpg') }}" class="specialty-img" alt="Embroidery">
                        <div class="specialty-body">
                            <div>
                                <div class="specialty-title">Embroidery</div>
                                <div class="specialty-sub">Zardosi, Thread work, Beads</div>
                            </div>
                            <div class="checkbox-custom">✓</div>
                        </div>
                    </div>

                    <!-- Card 5: Alterations (Checked) -->
                    <div class="specialty-card selected">
                        <img src="{{ asset('assets/images/hero_tailor_atelier.jpg') }}" class="specialty-img" alt="Alterations">
                        <div class="specialty-body">
                            <div>
                                <div class="specialty-title">Alterations</div>
                                <div class="specialty-sub">Refitting, resizing, repairs</div>
                            </div>
                            <div class="checkbox-custom">✓</div>
                        </div>
                    </div>

                    <!-- Card 6: Designer Patterns (Unchecked) -->
                    <div class="specialty-card">
                        <img src="{{ asset('assets/images/bespoke_tailor_atelier_hero.jpg') }}" class="specialty-img" alt="Designer Patterns">
                        <div class="specialty-body">
                            <div>
                                <div class="specialty-title">Designer Patterns</div>
                                <div class="specialty-sub">Complex draping & drafting</div>
                            </div>
                            <div class="checkbox-custom"></div>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <a href="{{ route('staff.onboard.step1') }}" class="btn-back-link">
                        <span class="material-symbols-outlined" style="font-size: 18px;">arrow_back</span>
                        Back
                    </a>
                    <a href="{{ route('staff.onboard.step3') }}" class="btn-save-next">
                        Next: Payout & Security
                        <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
                    </a>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
