<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Financial Analytics - {{ env('APP_NAME', 'DarziDesk') }}</title>
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

        .brand-box span { font-size: 9px; font-weight: 800; letter-spacing: 1.5px; color: var(--text-muted); display: block; margin-top: 2px; }
        .nav-list { list-style: none; }
        .nav-item { margin-bottom: 4px; }

        .nav-link {
            display: flex; align-items: center; gap: 12px;
            padding: 10px 12px; border-radius: 10px; font-size: 13.5px; font-weight: 600;
            color: var(--text-dark); text-decoration: none; transition: all 0.2s;
        }

        .nav-link.active { background: var(--accent-teal); color: #FFFFFF; }
        .nav-link:hover:not(.active) { background: #F1F5F9; }

        .main-wrapper { margin-left: 240px; flex: 1; display: flex; flex-direction: column; }

        .top-header {
            height: 64px; background: #FFFFFF; border-bottom: 1px solid var(--card-border);
            display: flex; align-items: center; justify-content: space-between; padding: 0 28px;
            position: sticky; top: 0; z-index: 90;
        }

        .search-bar {
            background: #EBF3FA; border-radius: 20px; padding: 6px 14px;
            display: flex; align-items: center; gap: 8px; width: 320px;
        }

        .search-bar input { border: none; background: transparent; outline: none; font-family: var(--font-main); font-size: 12.5px; width: 100%; }

        .branch-badge {
            background: #EBF8FF; color: #2B6CB0; font-size: 11px; font-weight: 800;
            padding: 6px 12px; border-radius: 16px; display: flex; align-items: center; gap: 6px;
        }

        .header-actions { display: flex; align-items: center; gap: 14px; }

        .content-area { padding: 28px; }

        .title-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; }
        .title-row h2 { font-size: 24px; font-weight: 800; }
        .title-row p { font-size: 13.5px; color: var(--text-muted); margin-top: 2px; }

        .btn-group { display: flex; gap: 10px; }

        .btn-date {
            padding: 8px 14px; border: 1px solid var(--card-border); border-radius: 10px;
            background: #FFF; font-family: var(--font-main); font-size: 12.5px; font-weight: 600;
            display: flex; align-items: center; gap: 8px; cursor: pointer;
        }

        .btn-export {
            background: var(--primary-teal); color: #FFF; border: none;
            padding: 10px 18px; border-radius: 10px; font-family: var(--font-main);
            font-size: 13px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 6px;
        }

        .kpi-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }

        .kpi-card { background: #FFFFFF; border: 1px solid var(--card-border); border-radius: 16px; padding: 20px; }

        .kpi-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px; }
        .kpi-lbl { font-size: 10px; font-weight: 800; letter-spacing: 0.8px; color: var(--text-muted); }
        .kpi-val { font-size: 24px; font-weight: 800; margin-top: 4px; }

        .chart-card {
            background: #FFFFFF; border: 1px solid var(--card-border);
            border-radius: 16px; padding: 24px; margin-bottom: 24px;
        }

        .chart-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px; }
        .chart-title { font-size: 15px; font-weight: 800; }

        .legend-row { display: flex; gap: 16px; font-size: 12px; font-weight: 600; }
        .legend-item { display: flex; align-items: center; gap: 6px; }

        .dot-teal { width: 10px; height: 10px; background: var(--primary-teal); border-radius: 50%; }
        .dot-grey { width: 10px; height: 10px; background: #CBD5E1; border-radius: 50%; }

        .chart-visual-area {
            height: 180px; display: flex; align-items: flex-end; justify-content: space-between;
            border-bottom: 1px solid var(--card-border); padding-bottom: 12px; margin-bottom: 12px;
        }

        .chart-month-col { display: flex; flex-direction: column; align-items: center; flex: 1; font-size: 11px; color: var(--text-muted); }

        .double-bar { display: flex; gap: 4px; align-items: flex-end; }
        .bar-rev { width: 12px; background: var(--primary-teal); border-radius: 4px 4px 0 0; }
        .bar-exp { width: 12px; background: #CBD5E1; border-radius: 4px 4px 0 0; }

        .grid-2col { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 24px; }

        .card-box { background: #FFFFFF; border: 1px solid var(--card-border); border-radius: 16px; padding: 24px; }
        .card-title { font-size: 15px; font-weight: 800; margin-bottom: 20px; }

        .donut-container { display: flex; align-items: center; gap: 24px; }

        .donut-chart {
            width: 120px; height: 120px; border-radius: 50%;
            background: conic-gradient(var(--primary-teal) 0% 45%, #26A69A 45% 70%, #64748B 70% 85%, #94A3B8 85% 100%);
            display: flex; align-items: center; justify-content: center; position: relative;
        }

        .donut-hole {
            width: 70px; height: 70px; background: #FFFFFF; border-radius: 50%;
            display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center;
        }

        .donut-hole .lbl { font-size: 9px; color: var(--text-muted); }
        .donut-hole .val { font-size: 12px; font-weight: 800; }

        .breakdown-legend { display: flex; flex-direction: column; gap: 10px; font-size: 12.5px; }

        .service-list { display: flex; flex-direction: column; gap: 16px; }

        .service-item-top { display: flex; justify-content: space-between; font-size: 13px; font-weight: 700; margin-bottom: 4px; }

        .service-bar-bg { height: 6px; background: #E2E8F0; border-radius: 3px; overflow: hidden; }
        .service-bar-fill { height: 100%; background: var(--primary-teal); }

        .transactions-card { background: #FFFFFF; border: 1px solid var(--card-border); border-radius: 16px; overflow: hidden; }

        .transactions-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }

        .transactions-table th {
            text-align: left; padding: 14px 20px; font-size: 10px; font-weight: 800;
            letter-spacing: 0.8px; color: var(--text-muted); background: #F8FAFC; border-bottom: 1px solid var(--card-border);
        }

        .transactions-table td { padding: 16px 20px; border-bottom: 1px solid var(--card-border); }

        .category-pill { font-size: 10px; font-weight: 800; padding: 3px 8px; border-radius: 12px; background: #EDF2F7; color: #4A5568; }

        .font-mono { font-family: var(--font-code); font-weight: 700; }

        .amount-minus { color: #E53E3E; }
        .amount-plus { color: #38A169; }

        .page-footer {
            background: #EBF3FA; border-top: 1px solid var(--card-border);
            padding: 32px 28px; margin-top: 40px; display: grid; grid-template-columns: 2fr repeat(3, 1fr); gap: 24px;
        }

        .footer-col h5 { font-size: 11px; font-weight: 800; letter-spacing: 0.8px; margin-bottom: 12px; color: var(--text-muted); }
        .footer-col ul { list-style: none; display: flex; flex-direction: column; gap: 8px; font-size: 12.5px; }
        .footer-col a { color: var(--text-dark); text-decoration: none; }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div>
            <div class="brand-box">
                <img src="{{ asset('assets/images/logo_wide.png') }}" alt="DarziDesk" style="height: 32px;">
                <span>Precision Tailoring SaaS</span>
            </div>

            <ul class="nav-list" style="margin-top: 32px;">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link">
                        <span class="material-symbols-outlined">dashboard</span>
                        Dashboard
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('branches.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">account_tree</span>
                        Branches
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
                    <a href="{{ route('financials.index') }}" class="nav-link active">
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

        <div>
            <div style="display:flex; align-items:center; gap:10px;">
                <img src="{{ asset('assets/images/onboarding_tailor.jpg') }}" style="width:34px; height:34px; border-radius:50%; object-fit:cover;" alt="Avatar">
                <div>
                    <h5 style="font-size:13px; font-weight:700;">Bespoke Master</h5>
                    <p style="font-size:11px; color:var(--text-muted);">London Branch</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Header -->
        <header class="top-header">
            <div class="search-bar">
                <span class="material-symbols-outlined" style="font-size: 16px; color: var(--text-muted);">search</span>
                <input type="text" placeholder="Search transactions, orders, or reports...">
            </div>

            <div class="header-actions">
                <div class="branch-badge">
                    <span class="material-symbols-outlined" style="font-size: 16px;">location_on</span>
                    London Branch
                </div>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">notifications</span>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">grid_view</span>
            </div>
        </header>

        <!-- Content Area -->
        <main class="content-area">
            <div class="title-row">
                <div>
                    <h2>Financial Analytics</h2>
                    <p>Real-time fiscal performance for the London boutique.</p>
                </div>
                <div class="btn-group">
                    <button class="btn-date">
                        <span class="material-symbols-outlined" style="font-size: 16px;">calendar_today</span>
                        Last 12 Months
                    </button>
                    <button class="btn-export">
                        <span class="material-symbols-outlined" style="font-size: 16px;">download</span>
                        Export Report
                    </button>
                </div>
            </div>

            <!-- 4 KPI Cards -->
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-lbl">TOTAL REVENUE</div>
                        <span style="font-size:11px; font-weight:700; color:#38A169;">↗ 12.4%</span>
                    </div>
                    <div class="kpi-val">£428,290</div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-lbl">GROSS PROFIT</div>
                        <span style="font-size:11px; font-weight:700; color:#38A169;">↗ 8.1%</span>
                    </div>
                    <div class="kpi-val">£186,400</div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-lbl">TOTAL EXPENSES</div>
                        <span style="font-size:11px; font-weight:700; color:#E53E3E;">↘ 4.2%</span>
                    </div>
                    <div class="kpi-val">£241,890</div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-lbl">NET MARGIN</div>
                        <span style="font-size:11px; font-weight:700; color:#38A169;">↗ 2.5%</span>
                    </div>
                    <div class="kpi-val">43.5%</div>
                </div>
            </div>

            <!-- Revenue vs Expenses Chart -->
            <div class="chart-card">
                <div class="chart-header">
                    <div class="chart-title">Revenue vs. Expenses</div>
                    <div class="legend-row">
                        <div class="legend-item"><div class="dot-teal"></div> Revenue</div>
                        <div class="legend-item"><div class="dot-grey"></div> Expenses</div>
                    </div>
                </div>

                <div class="chart-visual-area">
                    <div class="chart-month-col"><div class="double-bar"><div class="bar-rev" style="height:80px;"></div><div class="bar-exp" style="height:40px;"></div></div>Jan</div>
                    <div class="chart-month-col"><div class="double-bar"><div class="bar-rev" style="height:95px;"></div><div class="bar-exp" style="height:50px;"></div></div>Feb</div>
                    <div class="chart-month-col"><div class="double-bar"><div class="bar-rev" style="height:110px;"></div><div class="bar-exp" style="height:60px;"></div></div>Mar</div>
                    <div class="chart-month-col"><div class="double-bar"><div class="bar-rev" style="height:100px;"></div><div class="bar-exp" style="height:55px;"></div></div>Apr</div>
                    <div class="chart-month-col"><div class="double-bar"><div class="bar-rev" style="height:120px;"></div><div class="bar-exp" style="height:70px;"></div></div>May</div>
                    <div class="chart-month-col"><div class="double-bar"><div class="bar-rev" style="height:130px;"></div><div class="bar-exp" style="height:75px;"></div></div>Jun</div>
                    <div class="chart-month-col"><div class="double-bar"><div class="bar-rev" style="height:125px;"></div><div class="bar-exp" style="height:70px;"></div></div>Jul</div>
                    <div class="chart-month-col"><div class="double-bar"><div class="bar-rev" style="height:140px;"></div><div class="bar-exp" style="height:80px;"></div></div>Aug</div>
                    <div class="chart-month-col"><div class="double-bar"><div class="bar-rev" style="height:150px;"></div><div class="bar-exp" style="height:85px;"></div></div>Sep</div>
                    <div class="chart-month-col"><div class="double-bar"><div class="bar-rev" style="height:160px;"></div><div class="bar-exp" style="height:90px;"></div></div>Oct</div>
                    <div class="chart-month-col"><div class="double-bar"><div class="bar-rev" style="height:145px;"></div><div class="bar-exp" style="height:80px;"></div></div>Nov</div>
                    <div class="chart-month-col"><div class="double-bar"><div class="bar-rev" style="height:170px;"></div><div class="bar-exp" style="height:95px;"></div></div>Dec</div>
                </div>
            </div>

            <!-- Expense Breakdown & Services Grid -->
            <div class="grid-2col">
                <!-- Expense Breakdown -->
                <div class="card-box">
                    <div class="card-title">Expense Breakdown</div>
                    <div class="donut-container">
                        <div class="donut-chart">
                            <div class="donut-hole">
                                <div class="lbl">Total</div>
                                <div class="val">£241k</div>
                            </div>
                        </div>

                        <div class="breakdown-legend">
                            <div style="display:flex; align-items:center; gap:8px;">
                                <div style="width:8px; height:8px; background:var(--primary-teal); border-radius:50%;"></div>
                                <div><strong>Materials</strong> 45% (£108,850)</div>
                            </div>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <div style="width:8px; height:8px; background:#26A69A; border-radius:50%;"></div>
                                <div><strong>Labor</strong> 25% (£60,470)</div>
                            </div>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <div style="width:8px; height:8px; background:#64748B; border-radius:50%;"></div>
                                <div><strong>Rent</strong> 15% (£36,280)</div>
                            </div>
                            <div style="display:flex; align-items:center; gap:8px;">
                                <div style="width:8px; height:8px; background:#94A3B8; border-radius:50%;"></div>
                                <div><strong>Utilities</strong> 15% (£36,280)</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Top Performing Services -->
                <div class="card-box">
                    <div class="card-title">Top Performing Services</div>

                    <div class="service-list">
                        <div>
                            <div class="service-item-top">
                                <span>Bespoke Suits</span>
                                <span class="font-mono">£182,400</span>
                            </div>
                            <div class="service-bar-bg">
                                <div class="service-bar-fill" style="width: 85%;"></div>
                            </div>
                        </div>

                        <div>
                            <div class="service-item-top">
                                <span>Traditional Wear</span>
                                <span class="font-mono">£114,200</span>
                            </div>
                            <div class="service-bar-bg">
                                <div class="service-bar-fill" style="width: 60%; background:#26A69A;"></div>
                            </div>
                        </div>

                        <div>
                            <div class="service-item-top">
                                <span>Alterations</span>
                                <span class="font-mono">£82,100</span>
                            </div>
                            <div class="service-bar-bg">
                                <div class="service-bar-fill" style="width: 45%; background:#0284C7;"></div>
                            </div>
                        </div>

                        <div>
                            <div class="service-item-top">
                                <span>Fabric Sales</span>
                                <span class="font-mono">£49,500</span>
                            </div>
                            <div class="service-bar-bg">
                                <div class="service-bar-fill" style="width: 30%; background:#8B5CF6;"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Recent Financial Transactions Table -->
            <div class="transactions-card">
                <div style="padding:16px 20px; display:flex; justify-content:space-between; align-items:center; background:#F8FAFC; border-bottom:1px solid var(--card-border);">
                    <span style="font-size:15px; font-weight:800;">Recent Financial Transactions</span>
                    <a href="#" style="font-size:12.5px; font-weight:700; color:var(--primary-teal); text-decoration:none;">View All</a>
                </div>

                <table class="transactions-table">
                    <thead>
                        <tr>
                            <th>DATE</th>
                            <th>DESCRIPTION</th>
                            <th>CATEGORY</th>
                            <th>AMOUNT</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td class="font-mono">24 May, 2024</td>
                            <td>Italian Wool Import (Loro Piana)</td>
                            <td><span class="category-pill">Materials</span></td>
                            <td class="font-mono amount-minus">- £4,200.00</td>
                        </tr>
                        <tr>
                            <td class="font-mono">23 May, 2024</td>
                            <td>Order #8829 - Bespoke Wedding Suit</td>
                            <td><span class="category-pill" style="background:#E6FFFA; color:var(--primary-teal);">Sales</span></td>
                            <td class="font-mono amount-plus">+ £1,850.00</td>
                        </tr>
                        <tr>
                            <td class="font-mono">22 May, 2024</td>
                            <td>Quarterly Shop Rent</td>
                            <td><span class="category-pill">Overheads</span></td>
                            <td class="font-mono amount-minus">- £12,000.00</td>
                        </tr>
                        <tr>
                            <td class="font-mono">21 May, 2024</td>
                            <td>Payroll - Master Tailors (3 Staff)</td>
                            <td><span class="category-pill">Labor</span></td>
                            <td class="font-mono amount-minus">- £9,500.00</td>
                        </tr>
                        <tr>
                            <td class="font-mono">20 May, 2024</td>
                            <td>Custom Silk Lining Batch #04</td>
                            <td><span class="category-pill">Materials</span></td>
                            <td class="font-mono amount-minus">- £850.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </main>

        <!-- Footer -->
        <footer class="page-footer">
            <div>
                <img src="{{ asset('assets/images/logo_wide.png') }}" alt="DarziDesk" style="height: 28px; margin-bottom: 8px;">
                <p style="font-size:12px; color:var(--text-muted);">© 2024 DarziDesk. Precision Tailoring SaaS.</p>
            </div>
            <div class="footer-col">
                <h5>RESOURCES</h5>
                <ul>
                    <li><a href="#">Business Resources</a></li>
                    <li><a href="#">Partner Program</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h5>LEGAL</h5>
                <ul>
                    <li><a href="#">Privacy Policy</a></li>
                    <li><a href="#">Terms of Service</a></li>
                </ul>
            </div>
            <div class="footer-col">
                <h5>SUPPORT</h5>
                <ul>
                    <li><a href="#">Contact Support</a></li>
                    <li><a href="#">Help Center</a></li>
                </ul>
            </div>
        </footer>
    </div>

</body>
</html>
