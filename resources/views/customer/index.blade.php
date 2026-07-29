<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Directory - {{ env('APP_NAME', 'DarziDesk') }}</title>
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
            display: flex; align-items: center; gap: 8px; width: 320px;
        }

        .search-bar input { border: none; background: transparent; outline: none; font-family: var(--font-main); font-size: 12.5px; width: 100%; }

        .header-right { display: flex; align-items: center; gap: 16px; }

        .user-profile-widget { display: flex; align-items: center; gap: 10px; font-size: 12px; font-weight: 700; }
        .user-avatar { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; }

        .content-area { padding: 28px; }

        .breadcrumb { font-size: 11px; font-weight: 800; letter-spacing: 0.8px; color: var(--primary-teal); margin-bottom: 4px; text-transform: uppercase; }

        .title-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; }
        .title-row h2 { font-size: 24px; font-weight: 800; }
        .title-row p { font-size: 13.5px; color: var(--text-muted); margin-top: 2px; }

        .btn-new-customer {
            background: var(--primary-teal); color: #FFF; border: none;
            padding: 10px 20px; border-radius: 10px; font-family: var(--font-main);
            font-size: 13.5px; font-weight: 700; display: flex; align-items: center; gap: 8px; cursor: pointer;
        }

        .filter-card {
            background: #FFFFFF; border: 1px solid var(--card-border);
            border-radius: 16px; padding: 20px; margin-bottom: 24px;
            display: grid; grid-template-columns: repeat(3, 1fr) auto; gap: 16px; align-items: flex-end;
        }

        .filter-group { display: flex; flex-direction: column; gap: 6px; }
        .filter-group label { font-size: 10px; font-weight: 800; letter-spacing: 0.8px; color: var(--text-muted); }

        .select-box {
            background: #F8FAFC; border: 1.5px solid var(--card-border);
            border-radius: 10px; padding: 10px 14px; font-family: var(--font-main); font-size: 13px; font-weight: 600;
        }

        .select-box select { border: none; background: transparent; outline: none; width: 100%; font-family: var(--font-main); font-size: 13px; }

        .btn-reset {
            background: #E2E8F0; color: var(--text-dark); border: none;
            padding: 10px 18px; border-radius: 10px; font-family: var(--font-main);
            font-size: 13px; font-weight: 700; cursor: pointer; height: 42px;
        }

        .table-card { background: #FFFFFF; border: 1px solid var(--card-border); border-radius: 16px; overflow: hidden; }

        .customer-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }

        .customer-table th {
            text-align: left; padding: 14px 20px; font-size: 10px; font-weight: 800;
            letter-spacing: 0.8px; color: var(--text-muted); background: #F8FAFC; border-bottom: 1px solid var(--card-border);
        }

        .customer-table td { padding: 16px 20px; border-bottom: 1px solid var(--card-border); vertical-align: middle; }

        .customer-profile-cell { display: flex; align-items: center; gap: 12px; }
        .customer-avatar { width: 40px; height: 40px; border-radius: 50%; object-fit: cover; }

        .customer-name { font-weight: 700; font-size: 14px; text-decoration: none; color: var(--text-dark); }
        .customer-name:hover { color: var(--primary-teal); }
        .customer-id { font-size: 11.5px; color: var(--text-muted); }

        .orders-count { font-weight: 800; font-size: 14px; }
        .orders-val { font-size: 12px; color: var(--primary-teal); font-weight: 700; margin-top: 2px; }

        .body-shape-badge {
            font-size: 9.5px; font-weight: 800; letter-spacing: 0.5px;
            padding: 4px 10px; border-radius: 12px; background: #EDF2F7; color: #4A5568; display: inline-block;
        }

        .contact-email { font-size: 12.5px; color: var(--text-dark); }
        .contact-phone { font-size: 11.5px; color: var(--text-muted); margin-top: 2px; }

        .pagination-bar {
            padding: 16px 20px; display: flex; justify-content: space-between; align-items: center;
            font-size: 12.5px; color: var(--text-muted); background: #F8FAFC;
        }

        .page-pills { display: flex; gap: 6px; }
        .page-btn {
            width: 32px; height: 32px; border-radius: 8px; border: 1px solid var(--card-border);
            background: #FFF; font-size: 12.5px; font-weight: 700; display: flex; align-items: center; justify-content: center;
            cursor: pointer; color: var(--text-dark); text-decoration: none;
        }

        .page-btn.active { background: var(--primary-teal); color: #FFF; border-color: var(--primary-teal); }
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
                    <a href="{{ route('staff.index') }}" class="nav-link active">
                        <span class="material-symbols-outlined">group</span>
                        Staff & Clients
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
                <input type="text" placeholder="Search customers...">
            </div>

            <div class="header-right">
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">history</span>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">notifications</span>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">settings</span>
                <div class="user-profile-widget">
                    <span>Management Console<br><small style="color:var(--text-muted);">Super Admin</small></span>
                    <img src="{{ asset('assets/images/onboarding_tailor.jpg') }}" class="user-avatar" alt="Super Admin">
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="content-area">
            <div class="breadcrumb">MANAGEMENT › CUSTOMER DIRECTORY</div>

            <div class="title-row">
                <div>
                    <h2>Customer Ledger</h2>
                    <p>Managing 1,248 high-profile clients across 4 branches.</p>
                </div>

                <button class="btn-new-customer">
                    <span class="material-symbols-outlined" style="font-size: 18px;">person_add</span>
                    New Customer
                </button>
            </div>

            <!-- Filter Card -->
            <div class="filter-card">
                <div class="filter-group">
                    <label>BODY SHAPE</label>
                    <div class="select-box">
                        <select><option>All Shapes</option><option>Athletic</option><option>Slim</option><option>Broad</option></select>
                    </div>
                </div>

                <div class="filter-group">
                    <label>LAST ORDER DATE</label>
                    <div class="select-box">
                        <select><option>Anytime</option><option>Last 30 Days</option><option>Last 6 Months</option></select>
                    </div>
                </div>

                <div class="filter-group">
                    <label>CITY</label>
                    <div class="select-box">
                        <select><option>All Locations</option><option>London</option><option>New York</option><option>Paris</option></select>
                    </div>
                </div>

                <button class="btn-reset">Reset Filters</button>
            </div>

            <!-- Customer Directory Data Table -->
            <div class="table-card">
                <table class="customer-table">
                    <thead>
                        <tr>
                            <th>CUSTOMER PROFILE</th>
                            <th>TOTAL ORDERS</th>
                            <th>LAST VISIT</th>
                            <th>BODY SHAPE</th>
                            <th>CONTACT</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Row 1 -->
                        <tr>
                            <td>
                                <div class="customer-profile-cell">
                                    <img src="{{ asset('assets/images/onboarding_tailor.jpg') }}" class="customer-avatar" alt="Avatar">
                                    <div>
                                        <a href="{{ route('customers.show', 1) }}" class="customer-name">Alexander Vance</a>
                                        <div class="customer-id">ID: #CUST-9921</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="orders-count">14 Orders</div>
                                <div class="orders-val">$12,450 Lifetime</div>
                            </td>
                            <td>Oct 24, 2023</td>
                            <td><span class="body-shape-badge">ATHLETIC</span></td>
                            <td>
                                <div class="contact-email">a.vance@executive.com</div>
                                <div class="contact-phone">+44 7700 900077</div>
                            </td>
                            <td><span class="material-symbols-outlined" style="cursor:pointer; color:var(--text-muted);">more_vert</span></td>
                        </tr>

                        <!-- Row 2 -->
                        <tr>
                            <td>
                                <div class="customer-profile-cell">
                                    <img src="{{ asset('assets/images/onboarding_tailor_light.jpg') }}" class="customer-avatar" alt="Avatar">
                                    <div>
                                        <a href="{{ route('customers.show', 2) }}" class="customer-name">Elena Rodriguez</a>
                                        <div class="customer-id">ID: #CUST-8842</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="orders-count">06 Orders</div>
                                <div class="orders-val">$4,120 Lifetime</div>
                            </td>
                            <td>Nov 12, 2023</td>
                            <td><span class="body-shape-badge">SLIM</span></td>
                            <td>
                                <div class="contact-email">elena.r@architect.io</div>
                                <div class="contact-phone">+34 912 345 678</div>
                            </td>
                            <td><span class="material-symbols-outlined" style="cursor:pointer; color:var(--text-muted);">more_vert</span></td>
                        </tr>

                        <!-- Row 3 -->
                        <tr>
                            <td>
                                <div class="customer-profile-cell">
                                    <img src="{{ asset('assets/images/hero_tailor_atelier.jpg') }}" class="customer-avatar" alt="Avatar">
                                    <div>
                                        <a href="{{ route('customers.show', 3) }}" class="customer-name">Jonathan Sterling</a>
                                        <div class="customer-id">ID: #CUST-7701</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="orders-count">22 Orders</div>
                                <div class="orders-val">$38,900 Lifetime</div>
                            </td>
                            <td style="color:#10B981; font-weight:700;">Today</td>
                            <td><span class="body-shape-badge">REGULAR</span></td>
                            <td>
                                <div class="contact-email">sterling.j@law.com</div>
                                <div class="contact-phone">+1 212 555 0199</div>
                            </td>
                            <td><span class="material-symbols-outlined" style="cursor:pointer; color:var(--text-muted);">more_vert</span></td>
                        </tr>

                        <!-- Row 4 -->
                        <tr>
                            <td>
                                <div class="customer-profile-cell">
                                    <img src="{{ asset('assets/images/bespoke_tailor_atelier_hero.jpg') }}" class="customer-avatar" alt="Avatar">
                                    <div>
                                        <a href="{{ route('customers.show', 4) }}" class="customer-name">Marcus Chen</a>
                                        <div class="customer-id">ID: #CUST-5512</div>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <div class="orders-count">03 Orders</div>
                                <div class="orders-val">$2,800 Lifetime</div>
                            </td>
                            <td>Dec 01, 2023</td>
                            <td><span class="body-shape-badge">BROAD</span></td>
                            <td>
                                <div class="contact-email">m.chen@fintech.co</div>
                                <div class="contact-phone">+852 2123 4567</div>
                            </td>
                            <td><span class="material-symbols-outlined" style="cursor:pointer; color:var(--text-muted);">more_vert</span></td>
                        </tr>
                    </tbody>
                </table>

                <div class="pagination-bar">
                    <div>Showing 1-10 of 1,248 customers</div>
                    <div class="page-pills">
                        <a href="#" class="page-btn">‹</a>
                        <a href="#" class="page-btn active">1</a>
                        <a href="#" class="page-btn">2</a>
                        <a href="#" class="page-btn">3</a>
                        <span style="padding:0 4px; display:flex; align-items:center;">...</span>
                        <a href="#" class="page-btn">125</a>
                        <a href="#" class="page-btn">›</a>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
