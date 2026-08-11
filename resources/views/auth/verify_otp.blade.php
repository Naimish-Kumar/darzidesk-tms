<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Email OTP - {{ env('APP_NAME', 'DarziDesk') }}</title>

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
            flex: 1.1;
            background: linear-gradient(180deg, rgba(11, 28, 48, 0.82) 0%, rgba(0, 106, 103, 0.9) 100%), 
                        url('{{ asset("assets/images/hero_tailor_atelier.jpg") }}') center/cover no-repeat;
            padding: 60px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #FFFFFF;
            position: relative;
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
            font-size: 42px;
            font-weight: 800;
            line-height: 1.2;
            margin-bottom: 16px;
            letter-spacing: -0.02em;
        }

        .visual-content p {
            font-size: 16px;
            color: rgba(255, 255, 255, 0.85);
            max-width: 480px;
            line-height: 1.6;
        }

        .form-side {
            flex: 0.9;
            background: #FFFFFF;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 40px;
            position: relative;
        }

        .form-container {
            width: 100%;
            max-width: 440px;
        }

        .form-header {
            margin-bottom: 28px;
            text-align: left;
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
        }

        .otp-email-highlight {
            font-weight: 700;
            color: var(--primary-teal);
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-group label {
            display: block;
            font-size: 11.5px;
            font-weight: 800;
            letter-spacing: 0.6px;
            margin-bottom: 8px;
            color: var(--text-dark);
            text-transform: uppercase;
        }

        .otp-input-box {
            position: relative;
            display: flex;
            align-items: center;
        }

        .otp-input-box .material-symbols-outlined {
            position: absolute;
            left: 16px;
            color: var(--primary-teal);
            font-size: 24px;
        }

        .otp-input-box input {
            width: 100%;
            padding: 16px 16px 16px 52px;
            border: 2px solid var(--card-border);
            border-radius: 14px;
            font-family: var(--font-mono);
            font-size: 24px;
            font-weight: 800;
            letter-spacing: 8px;
            text-align: center;
            outline: none;
            transition: all 0.2s ease;
            background: #F8FAFC;
            color: var(--brand-navy);
        }

        .otp-input-box input:focus {
            background: #FFFFFF;
            border-color: var(--primary-teal);
            box-shadow: 0 0 0 4px rgba(0, 106, 103, 0.15);
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
        }

        .btn-submit:hover {
            background: var(--primary-dark);
            transform: translateY(-1px);
        }

        .resend-box {
            margin-top: 24px;
            text-align: center;
            font-size: 13.5px;
            color: var(--text-muted);
        }

        .resend-btn {
            background: none;
            border: none;
            color: var(--primary-teal);
            font-weight: 700;
            cursor: pointer;
            font-family: inherit;
            text-decoration: underline;
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
                <h1>Verify Your Atelier Account</h1>
                <p>Enter the 6-digit OTP verification code sent to your email to verify your shop owner account and access DarziDesk.</p>
            </div>
            <div style="font-size: 12px; color: rgba(255,255,255,0.6);">
                © {{ date('Y') }} {{ env('APP_NAME', 'DarziDesk') }} Bespoke Technologies.
            </div>
        </div>

        <!-- Right Side Form -->
        <div class="form-side">
            <div class="form-container">
                <div class="form-header">
                    <h2>Email OTP Verification</h2>
                    <p>Enter the 6-digit code sent to <span class="otp-email-highlight">{{ session('verify_email') ?? ($user->email ?? 'your registered email') }}</span></p>
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

                <form method="POST" action="{{ route('verify.otp.submit') }}">
                    @csrf
                    <div class="form-group">
                        <label>6-DIGIT OTP VERIFICATION CODE</label>
                        <div class="otp-input-box">
                            <span class="material-symbols-outlined">shield_lock</span>
                            <input type="text" name="otp" placeholder="123456" maxlength="6" pattern="[0-9]{6}" required autofocus autocomplete="one-time-code">
                        </div>
                    </div>

                    <button type="submit" class="btn-submit">
                        Verify OTP & Continue
                        <span class="material-symbols-outlined" style="font-size: 20px;">arrow_forward</span>
                    </button>
                </form>

                <div class="resend-box">
                    Didn't receive the OTP code? 
                    <form method="POST" action="{{ route('resend.otp') }}" style="display: inline;">
                        @csrf
                        <button type="submit" class="resend-btn">Resend OTP</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
