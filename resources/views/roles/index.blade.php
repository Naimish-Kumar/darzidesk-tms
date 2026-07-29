<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Roles & Permissions - {{ env('APP_NAME', 'DarziDesk') }}</title>
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

        .header-title-section { display: flex; align-items: center; gap: 24px; }
        .header-title-section h3 { font-size: 18px; font-weight: 800; color: var(--primary-teal); }
        .header-tabs { display: flex; gap: 20px; font-size: 13.5px; font-weight: 600; }
        .header-tab { color: var(--text-muted); text-decoration: none; padding-bottom: 4px; border-bottom: 2px solid transparent; }
        .header-tab.active { color: var(--primary-teal); border-bottom-color: var(--primary-teal); font-weight: 700; }
        .header-right { display: flex; align-items: center; gap: 14px; }

        .user-initials-badge {
            width: 32px; height: 32px; background: #26A69A; color: #FFF;
            border-radius: 50%; font-size: 11px; font-weight: 800;
            display: flex; align-items: center; justify-content: center;
        }

        .content-area { padding: 28px; }

        .roles-grid { display: grid; grid-template-columns: 280px 1fr; gap: 24px; }

        .roles-list-header { display: flex; align-items: center; justify-content: space-between; margin-bottom: 16px; font-size: 15px; font-weight: 800; }

        .btn-new-role { font-size: 12px; font-weight: 800; color: var(--primary-teal); text-decoration: none; display: flex; align-items: center; gap: 4px; }

        .role-cards-stack { display: flex; flex-direction: column; gap: 12px; }

        .role-card-item {
            background: #FFFFFF; border: 1.5px solid var(--card-border);
            border-radius: 14px; padding: 16px; cursor: pointer; transition: all 0.2s;
        }

        .role-card-item.selected { border-color: var(--primary-teal); box-shadow: 0 4px 12px rgba(0, 106, 103, 0.08); }
        .role-card-top { display: flex; align-items: center; justify-content: space-between; margin-bottom: 6px; }
        .role-card-left { display: flex; align-items: center; gap: 10px; }

        .role-icon-box {
            width: 32px; height: 32px; background: #E6FFFA; color: var(--primary-teal);
            border-radius: 8px; display: flex; align-items: center; justify-content: center;
        }

        .role-title { font-size: 14px; font-weight: 800; }

        .badge-default {
            font-size: 9px; font-weight: 800; letter-spacing: 0.5px;
            background: #E6FFFA; color: var(--primary-teal); padding: 2px 6px; border-radius: 4px;
        }

        .role-desc { font-size: 12px; color: var(--text-muted); margin-bottom: 12px; }

        .avatar-row { display: flex; gap: -6px; }

        .avatar-row img, .avatar-row .avatar-initials {
            width: 24px; height: 24px; border-radius: 50%; border: 2px solid #FFF;
            font-size: 9px; font-weight: 800; display: flex; align-items: center; justify-content: center;
            background: #CBD5E1; color: var(--text-dark); margin-left: -6px;
        }

        .avatar-row img:first-child, .avatar-row .avatar-initials:first-child { margin-left: 0; }

        .permissions-box { background: #FFFFFF; border: 1px solid var(--card-border); border-radius: 18px; padding: 28px; }

        .permissions-box-header {
            display: flex; align-items: flex-start; justify-content: space-between;
            padding-bottom: 20px; border-bottom: 1px solid var(--card-border); margin-bottom: 24px;
        }

        .permissions-box-header h3 { font-size: 20px; font-weight: 800; margin-bottom: 4px; }
        .permissions-box-header p { font-size: 13px; color: var(--text-muted); }

        .btn-save-permissions {
            background: var(--primary-teal); color: #FFF; border: none;
            padding: 10px 20px; border-radius: 10px; font-family: var(--font-main);
            font-size: 13.5px; font-weight: 700; cursor: pointer;
        }

        .discard-link { font-size: 13px; font-weight: 700; color: var(--text-muted); text-decoration: none; margin-right: 14px; }

        .module-section { margin-bottom: 28px; }

        .module-title { font-size: 14.5px; font-weight: 800; display: flex; align-items: center; gap: 10px; margin-bottom: 16px; color: var(--text-dark); }

        .permission-checkbox-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 14px; }

        .permission-card {
            border: 1.5px solid var(--card-border); border-radius: 12px;
            padding: 14px 16px; display: flex; align-items: flex-start; gap: 12px; cursor: pointer; transition: all 0.2s;
        }

        .permission-card.checked { border-color: var(--primary-teal); background: #FAFDFD; }

        .permission-card input { width: 18px; height: 18px; margin-top: 2px; accent-color: var(--primary-teal); }

        .permission-card-text h5 { font-size: 13.5px; font-weight: 700; margin-bottom: 2px; }
        .permission-card-text p { font-size: 12px; color: var(--text-muted); line-height: 1.4; }

        .audit-footer-bar {
            background: #F1F5F9; border-radius: 12px; padding: 12px 18px;
            font-size: 12px; color: var(--text-muted); display: flex; align-items: center; gap: 8px;
        }
    </style>
</head>
<body>

    <!-- Sidebar -->
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
                    <a href="{{ route('roles.index') }}" class="nav-link active">
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
            <div class="header-title-section">
                <h3>Roles & Permissions</h3>
                <div class="header-tabs">
                    <a href="#" class="header-tab">Employee Directory</a>
                    <a href="#" class="header-tab active">Access Management</a>
                    <a href="#" class="header-tab">Onboarding</a>
                </div>
            </div>

            <div class="header-right">
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">notifications</span>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">history</span>
                <div class="user-initials-badge">SA</div>
                <span style="font-size: 13px; font-weight: 700;">Admin</span>
            </div>
        </header>

        <!-- Content Area -->
        <main class="content-area">
            <div class="roles-grid">
                <!-- Left Roles List -->
                <div>
                    <div class="roles-list-header">
                        <span>Defined Roles</span>
                        <a href="#" class="btn-new-role">+ New Role</a>
                    </div>

                    <div class="role-cards-stack">
                        <!-- Role 1 (Selected) -->
                        <div class="role-card-item selected">
                            <div class="role-card-top">
                                <div class="role-card-left">
                                    <div class="role-icon-box">
                                        <span class="material-symbols-outlined">grade</span>
                                    </div>
                                    <div class="role-title">Owner</div>
                                </div>
                                <span class="badge-default">DEFAULT</span>
                            </div>
                            <div class="role-desc">Full system access</div>
                            <div class="avatar-row">
                                <div class="avatar-initials" style="background:#26A69A; color:#FFF;">MK</div>
                            </div>
                        </div>

                        <!-- Role 2 -->
                        <div class="role-card-item">
                            <div class="role-card-top">
                                <div class="role-card-left">
                                    <div class="role-icon-box" style="background:#EBF3FA; color:#2B6CB0;">
                                        <span class="material-symbols-outlined">storefront</span>
                                    </div>
                                    <div class="role-title">Shop Manager</div>
                                </div>
                            </div>
                            <div class="role-desc">Operations & Staff lead</div>
                            <div class="avatar-row">
                                <div class="avatar-initials">JS</div>
                                <div class="avatar-initials">RB</div>
                            </div>
                        </div>

                        <!-- Role 3 -->
                        <div class="role-card-item">
                            <div class="role-card-top">
                                <div class="role-card-left">
                                    <div class="role-icon-box" style="background:#F3E8FF; color:#7E22CE;">
                                        <span class="material-symbols-outlined">content_cut</span>
                                    </div>
                                    <div class="role-title">Senior Tailor</div>
                                </div>
                            </div>
                            <div class="role-desc">Production & Quality</div>
                            <div class="avatar-row">
                                <div class="avatar-initials">AM</div>
                                <div class="avatar-initials">TH</div>
                                <div class="avatar-initials">+4</div>
                            </div>
                        </div>

                        <!-- Role 4 -->
                        <div class="role-card-item">
                            <div class="role-card-top">
                                <div class="role-card-left">
                                    <div class="role-icon-box" style="background:#F1F5F9; color:#64748B;">
                                        <span class="material-symbols-outlined">school</span>
                                    </div>
                                    <div class="role-title">Apprentice</div>
                                </div>
                            </div>
                            <div class="role-desc">View-only & Basic entry</div>
                            <div class="avatar-row">
                                <div class="avatar-initials">LP</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Permissions Editor -->
                <div class="permissions-box">
                    <div class="permissions-box-header">
                        <div>
                            <h3>Owner</h3>
                            <p>Modify fine-grained access for this specific role.</p>
                        </div>

                        <div>
                            <a href="#" class="discard-link">Discard</a>
                            <button class="btn-save-permissions">Save Permissions</button>
                        </div>
                    </div>

                    <!-- Module 1: Orders -->
                    <div class="module-section">
                        <div class="module-title">
                            <span class="material-symbols-outlined" style="color: var(--primary-teal);">shopping_bag</span>
                            Orders Module
                        </div>

                        <div class="permission-checkbox-grid">
                            <div class="permission-card checked">
                                <input type="checkbox" checked>
                                <div class="permission-card-text">
                                    <h5>Create New Orders</h5>
                                    <p>Ability to register new customer orders and take measurements.</p>
                                </div>
                            </div>

                            <div class="permission-card checked">
                                <input type="checkbox" checked>
                                <div class="permission-card-text">
                                    <h5>Edit Measurements</h5>
                                    <p>Modify existing customer measurement profiles.</p>
                                </div>
                            </div>

                            <div class="permission-card checked">
                                <input type="checkbox" checked>
                                <div class="permission-card-text">
                                    <h5>Cancel/Refund Orders</h5>
                                    <p>Process cancellations and issue credit notes.</p>
                                </div>
                            </div>

                            <div class="permission-card checked">
                                <input type="checkbox" checked>
                                <div class="permission-card-text">
                                    <h5>Bulk Export Orders</h5>
                                    <p>Download CSV/PDF order summaries.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Module 2: Financials & Billing -->
                    <div class="module-section">
                        <div class="module-title">
                            <span class="material-symbols-outlined" style="color: var(--primary-teal);">account_balance_wallet</span>
                            Financials & Billing
                        </div>

                        <div class="permission-checkbox-grid">
                            <div class="permission-card checked">
                                <input type="checkbox" checked>
                                <div class="permission-card-text">
                                    <h5>View Revenue Reports</h5>
                                    <p>Access to monthly income and profit dashboards.</p>
                                </div>
                            </div>

                            <div class="permission-card checked">
                                <input type="checkbox" checked>
                                <div class="permission-card-text">
                                    <h5>Manage Pricing</h5>
                                    <p>Adjust standard labor and material costs.</p>
                                </div>
                            </div>

                            <div class="permission-card">
                                <input type="checkbox">
                                <div class="permission-card-text">
                                    <h5>Tax Configuration</h5>
                                    <p>Update GST/VAT and fiscal settings.</p>
                                </div>
                            </div>

                            <div class="permission-card checked">
                                <input type="checkbox" checked>
                                <div class="permission-card-text">
                                    <h5>Audit Logs</h5>
                                    <p>View historical transaction changes.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Module 3: Staff & Production -->
                    <div class="module-section">
                        <div class="module-title">
                            <span class="material-symbols-outlined" style="color: var(--primary-teal);">group</span>
                            Staff & Production
                        </div>

                        <div class="permission-checkbox-grid">
                            <div class="permission-card checked">
                                <input type="checkbox" checked>
                                <div class="permission-card-text">
                                    <h5>Assign Tasks</h5>
                                    <p>Delegate stitching or cutting tasks to artisans.</p>
                                </div>
                            </div>

                            <div class="permission-card checked">
                                <input type="checkbox" checked>
                                <div class="permission-card-text">
                                    <h5>Performance Tracking</h5>
                                    <p>View individual artisan turnaround times.</p>
                                </div>
                            </div>

                            <div class="permission-card checked">
                                <input type="checkbox" checked>
                                <div class="permission-card-text">
                                    <h5>Add/Remove Staff</h5>
                                    <p>Create user logins for new workshop employees.</p>
                                </div>
                            </div>

                            <div class="permission-card checked">
                                <input type="checkbox" checked>
                                <div class="permission-card-text">
                                    <h5>Salary Management</h5>
                                    <p>Calculate and approve artisan commissions.</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Footer Audit Notice -->
                    <div class="audit-footer-bar">
                        <span class="material-symbols-outlined" style="font-size: 16px;">lock</span>
                        Changes to permissions are logged in the global audit trail.
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
