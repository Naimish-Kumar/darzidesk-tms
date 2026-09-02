<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Your Account - {{ env('APP_NAME', 'DarziDesk') }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    <style>
        :root {
            --primary-teal: #D9A441;
            --primary-dark: #F4C861;
            --primary-light: rgba(217, 164, 65, 0.15);
            --dark-navy: #03111F;
            --text-dark: #FFFFFF;
            --text-muted: #D8E0E8;
            --card-border: #29435D;
            --font-main: 'Hanken Grotesk', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-main);
            color: #FFFFFF;
            background: #03111F;
            min-height: 100vh;
            display: flex;
        }

        .register-wrapper {
            display: flex;
            width: 100vw;
            min-height: 100vh;
        }

        /* Left Side Atelier Image Banner */
        .left-banner {
            flex: 1;
            background: #03111F;
            color: #FFFFFF;
            padding: 48px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }

        .bg-img-grid {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.85;
            filter: brightness(0.9);
        }

        .visual-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(3,17,31,0.4) 0%, rgba(3,17,31,0.9) 100%);
        }

        .logo-box {
            position: relative;
            z-index: 10;
            display: inline-flex;
            align-items: center;
            background: rgba(11, 34, 57, 0.65);
            backdrop-filter: blur(12px);
            padding: 8px 16px;
            border-radius: 12px;
            border: 1px solid rgba(41, 67, 93, 0.6);
            width: fit-content;
        }

        .banner-content {
            position: relative;
            z-index: 10;
            max-width: 540px;
        }

        .banner-content h1 {
            font-size: 38px;
            font-weight: 800;
            line-height: 1.15;
            margin-bottom: 14px;
            letter-spacing: -0.5px;
            text-shadow: 0 2px 10px rgba(0,0,0,0.3);
            color: #FFFFFF;
        }

        .banner-content p {
            font-size: 15px;
            color: #D8E0E8;
            line-height: 1.55;
            margin-bottom: 28px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
        }

        .feature-card {
            background: rgba(11, 34, 57, 0.75);
            backdrop-filter: blur(16px);
            border: 1px solid #29435D;
            border-radius: 16px;
            padding: 20px;
            transition: all 0.2s ease;
        }

        .feature-card:hover {
            transform: translateY(-2px);
            background: rgba(11, 34, 57, 0.9);
            border-color: #D9A441;
        }

        .feature-card .material-symbols-outlined {
            color: #D9A441;
            font-size: 26px;
            margin-bottom: 10px;
        }

        .feature-card h4 {
            font-size: 15px;
            font-weight: 700;
            margin-bottom: 6px;
            color: #FFFFFF;
        }

        .feature-card p {
            font-size: 12.5px;
            color: #D8E0E8;
            line-height: 1.45;
            margin: 0;
        }

        .social-proof {
            position: relative;
            z-index: 10;
            display: flex;
            align-items: center;
            gap: 14px;
            font-size: 11px;
            font-weight: 800;
            letter-spacing: 1px;
            color: #FFFFFF;
            background: rgba(11, 34, 57, 0.65);
            backdrop-filter: blur(12px);
            padding: 10px 20px;
            border-radius: 30px;
            width: fit-content;
            border: 1px solid rgba(41, 67, 93, 0.6);
        }

        .avatar-group {
            display: flex;
        }

        .avatar-group img {
            width: 30px;
            height: 30px;
            border-radius: 50%;
            border: 2px solid #03111F;
            margin-left: -10px;
            object-fit: cover;
        }

        .avatar-group img:first-child { margin-left: 0; }

        /* Right Form Side - Extra Wide */
        .form-side {
            width: 700px;
            padding: 48px 72px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #07192A;
            border-left: 1px solid #29435D;
            color: #FFFFFF;
            overflow-y: auto;
        }

        .form-container {
            max-width: 480px;
            width: 100%;
            margin: 0 auto;
        }

        .form-header h2 {
            font-size: 34px;
            font-weight: 800;
            color: #F4C861;
            margin-bottom: 6px;
            letter-spacing: -0.5px;
        }

        .form-header p {
            font-size: 15px;
            color: #D8E0E8;
            margin-bottom: 24px;
        }

        /* Google Sign Up Button */
        .btn-social-google {
            width: 100%;
            padding: 13.5px 20px;
            border: 1.5px solid #29435D;
            border-radius: 9999px;
            background: #0B2239;
            font-family: var(--font-main);
            font-size: 14.5px;
            font-weight: 700;
            color: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);
            margin-bottom: 24px;
            text-decoration: none;
        }

        .btn-social-google:hover {
            background: #102B45;
            border-color: #D9A441;
            color: #F4C861;
            transform: translateY(-1px);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin-bottom: 24px;
            color: #D8E0E8;
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: 1.2px;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid #29435D;
        }

        .divider::before { margin-right: 14px; }
        .divider::after { margin-left: 14px; }

        .form-group {
            margin-bottom: 16px;
        }

        .form-group label {
            display: block;
            font-size: 11.5px;
            font-weight: 800;
            letter-spacing: 0.6px;
            margin-bottom: 6px;
            color: #FFFFFF;
            text-transform: uppercase;
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group .material-symbols-outlined {
            position: absolute;
            left: 14px;
            color: #D8E0E8;
            font-size: 20px;
        }

        .input-group .password-toggle {
            left: auto;
            right: 14px;
            cursor: pointer;
            user-select: none;
            transition: color 0.2s;
        }

        .input-group .password-toggle:hover {
            color: #D9A441;
        }

        .input-group input {
            width: 100%;
            padding: 13px 42px;
            border: 1.5px solid #29435D;
            border-radius: 12px;
            font-family: var(--font-main);
            font-size: 14px;
            outline: none;
            transition: all 0.2s ease;
            background: #0B2239;
            color: #FFFFFF;
        }

        .input-group input:focus {
            background: #03111F;
            border-color: #D9A441;
            box-shadow: 0 0 0 3.5px rgba(217, 164, 65, 0.2);
        }

        .field-subtext {
            font-size: 11px;
            color: #D8E0E8;
            margin-top: 4px;
        }

        .checkbox-row {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-bottom: 20px;
            font-size: 13px;
            color: #D8E0E8;
            cursor: pointer;
        }

        .checkbox-row input {
            width: 18px;
            height: 18px;
            margin-top: 1px;
            accent-color: #D9A441;
            cursor: pointer;
        }

        .checkbox-row a {
            color: #F4C861;
            font-weight: 700;
            text-decoration: none;
        }

        .checkbox-row a:hover {
            color: #D9A441;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background: linear-gradient(135deg, #D9A441 0%, #F4C861 100%);
            color: #03111F;
            border: none;
            border-radius: 9999px;
            font-family: var(--font-main);
            font-size: 15px;
            font-weight: 800;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 6px 20px rgba(217, 164, 65, 0.3);
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #F4C861 0%, #FFE596 100%);
            box-shadow: 0 10px 28px rgba(217, 164, 65, 0.45);
            transform: translateY(-1px);
        }

        .shop-owner-card {
            background: #0B2239;
            border: 1px solid #29435D;
            border-radius: 16px;
            padding: 14px 18px;
            display: flex;
            align-items: center;
            gap: 14px;
            cursor: pointer;
            margin-top: 18px;
            transition: all 0.2s ease;
            width: 100%;
            text-align: left;
            font-family: inherit;
            box-sizing: border-box;
            color: #FFFFFF;
        }

        .shop-owner-card:hover {
            background: #102B45;
            border-color: #D9A441;
            transform: translateY(-1px);
        }

        .shop-owner-icon {
            width: 40px;
            height: 40px;
            background: rgba(217, 164, 65, 0.2);
            color: #D9A441;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .shop-owner-text h5 {
            font-size: 14px;
            font-weight: 700;
            color: #FFFFFF;
        }

        .shop-owner-text p {
            font-size: 12px;
            color: var(--text-muted);
        }

        .already-account {
            text-align: center;
            font-size: 13.5px;
            color: var(--text-muted);
            margin-top: 18px;
        }

        .already-account a {
            color: var(--primary-teal);
            font-weight: 800;
            text-decoration: none;
        }

        .copyright-text {
            text-align: center;
            font-size: 11px;
            color: var(--text-muted);
            margin-top: 24px;
        }

        @media (max-width: 900px) {
            .left-banner { display: none; }
            .form-side { width: 100%; padding: 40px 24px; }
        }
    </style>
</head>
<body>

    <div class="register-wrapper">
        <!-- Left Side Atelier Image Banner -->
        <div class="left-banner">
            <img src="{{ asset('assets/images/bespoke_tailor_atelier_hero.jpg') }}" class="bg-img-grid" alt="Master Tailor Atelier">
            <div class="visual-overlay"></div>

            <div class="logo-box">
                <img src="{{ asset('assets/images/logo_wide.png') }}" alt="DarziDesk" style="height: 34px;">
            </div>

            <div class="banner-content">
                <h1>The Artisan's Digital Atelier.</h1>
                <p>Bridge the gap between heritage craftsmanship and modern efficiency. Join a network of elite bespoke tailors and scale your workshop with precision measurement tracking, inventory management, and seamless client interactions.</p>

                <div class="features-grid">
                    <div class="feature-card">
                        <span class="material-symbols-outlined">straighten</span>
                        <h4>Precise Measurement</h4>
                        <p>Capture 40+ points of contact with delta tracking for every client fitting.</p>
                    </div>

                    <div class="feature-card">
                        <span class="material-symbols-outlined">inventory_2</span>
                        <h4>Fabric Ledger</h4>
                        <p>Automated inventory alerts for premium wools, silks, and seasonal linens.</p>
                    </div>
                </div>
            </div>

            <div class="social-proof">
                <div class="avatar-group">
                    <img src="{{ asset('assets/images/hero_tailor_atelier.jpg') }}" alt="Tailor">
                    <img src="{{ asset('assets/images/onboarding_tailor.jpg') }}" alt="Tailor">
                    <img src="{{ asset('assets/images/onboarding_tailor_light.jpg') }}" alt="Tailor">
                </div>
                TRUSTED BY 1,200+ MASTER ARTISANS
            </div>
        </div>

        <!-- Right Side Registration Form - Extra Wide -->
        <div class="form-side">
            <div class="form-container">
                <div class="form-header">
                    <h2>Create your account</h2>
                    <p>Experience the future of bespoke management.</p>
                </div>

                <!-- Single Continue with Google Button -->
                <a href="{{ route('auth.google') }}" class="btn-social-google" id="btn-google-register">
                    <svg width="20" height="20" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                    </svg>
                    <span>Continue with Google</span>
                </a>

                <div class="divider">OR REGISTER WITH EMAIL</div>

                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    @if (session('error'))
                        <div style="background: rgba(239, 68, 68, 0.18); color: #F87171; padding: 12px 16px; border-radius: 12px; font-size: 13px; font-weight: 600; margin-bottom: 20px; border: 1px solid rgba(239, 68, 68, 0.4);">
                            {{ session('error') }}
                        </div>
                    @endif

                    @if ($errors->any())
                        <div style="background: rgba(239, 68, 68, 0.18); color: #F87171; padding: 12px 16px; border-radius: 12px; font-size: 13px; font-weight: 600; margin-bottom: 20px; border: 1px solid rgba(239, 68, 68, 0.4);">
                            <ul style="margin: 0; padding-left: 18px; font-weight: 600;">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="form-group">
                        <label>FULL NAME</label>
                        <div class="input-group">
                            <span class="material-symbols-outlined">person</span>
                            <input type="text" name="name" value="{{ old('name') }}" placeholder="E.g. Julian Savile" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>WORK EMAIL ADDRESS</label>
                        <div class="input-group">
                            <span class="material-symbols-outlined">mail</span>
                            <input type="email" name="email" value="{{ old('email') }}" placeholder="name@atelier.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>PHONE NUMBER</label>
                        <div class="input-group">
                            <span class="material-symbols-outlined">call</span>
                            <input type="tel" name="phone" value="{{ old('phone') }}" placeholder="+1 (555) 000-0000" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>PASSWORD</label>
                        <div class="input-group">
                            <span class="material-symbols-outlined">lock</span>
                            <input type="password" id="registerPasswordInput" name="password" placeholder="••••••••" required>
                            <span class="material-symbols-outlined password-toggle" onclick="toggleRegisterPassword()">visibility</span>
                        </div>
                        <div class="field-subtext">Must be at least 8 characters long.</div>
                    </div>

                    <div class="checkbox-row">
                        <input type="checkbox" id="terms" required checked>
                        <label for="terms">I agree to the <a href="{{ route('terms.conditions') }}" target="_blank">Terms & Conditions</a> and <a href="{{ route('privacy.policy') }}" target="_blank">Privacy Policy</a>.</label>
                    </div>

                    <button type="submit" class="btn-submit">
                        Create Account
                        <span class="material-symbols-outlined" style="font-size: 18px;">arrow_forward</span>
                    </button>

                    <button type="submit" class="shop-owner-card">
                        <div class="shop-owner-icon">
                            <span class="material-symbols-outlined">storefront</span>
                        </div>
                        <div class="shop-owner-text" style="flex: 1;">
                            <h5>Register as a Shop Owner</h5>
                            <p>Manage orders, clients, and fabrics.</p>
                        </div>
                        <span class="material-symbols-outlined" style="color: var(--primary-teal); font-size: 20px;">arrow_forward</span>
                    </button>
                </form>

                <div class="already-account">
                    Already have an account? <a href="{{ route('login') }}">Sign In</a>
                </div>

                <div class="copyright-text">
                    © 2024 DarziDesk Bespoke Technologies. All rights reserved.
                </div>
            </div>
        </div>
    </div>

    <script>
        function toggleRegisterPassword() {
            const input = document.getElementById('registerPasswordInput');
            const toggle = document.querySelector('.password-toggle');
            if (input.type === 'password') {
                input.type = 'text';
                toggle.textContent = 'visibility_off';
            } else {
                input.type = 'password';
                toggle.textContent = 'visibility';
            }
        }
    </script>
</body>
</html>
