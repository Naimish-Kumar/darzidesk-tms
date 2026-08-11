<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Back - {{ env('APP_NAME', 'DarziDesk') }}</title>
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hanken+Grotesk:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0" rel="stylesheet">
    <style>
        :root {
            --primary-teal: #006A67;
            --primary-dark: #004D4B;
            --primary-light: #E6F4F3;
            --text-dark: #0B1C30;
            --text-muted: #6D7978;
            --card-border: #E2E8F0;
            --font-main: 'Hanken Grotesk', sans-serif;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: var(--font-main);
            color: var(--text-dark);
            background: #FFFFFF;
            min-height: 100vh;
            display: flex;
        }

        .login-wrapper {
            display: flex;
            width: 100vw;
            min-height: 100vh;
        }

        /* Left Side Visual Banner */
        .visual-side {
            flex: 1;
            position: relative;
            background: #0B1C30;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 48px;
            color: #FFFFFF;
        }

        .bg-img-grid {
            position: absolute;
            inset: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
            opacity: 0.88;
            filter: brightness(0.95);
        }

        .visual-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(11,28,48,0.3) 0%, rgba(11,28,48,0.85) 100%);
        }

        .logo-box {
            position: relative;
            z-index: 10;
            display: inline-flex;
            align-items: center;
            background: rgba(255, 255, 255, 0.15);
            backdrop-filter: blur(12px);
            padding: 8px 16px;
            border-radius: 12px;
            border: 1px solid rgba(255, 255, 255, 0.25);
            width: fit-content;
        }

        .quote-box {
            position: relative;
            z-index: 10;
            max-width: 540px;
            margin-bottom: 30px;
            background: rgba(11, 28, 48, 0.45);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 28px 32px;
            border-radius: 20px;
        }

        .quote-text {
            font-size: 24px;
            font-weight: 700;
            line-height: 1.35;
            margin-bottom: 16px;
            font-style: italic;
            letter-spacing: -0.3px;
        }

        .quote-author {
            font-size: 11px;
            letter-spacing: 1.5px;
            font-weight: 800;
            color: #26A69A;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .quote-author::before {
            content: '';
            width: 24px;
            height: 2px;
            background: #26A69A;
            border-radius: 2px;
        }

        .watermark-icon {
            position: absolute;
            bottom: 20px;
            right: 40px;
            font-size: 140px;
            opacity: 0.12;
            color: #FFFFFF;
            user-select: none;
        }

        /* Right Side Form Side */
        .form-side {
            width: 700px;
            padding: 48px 72px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            background: #FFFFFF;
        }

        .form-container {
            max-width: 480px;
            width: 100%;
            margin: 0 auto;
        }

        .form-header h2 {
            font-size: 32px;
            font-weight: 800;
            color: var(--text-dark);
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .form-header p {
            font-size: 14.5px;
            color: var(--text-muted);
            margin-bottom: 32px;
        }

        /* Full Width Google Button */
        .btn-social-google {
            width: 100%;
            padding: 13px 20px;
            border: 1.5px solid var(--card-border);
            border-radius: 12px;
            background: #FFFFFF;
            font-family: var(--font-main);
            font-size: 14.5px;
            font-weight: 700;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.03);
            margin-bottom: 28px;
            text-decoration: none;
        }

        .btn-social-google:hover {
            background: #F8FAFC;
            border-color: #CBD5E1;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            transform: translateY(-1px);
        }

        .btn-social-google:active {
            transform: translateY(0);
        }

        .divider {
            display: flex;
            align-items: center;
            text-align: center;
            margin-bottom: 28px;
            color: var(--text-muted);
            font-size: 10.5px;
            font-weight: 800;
            letter-spacing: 1.2px;
        }

        .divider::before, .divider::after {
            content: '';
            flex: 1;
            border-bottom: 1px solid var(--card-border);
        }

        .divider::before { margin-right: 14px; }
        .divider::after { margin-left: 14px; }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 8px;
            color: var(--text-dark);
        }

        .input-group {
            position: relative;
            display: flex;
            align-items: center;
        }

        .input-group .material-symbols-outlined {
            position: absolute;
            left: 14px;
            color: var(--text-muted);
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
            color: var(--primary-teal);
        }

        .input-group input {
            width: 100%;
            padding: 13px 42px;
            border: 1.5px solid var(--card-border);
            border-radius: 12px;
            font-family: var(--font-main);
            font-size: 14px;
            outline: none;
            transition: all 0.2s ease;
            background: #F8FAFC;
        }

        .input-group input:focus {
            background: #FFFFFF;
            border-color: var(--primary-teal);
            box-shadow: 0 0 0 3.5px rgba(0, 106, 103, 0.12);
        }

        .forgot-link {
            float: right;
            font-size: 12.5px;
            font-weight: 700;
            color: var(--primary-teal);
            text-decoration: none;
            transition: color 0.2s;
        }

        .forgot-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .checkbox-row {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 28px;
            font-size: 13.5px;
            color: var(--text-muted);
            cursor: pointer;
        }

        .checkbox-row input {
            width: 18px;
            height: 18px;
            accent-color: var(--primary-teal);
            cursor: pointer;
            border-radius: 4px;
        }

        .btn-submit {
            width: 100%;
            padding: 15px;
            background: var(--primary-teal);
            color: #FFFFFF;
            border: none;
            border-radius: 12px;
            font-family: var(--font-main);
            font-size: 15px;
            font-weight: 700;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 4px 12px rgba(0, 106, 103, 0.25);
        }

        .btn-submit:hover {
            background: var(--primary-dark);
            box-shadow: 0 6px 16px rgba(0, 106, 103, 0.35);
            transform: translateY(-1px);
        }

        .btn-submit:active {
            transform: translateY(0);
        }

        .register-text {
            text-align: center;
            font-size: 13.5px;
            color: var(--text-muted);
            margin-top: 28px;
        }

        .register-text a {
            color: var(--primary-teal);
            font-weight: 800;
            text-decoration: none;
        }

        .register-text a:hover {
            text-decoration: underline;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            font-size: 11px;
            font-weight: 800;
            color: var(--text-muted);
            letter-spacing: 0.8px;
            margin-top: 48px;
        }

        .footer-links a {
            color: inherit;
            text-decoration: none;
            transition: color 0.2s;
        }

        .footer-links a:hover {
            color: var(--primary-teal);
        }

        @media (max-width: 900px) {
            .visual-side { display: none; }
            .form-side { width: 100%; padding: 40px 24px; }
        }
    </style>
</head>
<body>

    <div class="login-wrapper">
        <!-- Left Side Visual Banner -->
        <div class="visual-side">
            <img src="{{ asset('assets/images/bespoke_tailor_atelier_hero.jpg') }}" class="bg-img-grid" alt="Master Tailor Handcrafting Suit">
            <div class="visual-overlay"></div>

            <div class="logo-box">
                <img src="{{ asset('assets/images/logo_wide.png') }}" alt="DarziDesk" style="height: 34px;">
            </div>

            <div class="quote-box">
                <div class="quote-text">"Precision is the soul of elegance. Every stitch tells a story of dedication."</div>
                <div class="quote-author">MASTER ARTISAN PAOLO RUSSO</div>
            </div>

            <span class="material-symbols-outlined watermark-icon">content_cut</span>
        </div>

        <!-- Right Side Form -->
        <div class="form-side">
            <div class="form-container">
                <div class="form-header">
                    <h2>Welcome Back</h2>
                    <p>Log in to manage your bespoke tailoring workspace.</p>
                </div>

                @if (session('error'))
                    <div style="background: #FEE2E2; color: #991B1B; padding: 12px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; margin-bottom: 20px; border: 1px solid #FCA5A5;">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('status'))
                    <div style="background: #D1FAE5; color: #065F46; padding: 12px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; margin-bottom: 20px; border: 1px solid #6EE7B7;">
                        {{ session('status') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div style="background: #FEE2E2; color: #991B1B; padding: 12px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; margin-bottom: 20px; border: 1px solid #FCA5A5;">
                        <ul style="margin: 0; padding-left: 18px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <!-- Single Continue with Google Button -->
                <a href="#" class="btn-social-google">
                    <svg width="20" height="20" viewBox="0 0 24 24">
                        <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                        <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                        <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.06H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.94l2.85-2.22.81-.63z"/>
                        <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.06l3.66 2.84c.87-2.6 3.3-4.52 6.16-4.52z"/>
                    </svg>
                    <span>Continue with Google</span>
                </a>

                <div class="divider">OR LOGIN WITH EMAIL</div>

                <form method="POST" action="{{ route('login') }}">
                    @csrf
                    <div class="form-group">
                        <label>Email Address</label>
                        <div class="input-group">
                            <span class="material-symbols-outlined">mail</span>
                            <input type="email" name="email" placeholder="name@atelier.com" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label>
                            Password
                            <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>
                        </label>
                        <div class="input-group">
                            <span class="material-symbols-outlined">lock</span>
                            <input type="password" id="passwordInput" name="password" placeholder="••••••••" required>
                            <span class="material-symbols-outlined password-toggle" onclick="togglePassword()">visibility</span>
                        </div>
                    </div>

                    <div class="checkbox-row">
                        <input type="checkbox" id="remember" name="remember" checked>
                        <label for="remember">Remember this device for 30 days</label>
                    </div>

                    <button type="submit" class="btn-submit">
                        Sign In to DarziDesk
                        <span class="material-symbols-outlined" style="font-size: 20px;">arrow_forward</span>
                    </button>
                </form>

                <div class="register-text">
                    Don't have an account? <a href="{{ route('register') }}">Register your workshop</a>
                </div>

                <div class="footer-links">
                    <a href="{{ route('privacy.policy') }}">PRIVACY POLICY</a>
                    <a href="{{ route('terms.conditions') }}">TERMS OF SERVICE</a>
                    <a href="{{ route('about.us') }}">ABOUT US</a>
                </div>

            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('passwordInput');
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
