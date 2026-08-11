<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Complete Business Profile - {{ env('APP_NAME', 'DarziDesk') }}</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@400;500;600;700;800&family=JetBrains+Mono:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="{{ asset('assets/fonts/tabler-icons.min.css') }}" />

    <style>
        :root {
            --primary-teal: #006A67;
            --primary-dark: #004D4B;
            --primary-light: #E6F4F3;
            --brand-navy: #0B1C30;
            --text-dark: #0B1C30;
            --text-muted: #6D7978;
            --bg-canvas: #F8FAFC;
            --card-border: #E2E8F0;
            --font-main: 'Hanken Grotesk', -apple-system, sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: var(--font-main);
            background-color: var(--bg-canvas);
            color: var(--text-dark);
            min-height: 100vh;
            display: flex;
        }

        .auth-wrapper {
            display: flex;
            width: 100vw;
            min-height: 100vh;
        }

        .visual-side {
            flex: 1;
            background: linear-gradient(180deg, rgba(11, 28, 48, 0.85) 0%, rgba(0, 106, 103, 0.92) 100%), 
                        url('{{ asset("assets/images/bespoke_tailor_atelier_hero.jpg") }}') center/cover no-repeat;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #FFFFFF;
        }

        .brand-logo-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            padding: 8px 18px;
            border-radius: 50px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            text-decoration: none;
            color: #FFFFFF;
            font-weight: 700;
            font-size: 16px;
            width: fit-content;
        }

        .visual-content h1 {
            font-size: 38px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 16px;
            letter-spacing: -0.02em;
        }

        .visual-content p {
            font-size: 15.5px;
            color: rgba(255, 255, 255, 0.85);
            max-width: 480px;
            line-height: 1.6;
        }

        .form-side {
            flex: 1.1;
            background: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 50px 40px;
            overflow-y: auto;
        }

        .form-container {
            width: 100%;
            max-width: 520px;
        }

        .step-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: var(--primary-light);
            color: var(--primary-teal);
            padding: 6px 16px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            margin-bottom: 14px;
        }

        .form-header h2 {
            font-size: 28px;
            font-weight: 800;
            color: var(--brand-navy);
            margin-bottom: 8px;
        }

        .form-header p {
            font-size: 14px;
            color: var(--text-muted);
            line-height: 1.5;
            margin-bottom: 24px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 16px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group.full-width {
            grid-column: span 2;
        }

        .form-group label {
            display: block;
            font-size: 11.5px;
            font-weight: 800;
            letter-spacing: 0.6px;
            margin-bottom: 6px;
            color: var(--text-dark);
            text-transform: uppercase;
        }

        .form-group label span {
            color: #ef4444;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group .material-symbols-outlined,
        .input-group .ti {
            position: absolute;
            left: 14px;
            color: var(--text-muted);
            font-size: 20px;
        }

        .input-group input,
        .input-group select {
            width: 100%;
            padding: 13px 14px 13px 44px;
            border: 1.5px solid var(--card-border);
            border-radius: 12px;
            font-family: var(--font-main);
            font-size: 14px;
            outline: none;
            transition: all 0.2s ease;
            background: #F8FAFC;
            color: var(--brand-navy);
        }

        .input-group input:focus,
        .input-group select:focus {
            background: #FFFFFF;
            border-color: var(--primary-teal);
            box-shadow: 0 0 0 3.5px rgba(0, 106, 103, 0.12);
        }

        .btn-submit {
            width: 100%;
            padding: 16px;
            background: var(--primary-teal);
            color: #FFFFFF;
            border: none;
            border-radius: 12px;
            font-family: var(--font-main);
            font-size: 15.5px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 15px rgba(0, 106, 103, 0.25);
            margin-top: 10px;
        }

        .btn-submit:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .alert-box {
            padding: 14px 18px;
            border-radius: 12px;
            font-size: 13.5px;
            margin-bottom: 20px;
            font-weight: 600;
        }
        .alert-danger {
            background: #fef2f2;
            border: 1px solid #fecaca;
            color: #991b1b;
        }
        .alert-success {
            background: #ecfdf5;
            border: 1px solid #a7f3d0;
            color: #065f46;
        }

        @media (max-width: 900px) {
            .visual-side { display: none; }
            .form-side { flex: 1; }
            .form-grid { grid-template-columns: 1fr; }
            .form-group.full-width { grid-column: span 1; }
        }
    </style>
</head>
<body>
    <div class="auth-wrapper">
        <!-- Left Side Visual -->
        <div class="visual-side">
            <a href="/" class="brand-logo-badge">
                <i class="ti ti-scissors" style="font-size: 22px;"></i>
                <span>{{ env('APP_NAME', 'DarziDesk') }}</span>
            </a>
            <div class="visual-content">
                <h1>Setup Your Business Profile</h1>
                <p>Welcome! Email verified successfully. Please enter your studio & workshop details to complete setting up your atelier account.</p>
            </div>
            <div style="font-size: 12px; color: rgba(255,255,255,0.6);">
                © {{ date('Y') }} {{ env('APP_NAME', 'DarziDesk') }} Bespoke Technologies.
            </div>
        </div>

        <!-- Right Side Form -->
        <div class="form-side">
            <div class="form-container">
                <div class="step-pill">
                    <i class="ti ti-circle-check-filled"></i> Step 2 of 2: Atelier Profile
                </div>
                <div class="form-header">
                    <h2>Complete Shop Details</h2>
                    <p>Enter your boutique or workshop information to activate your dashboard.</p>
                </div>

                @if (session('success'))
                    <div class="alert-box alert-success">
                        <i class="ti ti-circle-check me-1"></i> {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="alert-box alert-danger">
                        <i class="ti ti-alert-circle me-1"></i> {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert-box alert-danger">
                        <ul style="margin: 0; padding-left: 18px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('onboarding.business.details.submit') }}">
                    @csrf
                    <div class="form-grid">
                        <div class="form-group full-width">
                            <label>SHOP / BOUTIQUE NAME <span>*</span></label>
                            <div class="input-group">
                                <span class="material-symbols-outlined">storefront</span>
                                <input type="text" name="shop_name" value="{{ old('shop_name', $user->shop_name ?? '') }}" placeholder="E.g. Savile Row Atelier & Co." required>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label>PRIMARY SPECIALIZATION / CATEGORY <span>*</span></label>
                            <div class="input-group">
                                <span class="material-symbols-outlined">style</span>
                                <select name="specialty" required>
                                    <option value="Bespoke Suits & Tuxedos">Bespoke Suits & Tuxedos</option>
                                    <option value="Traditional & Heritage Wear">Traditional & Heritage Wear (Sherwani / Kurtas)</option>
                                    <option value="Boutique & Ladies Wear">Boutique & Ladies Wear</option>
                                    <option value="Alterations & Restyling Studio">Alterations & Restyling Studio</option>
                                    <option value="Custom Shirts & Trousers">Custom Shirts & Trousers</option>
                                </select>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label>STUDIO / WORKSHOP ADDRESS <span>*</span></label>
                            <div class="input-group">
                                <span class="material-symbols-outlined">home_pin</span>
                                <input type="text" name="address" value="{{ old('address', $user->address ?? '') }}" placeholder="E.g. 24 Savile Row, Mayfair" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>CITY / LOCATION <span>*</span></label>
                            <div class="input-group">
                                <span class="material-symbols-outlined">location_city</span>
                                <input type="text" name="city" value="{{ old('city', $user->city ?? '') }}" placeholder="E.g. London / New Delhi" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label>WHATSAPP / BUSINESS PHONE <span>*</span></label>
                            <div class="input-group">
                                <span class="material-symbols-outlined">phone</span>
                                <input type="tel" name="whatsapp_number" value="{{ old('whatsapp_number', $user->phone_number ?? '') }}" placeholder="+1 (555) 000-0000" required>
                            </div>
                        </div>

                        <div class="form-group full-width">
                            <label>STUDIO OPERATING HOURS</label>
                            <div class="input-group">
                                <span class="material-symbols-outlined">schedule</span>
                                <input type="text" name="business_hours" value="{{ old('business_hours', 'Mon - Sat: 10:00 AM - 8:00 PM') }}" placeholder="Mon - Sat: 10:00 AM - 8:00 PM">
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        Complete Setup & Launch Dashboard
                        <span class="material-symbols-outlined" style="font-size: 20px;">rocket_launch</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
