<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fitting Alert Configuration - {{ env('APP_NAME', 'DarziDesk') }}</title>
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
            display: flex; align-items: center; gap: 8px; width: 300px;
        }

        .search-bar input { border: none; background: transparent; outline: none; font-family: var(--font-main); font-size: 12.5px; width: 100%; }

        .header-right { display: flex; align-items: center; gap: 16px; }

        .content-area { padding: 28px; max-width: 1250px; margin: 0 auto; width: 100%; }

        .title-row { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 24px; }
        .title-row h2 { font-size: 22px; font-weight: 800; }
        .title-row p { font-size: 13px; color: var(--text-muted); margin-top: 2px; }

        .header-btns { display: flex; gap: 12px; }

        .btn-discard {
            background: #FFF; border: 1px solid var(--card-border); border-radius: 10px;
            padding: 10px 18px; font-size: 13px; font-weight: 700; cursor: pointer; color: var(--text-dark);
        }

        .btn-save-config {
            background: var(--primary-teal); color: #FFF; border: none; border-radius: 10px;
            padding: 10px 20px; font-size: 13px; font-weight: 700; cursor: pointer;
        }

        .grid-3col { display: grid; grid-template-columns: 260px 1fr 340px; gap: 24px; }

        .triggers-header { display: flex; justify-content: space-between; align-items: center; margin-bottom: 16px; }
        .triggers-title { font-size: 13px; font-weight: 800; }
        .enabled-badge { background: #E2E8F0; font-size: 10px; font-weight: 800; padding: 2px 8px; border-radius: 10px; }

        .trigger-card {
            background: #FFFFFF; border: 1.5px solid var(--card-border);
            border-radius: 14px; padding: 16px; margin-bottom: 14px; cursor: pointer; transition: all 0.2s;
        }

        .trigger-card.selected { border-color: var(--primary-teal); background: #FAFDFD; }

        .trigger-card-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 6px; }
        .trigger-name { font-size: 13.5px; font-weight: 800; }
        .toggle-switch { width: 32px; height: 18px; background: #CBD5E1; border-radius: 10px; position: relative; }
        .toggle-switch.on { background: var(--primary-teal); }
        .toggle-knob { width: 14px; height: 14px; background: #FFF; border-radius: 50%; position: absolute; top: 2px; left: 2px; transition: all 0.2s; }
        .toggle-switch.on .toggle-knob { left: 16px; }

        .trigger-desc { font-size: 11.5px; color: var(--text-muted); line-height: 1.4; margin-bottom: 10px; }

        .trigger-tags { display: flex; gap: 6px; }
        .trig-tag { font-size: 9.5px; font-weight: 800; background: #E6FFFA; color: var(--primary-teal); padding: 2px 6px; border-radius: 4px; }

        .btn-create-custom-trig {
            width: 100%; border: 1.5px dashed var(--card-border); border-radius: 12px;
            padding: 12px; background: transparent; font-size: 12.5px; font-weight: 700;
            color: var(--text-dark); cursor: pointer; text-align: center; display: flex; align-items: center; justify-content: center; gap: 6px;
        }

        .editor-card {
            background: #FFFFFF; border: 1px solid var(--card-border);
            border-radius: 16px; padding: 24px;
        }

        .editor-title { font-size: 14px; font-weight: 800; display: flex; align-items: center; gap: 8px; margin-bottom: 20px; }

        .section-sublabel { font-size: 10.5px; font-weight: 800; letter-spacing: 0.5px; color: var(--text-dark); uppercase; margin-bottom: 10px; }

        .channels-select-grid { display: grid; grid-template-columns: repeat(3, 1fr); gap: 10px; margin-bottom: 20px; }

        .channel-card {
            border: 1.5px solid var(--card-border); border-radius: 10px; padding: 12px 8px;
            text-align: center; cursor: pointer; transition: all 0.2s; font-size: 12px; font-weight: 700;
        }

        .channel-card.selected { border-color: var(--primary-teal); background: #E6FFFA; color: var(--primary-teal); }

        .placeholders-row { display: flex; flex-wrap: wrap; gap: 6px; margin-bottom: 20px; }
        .ph-pill { font-size: 10px; font-weight: 800; font-family: var(--font-code); background: #E6FFFA; color: var(--primary-teal); border: 1px solid var(--accent-teal); padding: 4px 8px; border-radius: 6px; cursor: pointer; }

        .message-textarea-box {
            border: 1.5px solid var(--card-border); border-radius: 12px; padding: 14px;
            font-family: var(--font-main); font-size: 13px; line-height: 1.5; min-height: 140px; margin-bottom: 20px;
        }

        .message-textarea-box textarea { width: 100%; height: 100px; border: none; outline: none; font-family: var(--font-main); font-size: 13px; background: transparent; }

        .char-count { font-size: 10.5px; color: var(--text-muted); text-align: right; }

        .editor-bottom-row { display: flex; justify-content: space-between; align-items: center; pt-4; border-top: 1px solid var(--card-border); }

        .preview-column { text-align: center; }

        .preview-header { font-size: 11px; font-weight: 800; letter-spacing: 1px; color: var(--text-muted); uppercase; margin-bottom: 16px; }

        .phone-mockup {
            width: 280px; height: 500px; background: #0B1C30; border-radius: 36px;
            padding: 12px; margin: 0 auto; box-shadow: 0 12px 32px rgba(0,0,0,0.15); position: relative;
        }

        .phone-screen {
            background: #E5DDD5; width: 100%; height: 100%; border-radius: 28px;
            overflow: hidden; display: flex; flex-direction: column; text-align: left;
        }

        .phone-chat-header {
            background: #006A67; color: #FFF; padding: 12px 14px; display: flex; align-items: center; gap: 10px; font-size: 12px; font-weight: 700;
        }

        .phone-chat-body { padding: 16px 12px; flex: 1; }

        .chat-bubble-received {
            background: #FFFFFF; border-radius: 10px 10px 10px 0; padding: 10px 12px;
            font-size: 11px; color: #1E293B; line-height: 1.4; box-shadow: 0 1px 2px rgba(0,0,0,0.1);
        }

        .draft-notice-pill {
            background: #0B1C30; color: #FFF; padding: 8px 14px; border-radius: 20px;
            font-size: 11px; font-weight: 700; display: inline-flex; align-items: center; gap: 6px; margin-top: 16px;
        }

        .test-msg-link { display: block; font-size: 12px; font-weight: 700; color: var(--primary-teal); text-decoration: none; margin-top: 8px; }
    </style>
</head>
<body>

    <!-- Sidebar Nav -->
    <aside class="sidebar">
        <div>
            <div class="brand-box">
                <img src="{{ asset('assets/images/logo_wide.png') }}" alt="DarziDesk" style="height: 32px;">
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
                    <a href="{{ route('communication.index') }}" class="nav-link">
                        <span class="material-symbols-outlined">chat</span>
                        Communication
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('roles.index') }}" class="nav-link active">
                        <span class="material-symbols-outlined">verified_user</span>
                        Roles & Permissions
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
                <input type="text" placeholder="Search templates...">
            </div>

            <div class="header-right">
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">history</span>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">notifications</span>
                <span class="material-symbols-outlined" style="font-size: 20px; color: var(--text-muted); cursor: pointer;">settings</span>
                <div class="user-profile-widget" style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:700;">
                    <span>Master Tailor John<br><small style="color:var(--text-muted);">Savile Row Branch</small></span>
                    <img src="{{ asset('assets/images/onboarding_tailor.jpg') }}" style="width:32px; height:32px; border-radius:50%; object-fit:cover;" alt="John">
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="content-area">
            <div class="title-row">
                <div>
                    <h2>Fitting Alert Configuration</h2>
                    <p>Automate customer notifications and manage trial communications across channels.</p>
                </div>

                <div class="header-btns">
                    <button class="btn-discard">Discard Changes</button>
                    <button class="btn-save-config">Save Configuration</button>
                </div>
            </div>

            <!-- 3 Column Layout -->
            <div class="grid-3col">
                <!-- Column 1: Active Triggers -->
                <div>
                    <div class="triggers-header">
                        <div class="triggers-title">Active Triggers</div>
                        <span class="enabled-badge">5 ENABLED</span>
                    </div>

                    <!-- Trigger 1 (Selected) -->
                    <div class="trigger-card selected">
                        <div class="trigger-card-top">
                            <div class="trigger-name">24h Before Fitting</div>
                            <div class="toggle-switch on"><div class="toggle-knob"></div></div>
                        </div>
                        <div class="trigger-desc">Reminder sent exactly one day before the scheduled trial appointment.</div>
                        <div class="trigger-tags">
                            <span class="trig-tag">💬 SMS</span>
                            <span class="trig-tag">💬 WhatsApp</span>
                        </div>
                    </div>

                    <!-- Trigger 2 -->
                    <div class="trigger-card">
                        <div class="trigger-card-top">
                            <div class="trigger-name">Order Ready for Trial</div>
                            <div class="toggle-switch on"><div class="toggle-knob"></div></div>
                        </div>
                        <div class="trigger-desc">Triggered when production status changes to 'Ready for Fitting'.</div>
                        <div class="trigger-tags">
                            <span class="trig-tag">✉️ Email</span>
                        </div>
                    </div>

                    <!-- Trigger 3 -->
                    <div class="trigger-card">
                        <div class="trigger-card-top">
                            <div class="trigger-name">Measurement Update</div>
                            <div class="toggle-switch"><div class="toggle-knob"></div></div>
                        </div>
                        <div class="trigger-desc">Confirmation of updated body measurements in ledger.</div>
                        <div style="font-size:10px; color:var(--text-muted);">No channels active</div>
                    </div>

                    <!-- Trigger 4 -->
                    <div class="trigger-card">
                        <div class="trigger-card-top">
                            <div class="trigger-name">Fitting Completion</div>
                            <div class="toggle-switch on"><div class="toggle-knob"></div></div>
                        </div>
                        <div class="trigger-desc">Thank you note after a successful trial session.</div>
                        <div class="trigger-tags">
                            <span class="trig-tag">💬 SMS</span>
                        </div>
                    </div>

                    <button class="btn-create-custom-trig">
                        <span class="material-symbols-outlined" style="font-size:16px;">add</span>
                        Create Custom Trigger
                    </button>
                </div>

                <!-- Column 2: Template Editor -->
                <div>
                    <div class="editor-card">
                        <div class="editor-title">
                            <span class="material-symbols-outlined" style="color:var(--primary-teal);">edit_note</span>
                            Template Editor
                        </div>

                        <div class="section-sublabel">SELECT CHANNEL</div>
                        <div class="channels-select-grid">
                            <div class="channel-card selected">💬 WhatsApp</div>
                            <div class="channel-card">💬 SMS</div>
                            <div class="channel-card">✉️ Email</div>
                        </div>

                        <div class="section-sublabel">DYNAMIC PLACEHOLDERS</div>
                        <div class="placeholders-row">
                            <span class="ph-pill">[Customer Name]</span>
                            <span class="ph-pill">[Trial Date]</span>
                            <span class="ph-pill">[Order ID]</span>
                            <span class="ph-pill">[Shop Name]</span>
                        </div>

                        <div class="section-sublabel">MESSAGE BODY</div>
                        <div class="message-textarea-box">
                            <textarea>Dear [Customer Name], this is a friendly reminder of your bespoke fitting scheduled for [Trial Date] at [Shop Name]. We look forward to seeing you. Please bring your preferred footwear for the best results.</textarea>
                            <div class="char-count">142 / 160 characters</div>
                        </div>

                        <div class="editor-bottom-row">
                            <div style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:700;">
                                🕒 Sending Time:
                                <select style="border:1px solid var(--card-border); border-radius:6px; padding:4px 8px; font-family:var(--font-main); font-size:12px;"><option>09:00 AM</option><option>10:00 AM</option></select>
                            </div>

                            <div style="display:flex; align-items:center; gap:8px; font-size:12px; font-weight:700;">
                                🌐 Auto-Translate
                                <div class="toggle-switch"><div class="toggle-knob"></div></div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Column 3: Live Channel Preview -->
                <div class="preview-column">
                    <div class="preview-header">LIVE CHANNEL PREVIEW</div>

                    <div class="phone-mockup">
                        <div class="phone-screen">
                            <div class="phone-chat-header">
                                <span class="material-symbols-outlined">arrow_back</span>
                                <div>
                                    <div>Bespoke Pro</div>
                                    <div style="font-size:9px; font-weight:400; opacity:0.8;">online</div>
                                </div>
                            </div>

                            <div class="phone-chat-body">
                                <div style="text-align:center; font-size:9px; font-weight:800; color:var(--text-muted); margin-bottom:12px;">TODAY</div>
                                <div class="chat-bubble-received">
                                    Dear <strong>Alex Thompson</strong>, this is a friendly reminder of your bespoke fitting scheduled for <strong>Tomorrow at 2:00 PM</strong> at <strong>Savile Row Branch</strong>. We look forward to seeing you. Please bring your preferred footwear for the best results.
                                    <div style="font-size:8px; color:var(--text-muted); text-align:right; margin-top:4px;">09:41 AM ✓✓</div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div>
                        <span class="draft-notice-pill">✓ All changes are drafted.</span>
                    </div>

                    <form action="{{ route('communication.sendAlert') }}" method="POST" style="margin-top:10px;">
                        @csrf
                        <input type="hidden" name="order_id" value="88294">
                        <input type="hidden" name="channel" value="whatsapp">
                        <input type="hidden" name="message" value="Fitting appointment reminder for Alex Thompson tomorrow at 2:00 PM">

                        <button type="submit" class="test-msg-link" style="border:none; cursor:pointer; background:none; text-decoration:underline;">▷ Send Test Message</button>
                    </form>
                    <div style="font-size:11px; color:var(--text-muted); margin-top:4px;">Send a live test to your registered mobile number.</div>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
