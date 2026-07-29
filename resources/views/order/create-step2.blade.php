<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Custom Order - Step 2: Garment & Fabric - {{ env('APP_NAME', 'DarziDesk') }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
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
            --font-code: 'JetBrains Mono', monospace;
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

        .nav-list { list-style: none; margin-top: 24px; }
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

        .header-title-bar { display: flex; align-items: center; gap: 12px; font-size: 13.5px; font-weight: 700; }
        .btn-new-order-badge { background: #E6FFFA; color: var(--primary-teal); padding: 4px 10px; border-radius: 8px; font-size: 12px; font-weight: 800; display: flex; align-items: center; gap: 6px; }

        .search-bar {
            background: #EBF3FA; border-radius: 20px; padding: 6px 14px;
            display: flex; align-items: center; gap: 8px; width: 260px;
        }

        .search-bar input { border: none; background: transparent; outline: none; font-family: var(--font-main); font-size: 12.5px; width: 100%; }

        .stepper-container {
            display: flex; align-items: center; justify-content: center;
            gap: 16px; padding: 24px 0 20px; max-width: 700px; margin: 0 auto;
        }

        .step-item { display: flex; align-items: center; gap: 8px; font-size: 12.5px; font-weight: 700; color: var(--text-muted); }
        .step-circle {
            width: 32px; height: 32px; border-radius: 50%; background: #CBD5E1; color: #FFF;
            font-size: 12.5px; font-weight: 800; display: flex; align-items: center; justify-content: center;
        }

        .step-item.done .step-circle { background: #10B981; }
        .step-item.active { color: var(--primary-teal); }
        .step-item.active .step-circle { background: var(--primary-teal); }

        .step-line { flex: 1; height: 2px; background: #CBD5E1; max-width: 80px; }

        .content-area { padding: 0 28px 40px; max-width: 1050px; margin: 0 auto; width: 100%; }

        .section-header-box { margin-bottom: 20px; }
        .section-header-box h3 { font-size: 20px; font-weight: 800; margin-bottom: 4px; }
        .section-header-box p { font-size: 13px; color: var(--text-muted); }

        .garment-grid { display: grid; grid-template-columns: repeat(6, 1fr); gap: 14px; margin-bottom: 28px; }

        .garment-card {
            background: #FFFFFF; border: 1.5px solid var(--card-border);
            border-radius: 14px; overflow: hidden; cursor: pointer; transition: all 0.2s;
            display: flex; flex-direction: column; align-items: center; text-align: center;
        }

        .garment-card.selected { border-color: var(--primary-teal); background: #E6FFFA; }

        .garment-img { height: 110px; width: 100%; object-fit: cover; }

        .garment-body { padding: 12px 8px; }
        .garment-title { font-size: 13px; font-weight: 800; margin-bottom: 2px; }
        .garment-sub { font-size: 10.5px; color: var(--text-muted); line-height: 1.3; }

        .grid-2col { display: grid; grid-template-columns: 1.4fr 1fr; gap: 24px; margin-bottom: 32px; }

        .info-card {
            background: #FFFFFF; border: 1px solid var(--card-border);
            border-radius: 16px; padding: 24px;
        }

        .card-title {
            font-size: 15px; font-weight: 800; display: flex; align-items: center; gap: 8px; margin-bottom: 20px;
        }

        .form-row-2col { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; margin-bottom: 16px; }

        .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 16px; }
        .form-group label { font-size: 10.5px; font-weight: 800; letter-spacing: 0.5px; color: var(--text-dark); text-transform: uppercase; }

        .input-box {
            background: #FFFFFF; border: 1.5px solid var(--card-border);
            border-radius: 10px; padding: 10px 14px; font-family: var(--font-main);
            font-size: 13px; outline: none; transition: border-color 0.2s; display: flex; align-items: center; gap: 10px;
        }

        .input-box input, .input-box select, .input-box textarea {
            border: none; background: transparent; outline: none; width: 100%; font-family: var(--font-main); font-size: 13px;
        }

        .upload-swatch-box {
            border: 1.5px dashed #CBD5E1; border-radius: 12px; padding: 16px;
            background: #F8FAFC; text-align: center; cursor: pointer; display: flex; align-items: center; gap: 12px;
        }

        .upload-icon-sm { width: 36px; height: 36px; background: #FFF; border: 1px solid var(--card-border); border-radius: 8px; display: flex; align-items: center; justify-content: center; }

        .urgent-alert-box {
            background: #E6FFFA; border: 1px solid var(--accent-teal); border-radius: 10px;
            padding: 10px; font-size: 11.5px; color: var(--primary-teal); font-weight: 700; margin-top: 10px; margin-bottom: 16px; display: flex; align-items: center; gap: 6px;
        }

        .priority-toggle { display: flex; background: #F1F5F9; border-radius: 20px; padding: 4px; gap: 4px; }
        .prio-btn { flex: 1; border: none; padding: 8px; border-radius: 16px; font-family: var(--font-main); font-size: 12px; font-weight: 700; cursor: pointer; background: transparent; color: var(--text-dark); }
        .prio-btn.active { background: var(--accent-teal); color: #FFF; }

        .form-actions-bottom { display: flex; align-items: center; justify-content: space-between; margin-top: 24px; }

        .btn-back { font-size: 13.5px; font-weight: 700; color: var(--text-dark); text-decoration: none; display: flex; align-items: center; gap: 6px; }

        .action-right-btns { display: flex; gap: 12px; }

        .btn-draft {
            background: #FFF; border: 1px solid var(--card-border); border-radius: 10px;
            padding: 12px 20px; font-size: 13.5px; font-weight: 700; cursor: pointer; color: var(--text-dark);
        }

        .btn-next-measurements {
            background: var(--primary-teal); color: #FFF; border: none; border-radius: 10px;
            padding: 12px 24px; font-family: var(--font-main); font-size: 14px; font-weight: 700;
            display: flex; align-items: center; gap: 8px; cursor: pointer; text-decoration: none;
        }
    </style>
</head>
<body>

    <!-- Sidebar Nav -->
    <aside class="sidebar">
        <div>
            <div class="brand-box">
                <img src="{{ asset('assets/images/logo_wide.png') }}" alt="DarziDesk" style="height: 32px;">
                <span>Bespoke Master • London</span>
            </div>

            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <span class="material-symbols-outlined">dashboard</span>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('orders.index') }}" class="nav-link active">
                        <span class="material-symbols-outlined">shopping_bag</span>
                        Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('production.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">cut</span>
                        Production
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('inventory.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">inventory_2</span>
                        Inventory
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('financials.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">payments</span>
                        Financials
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
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Header -->
        <header class="top-header">
            <div class="header-title-bar">
                Shop Workspace
                <span style="color:var(--card-border);">|</span>
                <span class="btn-new-order-badge">
                    <span class="material-symbols-outlined" style="font-size:16px;">add</span>
                    New Custom Order
                </span>
            </div>

            <div style="display:flex; align-items:center; gap:14px;">
                <div class="search-bar">
                    <span class="material-symbols-outlined" style="font-size: 16px; color: var(--text-muted);">search</span>
                    <input type="text" placeholder="Search orders...">
                </div>
                <span class="material-symbols-outlined" style="font-size:20px; color:var(--text-muted); cursor:pointer;">notifications</span>
                <img src="{{ asset('assets/images/onboarding_tailor.jpg') }}" style="width:32px; height:32px; border-radius:50%; object-fit:cover;" alt="User">
            </div>
        </header>

        <!-- Stepper Header -->
        <div class="stepper-container">
            <div class="step-item done">
                <div class="step-circle">✓</div>
                Client Selection
            </div>
            <div class="step-line"></div>
            <div class="step-item active">
                <div class="step-circle">2</div>
                Garment & Fabric
            </div>
            <div class="step-line"></div>
            <div class="step-item">
                <div class="step-circle">3</div>
                Measurements
            </div>
            <div class="step-line"></div>
            <div class="step-item">
                <div class="step-circle">4</div>
                Finalize
            </div>
        </div>

        <!-- Content Area -->
        <main class="content-area">
            <div class="section-header-box">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <h3>Select Garment Type</h3>
                    <span style="font-size:10px; font-weight:800; color:var(--text-muted); letter-spacing:0.5px;">CATEGORY_ID: 402</span>
                </div>
                <p>Choose the base category for this custom piece.</p>
            </div>

            <!-- Garment Cards Grid (6) -->
            <div class="garment-grid">
                <!-- Card 1: 3-Piece Suit (Selected) -->
                <div class="garment-card selected">
                    <img src="{{ asset('assets/images/bespoke_tailor_atelier_hero.jpg') }}" class="garment-img" alt="Suit">
                    <div class="garment-body">
                        <div class="garment-title">3-Piece Suit</div>
                        <div class="garment-sub">Bespoke Jacket, Vest, Pant</div>
                    </div>
                </div>

                <!-- Card 2: Sherwani -->
                <div class="garment-card">
                    <img src="{{ asset('assets/images/hero_tailor_atelier.jpg') }}" class="garment-img" alt="Sherwani">
                    <div class="garment-body">
                        <div class="garment-title">Sherwani</div>
                        <div class="garment-sub">Traditional Wedding Wear</div>
                    </div>
                </div>

                <!-- Card 3: Formal Shirt -->
                <div class="garment-card">
                    <img src="{{ asset('assets/images/onboarding_tailor_light.jpg') }}" class="garment-img" alt="Shirt">
                    <div class="garment-body">
                        <div class="garment-title">Formal Shirt</div>
                        <div class="garment-sub">100% Egyptian Cotton</div>
                    </div>
                </div>

                <!-- Card 4: Waistcoat -->
                <div class="garment-card">
                    <img src="{{ asset('assets/images/onboarding_tailor.jpg') }}" class="garment-img" alt="Waistcoat">
                    <div class="garment-body">
                        <div class="garment-title">Waistcoat</div>
                        <div class="garment-sub">Classic / Double Breasted</div>
                    </div>
                </div>

                <!-- Card 5: Trouser -->
                <div class="garment-card">
                    <img src="{{ asset('assets/images/hero_tailor_atelier.jpg') }}" class="garment-img" alt="Trouser">
                    <div class="garment-body">
                        <div class="garment-title">Trouser</div>
                        <div class="garment-sub">Slim / Regular / Pleated</div>
                    </div>
                </div>

                <!-- Card 6: Blazer -->
                <div class="garment-card">
                    <img src="{{ asset('assets/images/bespoke_tailor_atelier_hero.jpg') }}" class="garment-img" alt="Blazer">
                    <div class="garment-body">
                        <div class="garment-title">Blazer</div>
                        <div class="garment-sub">Sport Coat / Blazer</div>
                    </div>
                </div>
            </div>

            <!-- 2-Column Details Grid -->
            <div class="grid-2col">
                <!-- Left: Fabric Information -->
                <div class="info-card">
                    <div class="card-title">
                        <span class="material-symbols-outlined" style="color:var(--primary-teal);">texture</span>
                        Fabric Information
                    </div>

                    <div class="form-row-2col">
                        <div class="form-group">
                            <label>Fabric SKU / Code</label>
                            <div class="input-box">
                                <input type="text" placeholder="e.g., VIT-120S-449">
                                <span class="material-symbols-outlined" style="font-size:16px; color:var(--text-muted);">qr_code_scanner</span>
                            </div>
                            <div style="font-size:10px; color:var(--text-muted);">Scan barcode or enter fabric ID from swatch book.</div>
                        </div>

                        <div class="form-group">
                            <label>Fabric Mill</label>
                            <div class="input-box">
                                <select><option>Vitale Barberis Canonico</option><option>Scabal</option><option>Dormeuil</option></select>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Fabric Notes & Composition</label>
                        <div class="input-box" style="height:70px;">
                            <textarea placeholder="Describe fabric pattern, weight, or special handling instructions..."></textarea>
                        </div>
                    </div>

                    <div class="upload-swatch-box">
                        <div class="upload-icon-sm">
                            <span class="material-symbols-outlined" style="font-size:18px; color:var(--text-muted);">add_a_photo</span>
                        </div>
                        <div style="text-align:left;">
                            <div style="font-size:12.5px; font-weight:800;">Upload Swatch Image</div>
                            <div style="font-size:11px; color:var(--text-muted);">Optional: Add a photo for production reference.</div>
                        </div>
                    </div>
                </div>

                <!-- Right: Key Milestones -->
                <div class="info-card">
                    <div class="card-title">
                        <span class="material-symbols-outlined" style="color:var(--primary-teal);">event</span>
                        Key Milestones
                    </div>

                    <div class="form-group">
                        <label>FIRST TRIAL DATE</label>
                        <div class="input-box">
                            <input type="text" placeholder="dd/mm/yyyy">
                            <span class="material-symbols-outlined" style="font-size:16px; color:var(--text-muted);">calendar_today</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>COMMITTED DELIVERY DATE</label>
                        <div class="input-box">
                            <input type="text" placeholder="dd/mm/yyyy">
                            <span class="material-symbols-outlined" style="font-size:16px; color:var(--primary-teal);">star</span>
                        </div>

                        <div class="urgent-alert-box">
                            <span class="material-symbols-outlined" style="font-size:16px;">priority_high</span>
                            Urgent: 12-day turnaround selected.
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Priority Status</label>
                        <div class="priority-toggle">
                            <button class="prio-btn">Standard</button>
                            <button class="prio-btn active">Express</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Form Actions Bottom -->
            <div class="form-actions-bottom">
                <a href="{{ route('orders.create.step1') }}" class="btn-back">
                    <span class="material-symbols-outlined" style="font-size:18px;">arrow_back</span>
                    Back to Client Details
                </a>

                <div class="action-right-btns">
                    <button class="btn-draft">Save as Draft</button>
                    <a href="{{ route('orders.index') }}" class="btn-next-measurements">
                        Next: Measurements
                        <span class="material-symbols-outlined" style="font-size:18px;">arrow_forward</span>
                    </a>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
