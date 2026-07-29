<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Profile - Alexander Sterling - {{ env('APP_NAME', 'DarziDesk') }}</title>
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

        .search-bar {
            background: #F1F5F9; border-radius: 20px; padding: 6px 14px;
            display: flex; align-items: center; gap: 8px; width: 300px;
        }

        .search-bar input { border: none; background: transparent; outline: none; font-family: var(--font-main); font-size: 12.5px; width: 100%; }

        .header-right { display: flex; align-items: center; gap: 16px; }

        .user-profile-widget { display: flex; align-items: center; gap: 10px; font-size: 12px; font-weight: 700; }
        .user-avatar { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; }

        .content-area { padding: 28px; }

        .breadcrumb { font-size: 12px; font-weight: 600; color: var(--text-muted); margin-bottom: 8px; }
        .breadcrumb a { color: var(--primary-teal); text-decoration: none; font-weight: 700; }

        .customer-header-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; }

        .customer-title-area { display: flex; align-items: center; gap: 14px; }
        .customer-title-area h2 { font-size: 24px; font-weight: 800; }

        .tag-pill { font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 6px; }
        .tag-vip { background: #FEFCBF; color: #744210; }
        .tag-active { background: #E6FFFA; color: var(--primary-teal); }

        .action-btns { display: flex; gap: 10px; }

        .btn-outline {
            background: #FFF; border: 1px solid var(--card-border); padding: 8px 14px;
            border-radius: 8px; font-family: var(--font-main); font-size: 12.5px; font-weight: 700;
            display: flex; align-items: center; gap: 6px; cursor: pointer; color: var(--text-dark);
        }

        .btn-create-order {
            background: var(--primary-teal); color: #FFF; border: none; padding: 8px 18px;
            border-radius: 8px; font-family: var(--font-main); font-size: 12.5px; font-weight: 700;
            display: flex; align-items: center; gap: 6px; cursor: pointer;
        }

        .grid-layout { display: grid; grid-template-columns: 280px 1fr; gap: 24px; margin-bottom: 28px; }

        .card-box { background: #FFFFFF; border: 1px solid var(--card-border); border-radius: 16px; padding: 20px; margin-bottom: 20px; }

        .contact-card-header { display: flex; gap: 14px; align-items: center; margin-bottom: 16px; }
        .contact-avatar { width: 50px; height: 50px; border-radius: 10px; object-fit: cover; }

        .contact-details-list { display: flex; flex-direction: column; gap: 10px; font-size: 12px; color: var(--text-muted); }
        .contact-details-list div { display: flex; align-items: center; gap: 8px; }

        .physique-title { font-size: 13.5px; font-weight: 800; display: flex; align-items: center; gap: 6px; margin-bottom: 12px; }

        .physique-tags { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 16px; }
        .physique-pill { font-size: 11px; font-weight: 700; background: #E6FFFA; color: var(--primary-teal); padding: 4px 10px; border-radius: 6px; }

        .posture-list { display: flex; flex-direction: column; gap: 10px; font-size: 11.5px; color: var(--text-dark); line-height: 1.4; }
        .posture-item { display: flex; align-items: flex-start; gap: 8px; }

        .history-list { display: flex; flex-direction: column; gap: 12px; font-size: 11.5px; }

        .measurement-card { background: #FFFFFF; border: 1px solid var(--card-border); border-radius: 16px; padding: 24px; }

        .tabs-header { display: flex; gap: 24px; border-bottom: 1px solid var(--card-border); padding-bottom: 12px; margin-bottom: 24px; font-size: 13.5px; font-weight: 700; }
        .tab-item { color: var(--text-muted); text-decoration: none; padding-bottom: 10px; border-bottom: 2px solid transparent; }
        .tab-item.active { color: var(--primary-teal); border-bottom-color: var(--primary-teal); }

        .measurement-split { display: grid; grid-template-columns: 200px 1fr; gap: 28px; margin-bottom: 24px; }

        .mannequin-container {
            background: #F8FAFC; border: 1px solid var(--card-border); border-radius: 14px;
            padding: 20px; display: flex; flex-direction: column; align-items: center; justify-content: center; position: relative;
        }

        .interactive-tag { position: absolute; top: 12px; left: 12px; font-size: 9px; font-weight: 800; background: #FFF; border: 1px solid var(--card-border); padding: 2px 6px; border-radius: 4px; color: var(--primary-teal); }

        .mannequin-wireframe { width: 100px; height: 180px; border: 2px dashed #94A3B8; border-radius: 40px 40px 10px 10px; position: relative; margin: 20px 0; }

        .tag-box { background: #FFF; border: 1px solid var(--card-border); padding: 4px 8px; border-radius: 6px; font-size: 10px; font-weight: 700; text-align: center; margin-top: 6px; width: 100%; }

        .values-stack { display: flex; flex-direction: column; gap: 12px; }

        .val-item {
            border: 1.5px solid var(--card-border); border-radius: 12px; padding: 12px 16px;
            display: flex; justify-content: space-between; align-items: center;
        }

        .val-item.highlight { border-color: var(--primary-teal); background: #FAFDFD; }

        .val-name { font-size: 13px; font-weight: 700; }
        .val-sub { font-size: 11px; color: var(--text-muted); margin-top: 2px; }

        .val-num { font-family: var(--font-code); font-size: 16px; font-weight: 800; text-align: right; }
        .val-unit { font-size: 10px; color: var(--primary-teal); font-weight: 700; }
        .val-change { font-size: 10px; color: #E53E3E; font-weight: 700; }

        .special-req-box {
            background: #F8FAFC; border: 1px solid var(--card-border); border-radius: 12px;
            padding: 16px; font-size: 12px; color: var(--text-dark); line-height: 1.5; font-style: italic;
        }

        .recent-orders-header { font-size: 15px; font-weight: 800; margin-bottom: 16px; }

        .orders-2col { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

        .order-summary-card {
            background: #FFFFFF; border: 1px solid var(--card-border); border-radius: 14px;
            padding: 16px; display: flex; align-items: center; gap: 14px; justify-content: space-between;
        }

        .order-icon { width: 36px; height: 36px; background: #E6FFFA; color: var(--primary-teal); border-radius: 8px; display: flex; align-items: center; justify-content: center; }

        .order-info h5 { font-size: 13.5px; font-weight: 800; margin-bottom: 2px; }
        .order-info p { font-size: 11.5px; color: var(--text-muted); }
    </style>
</head>
<body>

    <!-- Sidebar Nav -->
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
                    <a href="{{ route('customers.index') }}" class="nav-link active">
                        <span class="material-symbols-outlined">group</span>
                        Customers
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('orders.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">shopping_bag</span>
                        Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('financials.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">payments</span>
                        Financials
                    </a>
                </li>
            </ul>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Header -->
        <header class="top-header">
            <div class="search-bar">
                <span class="material-symbols-outlined" style="font-size: 16px; color: var(--text-muted);">search</span>
                <input type="text" placeholder="Search customers, orders...">
            </div>

            <div class="header-right">
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">history</span>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">notifications</span>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">settings</span>
                <div class="user-profile-widget">
                    <span>James Harrington<br><small style="color:var(--text-muted);">Master Tailor</small></span>
                    <img src="{{ asset('assets/images/onboarding_tailor.jpg') }}" class="user-avatar" alt="Master Tailor">
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="content-area">
            <div class="breadcrumb">
                <a href="{{ route('customers.index') }}">Customers</a> › Alexander Sterling
            </div>

            <div class="customer-header-row">
                <div class="customer-title-area">
                    <h2>Alexander Sterling</h2>
                    <span class="tag-pill tag-vip">VIP CLIENT</span>
                    <span class="tag-pill tag-active">ACTIVE SUBSCRIPTIONS</span>
                </div>

                <div class="action-btns">
                    <button class="btn-outline">
                        <span class="material-symbols-outlined" style="font-size: 16px;">picture_as_pdf</span>
                        Download PDF Profile
                    </button>
                    <button class="btn-outline">
                        <span class="material-symbols-outlined" style="font-size: 16px;">edit</span>
                        Edit Measurements
                    </button>
                    <button class="btn-create-order">
                        <span class="material-symbols-outlined" style="font-size: 16px;">add_shopping_cart</span>
                        Create Order
                    </button>
                </div>
            </div>

            <!-- Grid Layout -->
            <div class="grid-layout">
                <!-- Left Column -->
                <div>
                    <!-- Contact Details Card -->
                    <div class="card-box">
                        <div class="contact-card-header">
                            <img src="{{ asset('assets/images/hero_tailor_atelier.jpg') }}" class="contact-avatar" alt="Alexander Sterling">
                            <div>
                                <div style="font-size:13px; font-weight:800;">Contact Details</div>
                                <div style="font-size:11px; color:var(--text-muted);">Last Visit: Oct 12, 2023</div>
                            </div>
                        </div>

                        <div class="contact-details-list">
                            <div>
                                <span class="material-symbols-outlined" style="font-size:16px;">mail</span>
                                a.sterling@enterprise.com
                            </div>
                            <div>
                                <span class="material-symbols-outlined" style="font-size:16px;">call</span>
                                +1 (555) 012-3456
                            </div>
                            <div>
                                <span class="material-symbols-outlined" style="font-size:16px;">location_on</span>
                                Greenwich, London, UK
                            </div>
                        </div>
                    </div>

                    <!-- Physique Profile Card -->
                    <div class="card-box">
                        <div class="physique-title">
                            <span class="material-symbols-outlined" style="font-size:18px; color:var(--primary-teal);">accessibility_new</span>
                            Physique Profile
                        </div>

                        <div style="font-size:10px; font-weight:800; letter-spacing:0.8px; color:var(--text-muted); margin-bottom:6px;">BODY SHAPE</div>
                        <div class="physique-tags">
                            <span class="physique-pill">Athletic V-Taper</span>
                            <span class="physique-pill">Broad Shoulders</span>
                        </div>

                        <div style="font-size:10px; font-weight:800; letter-spacing:0.8px; color:var(--text-muted); margin-bottom:6px;">POSTURE NOTES</div>
                        <div class="posture-list">
                            <div class="posture-item">
                                <span class="material-symbols-outlined" style="font-size:16px; color:#D69E2E;">warning</span>
                                Slightly dropped right shoulder (-1.5cm).
                            </div>
                            <div class="posture-item">
                                <span class="material-symbols-outlined" style="font-size:16px; color:#10B981;">check_circle</span>
                                Erect posture, requires minimal back-collar adjustment.
                            </div>
                            <div class="posture-item">
                                <span class="material-symbols-outlined" style="font-size:16px; color:#10B981;">check_circle</span>
                                Prominent chest development; extra ease required in lapel break.
                            </div>
                        </div>
                    </div>

                    <!-- Change History -->
                    <div class="card-box">
                        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:12px;">
                            <div style="font-size:13px; font-weight:800;">Change History</div>
                            <a href="#" style="font-size:11px; font-weight:700; color:var(--primary-teal); text-decoration:none;">View All</a>
                        </div>

                        <div class="history-list">
                            <div>
                                <div style="font-weight:700;">Measurements Updated</div>
                                <div style="font-size:10.5px; color:var(--text-muted);">Oct 12, 2023 • By James H.</div>
                                <div style="font-size:11px; margin-top:2px;">Waist increased by +1.5cm due to comfort preference.</div>
                            </div>
                            <div>
                                <div style="font-weight:700;">Profile Created</div>
                                <div style="font-size:10.5px; color:var(--text-muted);">Mar 04, 2023 • By Sarah K.</div>
                                <div style="font-size:11px; margin-top:2px;">Initial comprehensive measurement profile recorded.</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Measurement Card -->
                <div>
                    <div class="measurement-card">
                        <div class="tabs-header">
                            <a href="#" class="tab-item active">Upper Body</a>
                            <a href="#" class="tab-item">Trousers</a>
                            <a href="#" class="tab-item">Overcoat</a>
                            <a href="#" class="tab-item">Historical Logs</a>
                        </div>

                        <div class="measurement-split">
                            <!-- Mannequin Diagram -->
                            <div class="mannequin-container">
                                <span class="interactive-tag">• Interactive Reference</span>
                                <div class="mannequin-wireframe"></div>
                                <div class="tag-box">Shoulder Width: 48.5 cm</div>
                                <div class="tag-box">Arm Length: 64.0 cm</div>
                            </div>

                            <!-- Measurement Values List -->
                            <div class="values-stack">
                                <div class="val-item highlight">
                                    <div>
                                        <div class="val-name">Neck Circumference</div>
                                        <div class="val-sub">Measured at base of neck</div>
                                    </div>
                                    <div>
                                        <div class="val-num">41.5 <span class="val-unit">cm</span></div>
                                        <div class="val-change">+0.5 vs Last</div>
                                    </div>
                                </div>

                                <div class="val-item">
                                    <div>
                                        <div class="val-name">Chest (Full)</div>
                                        <div class="val-sub">Across widest part of chest</div>
                                    </div>
                                    <div>
                                        <div class="val-num">108.0 <span class="val-unit">cm</span></div>
                                        <div style="font-size:10px; color:var(--text-muted);">No change</div>
                                    </div>
                                </div>

                                <div class="val-item highlight">
                                    <div>
                                        <div class="val-name">Waist (Natural)</div>
                                        <div class="val-sub">Measured at naval line</div>
                                    </div>
                                    <div>
                                        <div class="val-num">92.0 <span class="val-unit">cm</span></div>
                                        <div class="val-change">+1.5 vs Last</div>
                                    </div>
                                </div>

                                <div class="val-item">
                                    <div>
                                        <div class="val-name">Shoulder to Shoulder</div>
                                        <div class="val-sub">Bone-to-bone width</div>
                                    </div>
                                    <div>
                                        <div class="val-num">48.5 <span class="val-unit">cm</span></div>
                                        <div style="font-size:10px; color:var(--text-muted);">No change</div>
                                    </div>
                                </div>

                                <div class="val-item">
                                    <div>
                                        <div class="val-name">Jacket Length</div>
                                        <div class="val-sub">Base of neck to seat</div>
                                    </div>
                                    <div>
                                        <div class="val-num">76.0 <span class="val-unit">cm</span></div>
                                        <div style="font-size:10px; color:var(--text-muted);">No change</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Special Requirements Box -->
                        <div class="special-req-box">
                            <strong>Special Requirements:</strong> "Client prefers a snug fit around the waist for a modern silhouette, but requires extra ease in the armholes for mobility during driving."
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Orders using these Measurements -->
            <div class="recent-orders-header">Recent Orders using these Measurements</div>
            <div class="orders-2col">
                <div class="order-summary-card">
                    <div style="display:flex; align-items:center; gap:12px;">
                        <div class="order-icon">
                            <span class="material-symbols-outlined">dry_cleaning</span>
                        </div>
                        <div class="order-info">
                            <h5>Navy Worsted Wool Suit</h5>
                            <p>Order #ORD-8821 • Delivered Oct 2023</p>
                        </div>
                    </div>
                    <span class="material-symbols-outlined" style="cursor:pointer; color:var(--primary-teal);">open_in_new</span>
                </div>

                <div class="order-summary-card">
                    <div style="display:flex; align-items:center; gap:12px;">
                        <div class="order-icon" style="background:#EBF3FA; color:#2B6CB0;">
                            <span class="material-symbols-outlined">content_cut</span>
                        </div>
                        <div class="order-info">
                            <h5>Charcoal Tweed Blazer</h5>
                            <p>Order #ORD-7104 • Delivered Jun 2023</p>
                        </div>
                    </div>
                    <span class="material-symbols-outlined" style="cursor:pointer; color:var(--primary-teal);">open_in_new</span>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
