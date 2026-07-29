<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Branch - Step 1: Basic Info - {{ env('APP_NAME', 'DarziDesk') }}</title>
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
        .nav-link:hover:not(.active) { background: #F1F5F9; }

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

        .header-left { display: flex; align-items: center; gap: 12px; font-size: 14px; font-weight: 700; }
        .header-left span { color: var(--text-muted); font-weight: 500; }

        .search-bar {
            background: #F1F5F9; border-radius: 20px; padding: 6px 14px;
            display: flex; align-items: center; gap: 8px; width: 260px;
        }

        .search-bar input { border: none; background: transparent; outline: none; font-family: var(--font-main); font-size: 12.5px; width: 100%; }

        .header-right { display: flex; align-items: center; gap: 16px; }

        .user-avatar { width: 32px; height: 32px; border-radius: 50%; object-fit: cover; }

        .stepper-container {
            display: flex; align-items: center; justify-content: center;
            gap: 16px; padding: 32px 0 24px; max-width: 600px; margin: 0 auto;
        }

        .step-item { display: flex; flex-direction: column; align-items: center; gap: 6px; }

        .step-circle {
            width: 36px; height: 36px; border-radius: 50%; background: #CBD5E1; color: #FFF;
            font-size: 14px; font-weight: 800; display: flex; align-items: center; justify-content: center;
        }

        .step-circle.active { background: var(--primary-teal); }
        .step-lbl { font-size: 12px; font-weight: 700; color: var(--text-muted); }
        .step-lbl.active { color: var(--primary-teal); }

        .step-line { flex: 1; height: 2px; background: #CBD5E1; }

        .content-area { padding: 0 28px 40px; max-width: 900px; margin: 0 auto; width: 100%; }

        .form-card {
            background: #FFFFFF; border: 1px solid var(--card-border);
            border-radius: 18px; padding: 36px; margin-bottom: 28px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.03);
        }

        .form-card-header { margin-bottom: 28px; }
        .form-card-header h3 { font-size: 22px; font-weight: 800; margin-bottom: 6px; }
        .form-card-header p { font-size: 13.5px; color: var(--text-muted); }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 32px; }

        .form-group { display: flex; flex-direction: column; gap: 6px; }
        .form-group label { font-size: 13px; font-weight: 700; color: var(--text-dark); }

        .input-box {
            background: #F8FAFC; border: 1.5px solid var(--card-border);
            border-radius: 10px; padding: 12px 14px; font-family: var(--font-main);
            font-size: 13.5px; outline: none; transition: border-color 0.2s; display: flex; align-items: center; gap: 10px;
        }

        .input-box input { border: none; background: transparent; outline: none; width: 100%; font-family: var(--font-main); font-size: 13.5px; }

        .input-box:focus-within { border-color: var(--primary-teal); background: #FFFFFF; }

        .divider-line { height: 1px; background: var(--card-border); margin-bottom: 24px; }

        .form-actions { display: flex; align-items: center; justify-content: space-between; }

        .btn-cancel { font-size: 13.5px; font-weight: 700; color: var(--text-muted); text-decoration: none; }

        .btn-save-next {
            background: var(--primary-teal); color: #FFF; border: none;
            padding: 12px 24px; border-radius: 10px; font-family: var(--font-main);
            font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 8px;
            cursor: pointer; text-decoration: none;
        }

        .callout-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px; }

        .callout-card {
            background: #F0F9FF; border: 1px solid #BAE6FD; border-radius: 14px;
            padding: 18px; display: flex; flex-direction: column; gap: 8px;
        }

        .callout-title { font-size: 13.5px; font-weight: 800; color: #0369A1; display: flex; align-items: center; gap: 6px; }
        .callout-desc { font-size: 12px; color: #0C4A6E; line-height: 1.4; }
    </style>
</head>
<body>

    <!-- Sidebar -->
    <aside class="sidebar">
        <div>
            <div class="brand-box">
                <h2>Bespoke Pro</h2>
                <span>ENTERPRISE SUITE</span>
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
                    <a href="{{ route('branches.index') }}" class="nav-link active">
                        <span class="material-symbols-outlined">account_tree</span>
                        Branch Management
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
                    <a href="{{ route('staff.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">group</span>
                        Staff
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
        <!-- Header -->
        <header class="top-header">
            <div class="header-left">
                Management Console <span>/ Add New Branch</span>
            </div>

            <div class="header-right">
                <div class="search-bar">
                    <span class="material-symbols-outlined" style="font-size: 16px; color: var(--text-muted);">search</span>
                    <input type="text" placeholder="Quick Search...">
                </div>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">history</span>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">notifications</span>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">settings</span>
                <img src="{{ asset('assets/images/onboarding_tailor.jpg') }}" class="user-avatar" alt="User">
            </div>
        </header>

        <!-- Stepper Header -->
        <div class="stepper-container">
            <div class="step-item">
                <div class="step-circle active">1</div>
                <div class="step-lbl active">Basic Info</div>
            </div>
            <div class="step-line"></div>
            <div class="step-item">
                <div class="step-circle">2</div>
                <div class="step-lbl">Location</div>
            </div>
            <div class="step-line"></div>
            <div class="step-item">
                <div class="step-circle">3</div>
                <div class="step-lbl">Settings</div>
            </div>
        </div>

        <!-- Content Area -->
        <main class="content-area">
            <div class="form-card">
                <div class="form-card-header">
                    <h3>Branch Details</h3>
                    <p>Start by providing the essential identification and contact details for your new workspace.</p>
                </div>

                <div class="form-grid">
                    <div class="form-group">
                        <label>Branch Name</label>
                        <div class="input-box">
                            <input type="text" placeholder="e.g. London Mayfair Boutique">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Branch Code</label>
                        <div class="input-box">
                            <input type="text" placeholder="e.g. LND-MAY-01">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Primary Contact Person</label>
                        <div class="input-box">
                            <input type="text" placeholder="Full Name">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Email Address</label>
                        <div class="input-box">
                            <span class="material-symbols-outlined" style="font-size: 18px; color: var(--text-muted);">mail</span>
                            <input type="email" placeholder="branch@tailorshop.com">
                        </div>
                    </div>
                </div>

                <div class="divider-line"></div>

                <div class="form-actions">
                    <a href="{{ route('branches.index') }}" class="btn-cancel">Cancel</a>
                    <a href="{{ route('branches.create.step2') }}" class="btn-save-next">
                        Save & Next
                        <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
                    </a>
                </div>
            </div>

            <!-- 3 Callout Cards -->
            <div class="callout-grid">
                <div class="callout-card">
                    <div class="callout-title">
                        <span class="material-symbols-outlined" style="font-size: 18px;">info</span>
                        Precision Coding
                    </div>
                    <div class="callout-desc">
                        Branch codes help in segmenting inventory and order tracking across your global network.
                    </div>
                </div>

                <div class="callout-card">
                    <div class="callout-title">
                        <span class="material-symbols-outlined" style="font-size: 18px;">verified_user</span>
                        Admin Rights
                    </div>
                    <div class="callout-desc">
                        Primary contacts will receive administrative setup links for their specific workstation.
                    </div>
                </div>

                <div class="callout-card">
                    <div class="callout-title">
                        <span class="material-symbols-outlined" style="font-size: 18px;">sync</span>
                        Auto-Save
                    </div>
                    <div class="callout-desc">
                        Your progress is automatically saved as a draft in the Branch Management list.
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
