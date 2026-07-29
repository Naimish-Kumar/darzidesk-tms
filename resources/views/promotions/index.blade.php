<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promotions & Rewards - {{ env('APP_NAME', 'DarziDesk') }}</title>
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

        .brand-box h2 { font-size: 16px; font-weight: 800; color: var(--primary-teal); }
        .brand-box span { font-size: 9px; font-weight: 800; letter-spacing: 1.5px; color: var(--text-muted); display: block; margin-top: 2px; }

        .nav-list { list-style: none; margin-top: 24px; }
        .nav-item { margin-bottom: 4px; }

        .nav-link {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 12px; border-radius: 10px; font-size: 13.5px; font-weight: 600;
            color: var(--text-dark); text-decoration: none; transition: all 0.2s;
        }

        .nav-link.active { background: #E6FFFA; color: var(--primary-teal); font-weight: 700; border-left: 3px solid var(--primary-teal); }

        .sidebar-bottom-owner {
            border-top: 1px solid var(--card-border); padding-top: 16px; margin-top: 20px;
        }

        .owner-info { display: flex; align-items: center; gap: 10px; margin-bottom: 12px; }
        .owner-avatar { width: 34px; height: 34px; border-radius: 50%; object-fit: cover; }

        .btn-new-order-sidebar {
            width: 100%; background: var(--primary-teal); color: #FFF; border: none;
            padding: 10px; border-radius: 8px; font-size: 12.5px; font-weight: 700; cursor: pointer;
        }

        .main-wrapper { margin-left: 240px; flex: 1; display: flex; flex-direction: column; }

        .top-header {
            height: 64px; background: #FFFFFF; border-bottom: 1px solid var(--card-border);
            display: flex; align-items: center; justify-content: space-between; padding: 0 28px;
            position: sticky; top: 0; z-index: 90;
        }

        .search-bar {
            background: #F1F5F9; border-radius: 20px; padding: 6px 16px;
            display: flex; align-items: center; gap: 8px; width: 360px;
        }

        .search-bar input { border: none; background: transparent; outline: none; font-family: var(--font-main); font-size: 12.5px; width: 100%; }

        .header-right { display: flex; align-items: center; gap: 16px; font-size: 12.5px; font-weight: 700; }

        .content-area { padding: 28px; max-width: 1250px; margin: 0 auto; width: 100%; }

        .title-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; }
        .title-row h2 { font-size: 22px; font-weight: 800; }
        .title-row p { font-size: 13px; color: var(--text-muted); margin-top: 2px; }

        .btn-create-coupon {
            background: var(--primary-teal); color: #FFF; border: none;
            padding: 10px 18px; border-radius: 10px; font-size: 13px; font-weight: 700;
            display: flex; align-items: center; gap: 6px; cursor: pointer;
        }

        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; margin-bottom: 28px; }

        .stat-card {
            background: #FFFFFF; border: 1px solid var(--card-border);
            border-radius: 16px; padding: 20px; position: relative;
        }

        .stat-icon-circle { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px; }
        .icon-teal { background: #E6FFFA; color: var(--primary-teal); }
        .icon-blue { background: #EBF3FA; color: #2B6CB0; }
        .icon-red { background: #FEE2E2; color: #E53E3E; }
        .icon-purple { background: #F3E8FF; color: #7E22CE; }

        .stat-lbl { font-size: 10px; font-weight: 800; letter-spacing: 0.8px; color: var(--text-muted); uppercase; margin-bottom: 4px; }
        .stat-val { font-size: 24px; font-weight: 800; font-family: var(--font-code); }
        .stat-trend { font-size: 11px; font-weight: 700; position: absolute; top: 20px; right: 20px; }

        .table-card-box {
            background: #FFFFFF; border: 1px solid var(--card-border);
            border-radius: 18px; overflow: hidden; margin-bottom: 28px;
        }

        .tabs-header-bar {
            display: flex; gap: 24px; padding: 16px 24px 0; border-bottom: 1px solid var(--card-border);
            font-size: 13.5px; font-weight: 700;
        }

        .tab-btn { padding-bottom: 12px; border-bottom: 2px solid transparent; color: var(--text-muted); cursor: pointer; text-decoration: none; }
        .tab-btn.active { color: var(--primary-teal); border-bottom-color: var(--primary-teal); font-weight: 800; }

        .table-filters-bar {
            padding: 16px 24px; display: flex; justify-content: space-between; align-items: center;
            background: #FAFDFD; border-bottom: 1px solid var(--card-border);
        }

        .filter-selects { display: flex; gap: 12px; }
        .f-select { border: 1px solid var(--card-border); border-radius: 8px; padding: 6px 12px; font-family: var(--font-main); font-size: 12px; font-weight: 700; background: #FFF; outline: none; }

        .search-code-box {
            background: #FFF; border: 1px solid var(--card-border); border-radius: 8px;
            padding: 6px 12px; display: flex; align-items: center; gap: 6px; width: 220px;
        }

        .search-code-box input { border: none; outline: none; font-size: 12px; width: 100%; }

        .data-table { width: 100%; border-collapse: collapse; text-align: left; }
        .data-table th { padding: 14px 24px; font-size: 10.5px; font-weight: 800; letter-spacing: 0.8px; color: var(--text-muted); uppercase; border-bottom: 1px solid var(--card-border); }
        .data-table td { padding: 16px 24px; font-size: 13px; border-bottom: 1px solid var(--card-border); }

        .code-pill { font-family: var(--font-code); font-weight: 800; padding: 4px 10px; border-radius: 6px; font-size: 12px; letter-spacing: 0.5px; display: inline-block; }
        .code-teal { background: #E6FFFA; color: var(--primary-teal); border: 1px solid var(--accent-teal); }
        .code-purple { background: #F3E8FF; color: #7E22CE; border: 1px solid #D8B4FE; }
        .code-gray { background: #EDF2F7; color: #4A5568; border: 1px solid #CBD5E1; }

        .progress-bar-bg { width: 80px; height: 6px; background: #E2E8F0; border-radius: 4px; overflow: hidden; display: inline-block; margin-right: 8px; vertical-align: middle; }
        .progress-bar-fill { height: 100%; background: var(--primary-teal); border-radius: 4px; }

        .status-pill { font-size: 11px; font-weight: 700; padding: 2px 8px; border-radius: 10px; display: inline-flex; align-items: center; gap: 4px; }
        .st-active { background: #E6FFFA; color: var(--primary-teal); }
        .st-sched { background: #EBF3FA; color: #2B6CB0; }
        .st-exp { background: #EDF2F7; color: #718096; }

        .pagination-bar { padding: 16px 24px; display: flex; justify-content: space-between; align-items: center; font-size: 12.5px; color: var(--text-muted); }
        .page-nums { display: flex; gap: 6px; }
        .p-btn { width: 28px; height: 28px; border-radius: 6px; border: 1px solid var(--card-border); display: flex; align-items: center; justify-content: center; cursor: pointer; font-weight: 700; }
        .p-btn.active { background: var(--primary-teal); color: #FFF; border-color: var(--primary-teal); }

        .bottom-2col { display: grid; grid-template-columns: 1.8fr 1fr; gap: 24px; margin-bottom: 40px; }

        .campaign-banner-card {
            background: linear-gradient(135deg, #0B1C30 0%, #006A67 100%);
            border-radius: 20px; padding: 28px; color: #FFF; position: relative; overflow: hidden;
            display: flex; flex-direction: column; justify-content: space-between; min-height: 220px;
        }

        .camp-badge { background: rgba(255,255,255,0.15); border: 1px solid rgba(255,255,255,0.25); font-size: 10.5px; font-weight: 800; padding: 4px 12px; border-radius: 20px; display: inline-block; margin-bottom: 12px; }

        .camp-title { font-size: 20px; font-weight: 800; margin-bottom: 6px; }
        .camp-desc { font-size: 13px; opacity: 0.85; max-width: 480px; line-height: 1.4; margin-bottom: 20px; }

        .camp-actions { display: flex; align-items: center; gap: 16px; }
        .btn-view-analytics { background: #FFF; color: var(--dark-navy); border: none; padding: 10px 20px; border-radius: 10px; font-size: 13px; font-weight: 800; cursor: pointer; }

        .banner-bg-illu {
            position: absolute; right: -20px; top: 0; bottom: 0; width: 260px;
            object-fit: cover; opacity: 0.35; border-radius: 0 20px 20px 0; pointer-events: none;
        }

        .loyalty-card {
            background: #FFFFFF; border: 1px solid var(--card-border);
            border-radius: 20px; padding: 24px; display: flex; flex-direction: column; justify-content: space-between;
        }

        .loyalty-title { font-size: 14px; font-weight: 800; display: flex; align-items: center; gap: 6px; color: var(--primary-teal); margin-bottom: 8px; }

        .tier-row { display: flex; justify-content: space-between; font-size: 12.5px; margin-bottom: 4px; }
        .tier-bar-bg { height: 6px; background: #E2E8F0; border-radius: 4px; overflow: hidden; margin-bottom: 12px; }
        .tier-bar-fill { height: 100%; background: var(--primary-teal); border-radius: 4px; }

        .btn-manage-rules {
            width: 100%; background: #FFF; border: 1px solid var(--card-border);
            padding: 10px; border-radius: 10px; font-size: 12.5px; font-weight: 700; cursor: pointer; text-align: center; color: var(--text-dark);
        }

        footer { border-top: 1px solid var(--card-border); padding-top: 20px; display: flex; justify-content: space-between; font-size: 11.5px; color: var(--text-muted); }
    </style>
</head>
<body>

    <!-- Sidebar Nav -->
    <aside class="sidebar">
        <div>
            <div class="brand-box">
                <img src="{{ asset('assets/images/logo_wide.png') }}" alt="DarziDesk" style="height: 32px;">
                <span>ADMIN SUITE</span>
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
                    <a href="{{ route('financials.index') }}" class="nav-link active">
                        <span class="material-symbols-outlined">receipt_long</span>
                        Billing & Rewards
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('orders.index') }}" class="nav-link">
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
                    <a href="{{ route('staff.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">group</span>
                        Staff
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-bottom-owner">
            <div class="owner-info">
                <img src="{{ asset('assets/images/onboarding_tailor.jpg') }}" class="owner-avatar" alt="Master Tailor">
                <div>
                    <h5 style="font-size:12.5px; font-weight:800;">Master Tailor</h5>
                    <p style="font-size:10.5px; color:var(--text-muted);">Shop Owner</p>
                </div>
            </div>
            <button class="btn-new-order-sidebar">New Order</button>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Header -->
        <header class="top-header">
            <div class="search-bar">
                <span class="material-symbols-outlined" style="font-size: 16px; color: var(--text-muted);">search</span>
                <input type="text" placeholder="Search promotions, orders, or customers...">
            </div>

            <div class="header-right">
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">notifications</span>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">settings</span>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">help_outline</span>
                <div style="display:flex; align-items:center; gap:8px;">
                    <span>Administrator</span>
                    <span class="material-symbols-outlined" style="font-size: 18px; color: var(--primary-teal);">account_circle</span>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="content-area">
            <div class="title-row">
                <div>
                    <h2>Promotions & Rewards</h2>
                    <p>Manage bespoke coupons, seasonal campaigns, and customer loyalty incentives.</p>
                </div>

                <button class="btn-create-coupon">
                    <span class="material-symbols-outlined" style="font-size:16px;">add</span>
                    Create New Coupon
                </button>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon-circle icon-teal">
                        <span class="material-symbols-outlined">confirmation_number</span>
                    </div>
                    <div class="stat-lbl">TOTAL COUPONS ISSUED</div>
                    <div class="stat-val">1,284</div>
                    <span class="stat-trend" style="color:#10B981;">+12%</span>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-circle icon-blue">
                        <span class="material-symbols-outlined">campaign</span>
                    </div>
                    <div class="stat-lbl">ACTIVE CAMPAIGNS</div>
                    <div class="stat-val">08</div>
                    <span class="stat-trend" style="color:var(--primary-teal);">Active</span>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-circle icon-red">
                        <span class="material-symbols-outlined">payments</span>
                    </div>
                    <div class="stat-lbl">TOTAL DISCOUNT GIVEN</div>
                    <div class="stat-val">$42,500</div>
                    <span class="stat-trend" style="color:#E53E3E;">-8.4k</span>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-circle icon-purple">
                        <span class="material-symbols-outlined">analytics</span>
                    </div>
                    <div class="stat-lbl">REDEMPTION RATE</div>
                    <div class="stat-val">24.6%</div>
                    <span class="stat-trend" style="color:#10B981;">High</span>
                </div>
            </div>

            <!-- Table Card Box -->
            <div class="table-card-box">
                <div class="tabs-header-bar">
                    <a href="#" class="tab-btn active">Coupons</a>
                    <a href="#" class="tab-btn">Seasonal Campaigns</a>
                    <a href="#" class="tab-btn">Loyalty Rewards</a>
                </div>

                <div class="table-filters-bar">
                    <div class="filter-selects">
                        <select class="f-select"><option>All Statuses ▾</option></select>
                        <select class="f-select"><option>Last 30 Days ▾</option></select>
                    </div>

                    <div class="search-code-box">
                        <span class="material-symbols-outlined" style="font-size:16px; color:var(--text-muted);">search</span>
                        <input type="text" placeholder="Search code...">
                    </div>
                </div>

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>CODE</th>
                            <th>TYPE</th>
                            <th>VALUE</th>
                            <th>PERIOD</th>
                            <th>USAGE</th>
                            <th>STATUS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><span class="code-pill code-teal">BESPOKE20</span></td>
                            <td>Percentage</td>
                            <td><strong>20% OFF</strong></td>
                            <td>Oct 12 — Dec 31 <small style="color:var(--text-muted); display:block;">Expires in 22 days</small></td>
                            <td>
                                <div class="progress-bar-bg"><div class="progress-bar-fill" style="width:85%;"></div></div>
                                <strong>425/500</strong>
                            </td>
                            <td><span class="status-pill st-active">• Active</span></td>
                        </tr>

                        <tr>
                            <td><span class="code-pill code-purple">WINTER50</span></td>
                            <td>Fixed Amount</td>
                            <td><strong>$50.00</strong></td>
                            <td>Nov 01 — Jan 15</td>
                            <td>
                                <div class="progress-bar-bg"><div class="progress-bar-fill" style="width:12%; background:#2B6CB0;"></div></div>
                                <strong>12/100</strong>
                            </td>
                            <td><span class="status-pill st-sched">• Scheduled</span></td>
                        </tr>

                        <tr>
                            <td><span class="code-pill code-gray">EIDGIFT15</span></td>
                            <td>Percentage</td>
                            <td><strong>15% OFF</strong></td>
                            <td>Apr 10 — May 10</td>
                            <td>
                                <div class="progress-bar-bg"><div class="progress-bar-fill" style="width:100%; background:#CBD5E1;"></div></div>
                                <strong>250/250</strong>
                            </td>
                            <td><span class="status-pill st-exp">• Expired</span></td>
                        </tr>
                    </tbody>
                </table>

                <div class="pagination-bar">
                    <div>Showing 1 to 10 of 24 results</div>
                    <div class="page-nums">
                        <div class="p-btn">&lt;</div>
                        <div class="p-btn active">1</div>
                        <div class="p-btn">2</div>
                        <div class="p-btn">3</div>
                        <div class="p-btn">&gt;</div>
                    </div>
                </div>
            </div>

            <!-- Bottom 2 Cards Grid -->
            <div class="bottom-2col">
                <!-- Left Campaign Banner -->
                <div class="campaign-banner-card">
                    <img src="{{ asset('assets/images/bespoke_tailor_atelier_hero.jpg') }}" class="banner-bg-illu" alt="Banner">
                    <div>
                        <span class="camp-badge">Current Active Campaign</span>
                        <div class="camp-title">Eid Al-Fitr Artisan Sale</div>
                        <div class="camp-desc">Drive 2x more conversions during the festive season with automated loyal customer discounts.</div>
                    </div>

                    <div class="camp-actions">
                        <button class="btn-view-analytics">View Analytics</button>
                        <span style="font-size:12.5px; opacity:0.8;">Ending in 4 days</span>
                    </div>
                </div>

                <!-- Right Loyalty Health -->
                <div class="loyalty-card">
                    <div>
                        <div class="loyalty-title">
                            <span class="material-symbols-outlined">star</span>
                            Loyalty Health
                        </div>
                        <div style="font-size:12px; color:var(--text-muted); margin-bottom:16px; line-height:1.4;">
                            Your "VVIP Elite" tier members have contributed to <strong>40%</strong> of this month's revenue.
                        </div>

                        <div class="tier-row">
                            <span>VVIP Elite (42)</span>
                            <span style="font-family:var(--font-code); font-weight:800; color:#10B981;">$12,400</span>
                        </div>
                        <div class="tier-bar-bg"><div class="tier-bar-fill" style="width:75%;"></div></div>

                        <div class="tier-row">
                            <span>Silver (156)</span>
                            <span style="font-family:var(--font-code); font-weight:800; color:var(--primary-teal);">$4,200</span>
                        </div>
                        <div class="tier-bar-bg"><div class="tier-bar-fill" style="width:35%;"></div></div>
                    </div>

                    <button class="btn-manage-rules">Manage Reward Rules</button>
                </div>
            </div>

            <footer>
                <div>© 2024 Tailored Precision • DarziDesk Suite</div>
                <div style="display:flex; gap:16px;">
                    <a href="#" style="color:var(--text-muted); text-decoration:none;">Documentation</a>
                    <a href="#" style="color:var(--text-muted); text-decoration:none;">Support</a>
                    <a href="#" style="color:var(--text-muted); text-decoration:none;">API Reference</a>
                </div>
            </footer>
        </main>
    </div>

</body>
</html>
