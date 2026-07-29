<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Executive Overview - {{ env('APP_NAME', 'DarziDesk') }}</title>
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

        .brand-box { display: flex; align-items: center; gap: 10px; }
        .brand-box h2 { font-size: 16px; font-weight: 800; color: var(--primary-teal); }
        .brand-box span { font-size: 9px; font-weight: 800; letter-spacing: 1.5px; color: var(--text-muted); display: block; }

        .nav-section-label { font-size: 10px; font-weight: 800; letter-spacing: 1px; color: var(--text-muted); uppercase; margin: 16px 0 6px 12px; }

        .nav-list { list-style: none; }
        .nav-item { margin-bottom: 2px; }

        .nav-link {
            display: flex; align-items: center; gap: 12px;
            padding: 8px 12px; border-radius: 10px; font-size: 13px; font-weight: 600;
            color: var(--text-dark); text-decoration: none; transition: all 0.2s;
        }

        .nav-link.active { background: #E6FFFA; color: var(--primary-teal); font-weight: 700; border-left: 3px solid var(--primary-teal); }

        .sidebar-user-widget {
            background: #F8FAFC; border-radius: 12px; padding: 10px; display: flex; align-items: center; gap: 10px;
        }
        .user-avatar { width: 34px; height: 34px; border-radius: 50%; object-fit: cover; }

        .main-wrapper { margin-left: 240px; flex: 1; display: flex; flex-direction: column; }

        .top-header {
            height: 64px; background: #FFFFFF; border-bottom: 1px solid var(--card-border);
            display: flex; align-items: center; justify-content: space-between; padding: 0 28px;
            position: sticky; top: 0; z-index: 90;
        }

        .search-bar {
            background: #F1F5F9; border-radius: 20px; padding: 6px 16px;
            display: flex; align-items: center; gap: 8px; width: 340px;
        }

        .search-bar input { border: none; background: transparent; outline: none; font-family: var(--font-main); font-size: 12.5px; width: 100%; }

        .btn-export-report {
            background: var(--primary-teal); color: #FFF; border: none;
            padding: 8px 16px; border-radius: 8px; font-size: 12.5px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 6px;
        }

        .content-area { padding: 28px; max-width: 1250px; margin: 0 auto; width: 100%; position: relative; }

        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; margin-bottom: 28px; }

        .stat-card {
            background: #FFFFFF; border: 1px solid var(--card-border);
            border-radius: 16px; padding: 20px; position: relative;
        }

        .stat-card-header { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 8px; }
        .stat-title { font-size: 12px; font-weight: 700; color: var(--text-muted); }
        .stat-icon { font-size: 28px; opacity: 0.25; color: var(--text-dark); }

        .stat-val { font-size: 28px; font-weight: 800; font-family: var(--font-code); margin-bottom: 4px; }
        .stat-sub { font-size: 11px; font-weight: 700; }

        .grid-2col { display: grid; grid-template-columns: 1.8fr 1fr; gap: 24px; margin-bottom: 28px; }

        .card-box { background: #FFFFFF; border: 1px solid var(--card-border); border-radius: 18px; padding: 24px; }
        .card-box-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .card-box-title { font-size: 15px; font-weight: 800; }

        .branch-table { width: 100%; border-collapse: collapse; text-align: left; }
        .branch-table th { font-size: 10.5px; font-weight: 800; letter-spacing: 0.8px; color: var(--text-muted); uppercase; padding-bottom: 12px; border-bottom: 1px solid var(--card-border); }
        .branch-table td { padding: 14px 0; font-size: 13px; border-bottom: 1px solid var(--card-border); }

        .branch-avatar-circle {
            width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center;
            font-size: 11px; font-weight: 800; color: #FFF; flex-shrink: 0;
        }

        .growth-pill-green { background: #E6FFFA; color: var(--primary-teal); font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 6px; }
        .growth-pill-red { background: #FEE2E2; color: #E53E3E; font-size: 11px; font-weight: 800; padding: 2px 8px; border-radius: 6px; }

        .capacity-dot { width: 6px; height: 6px; border-radius: 50%; display: inline-block; margin-right: 4px; }

        .artisan-list { display: flex; flex-direction: column; gap: 14px; margin-bottom: 20px; }

        .artisan-row { display: flex; justify-content: space-between; align-items: center; }
        .artisan-left { display: flex; align-items: center; gap: 10px; }

        .rank-badge {
            width: 20px; height: 20px; border-radius: 50%; font-size: 10px; font-weight: 800;
            display: flex; align-items: center; justify-content: center; color: #FFF; position: absolute; bottom: -2px; right: -2px;
        }

        .artisan-avatar-wrap { position: relative; }
        .artisan-avatar { width: 38px; height: 38px; border-radius: 50%; object-fit: cover; }

        .artisan-name { font-size: 13px; font-weight: 800; }
        .artisan-sub { font-size: 11px; color: var(--text-muted); }

        .artisan-rev { font-family: var(--font-code); font-weight: 800; font-size: 14px; color: var(--primary-teal); text-align: right; }

        .btn-view-leaderboard {
            width: 100%; background: #F8FAFC; border: 1px solid var(--card-border);
            padding: 10px; border-radius: 10px; font-size: 12.5px; font-weight: 700; cursor: pointer; text-align: center; color: var(--text-dark);
        }

        .bottom-grid-2col { display: grid; grid-template-columns: 1.8fr 1fr; gap: 24px; }

        .chart-placeholder-box {
            height: 140px; border: 1px dashed var(--card-border); border-radius: 12px;
            display: flex; align-items: center; justify-content: center; color: var(--text-muted); font-size: 12px; font-weight: 700; margin-top: 10px;
        }

        .target-cluster-row { margin-bottom: 14px; }
        .target-header { display: flex; justify-content: space-between; font-size: 12px; font-weight: 700; margin-bottom: 6px; }

        .bar-bg { height: 8px; background: #E2E8F0; border-radius: 4px; overflow: hidden; }
        .bar-fill { height: 100%; background: var(--primary-teal); border-radius: 4px; }

        .fab-add-btn {
            position: absolute; bottom: 28px; right: 28px; width: 48px; height: 48px;
            border-radius: 50%; background: var(--primary-teal); color: #FFF;
            border: none; display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 12px rgba(0,106,103,0.3); cursor: pointer;
        }
    </style>
</head>
<body>

    <!-- Sidebar Nav -->
    <aside class="sidebar">
        <div>
            <div class="brand-box">
                <span class="material-symbols-outlined" style="font-size:28px; color:var(--primary-teal);">view_in_ar</span>
                <div>
                    <h2>Bespoke Enterprise</h2>
                    <span>Management Suite</span>
                </div>
            </div>

            <ul class="nav-list" style="margin-top:20px;">
                <li class="nav-item">
                    <a href="{{ route('executive.index') }}" class="nav-link active">
                        <span class="material-symbols-outlined">dashboard</span>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('pos.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">receipt</span>
                        Transactions
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('inventory.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">inventory_2</span>
                        Inventory
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('orders.create.step3') }}" class="nav-link">
                        <span class="material-symbols-outlined">straighten</span>
                        Measurements
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('reconciliation.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">point_of_sale</span>
                        Reconciliation
                    </a>
                </li>
            </ul>

            <div class="nav-section-label">OPERATIONS</div>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ route('staff.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">group</span>
                        Staff
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('profile.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">storefront</span>
                        Business Profile
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('branches.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">account_tree</span>
                        Branch Management
                    </a>
                </li>
            </ul>

            <div class="nav-section-label">SYSTEM</div>
            <ul class="nav-list">
                <li class="nav-item">
                    <a href="{{ route('roles.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">verified_user</span>
                        Roles & Permissions
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('promotions.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">receipt_long</span>
                        Billing
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <span class="material-symbols-outlined">settings</span>
                        Settings
                    </a>
                </li>
            </ul>
        </div>

        <div class="sidebar-user-widget">
            <img src="{{ asset('assets/images/onboarding_tailor.jpg') }}" class="user-avatar" alt="Julian">
            <div>
                <h5 style="font-size:12.5px; font-weight:800;">Julian Thorne</h5>
                <p style="font-size:10px; color:var(--text-muted);">Global Administrator</p>
            </div>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Header -->
        <header class="top-header">
            <h3 style="font-size:18px; font-weight:800;">Executive Overview</h3>

            <div class="search-bar">
                <span class="material-symbols-outlined" style="font-size: 16px; color: var(--text-muted);">search</span>
                <input type="text" placeholder="Search consolidated data...">
            </div>

            <div style="display:flex; align-items:center; gap:14px;">
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">notifications</span>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">history</span>
                <button class="btn-export-report">
                    <span class="material-symbols-outlined" style="font-size:16px;">download</span>
                    Export Report
                </button>
            </div>
        </header>

        <!-- Content Area -->
        <main class="content-area">
            <!-- 4 Top Stat Cards -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-title">Total Revenue (Consolidated)</div>
                        <span class="material-symbols-outlined stat-icon">payments</span>
                    </div>
                    <div class="stat-val">$1,284,500.0</div>
                    <div class="stat-sub" style="color:#10B981;">↗ +12.4% from last month</div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-title">Total Orders</div>
                        <span class="material-symbols-outlined stat-icon">shopping_bag</span>
                    </div>
                    <div class="stat-val">4,822</div>
                    <div class="stat-sub" style="color:#10B981;">↗ +5.2% vs target</div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-title">Avg. Order Value</div>
                        <span class="material-symbols-outlined stat-icon">bar_chart</span>
                    </div>
                    <div class="stat-val">$266.38</div>
                    <div class="stat-sub" style="color:var(--text-muted);">— Stable performance</div>
                </div>

                <div class="stat-card">
                    <div class="stat-card-header">
                        <div class="stat-title">Global Profit Margin</div>
                        <span class="material-symbols-outlined stat-icon">show_chart</span>
                    </div>
                    <div class="stat-val">34.8%</div>
                    <div class="stat-sub" style="color:#E53E3E;">↘ -0.4% (Material costs)</div>
                </div>
            </div>

            <!-- Middle Split 2 Columns -->
            <div class="grid-2col">
                <!-- Branch Performance Table -->
                <div class="card-box">
                    <div class="card-box-header">
                        <div class="card-box-title">Branch Performance</div>
                        <div style="display:flex; gap:10px; font-size:12px; font-weight:700;">
                            <select style="border:1px solid var(--card-border); border-radius:6px; padding:4px 8px; font-family:var(--font-main);"><option>This Month ▾</option></select>
                            <select style="border:1px solid var(--card-border); border-radius:6px; padding:4px 8px; font-family:var(--font-main);"><option>All Locations ▾</option></select>
                        </div>
                    </div>

                    <table class="branch-table">
                        <thead>
                            <tr>
                                <th>BRANCH NAME</th>
                                <th>REVENUE (MTD)</th>
                                <th>GROWTH</th>
                                <th>ACTIVE ORDERS</th>
                                <th>CAPACITY</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div style="display:flex; align-items:center; gap:10px;">
                                        <div class="branch-avatar-circle" style="background:#26A69A;">LC</div>
                                        <div>
                                            <strong>London Central</strong>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-family:var(--font-code); font-weight:800;">$412,400</td>
                                <td><span class="growth-pill-green">+18.2%</span></td>
                                <td>1,120</td>
                                <td><span class="capacity-dot" style="background:#10B981;"></span> Optimal</td>
                            </tr>

                            <tr>
                                <td>
                                    <div style="display:flex; align-items:center; gap:10px;">
                                        <div class="branch-avatar-circle" style="background:#006A67;">DM</div>
                                        <div>
                                            <strong>Dubai Marina</strong>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-family:var(--font-code); font-weight:800;">$388,200</td>
                                <td><span class="growth-pill-green">+11.5%</span></td>
                                <td>895</td>
                                <td><span class="capacity-dot" style="background:#10B981;"></span> Optimal</td>
                            </tr>

                            <tr>
                                <td>
                                    <div style="display:flex; align-items:center; gap:10px;">
                                        <div class="branch-avatar-circle" style="background:#8B5CF6;">NS</div>
                                        <div>
                                            <strong>New York Soho</strong>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-family:var(--font-code); font-weight:800;">$294,000</td>
                                <td><span class="growth-pill-red">-2.4%</span></td>
                                <td>940</td>
                                <td><span class="capacity-dot" style="background:#D69E2E;"></span> Near Limit</td>
                            </tr>

                            <tr>
                                <td>
                                    <div style="display:flex; align-items:center; gap:10px;">
                                        <div class="branch-avatar-circle" style="background:#64748B;">PG</div>
                                        <div>
                                            <strong>Paris Ginza</strong>
                                        </div>
                                    </div>
                                </td>
                                <td style="font-family:var(--font-code); font-weight:800;">$189,900</td>
                                <td><span class="growth-pill-green">+4.8%</span></td>
                                <td>542</td>
                                <td><span class="capacity-dot" style="background:#10B981;"></span> Optimal</td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <!-- Elite Artisans Leaderboard -->
                <div class="card-box">
                    <div class="card-box-header">
                        <div class="card-box-title" style="display:flex; align-items:center; gap:6px;">
                            <span class="material-symbols-outlined" style="color:var(--primary-teal);">military_tech</span>
                            Elite Artisans
                        </div>
                    </div>

                    <div class="artisan-list">
                        <!-- Rank 1 -->
                        <div class="artisan-row">
                            <div class="artisan-left">
                                <div class="artisan-avatar-wrap">
                                    <img src="{{ asset('assets/images/onboarding_tailor.jpg') }}" class="artisan-avatar" alt="Artisan">
                                    <div class="rank-badge" style="background:#10B981;">1</div>
                                </div>
                                <div>
                                    <div class="artisan-name">Alessandro Rossi</div>
                                    <div class="artisan-sub">Milan Hub • Master Tailor</div>
                                </div>
                            </div>
                            <div>
                                <div class="artisan-rev">$42.5k</div>
                                <div style="font-size:9.5px; color:var(--text-muted); text-align:right;">REVENUE</div>
                            </div>
                        </div>

                        <!-- Rank 2 -->
                        <div class="artisan-row">
                            <div class="artisan-left">
                                <div class="artisan-avatar-wrap">
                                    <img src="{{ asset('assets/images/hero_tailor_atelier.jpg') }}" class="artisan-avatar" alt="Artisan">
                                    <div class="rank-badge" style="background:#006A67;">2</div>
                                </div>
                                <div>
                                    <div class="artisan-name">Elena Vance</div>
                                    <div class="artisan-sub">London Central • Senior Stylist</div>
                                </div>
                            </div>
                            <div>
                                <div class="artisan-rev">$38.1k</div>
                                <div style="font-size:9.5px; color:var(--text-muted); text-align:right;">REVENUE</div>
                            </div>
                        </div>

                        <!-- Rank 3 -->
                        <div class="artisan-row">
                            <div class="artisan-left">
                                <div class="artisan-avatar-wrap">
                                    <img src="{{ asset('assets/images/bespoke_tailor_atelier_hero.jpg') }}" class="artisan-avatar" alt="Artisan">
                                    <div class="rank-badge" style="background:#2B6CB0;">3</div>
                                </div>
                                <div>
                                    <div class="artisan-name">Samuel Oak</div>
                                    <div class="artisan-sub">Dubai Marina • Suit Specialist</div>
                                </div>
                            </div>
                            <div>
                                <div class="artisan-rev">$35.9k</div>
                                <div style="font-size:9.5px; color:var(--text-muted); text-align:right;">REVENUE</div>
                            </div>
                        </div>
                    </div>

                    <button class="btn-view-leaderboard">View Leaderboard</button>
                </div>
            </div>

            <!-- Bottom Section (Revenue Trends & Target Achievement) -->
            <div class="bottom-grid-2col">
                <div class="card-box">
                    <div class="card-box-header">
                        <div>
                            <div class="card-box-title">Revenue Trends</div>
                            <div style="font-size:11.5px; color:var(--text-muted);">Consolidated top 3 branch performance (6 months)</div>
                        </div>

                        <div style="display:flex; gap:12px; font-size:11px; font-weight:800;">
                            <span style="color:#006A67;">• LONDON</span>
                            <span style="color:#9F7AEA;">• DUBAI</span>
                            <span style="color:#718096;">• NY</span>
                        </div>
                    </div>

                    <div class="chart-placeholder-box">
                        📈 Revenue Trends Area Chart Visualisation
                    </div>
                </div>

                <div class="card-box">
                    <div class="card-box-title" style="margin-bottom:6px;">Target Achievement</div>
                    <div style="font-size:11.5px; color:var(--text-muted); margin-bottom:16px;">Branch progress against quarterly targets</div>

                    <div class="target-cluster-row">
                        <div class="target-header">
                            <span>Europe Cluster</span>
                            <span>82% ($1.2M / $1.5M)</span>
                        </div>
                        <div class="bar-bg"><div class="bar-fill" style="width:82%;"></div></div>
                    </div>

                    <div class="target-cluster-row" style="margin-bottom:0;">
                        <div class="target-header">
                            <span>Middle East Cluster</span>
                            <span>91% ($910k / $1.0M)</span>
                        </div>
                        <div class="bar-bg"><div class="bar-fill" style="width:91%; background:#26A69A;"></div></div>
                    </div>
                </div>
            </div>

            <!-- FAB Button -->
            <button class="fab-add-btn">
                <span class="material-symbols-outlined">add</span>
            </button>
        </main>
    </div>

</body>
</html>
