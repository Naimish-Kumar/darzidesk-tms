<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Billing & Subscriptions - {{ env('APP_NAME', 'DarziDesk') }}</title>
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

        .user-pill {
            background: #EBF3FA; border-radius: 12px; padding: 10px 12px;
            display: flex; align-items: center; gap: 10px; margin-top: 16px;
        }

        .user-avatar {
            width: 32px; height: 32px; background: #4FD1C5; color: #FFFFFF;
            border-radius: 8px; font-size: 12px; font-weight: 800;
            display: flex; align-items: center; justify-content: center;
        }

        .user-info h5 { font-size: 13px; font-weight: 700; }
        .user-info p { font-size: 10px; font-weight: 800; color: var(--primary-teal); letter-spacing: 0.5px; }

        .main-wrapper { margin-left: 240px; flex: 1; display: flex; flex-direction: column; }

        .top-header {
            height: 64px; background: #FFFFFF; border-bottom: 1px solid var(--card-border);
            display: flex; align-items: center; justify-content: space-between; padding: 0 28px;
            position: sticky; top: 0; z-index: 90;
        }

        .header-title-section { display: flex; align-items: center; gap: 24px; }
        .header-title-section h3 { font-size: 18px; font-weight: 800; color: var(--primary-teal); }
        .header-tabs { display: flex; gap: 20px; font-size: 13.5px; font-weight: 600; }
        .header-tab { color: var(--text-muted); text-decoration: none; padding-bottom: 4px; border-bottom: 2px solid transparent; }
        .header-tab.active { color: var(--primary-teal); border-bottom-color: var(--primary-teal); font-weight: 700; }
        .header-right { display: flex; align-items: center; gap: 14px; }

        .content-area { padding: 28px; max-width: 1200px; }

        .grid-2col { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 28px; }

        .active-plan-card {
            background: #FFFFFF; border: 1px solid var(--card-border);
            border-radius: 18px; padding: 24px; position: relative;
        }

        .badge-active {
            font-size: 10px; font-weight: 800; letter-spacing: 0.8px;
            background: #E6FFFA; color: var(--primary-teal); padding: 4px 10px; border-radius: 6px;
        }

        .plan-title { font-size: 26px; font-weight: 800; margin: 12px 0 16px; }

        .price-seal {
            position: absolute; top: 20px; right: 24px;
            width: 80px; height: 80px; background: #E6FFFA; color: var(--primary-teal);
            border-radius: 50%; display: flex; flex-direction: column; align-items: center; justify-content: center;
            border: 2px dashed var(--accent-teal); text-align: center;
        }

        .price-seal .amount { font-size: 18px; font-weight: 800; }
        .price-seal .period { font-size: 9px; font-weight: 700; }

        .features-2col { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; margin-bottom: 24px; }
        .feat-item { font-size: 13px; font-weight: 600; display: flex; align-items: center; gap: 8px; }

        .btn-update-payment {
            background: var(--primary-teal); color: #FFF; border: none;
            padding: 10px 18px; border-radius: 8px; font-family: var(--font-main);
            font-size: 13px; font-weight: 700; cursor: pointer; float: right;
        }

        .payment-method-card {
            background: #FFFFFF; border: 1px solid var(--card-border);
            border-radius: 18px; padding: 24px; display: flex; flex-direction: column; justify-content: space-between;
        }

        .credit-card-graphic {
            background: linear-gradient(135deg, #1E293B 0%, #0F172A 100%);
            color: #FFFFFF; border-radius: 14px; padding: 20px; margin-bottom: 16px;
            box-shadow: 0 4px 14px rgba(0,0,0,0.15);
        }

        .card-top-icon { display: flex; justify-content: space-between; margin-bottom: 24px; }
        .card-number { font-family: var(--font-code); font-size: 18px; letter-spacing: 2px; margin-bottom: 16px; }
        .card-footer { display: flex; justify-content: space-between; font-size: 10px; letter-spacing: 0.8px; }

        .btn-add-card {
            width: 100%; padding: 10px; border: 1px dashed var(--card-border);
            border-radius: 10px; background: #FFF; font-family: var(--font-main);
            font-size: 13px; font-weight: 700; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 6px;
        }

        .section-header-row { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
        .section-header-row h3 { font-size: 18px; font-weight: 800; }

        .tier-cards-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 28px; }

        .tier-card {
            background: #FFFFFF; border: 2px solid var(--card-border);
            border-radius: 18px; padding: 24px; position: relative; overflow: hidden;
            display: flex; flex-direction: column; justify-content: space-between;
        }

        .tier-card.popular { border-color: var(--primary-teal); }

        .popular-ribbon {
            position: absolute; top: 16px; right: -30px;
            background: var(--primary-teal); color: #FFF;
            font-size: 9px; font-weight: 800; letter-spacing: 1px;
            padding: 4px 30px; transform: rotate(45deg);
        }

        .tier-icon {
            width: 36px; height: 36px; background: #E6FFFA; color: var(--primary-teal);
            border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 12px;
        }

        .tier-title { font-size: 17px; font-weight: 800; margin-bottom: 4px; }
        .tier-sub { font-size: 12px; color: var(--text-muted); margin-bottom: 16px; }

        .tier-bullets { display: flex; flex-direction: column; gap: 10px; margin-bottom: 24px; font-size: 13px; }
        .tier-bullets div { display: flex; align-items: flex-start; gap: 8px; }

        .btn-upgrade {
            width: 100%; padding: 12px; background: var(--primary-teal); color: #FFF;
            border: none; border-radius: 10px; font-family: var(--font-main);
            font-size: 14px; font-weight: 700; cursor: pointer; text-align: center;
        }

        .btn-sales-outline {
            width: 100%; padding: 12px; border: 1.5px solid var(--primary-teal);
            color: var(--primary-teal); background: #FFF; border-radius: 10px;
            font-family: var(--font-main); font-size: 14px; font-weight: 700; cursor: pointer; text-align: center;
        }

        .billing-table-card { background: #FFFFFF; border: 1px solid var(--card-border); border-radius: 16px; overflow: hidden; }
        .billing-table { width: 100%; border-collapse: collapse; font-size: 13.5px; }

        .billing-table th {
            text-align: left; padding: 14px 20px; font-size: 10px; font-weight: 800;
            letter-spacing: 0.8px; color: var(--text-muted); background: #F8FAFC; border-bottom: 1px solid var(--card-border);
        }

        .billing-table td { padding: 16px 20px; border-bottom: 1px solid var(--card-border); }

        .font-mono { font-family: var(--font-code); font-weight: 700; }

        .badge-paid { font-size: 9.5px; font-weight: 800; background: #D1FAE5; color: #047857; padding: 2px 8px; border-radius: 6px; }
        .badge-refunded { font-size: 9.5px; font-weight: 800; background: #FEE2E2; color: #DC2626; padding: 2px 8px; border-radius: 6px; }

        .table-footer-link { padding: 14px; text-align: center; font-size: 12.5px; font-weight: 700; color: var(--text-muted); background: #F8FAFC; cursor: pointer; }
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
                    <a href="{{ route('billing.index') }}" class="nav-link active">
                        <span class="material-symbols-outlined">receipt_long</span>
                        Billing
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
            <div class="user-pill">
                <div class="user-avatar">SO</div>
                <div class="user-info">
                    <h5>Savile Row Bespoke</h5>
                    <p>PREMIUM TIER</p>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Wrapper -->
    <div class="main-wrapper">
        <!-- Top Header -->
        <header class="top-header">
            <div class="header-title-section">
                <h3>Billing & Subscriptions</h3>
                <div class="header-tabs">
                    <a href="#" class="header-tab">Account Settings</a>
                    <a href="#" class="header-tab active">Billing</a>
                    <a href="#" class="header-tab">Team Access</a>
                </div>
            </div>

            <div class="header-right">
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">notifications</span>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">history</span>
                <span class="material-symbols-outlined" style="font-size: 24px; color: var(--text-muted); cursor: pointer;">account_circle</span>
            </div>
        </header>

        <!-- Content Area -->
        <main class="content-area">

            <!-- Grid: Active Plan & Payment Method -->
            <div class="grid-2col">
                <!-- Active Plan Card -->
                <div class="active-plan-card">
                    <span class="badge-active">ACTIVE PLAN</span>
                    <div class="plan-title">Premium Tailor Tier</div>

                    <div class="price-seal">
                        <div class="amount">$149</div>
                        <div class="period">/mo Billed Annually</div>
                    </div>

                    <div class="features-2col">
                        <div class="feat-item">
                            <span class="material-symbols-outlined" style="color: #10B981; font-size: 18px;">check_circle</span>
                            Unlimited Order Management
                        </div>
                        <div class="feat-item">
                            <span class="material-symbols-outlined" style="color: #10B981; font-size: 18px;">check_circle</span>
                            Advanced Measurement Sync
                        </div>
                        <div class="feat-item">
                            <span class="material-symbols-outlined" style="color: #10B981; font-size: 18px;">check_circle</span>
                            Priority Artisan Dispatch
                        </div>
                        <div class="feat-item">
                            <span class="material-symbols-outlined" style="color: #10B981; font-size: 18px;">check_circle</span>
                            Custom Brand Whitelabeling
                        </div>
                    </div>

                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <div style="font-size:12px; color:var(--text-muted);">
                            Next Renewal Date: <strong>October 24, 2024</strong>
                        </div>
                        <button class="btn-update-payment">Update Payment Details</button>
                    </div>
                </div>

                <!-- Primary Payment Method Card -->
                <div class="payment-method-card">
                    <div>
                        <div style="font-size:14.5px; font-weight:800; display:flex; align-items:center; gap:8px; margin-bottom:16px;">
                            <span class="material-symbols-outlined" style="color: var(--primary-teal);">credit_card</span>
                            Primary Payment Method
                        </div>

                        <div class="credit-card-graphic">
                            <div class="card-top-icon">
                                <div style="width: 32px; height: 20px; background: rgba(255,255,255,0.2); border-radius:4px;"></div>
                                <span class="material-symbols-outlined" style="font-size: 20px;">contactless</span>
                            </div>
                            <div class="card-number">•••• •••• •••• 4242</div>
                            <div class="card-footer">
                                <div>CARD HOLDER<br><strong>ALEXANDER MCQUEEN</strong></div>
                                <div>EXP RES<br><strong>12/26</strong></div>
                            </div>
                        </div>
                    </div>

                    <button class="btn-add-card">
                        <span class="material-symbols-outlined" style="font-size: 18px;">add</span>
                        Add New Card
                    </button>
                </div>
            </div>

            <!-- Scale Your Workshop -->
            <div class="section-header-row">
                <h3>Scale Your Workshop</h3>
                <a href="#" style="font-size:12.5px; font-weight:800; color:var(--primary-teal); text-decoration:none;">Compare All Tiers →</a>
            </div>

            <div class="tier-cards-grid">
                <!-- Enterprise Card -->
                <div class="tier-card popular">
                    <div class="popular-ribbon">POPULAR</div>
                    <div>
                        <div class="tier-icon">
                            <span class="material-symbols-outlined">center_focus_strong</span>
                        </div>
                        <div class="tier-title">Enterprise & AI Scanning</div>
                        <div class="tier-sub">For high-volume atelier networks</div>

                        <div class="tier-bullets">
                            <div>
                                <span class="material-symbols-outlined" style="color: #0284C7; font-size: 18px;">bolt</span>
                                <div><strong>AI Body Scanning:</strong> Generate 3D avatars and precise measurements from 2 photos.</div>
                            </div>
                            <div>
                                <span class="material-symbols-outlined" style="color: #0284C7; font-size: 18px;">bolt</span>
                                <div>Multi-location workshop synchronization.</div>
                            </div>
                            <div>
                                <span class="material-symbols-outlined" style="color: #0284C7; font-size: 18px;">bolt</span>
                                <div>Dedicated account manager & 24/7 technical support.</div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div style="font-size: 24px; font-weight: 800; margin-bottom: 14px;">
                            $499 <span style="font-size: 12px; font-weight: 500; color: var(--text-muted);">/month billed annually</span>
                        </div>
                        <button class="btn-upgrade">Upgrade to Enterprise</button>
                    </div>
                </div>

                <!-- Bespoke Couture Card -->
                <div class="tier-card">
                    <div>
                        <div class="tier-icon" style="background:#F1F5F9; color:#475569;">
                            <span class="material-symbols-outlined">straighten</span>
                        </div>
                        <div class="tier-title">Bespoke Couture</div>
                        <div class="tier-sub">Custom features for unique boutiques</div>

                        <p style="font-size: 13px; color: var(--text-muted); line-height: 1.5; margin-bottom: 24px;">
                            Looking for a custom solution with API access, specialized CAD integrations, or volume-based pricing? Let's build a plan that fits your craft perfectly.
                        </p>
                    </div>

                    <button class="btn-sales-outline">Talk to Sales</button>
                </div>
            </div>

            <!-- Billing History Table -->
            <div class="section-header-row">
                <h3>Billing History</h3>
                <div style="display:flex; gap:8px;">
                    <select style="border:1px solid var(--card-border); padding:6px 12px; border-radius:8px; font-size:12px;">
                        <option>Last 12 Months</option>
                    </select>
                    <button style="border:1px solid var(--card-border); background:#FFF; padding:6px 10px; border-radius:8px; cursor:pointer;">
                        <span class="material-symbols-outlined" style="font-size: 16px;">tune</span>
                    </button>
                </div>
            </div>

            <div class="billing-table-card">
                <table class="billing-table">
                    <thead>
                        <tr>
                            <th>DATE</th>
                            <th>INVOICE ID</th>
                            <th>AMOUNT</th>
                            <th>STATUS</th>
                            <th>DOWNLOAD</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Sep 24, 2024</td>
                            <td class="font-mono">INV-2024-009</td>
                            <td class="font-mono">$149.00</td>
                            <td><span class="badge-paid">PAID</span></td>
                            <td><span class="material-symbols-outlined" style="cursor:pointer; color:var(--primary-teal);">download</span></td>
                        </tr>
                        <tr>
                            <td>Aug 24, 2024</td>
                            <td class="font-mono">INV-2024-008</td>
                            <td class="font-mono">$149.00</td>
                            <td><span class="badge-paid">PAID</span></td>
                            <td><span class="material-symbols-outlined" style="cursor:pointer; color:var(--primary-teal);">download</span></td>
                        </tr>
                        <tr>
                            <td>Jul 24, 2024</td>
                            <td class="font-mono">INV-2024-007</td>
                            <td class="font-mono">$149.00</td>
                            <td><span class="badge-paid">PAID</span></td>
                            <td><span class="material-symbols-outlined" style="cursor:pointer; color:var(--primary-teal);">download</span></td>
                        </tr>
                        <tr>
                            <td>Jun 24, 2024</td>
                            <td class="font-mono">INV-2024-006</td>
                            <td class="font-mono">$149.00</td>
                            <td><span class="badge-refunded">REFUNDED</span></td>
                            <td><span class="material-symbols-outlined" style="cursor:pointer; color:var(--primary-teal);">download</span></td>
                        </tr>
                    </tbody>
                </table>

                <div class="table-footer-link">View All Invoices</div>
            </div>

        </main>
    </div>

</body>
</html>
