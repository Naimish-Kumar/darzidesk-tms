<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Management - {{ env('APP_NAME', 'DarziDesk') }}</title>
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
            display: flex; align-items: center; gap: 8px; width: 300px;
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

        .btn-export {
            background: #E2E8F0; color: var(--text-dark); border: none;
            padding: 10px 16px; border-radius: 10px; font-family: var(--font-main);
            font-size: 13px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 6px;
        }

        .btn-onboard {
            background: var(--accent-teal); color: #FFF; border: none;
            padding: 10px 18px; border-radius: 10px; font-family: var(--font-main);
            font-size: 13px; font-weight: 700; cursor: pointer; display: flex; align-items: center; gap: 6px;
        }

        .kpi-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }

        .kpi-card { background: #FFFFFF; border: 1px solid var(--card-border); border-radius: 16px; padding: 20px; }

        .kpi-top { display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px; }

        .kpi-icon {
            width: 34px; height: 34px; background: #E6FFFA; color: var(--primary-teal);
            border-radius: 8px; display: flex; align-items: center; justify-content: center;
        }

        .kpi-val { font-size: 28px; font-weight: 800; }
        .kpi-lbl { font-size: 10px; font-weight: 800; letter-spacing: 0.8px; color: var(--text-muted); margin-top: 2px; }

        .main-grid { display: grid; grid-template-columns: 2fr 1fr; gap: 20px; }

        .filter-tabs-card {
            background: #FFFFFF; border: 1px solid var(--card-border);
            border-radius: 16px; padding: 14px; margin-bottom: 16px;
            display: flex; justify-content: space-between; align-items: center;
        }

        .tab-pills { display: flex; gap: 6px; }

        .tab-pill {
            padding: 6px 14px; border-radius: 8px; font-size: 12.5px; font-weight: 700;
            border: none; background: transparent; color: var(--text-muted); cursor: pointer;
        }

        .tab-pill.active { background: var(--primary-teal); color: #FFF; }

        .table-card { background: #FFFFFF; border: 1px solid var(--card-border); border-radius: 16px; overflow: hidden; }

        .staff-table { width: 100%; border-collapse: collapse; font-size: 13px; }

        .staff-table th {
            text-align: left; padding: 12px 16px; font-size: 10px; font-weight: 800;
            letter-spacing: 0.8px; color: var(--text-muted); background: #F8FAFC; border-bottom: 1px solid var(--card-border);
        }

        .staff-table td { padding: 14px 16px; border-bottom: 1px solid var(--card-border); vertical-align: middle; }

        .staff-profile-col { display: flex; align-items: center; gap: 10px; font-weight: 700; }
        .staff-img { width: 34px; height: 34px; border-radius: 50%; object-fit: cover; }

        .role-badge { font-size: 10px; font-weight: 800; padding: 3px 8px; border-radius: 6px; display: inline-block; }
        .role-master { background: #E6FFFA; color: var(--primary-teal); }
        .role-cutter { background: #EDF2F7; color: #4A5568; }
        .role-stitcher { background: #F3E8FF; color: #7E22CE; }

        .badge-paid { font-size: 9px; font-weight: 800; background: #D1FAE5; color: #047857; padding: 2px 6px; border-radius: 4px; }
        .badge-pending { font-size: 9px; font-weight: 800; background: #FEFCBF; color: #D69E2E; padding: 2px 6px; border-radius: 4px; }

        .pagination-bar { padding: 14px 18px; display: flex; justify-content: space-between; align-items: center; font-size: 12px; color: var(--text-muted); }

        .right-card { background: #FFFFFF; border: 1px solid var(--card-border); border-radius: 16px; padding: 20px; margin-bottom: 20px; }

        .right-card-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
        .right-card-title { font-size: 15px; font-weight: 800; }

        .performer-list { display: flex; flex-direction: column; gap: 12px; }
        .performer-item { display: flex; align-items: center; justify-content: space-between; }
        .performer-left { display: flex; align-items: center; gap: 10px; position: relative; }

        .rank-badge {
            position: absolute; top: -4px; left: -4px; width: 16px; height: 16px;
            background: #ECC94B; color: #FFF; border-radius: 50%; font-size: 9px; font-weight: 800;
            display: flex; align-items: center; justify-content: center; border: 1px solid #FFF;
        }

        .performer-name { font-size: 13px; font-weight: 700; }
        .performer-role { font-size: 11px; color: var(--text-muted); }

        .efficacy-val { font-size: 13px; font-weight: 800; color: #38A169; text-align: right; }
        .efficacy-val span { font-size: 9px; font-weight: 800; color: var(--text-muted); display: block; }

        .chart-bars { display: flex; align-items: flex-end; justify-content: space-around; height: 100px; margin-top: 16px; }
        .chart-bar-col { display: flex; flex-direction: column; align-items: center; gap: 6px; }
        .chart-bar { width: 28px; border-radius: 6px; background: #E2E8F0; }

        .notice-box {
            background: #FEFCBF; border: 1px solid #F6E05E; border-radius: 10px;
            padding: 12px; font-size: 11.5px; color: #744210; margin-top: 16px; display: flex; gap: 8px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div>
            <div class="brand-box">
                <img src="{{ asset('assets/images/logo_wide.png') }}" alt="DarziDesk" style="height: 32px;">
            </div>

            <div style="background:#EDF2F7; border-radius:12px; padding:10px; display:flex; align-items:center; gap:10px; margin:16px 0;">
                <img src="{{ asset('assets/images/onboarding_tailor.jpg') }}" style="width:32px; height:32px; border-radius:50%; object-fit:cover;" alt="Avatar">
                <div>
                    <h5 style="font-size:13px; font-weight:700;">Bespoke Master</h5>
                    <p style="font-size:11px; color:var(--text-muted);">London Branch</p>
                </div>
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
                    <a href="{{ route('financials.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">payments</span>
                        Financials
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('staff.index') }}" class="nav-link active">
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
            <div class="search-bar">
                <span class="material-symbols-outlined" style="font-size: 16px; color: var(--text-muted);">search</span>
                <input type="text" placeholder="Search staff members...">
            </div>

            <div class="header-actions">
                <div class="branch-badge">
                    <span class="material-symbols-outlined" style="font-size: 16px;">storefront</span>
                    London Central
                </div>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">notifications</span>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">grid_view</span>
                <img src="{{ asset('assets/images/onboarding_tailor.jpg') }}" style="width:32px; height:32px; border-radius:50%; object-fit:cover;" alt="User">
            </div>
        </header>

        <!-- Content Area -->
        <main class="content-area">
            <div class="title-row">
                <div>
                    <h2>Staff Management</h2>
                    <p>Manage your workforce, monitor performance, and process payouts.</p>
                </div>
                <div class="btn-group">
                    <button class="btn-export">
                        <span class="material-symbols-outlined" style="font-size: 16px;">download</span>
                        Export Report
                    </button>
                    <a href="{{ route('staff.onboard.step1') }}" class="btn-onboard" style="text-decoration:none;">
                        <span class="material-symbols-outlined" style="font-size: 16px;">person_add</span>
                        Onboard Staff
                    </a>
                </div>
            </div>

            <!-- 4 Metric Cards Grid -->
            <div class="kpi-grid">
                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-icon">
                            <span class="material-symbols-outlined">group</span>
                        </div>
                        <span style="font-size:11px; font-weight:700; color:#38A169;">↑ +2</span>
                    </div>
                    <div class="kpi-val">24</div>
                    <div class="kpi-lbl">TOTAL STAFF</div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-icon" style="background:#EBF8FF; color:#3182CE;">
                            <span class="material-symbols-outlined">bolt</span>
                        </div>
                        <span style="font-size:11px; font-weight:700; color:var(--text-muted);">75% active</span>
                    </div>
                    <div class="kpi-val">18</div>
                    <div class="kpi-lbl">ACTIVE TODAY</div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-icon" style="background:#FEFCBF; color:#D69E2E;">
                            <span class="material-symbols-outlined">star</span>
                        </div>
                        <span style="font-size:11px; font-weight:700; color:#38A169;">↗ +4%</span>
                    </div>
                    <div class="kpi-val">94%</div>
                    <div class="kpi-lbl">AVG. PERFORMANCE</div>
                </div>

                <div class="kpi-card">
                    <div class="kpi-top">
                        <div class="kpi-icon" style="background:#FFF5F5; color:#E53E3E;">
                            <span class="material-symbols-outlined">payments</span>
                        </div>
                        <span style="font-size:11px; font-weight:700; color:var(--text-muted);">6 pending</span>
                    </div>
                    <div class="kpi-val">£4,250</div>
                    <div class="kpi-lbl">TOTAL PAYOUTS DUE</div>
                </div>
            </div>

            <!-- Main Grid: Data Table & Right Cards -->
            <div class="main-grid">
                <!-- Left Section: Table -->
                <div>
                    <div class="filter-tabs-card">
                        <div class="tab-pills">
                            <button class="tab-pill active">All Roles</button>
                            <button class="tab-pill">Master Tailors</button>
                            <button class="tab-pill">Stitchers</button>
                            <button class="tab-pill">Cutters</button>
                        </div>
                        <div style="font-size:12px; color:var(--text-muted);">
                            Status: <select style="border:none; background:transparent; font-weight:700;"><option>Active Only</option></select>
                        </div>
                    </div>

                    <div class="table-card">
                        <table class="staff-table">
                            <thead>
                                <tr>
                                    <th>Staff Member</th>
                                    <th>Role</th>
                                    <th>Workload</th>
                                    <th>Performance</th>
                                    <th>Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="staff-profile-col">
                                            <img src="{{ asset('assets/images/onboarding_tailor.jpg') }}" class="staff-img" alt="Staff">
                                            <div>
                                                <div>Albert Finch</div>
                                                <div style="font-size:11px; color:var(--text-muted); font-weight:400;">albert.f@darzi.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="role-badge role-master">Master Tailor</span></td>
                                    <td>
                                        <span style="font-size:11px; font-weight:700;">12/15</span>
                                        <span style="font-size:10px; color:var(--text-muted);">80%</span>
                                    </td>
                                    <td><span style="font-weight:700; color:#D69E2E;">★ 98</span></td>
                                    <td><span class="badge-paid">Paid</span></td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="staff-profile-col">
                                            <img src="{{ asset('assets/images/onboarding_tailor_light.jpg') }}" class="staff-img" alt="Staff">
                                            <div>
                                                <div>Elena Rossi</div>
                                                <div style="font-size:11px; color:var(--text-muted); font-weight:400;">e.rossi@darzi.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="role-badge role-cutter">Cutter</span></td>
                                    <td>
                                        <span style="font-size:11px; font-weight:700; color:#E53E3E;">14/15</span>
                                        <span style="font-size:10px; color:var(--text-muted);">93%</span>
                                    </td>
                                    <td><span style="font-weight:700; color:#D69E2E;">★ 92</span></td>
                                    <td><span class="badge-pending">Pending</span></td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="staff-profile-col">
                                            <img src="{{ asset('assets/images/hero_tailor_atelier.jpg') }}" class="staff-img" alt="Staff">
                                            <div>
                                                <div>Marcus Chen</div>
                                                <div style="font-size:11px; color:var(--text-muted); font-weight:400;">m.chen@darzi.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="role-badge role-stitcher">Stitcher</span></td>
                                    <td>
                                        <span style="font-size:11px; font-weight:700;">6/15</span>
                                        <span style="font-size:10px; color:var(--text-muted);">40%</span>
                                    </td>
                                    <td><span style="font-weight:700; color:#D69E2E;">★ 89</span></td>
                                    <td><span class="badge-paid">Paid</span></td>
                                </tr>

                                <tr>
                                    <td>
                                        <div class="staff-profile-col">
                                            <img src="{{ asset('assets/images/bespoke_tailor_atelier_hero.jpg') }}" class="staff-img" alt="Staff">
                                            <div>
                                                <div>Julian Banks</div>
                                                <div style="font-size:11px; color:var(--text-muted); font-weight:400;">j.banks@darzi.com</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td><span class="role-badge role-master">Master Tailor</span></td>
                                    <td>
                                        <span style="font-size:11px; font-weight:700;">10/15</span>
                                        <span style="font-size:10px; color:var(--text-muted);">66%</span>
                                    </td>
                                    <td><span style="font-weight:700; color:#D69E2E;">★ 96</span></td>
                                    <td><span class="badge-paid">Paid</span></td>
                                </tr>
                            </tbody>
                        </table>

                        <div class="pagination-bar">
                            <div>Showing 4 of 24 members</div>
                            <div style="display:flex; gap:6px;">
                                <button style="border:1px solid var(--card-border); padding:4px 8px; border-radius:6px; background:#FFF;">Prev</button>
                                <button style="background:var(--primary-teal); color:#FFF; border:none; padding:4px 10px; border-radius:6px;">1</button>
                                <button style="border:1px solid var(--card-border); padding:4px 10px; border-radius:6px; background:#FFF;">2</button>
                                <button style="border:1px solid var(--card-border); padding:4px 10px; border-radius:6px; background:#FFF;">3</button>
                                <button style="border:1px solid var(--card-border); padding:4px 8px; border-radius:6px; background:#FFF;">Next</button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Section: Top Performers & Workload Balance -->
                <div>
                    <!-- Top Performers -->
                    <div class="right-card">
                        <div class="right-card-header">
                            <div class="right-card-title">Top Performers</div>
                            <a href="#" style="font-size:11.5px; font-weight:700; color:var(--primary-teal); text-decoration:none;">View All</a>
                        </div>

                        <div class="performer-list">
                            <div class="performer-item">
                                <div class="performer-left">
                                    <div class="rank-badge">1</div>
                                    <img src="{{ asset('assets/images/onboarding_tailor.jpg') }}" style="width:32px; height:32px; border-radius:50%; object-fit:cover;" alt="Avatar">
                                    <div>
                                        <div class="performer-name">Albert Finch</div>
                                        <div class="performer-role">Master Tailor</div>
                                    </div>
                                </div>
                                <div class="efficacy-val">98% <span>EFFICACY</span></div>
                            </div>

                            <div class="performer-item">
                                <div class="performer-left">
                                    <div class="rank-badge" style="background:#CBD5E1;">2</div>
                                    <img src="{{ asset('assets/images/bespoke_tailor_atelier_hero.jpg') }}" style="width:32px; height:32px; border-radius:50%; object-fit:cover;" alt="Avatar">
                                    <div>
                                        <div class="performer-name">Julian Banks</div>
                                        <div class="performer-role">Master Tailor</div>
                                    </div>
                                </div>
                                <div class="efficacy-val">96% <span>EFFICACY</span></div>
                            </div>

                            <div class="performer-item">
                                <div class="performer-left">
                                    <div class="rank-badge" style="background:#ED8936;">3</div>
                                    <img src="{{ asset('assets/images/onboarding_tailor_light.jpg') }}" style="width:32px; height:32px; border-radius:50%; object-fit:cover;" alt="Avatar">
                                    <div>
                                        <div class="performer-name">Elena Rossi</div>
                                        <div class="performer-role">Head Cutter</div>
                                    </div>
                                </div>
                                <div class="efficacy-val">92% <span>EFFICACY</span></div>
                            </div>
                        </div>
                    </div>

                    <!-- Workload Balance -->
                    <div class="right-card">
                        <div class="right-card-title">Workload Balance</div>

                        <div class="chart-bars">
                            <div class="chart-bar-col">
                                <div class="chart-bar" style="height:70px; background:#006A67;"></div>
                                <span style="font-size:10px; font-weight:700;">Master</span>
                            </div>
                            <div class="chart-bar-col">
                                <div class="chart-bar" style="height:90px; background:#3182CE;"></div>
                                <span style="font-size:10px; font-weight:700;">Cutter</span>
                            </div>
                            <div class="chart-bar-col">
                                <div class="chart-bar" style="height:50px; background:#8B5CF6;"></div>
                                <span style="font-size:10px; font-weight:700;">Stitcher</span>
                            </div>
                            <div class="chart-bar-col">
                                <div class="chart-bar" style="height:35px; background:#DD6B20;"></div>
                                <span style="font-size:10px; font-weight:700;">Finisher</span>
                            </div>
                        </div>

                        <div class="notice-box">
                            <span class="material-symbols-outlined" style="font-size: 18px;">info</span>
                            <div>Cutting team is nearing full capacity (95%). Consider reallocating pending orders.</div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
