<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Management - {{ env('APP_NAME', 'DarziDesk') }}</title>
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

        .search-bar {
            background: #F1F5F9; border-radius: 20px; padding: 6px 16px;
            display: flex; align-items: center; gap: 8px; width: 340px;
        }

        .search-bar input { border: none; background: transparent; outline: none; font-family: var(--font-main); font-size: 12.5px; width: 100%; }

        .header-right { display: flex; align-items: center; gap: 16px; }

        .branch-btn {
            background: #EBF8FF; border: 1px solid #BAE6FD; border-radius: 8px;
            padding: 6px 12px; font-size: 12px; font-weight: 700; color: #0284C7;
            display: flex; align-items: center; gap: 6px; cursor: pointer;
        }

        .content-area { padding: 28px; flex: 1; }

        .title-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; }
        .title-row h2 { font-size: 24px; font-weight: 800; }
        .title-row p { font-size: 13.5px; color: var(--text-muted); margin-top: 2px; }

        .header-actions { display: flex; gap: 12px; }

        .btn-export {
            background: #FFF; border: 1px solid var(--card-border); border-radius: 10px;
            padding: 10px 18px; font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 6px; cursor: pointer; color: var(--text-dark);
        }

        .btn-add-material {
            background: var(--primary-teal); color: #FFF; border: none; border-radius: 10px;
            padding: 10px 20px; font-size: 13px; font-weight: 700; display: flex; align-items: center; gap: 6px; cursor: pointer; text-decoration: none;
        }

        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 18px; margin-bottom: 24px; }

        .stat-card {
            background: #FFFFFF; border: 1px solid var(--card-border);
            border-radius: 16px; padding: 20px; position: relative;
        }

        .stat-icon-circle {
            width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px;
        }

        .icon-teal { background: #E6FFFA; color: var(--primary-teal); }
        .icon-yellow { background: #FEFCBF; color: #D69E2E; }
        .icon-red { background: #FEE2E2; color: #E53E3E; }
        .icon-blue { background: #EBF3FA; color: #2B6CB0; }

        .stat-title { font-size: 10px; font-weight: 800; letter-spacing: 0.8px; color: var(--text-muted); margin-bottom: 4px; }
        .stat-val { font-size: 26px; font-weight: 800; font-family: var(--font-code); }
        .stat-sub { font-size: 11px; margin-top: 4px; font-weight: 600; }

        .table-controls-card {
            background: #FFFFFF; border: 1px solid var(--card-border);
            border-radius: 16px 16px 0 0; padding: 16px 20px;
            display: flex; justify-content: space-between; align-items: center; border-bottom: 1px solid var(--card-border);
        }

        .filter-selects { display: flex; gap: 12px; }
        .filter-dropdown {
            background: #F8FAFC; border: 1px solid var(--card-border); border-radius: 8px;
            padding: 8px 12px; font-family: var(--font-main); font-size: 12.5px; font-weight: 600; outline: none;
        }

        .table-card { background: #FFFFFF; border: 1px solid var(--card-border); border-top: none; border-radius: 0 0 16px 16px; overflow: hidden; }

        .inventory-table { width: 100%; border-collapse: collapse; font-size: 13px; }

        .inventory-table th {
            text-align: left; padding: 12px 20px; font-size: 10px; font-weight: 800;
            letter-spacing: 0.8px; color: var(--text-muted); background: #F8FAFC; border-bottom: 1px solid var(--card-border);
        }

        .inventory-table td { padding: 16px 20px; border-bottom: 1px solid var(--card-border); vertical-align: middle; }

        .material-item-cell { display: flex; align-items: center; gap: 12px; }
        .material-img { width: 44px; height: 44px; border-radius: 8px; object-fit: cover; }

        .material-name { font-weight: 700; font-size: 13.5px; }

        .sku-code { font-family: var(--font-code); font-size: 11.5px; font-weight: 700; color: var(--text-muted); }

        .stock-bar-wrap { width: 140px; }
        .stock-num { font-size: 11.5px; font-weight: 700; margin-bottom: 4px; }
        .progress-bar-bg { height: 5px; background: #E2E8F0; border-radius: 4px; overflow: hidden; }
        .progress-bar-fill { height: 100%; border-radius: 4px; }
        .fill-green { background: #10B981; }
        .fill-yellow { background: #D69E2E; }
        .fill-red { background: #E53E3E; }

        .status-pill { font-size: 10px; font-weight: 800; padding: 4px 10px; border-radius: 12px; display: inline-block; }
        .status-instock { background: #E6FFFA; color: var(--primary-teal); }
        .status-lowstock { background: #FEFCBF; color: #D69E2E; }
        .status-outstock { background: #FEE2E2; color: #E53E3E; }

        .unit-price { font-family: var(--font-code); font-weight: 800; font-size: 13.5px; }

        .btn-action-small {
            background: #E2E8F0; color: var(--text-dark); border: none; padding: 4px 10px;
            border-radius: 6px; font-size: 10px; font-weight: 800; cursor: pointer; margin-left: 8px;
        }

        .btn-action-red { background: #E53E3E; color: #FFF; }

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

        .footer-bar {
            height: 40px; background: #EBF3FA; border-top: 1px solid var(--card-border);
            display: flex; align-items: center; justify-content: space-between; padding: 0 28px;
            font-size: 11.5px; color: var(--text-muted);
        }
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

            <div style="background:#EBF3FA; border-radius:12px; padding:10px; display:flex; align-items:center; gap:10px; margin-top:16px;">
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
                    <a href="{{ route('production.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">cut</span>
                        Production
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('inventory.index') }}" class="nav-link active">
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
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Header -->
        <header class="top-header">
            <div class="search-bar">
                <span class="material-symbols-outlined" style="font-size: 16px; color: var(--text-muted);">search</span>
                <input type="text" placeholder="Search materials, SKUs, or suppliers...">
            </div>

            <div class="header-right">
                <button class="branch-btn">
                    <span class="material-symbols-outlined" style="font-size: 16px;">storefront</span>
                    SWITCH BRANCH ▾
                </button>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">notifications</span>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">grid_view</span>
            </div>
        </header>

        <!-- Content Area -->
        <main class="content-area">
            <div class="title-row">
                <div>
                    <h2>Inventory Management</h2>
                    <p>Manage luxury fabrics, trims, and tailoring essentials.</p>
                </div>

                <div class="header-actions">
                    <button class="btn-export">
                        <span class="material-symbols-outlined" style="font-size: 16px;">upload</span>
                        Export Ledger
                    </button>
                    <a href="{{ route('inventory.create') }}" class="btn-add-material">
                        <span class="material-symbols-outlined" style="font-size: 16px;">add</span>
                        Add New Material
                    </a>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon-circle icon-teal">
                        <span class="material-symbols-outlined">inventory_2</span>
                    </div>
                    <div class="stat-title">TOTAL SKUs</div>
                    <div class="stat-val">1,284</div>
                    <div class="stat-sub" style="color:#10B981;">↗ +12</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-circle icon-yellow">
                        <span class="material-symbols-outlined">warning</span>
                    </div>
                    <div class="stat-title">LOW STOCK ITEMS</div>
                    <div class="stat-val">42</div>
                    <div class="stat-sub" style="color:#D69E2E;">Requires attention soon</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-circle icon-red">
                        <span class="material-symbols-outlined">block</span>
                    </div>
                    <div class="stat-title">OUT OF STOCK</div>
                    <div class="stat-val">08</div>
                    <div class="stat-sub" style="color:#E53E3E;">Critical restocking needed</div>
                </div>

                <div class="stat-card">
                    <div class="stat-icon-circle icon-blue">
                        <span class="material-symbols-outlined">account_balance_wallet</span>
                    </div>
                    <div class="stat-title">INVENTORY VALUE</div>
                    <div class="stat-val">$248.5k</div>
                    <div class="stat-sub" style="color:var(--text-muted);">Market value valuation</div>
                </div>
            </div>

            <!-- Table Controls -->
            <div class="table-controls-card">
                <div class="filter-selects">
                    <select class="filter-dropdown"><option>All Categories</option><option>Fabrics</option><option>Trims</option><option>Threads</option><option>Linings</option></select>
                    <select class="filter-dropdown"><option>All Statuses</option><option>In Stock</option><option>Low Stock</option><option>Out of Stock</option></select>
                </div>

                <div style="font-size:12.5px; color:var(--text-muted); display:flex; align-items:center; gap:8px;">
                    Sort by:
                    <select class="filter-dropdown"><option>Stock (High to Low)</option><option>Stock (Low to High)</option><option>Price</option></select>
                </div>
            </div>

            <!-- Inventory Data Table -->
            <div class="table-card">
                <table class="inventory-table">
                    <thead>
                        <tr>
                            <th>MATERIAL</th>
                            <th>SKU/ID</th>
                            <th>CURRENT STOCK</th>
                            <th>STATUS</th>
                            <th>UNIT PRICE</th>
                            <th>SUPPLIER</th>
                            <th>ACTIONS</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Row 1 -->
                        <tr>
                            <td>
                                <div class="material-item-cell">
                                    <img src="{{ asset('assets/images/bespoke_tailor_atelier_hero.jpg') }}" class="material-img" alt="Fabric">
                                    <div class="material-name">Super 120s Navy Wool Fabric</div>
                                </div>
                            </td>
                            <td><span class="sku-code">FAB-NVY-120-HS</span></td>
                            <td>
                                <div class="stock-bar-wrap">
                                    <div class="stock-num">45m / 100m</div>
                                    <div class="progress-bar-bg"><div class="progress-bar-fill fill-green" style="width:45%;"></div></div>
                                </div>
                            </td>
                            <td><span class="status-pill status-instock">In Stock</span></td>
                            <td><span class="unit-price">$85.00</span></td>
                            <td>Scabal London</td>
                            <td><span class="material-symbols-outlined" style="cursor:pointer; color:var(--text-muted);">edit</span></td>
                        </tr>

                        <!-- Row 2 -->
                        <tr>
                            <td>
                                <div class="material-item-cell">
                                    <img src="{{ asset('assets/images/onboarding_tailor_light.jpg') }}" class="material-img" alt="Trims">
                                    <div class="material-name">Antique Gold Blazer Set Trims</div>
                                </div>
                            </td>
                            <td><span class="sku-code">TRM-GLD-BLZ-02</span></td>
                            <td>
                                <div class="stock-bar-wrap">
                                    <div class="stock-num" style="color:#D69E2E;">12 pcs / 150 pcs</div>
                                    <div class="progress-bar-bg"><div class="progress-bar-fill fill-yellow" style="width:12%;"></div></div>
                                </div>
                            </td>
                            <td><span class="status-pill status-lowstock">Low Stock</span></td>
                            <td><span class="unit-price">$4.50</span></td>
                            <td>Savile Row Trims</td>
                            <td>
                                <span class="material-symbols-outlined" style="cursor:pointer; color:var(--text-muted);">edit</span>
                                <button class="btn-action-small">RESTOCK</button>
                            </td>
                        </tr>

                        <!-- Row 3 -->
                        <tr>
                            <td>
                                <div class="material-item-cell">
                                    <img src="{{ asset('assets/images/onboarding_tailor.jpg') }}" class="material-img" alt="Threads">
                                    <div class="material-name">Emerald Silk Thread Threads</div>
                                </div>
                            </td>
                            <td><span class="sku-code">THR-EMR-SLK-01</span></td>
                            <td>
                                <div class="stock-bar-wrap">
                                    <div class="stock-num" style="color:#E53E3E;">0 m / 500 m</div>
                                    <div class="progress-bar-bg"><div class="progress-bar-fill fill-red" style="width:0%;"></div></div>
                                </div>
                            </td>
                            <td><span class="status-pill status-outstock">Out of Stock</span></td>
                            <td><span class="unit-price">$12.00</span></td>
                            <td>Gutermann Fine</td>
                            <td>
                                <span class="material-symbols-outlined" style="cursor:pointer; color:var(--text-muted);">edit</span>
                                <button class="btn-action-small btn-action-red">ORDER NOW</button>
                            </td>
                        </tr>

                        <!-- Row 4 -->
                        <tr>
                            <td>
                                <div class="material-item-cell">
                                    <img src="{{ asset('assets/images/hero_tailor_atelier.jpg') }}" class="material-img" alt="Linings">
                                    <div class="material-name">Charcoal Viscose Lining Linings</div>
                                </div>
                            </td>
                            <td><span class="sku-code">LIN-CHR-VIS-80</span></td>
                            <td>
                                <div class="stock-bar-wrap">
                                    <div class="stock-num">180m / 200m</div>
                                    <div class="progress-bar-bg"><div class="progress-bar-fill fill-green" style="width:90%;"></div></div>
                                </div>
                            </td>
                            <td><span class="status-pill status-instock">In Stock</span></td>
                            <td><span class="unit-price">$18.00</span></td>
                            <td>Dugdale Bros</td>
                            <td><span class="material-symbols-outlined" style="cursor:pointer; color:var(--text-muted);">edit</span></td>
                        </tr>
                    </tbody>
                </table>

                <div class="pagination-bar">
                    <div>Showing 1-4 of 1,284 materials</div>
                    <div class="page-pills">
                        <a href="#" class="page-btn">‹</a>
                        <a href="#" class="page-btn active">1</a>
                        <a href="#" class="page-btn">2</a>
                        <a href="#" class="page-btn">3</a>
                        <span style="padding:0 4px; display:flex; align-items:center;">...</span>
                        <a href="#" class="page-btn">321</a>
                        <a href="#" class="page-btn">›</a>
                    </div>
                </div>
            </div>
        </main>

        <!-- Footer -->
        <footer class="footer-bar">
            <div>DarziDesk © 2024 DarziDesk. Precision Tailoring SaaS.</div>
            <div style="display:flex; gap:20px;">
                <a href="#" style="color:var(--text-muted); text-decoration:none;">Privacy Policy</a>
                <a href="#" style="color:var(--text-muted); text-decoration:none;">Terms of Service</a>
                <a href="#" style="color:var(--text-muted); text-decoration:none;">Support</a>
            </div>
        </footer>
    </div>

</body>
</html>
