<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Branch - Step 3: Operational Settings - {{ env('APP_NAME', 'DarziDesk') }}</title>
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

        .btn-add-branch-nav {
            width: 100%; background: var(--primary-teal); color: #FFF; border: none;
            padding: 12px; border-radius: 10px; font-family: var(--font-main);
            font-size: 13.5px; font-weight: 700; display: flex; align-items: center; justify-content: center; gap: 8px; cursor: pointer;
        }

        .main-wrapper { margin-left: 240px; flex: 1; display: flex; flex-direction: column; }

        .top-header {
            height: 64px; background: #FFFFFF; border-bottom: 1px solid var(--card-border);
            display: flex; align-items: center; justify-content: space-between; padding: 0 28px;
            position: sticky; top: 0; z-index: 90;
        }

        .search-bar {
            background: #F1F5F9; border-radius: 20px; padding: 6px 14px;
            display: flex; align-items: center; gap: 8px; width: 340px;
        }

        .search-bar input { border: none; background: transparent; outline: none; font-family: var(--font-main); font-size: 12.5px; width: 100%; }

        .header-right { display: flex; align-items: center; gap: 16px; }

        .content-area { padding: 28px; max-width: 1100px; margin: 0 auto; width: 100%; }

        .title-stepper-row { display: flex; align-items: center; justify-content: space-between; margin-bottom: 24px; }
        .title-stepper-row h2 { font-size: 22px; font-weight: 800; }

        .stepper-mini { display: flex; align-items: center; gap: 12px; }
        .step-mini-item { display: flex; align-items: center; gap: 6px; font-size: 12px; font-weight: 700; color: var(--text-muted); }
        .step-mini-circle { width: 24px; height: 24px; border-radius: 50%; background: #10B981; color: #FFF; font-size: 11px; display: flex; align-items: center; justify-content: center; }
        .step-mini-circle.active { background: var(--primary-teal); }

        .grid-2col { display: grid; grid-template-columns: 1.8fr 1fr; gap: 24px; }

        .settings-card {
            background: #FFFFFF; border: 1px solid var(--card-border);
            border-radius: 18px; padding: 24px; margin-bottom: 20px;
        }

        .settings-card-title {
            font-size: 16px; font-weight: 800; display: flex; align-items: center; gap: 10px; margin-bottom: 20px;
        }

        .time-row {
            display: flex; align-items: center; justify-content: space-between;
            padding: 12px 0; border-bottom: 1px solid #F1F5F9; font-size: 13.5px;
        }

        .time-row:last-child { border-bottom: none; }

        .day-toggle { display: flex; align-items: center; gap: 12px; font-weight: 700; min-width: 120px; }

        .toggle-switch {
            width: 38px; height: 20px; background: var(--primary-teal); border-radius: 10px;
            position: relative; cursor: pointer; display: inline-block;
        }

        .toggle-switch::after {
            content: ''; position: absolute; top: 2px; right: 2px; width: 16px; height: 16px;
            background: #FFF; border-radius: 50%; transition: all 0.2s;
        }

        .toggle-switch.off { background: #CBD5E1; }
        .toggle-switch.off::after { right: 20px; }

        .time-inputs { display: flex; align-items: center; gap: 10px; }

        .time-box {
            background: #EBF3FA; border: 1px solid var(--card-border); border-radius: 8px;
            padding: 6px 12px; font-size: 12.5px; font-weight: 600; display: flex; align-items: center; gap: 6px;
        }

        .btn-apply-all {
            color: var(--primary-teal); font-size: 13px; font-weight: 700; text-decoration: none;
            display: inline-flex; align-items: center; gap: 6px; margin-top: 14px;
        }

        .form-grid-2col { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group label { font-size: 10px; font-weight: 800; letter-spacing: 0.8px; color: var(--text-muted); }

        .select-box {
            background: #EBF3FA; border: 1px solid var(--card-border); border-radius: 10px;
            padding: 10px 12px; font-family: var(--font-main); font-size: 13px; font-weight: 700;
        }

        .select-box select { border: none; background: transparent; outline: none; width: 100%; font-family: var(--font-main); font-size: 13px; font-weight: 700; }

        .sub-hint { font-size: 11px; color: var(--text-muted); margin-top: 4px; line-height: 1.3; }

        .bottom-actions-row {
            display: flex; align-items: center; justify-content: space-between; margin-top: 24px;
        }

        .btn-previous-link { font-size: 13.5px; font-weight: 700; color: var(--text-dark); text-decoration: none; display: flex; align-items: center; gap: 6px; }

        .btn-complete-setup {
            background: var(--primary-teal); color: #FFF; border: none;
            padding: 12px 24px; border-radius: 10px; font-family: var(--font-main);
            font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 8px;
            cursor: pointer; text-decoration: none;
        }

        .preview-card {
            background: #FFFFFF; border: 1px solid var(--card-border);
            border-radius: 18px; overflow: hidden; margin-bottom: 20px;
        }

        .preview-hero {
            height: 140px; background: #0B1C30; position: relative;
            background-image: url('{{ asset('assets/images/bespoke_tailor_atelier_hero.jpg') }}'); background-size: cover; background-position: center;
        }

        .preview-body { padding: 20px; }

        .preview-title { font-size: 18px; font-weight: 800; margin-bottom: 4px; }
        .preview-address { font-size: 12px; color: var(--text-muted); margin-bottom: 16px; }

        .progress-bar-bg { height: 6px; background: #E2E8F0; border-radius: 3px; overflow: hidden; margin-top: 6px; margin-bottom: 16px; }
        .progress-bar-fill { height: 100%; background: var(--primary-teal); }

        .pills-row { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 20px; }
        .pill-item { font-size: 9.5px; font-weight: 800; letter-spacing: 0.5px; background: #E6FFFA; color: var(--primary-teal); padding: 4px 8px; border-radius: 6px; }

        .info-notice-box {
            background: #F0F9FF; border: 1px solid #BAE6FD; border-radius: 12px;
            padding: 12px; font-size: 12px; color: #0C4A6E; display: flex; gap: 8px; line-height: 1.4;
        }

        .help-card {
            background: #FFFFFF; border: 1px solid var(--card-border);
            border-radius: 14px; padding: 16px; display: flex; align-items: center; justify-content: space-between;
            cursor: pointer; text-decoration: none; color: var(--text-dark);
        }

        .help-card h5 { font-size: 13.5px; font-weight: 700; }
        .help-card p { font-size: 11.5px; color: var(--text-muted); }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div>
            <div class="brand-box">
                <h2>Bespoke Pro</h2>
                <span>ENTERPRISE SUITE</span>
            </div>

            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <span class="material-symbols-outlined">dashboard</span>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profile.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">storefront</span>
                        Business Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('branches.index') }}" class="nav-link active">
                        <span class="material-symbols-outlined">account_tree</span>
                        Branch Management
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('roles.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">verified_user</span>
                        Roles & Permissions
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('billing.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">receipt_long</span>
                        Billing
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('orders.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">shopping_bag</span>
                        Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="material-symbols-outlined">cut</span>
                        Production
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="material-symbols-outlined">inventory_2</span>
                        Inventory
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('staff.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">group</span>
                        Staff
                    </a>
                </li>
            </ul>
        </div>

        <div>
            <a href="{{ route('branches.create.step1') }}" class="btn-add-branch-nav">
                <span class="material-symbols-outlined">add</span>
                Add New Branch
            </a>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Header -->
        <header class="top-header">
            <div class="search-bar">
                <span class="material-symbols-outlined" style="font-size: 16px; color: var(--text-muted);">search</span>
                <input type="text" placeholder="Search orders, staff, or branches...">
            </div>

            <div class="header-right">
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">history</span>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">notifications</span>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">settings</span>
                <img src="{{ asset('assets/images/onboarding_tailor.jpg') }}" style="width:32px; height:32px; border-radius:50%; object-fit:cover;" alt="User">
            </div>
        </header>

        <!-- Content Area -->
        <main class="content-area">
            <div class="title-stepper-row">
                <div>
                    <span style="font-size: 12px; font-weight: 700; color: var(--text-muted);">Branch Management › Add New Branch</span>
                    <h2>Step 3: Operational Settings</h2>
                </div>

                <div class="stepper-mini">
                    <div class="step-mini-item">
                        <div class="step-mini-circle">✓</div> Details
                    </div>
                    <div style="width: 20px; height: 2px; background: #10B981;"></div>
                    <div class="step-mini-item">
                        <div class="step-mini-circle">✓</div> Capabilities
                    </div>
                    <div style="width: 20px; height: 2px; background: var(--primary-teal);"></div>
                    <div class="step-mini-item">
                        <div class="step-mini-circle active">3</div> Operations
                    </div>
                </div>
            </div>

            <div class="grid-2col">
                <!-- Left Column: Forms -->
                <div>
                    <!-- Business Hours -->
                    <div class="settings-card">
                        <div class="settings-card-title">
                            <span class="material-symbols-outlined" style="color: var(--primary-teal);">schedule</span>
                            Business Hours
                        </div>

                        <div class="time-row">
                            <div class="day-toggle">
                                <div class="toggle-switch"></div>
                                Monday
                            </div>
                            <div class="time-inputs">
                                <div class="time-box">09:00 AM <span class="material-symbols-outlined" style="font-size:14px;">schedule</span></div>
                                <span style="font-size:12px; color:var(--text-muted);">to</span>
                                <div class="time-box">06:00 PM <span class="material-symbols-outlined" style="font-size:14px;">schedule</span></div>
                                <span class="material-symbols-outlined" style="font-size:18px; color:var(--text-muted); cursor:pointer;">delete</span>
                            </div>
                        </div>

                        <div class="time-row">
                            <div class="day-toggle">
                                <div class="toggle-switch"></div>
                                Tuesday
                            </div>
                            <div class="time-inputs">
                                <div class="time-box">09:00 AM <span class="material-symbols-outlined" style="font-size:14px;">schedule</span></div>
                                <span style="font-size:12px; color:var(--text-muted);">to</span>
                                <div class="time-box">06:00 PM <span class="material-symbols-outlined" style="font-size:14px;">schedule</span></div>
                                <span class="material-symbols-outlined" style="font-size:18px; color:var(--text-muted); cursor:pointer;">delete</span>
                            </div>
                        </div>

                        <div class="time-row">
                            <div class="day-toggle">
                                <div class="toggle-switch off"></div>
                                Sunday
                            </div>
                            <div style="font-size:13px; color:var(--text-muted); font-style:italic;">Closed</div>
                        </div>

                        <a href="#" class="btn-apply-all">
                            <span class="material-symbols-outlined" style="font-size:16px;">add_circle</span>
                            Apply to all days
                        </a>
                    </div>

                    <!-- Localization & Financials -->
                    <div class="settings-card">
                        <div class="settings-card-title">
                            <span class="material-symbols-outlined" style="color: var(--primary-teal);">language</span>
                            Localization & Financials
                        </div>

                        <div class="form-grid-2col">
                            <div class="form-group">
                                <label>DEFAULT CURRENCY</label>
                                <div class="select-box">
                                    <select>
                                        <option>GBP - British Pound (£)</option>
                                        <option>USD - US Dollar ($)</option>
                                        <option>EUR - Euro (€)</option>
                                    </select>
                                </div>
                                <div class="sub-hint">This will be used for all invoices generated by this branch.</div>
                            </div>

                            <div class="form-group">
                                <label>BRANCH TIMEZONE</label>
                                <div class="select-box">
                                    <select>
                                        <option>GMT +00:00 (London)</option>
                                        <option>EST -05:00 (New York)</option>
                                    </select>
                                </div>
                                <div class="sub-hint">Used for scheduling bookings and production deadlines.</div>
                            </div>
                        </div>
                    </div>

                    <div class="bottom-actions-row">
                        <a href="{{ route('branches.create.step2') }}" class="btn-previous-link">
                            <span class="material-symbols-outlined" style="font-size:18px;">arrow_back</span>
                            Previous Step
                        </a>

                        <div style="display:flex; align-items:center; gap:16px;">
                            <a href="{{ route('branches.index') }}" style="font-size:13.5px; font-weight:700; color:var(--text-muted); text-decoration:none;">Save Draft</a>
                            <a href="{{ route('branches.index') }}" class="btn-complete-setup">
                                Complete Setup
                                <span class="material-symbols-outlined" style="font-size:18px;">check_circle</span>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Preview -->
                <div>
                    <div class="preview-card">
                        <div class="preview-hero"></div>
                        <div class="preview-body">
                            <div class="preview-title">Savile Row Annex</div>
                            <div class="preview-address">15 Savile Row, Mayfair, London, W1S 3PJ</div>

                            <div style="display:flex; justify-content:space-between; font-size:12px; font-weight:700;">
                                <span>Setup Progress</span>
                                <span style="color:var(--primary-teal);">85%</span>
                            </div>
                            <div class="progress-bar-bg">
                                <div class="progress-bar-fill" style="width: 85%;"></div>
                            </div>

                            <div class="pills-row">
                                <span class="pill-item">BESPOKE SUITE</span>
                                <span class="pill-item">EXPRESS ALTERATION</span>
                                <span class="pill-item">FABRIC SOURCING</span>
                            </div>

                            <div class="info-notice-box">
                                <span class="material-symbols-outlined" style="font-size:18px; color:#0284C7;">info</span>
                                <div>Completing this step will finalize the branch creation and allow you to start assigning staff and inventory.</div>
                            </div>
                        </div>
                    </div>

                    <a href="#" class="help-card">
                        <div>
                            <h5>Need help?</h5>
                            <p>Operational Guidelines</p>
                        </div>
                        <span class="material-symbols-outlined" style="color:var(--text-muted);">arrow_forward</span>
                    </a>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
