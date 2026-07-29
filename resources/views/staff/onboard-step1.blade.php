<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Staff Onboarding - Step 1: Personal Profile - {{ env('APP_NAME', 'DarziDesk') }}</title>
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

        .main-wrapper { margin-left: 240px; flex: 1; display: flex; flex-direction: column; }

        .top-header {
            height: 64px; background: #FFFFFF; border-bottom: 1px solid var(--card-border);
            display: flex; align-items: center; justify-content: space-between; padding: 0 28px;
            position: sticky; top: 0; z-index: 90;
        }

        .header-title-section h3 { font-size: 18px; font-weight: 800; color: var(--primary-teal); }
        .header-right { display: flex; align-items: center; gap: 14px; }

        .user-initials-badge {
            width: 32px; height: 32px; background: #26A69A; color: #FFF;
            border-radius: 50%; font-size: 11px; font-weight: 800;
            display: flex; align-items: center; justify-content: center;
        }

        .stepper-container {
            display: flex; align-items: center; justify-content: center;
            gap: 16px; padding: 28px 0 20px; max-width: 650px; margin: 0 auto;
        }

        .step-item { display: flex; flex-direction: column; align-items: center; gap: 6px; }

        .step-circle {
            width: 34px; height: 34px; border-radius: 50%; background: #CBD5E1; color: #FFF;
            font-size: 13px; font-weight: 800; display: flex; align-items: center; justify-content: center;
        }

        .step-circle.active { background: var(--primary-teal); }
        .step-lbl { font-size: 11.5px; font-weight: 700; color: var(--text-muted); }
        .step-lbl.active { color: var(--primary-teal); }

        .step-line { flex: 1; height: 2px; background: #CBD5E1; max-width: 100px; }

        .content-area { padding: 0 28px 40px; max-width: 850px; margin: 0 auto; width: 100%; }

        .form-card {
            background: #FFFFFF; border: 1px solid var(--card-border);
            border-radius: 18px; padding: 36px; margin-bottom: 24px;
        }

        .form-card-header h3 { font-size: 20px; font-weight: 800; margin-bottom: 4px; }
        .form-card-header p { font-size: 13px; color: var(--text-muted); margin-bottom: 28px; }

        .avatar-upload-box { display: flex; align-items: center; gap: 20px; margin-bottom: 28px; }

        .avatar-circle-placeholder {
            width: 72px; height: 72px; border-radius: 50%; background: #E2E8F0;
            border: 2px dashed #94A3B8; display: flex; align-items: center; justify-content: center;
            color: #64748B; position: relative;
        }

        .edit-icon-badge {
            position: absolute; bottom: 0; right: 0; width: 22px; height: 22px;
            background: var(--primary-teal); color: #FFF; border-radius: 50%;
            font-size: 12px; display: flex; align-items: center; justify-content: center; border: 2px solid #FFF;
        }

        .upload-info h5 { font-size: 13.5px; font-weight: 700; margin-bottom: 2px; }
        .upload-info p { font-size: 11.5px; color: var(--text-muted); margin-bottom: 6px; }
        .btn-upload-text { font-size: 12px; font-weight: 800; color: var(--primary-teal); text-decoration: none; }

        .form-group { display: flex; flex-direction: column; gap: 6px; margin-bottom: 20px; }
        .form-group label { font-size: 12.5px; font-weight: 700; color: var(--text-dark); }

        .input-box {
            background: #FFFFFF; border: 1.5px solid var(--card-border);
            border-radius: 10px; padding: 12px 14px; font-family: var(--font-main);
            font-size: 13.5px; outline: none; transition: border-color 0.2s; display: flex; align-items: center; gap: 10px;
        }

        .input-box input { border: none; background: transparent; outline: none; width: 100%; font-family: var(--font-main); font-size: 13.5px; }

        .input-box.disabled { background: #F1F5F9; color: var(--text-muted); }

        .form-row-2col { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

        .divider-line { height: 1px; background: var(--card-border); margin: 24px 0; }

        .form-actions { display: flex; align-items: center; justify-content: space-between; }

        .btn-cancel { font-size: 13.5px; font-weight: 700; color: var(--text-muted); text-decoration: none; }

        .btn-save-next {
            background: var(--primary-teal); color: #FFF; border: none;
            padding: 12px 24px; border-radius: 10px; font-family: var(--font-main);
            font-size: 14px; font-weight: 700; display: flex; align-items: center; gap: 8px;
            cursor: pointer; text-decoration: none;
        }

        .callout-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

        .callout-card {
            background: #F0F9FF; border: 1px solid #BAE6FD; border-radius: 14px;
            padding: 18px; display: flex; align-items: flex-start; gap: 12px;
        }

        .callout-title { font-size: 12.5px; font-weight: 800; color: #0369A1; margin-bottom: 2px; }
        .callout-desc { font-size: 11.5px; color: #0C4A6E; line-height: 1.4; }
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
                    <a href="{{ route('orders.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">shopping_bag</span>
                        Orders
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('staff.index') }}" class="nav-link active">
                        <span class="material-symbols-outlined">group</span>
                        Staff
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('financials.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">payments</span>
                        Financials
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('branches.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">account_tree</span>
                        Branches
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
                <h3>Staff Onboarding</h3>
            </div>

            <div class="header-right">
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">notifications</span>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">history</span>
                <div class="user-initials-badge">SO</div>
            </div>
        </header>

        <!-- Stepper -->
        <div class="stepper-container">
            <div class="step-item">
                <div class="step-circle active">1</div>
                <div class="step-lbl active">Basic Info</div>
            </div>
            <div class="step-line"></div>
            <div class="step-item">
                <div class="step-circle">2</div>
                <div class="step-lbl">Skills & Specialties</div>
            </div>
            <div class="step-line"></div>
            <div class="step-item">
                <div class="step-circle">3</div>
                <div class="step-lbl">Payout & Security</div>
            </div>
        </div>

        <!-- Content Area -->
        <main class="content-area">
            <div class="form-card">
                <div class="form-card-header">
                    <h3>Step 1: Personal Profile</h3>
                    <p>Enter the foundational details for your new artisan or staff member.</p>
                </div>

                <!-- Avatar Upload Section -->
                <div class="avatar-upload-box">
                    <div class="avatar-circle-placeholder">
                        <span class="material-symbols-outlined" style="font-size: 32px;">person_add</span>
                        <div class="edit-icon-badge">
                            <span class="material-symbols-outlined" style="font-size: 12px;">edit</span>
                        </div>
                    </div>
                    <div class="upload-info">
                        <h5>Profile Image</h5>
                        <p>JPG, PNG or GIF. Max size 2MB.</p>
                        <a href="#" class="btn-upload-text">Upload photo</a>
                    </div>
                </div>

                <!-- Form Fields -->
                <div class="form-group">
                    <label>Full Name</label>
                    <div class="input-box">
                        <input type="text" placeholder="e.g. Sameer Al-Fayed">
                    </div>
                </div>

                <div class="form-row-2col">
                    <div class="form-group">
                        <label>Email Address</label>
                        <div class="input-box">
                            <span class="material-symbols-outlined" style="font-size: 18px; color: var(--text-muted);">mail</span>
                            <input type="email" value="sameer@darzidesk.com">
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Phone Number</label>
                        <div class="input-box">
                            <span class="material-symbols-outlined" style="font-size: 18px; color: var(--text-muted);">call</span>
                            <input type="text" value="+91 98765 43210">
                        </div>
                    </div>
                </div>

                <div class="form-row-2col">
                    <div class="form-group">
                        <label>Date of Joining</label>
                        <div class="input-box">
                            <input type="text" placeholder="dd/mm/yyyy">
                            <span class="material-symbols-outlined" style="font-size: 18px; color: var(--text-muted);">calendar_today</span>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>Staff ID (Auto-generated)</label>
                        <div class="input-box disabled">
                            <input type="text" value="DZ-2024-089" readonly>
                        </div>
                    </div>
                </div>

                <div class="divider-line"></div>

                <div class="form-actions">
                    <a href="{{ route('staff.index') }}" class="btn-cancel">Cancel</a>
                    <a href="{{ route('staff.onboard.step2') }}" class="btn-save-next">
                        Next: Skills & Specialties
                        <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
                    </a>
                </div>
            </div>

            <!-- Callout Cards -->
            <div class="callout-grid">
                <div class="callout-card">
                    <span class="material-symbols-outlined" style="color: #0284C7;">info</span>
                    <div>
                        <div class="callout-title">Why is this needed?</div>
                        <div class="callout-desc">Accurate basic info ensures seamless internal communication and automated payroll tracking in later steps.</div>
                    </div>
                </div>

                <div class="callout-card">
                    <span class="material-symbols-outlined" style="color: #0284C7;">security</span>
                    <div>
                        <div class="callout-title">Encrypted Data</div>
                        <div class="callout-desc">All staff information is stored in a secure, AES-256 encrypted vault accessible only by shop administrators.</div>
                    </div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
