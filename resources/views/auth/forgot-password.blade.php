<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - {{ env('APP_NAME', 'DarziDesk') }}</title>
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

        .login-wrapper {
            display: flex;
            width: 100vw;
            min-height: 100vh;
        }

        /* Left Side Visual Banner */
        .visual-side {
            flex: 1;
            position: relative;
            background: #03111F;
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

        .quote-box {
            position: relative;
            z-index: 10;
            max-width: 540px;
            margin-bottom: 30px;
            background: rgba(11, 34, 57, 0.75);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(41, 67, 93, 0.8);
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
            color: #FFFFFF;
        }

        .quote-author {
            font-size: 11px;
            letter-spacing: 1.5px;
            font-weight: 800;
            color: #D9A441;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .quote-author::before {
            content: '';
            width: 24px;
            height: 2px;
            background: #D9A441;
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
            background: #07192A;
            border-left: 1px solid #29435D;
            color: #FFFFFF;
        }

        .form-container {
            max-width: 480px;
            width: 100%;
            margin: 0 auto;
        }

        .form-header h2 {
            font-size: 32px;
            font-weight: 800;
            color: #F4C861;
            margin-bottom: 8px;
            letter-spacing: -0.5px;
        }

        .form-header p {
            font-size: 14.5px;
            color: #D8E0E8;
            margin-bottom: 32px;
        }

        .form-group {
            margin-bottom: 24px;
        }

        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            margin-bottom: 8px;
            color: #FFFFFF;
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
            gap: 10px;
            cursor: pointer;
            transition: all 0.2s ease;
            box-shadow: 0 6px 20px rgba(217, 164, 65, 0.3);
        }

        .btn-submit:hover {
            background: linear-gradient(135deg, #F4C861 0%, #FFE596 100%);
            box-shadow: 0 10px 28px rgba(217, 164, 65, 0.45);
            transform: translateY(-1px);
        }

        .back-to-login {
            text-align: center;
            font-size: 13.5px;
            color: #D8E0E8;
            margin-top: 28px;
        }

        .back-to-login a {
            color: #F4C861;
            font-weight: 800;
            text-decoration: none;
        }

        .back-to-login a:hover {
            color: #D9A441;
            text-decoration: underline;
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
            <img src="{{ asset('assets/images/hero_tailor_atelier.jpg') }}" class="bg-img-grid" alt="Master Tailor Handcrafting Suit">
            <div class="visual-overlay"></div>

            <div class="logo-box">
                <a href="{{ route('home') }}">
                    <img src="{{ asset('assets/images/logo_wide.png') }}" alt="DarziDesk" style="height: 34px; object-fit: contain;">
                </a>
            </div>

            <div class="quote-box">
                <div class="quote-text">"Security & precision go hand in hand. Access your atelier workspace seamlessly."</div>
                <div class="quote-author">DARZI ACCOUNT PROTECTION</div>
            </div>

            <span class="material-symbols-outlined watermark-icon">lock_reset</span>
        </div>

        <!-- Right Side Form -->
        <div class="form-side">
            <div class="form-container">
                <div class="form-header">
                    <h2>Forgot Password?</h2>
                    <p>Enter your registered email address and we'll send you a link to reset your password.</p>
                </div>

                @if (session('error'))
                    <div style="background: rgba(239, 68, 68, 0.2); color: #F87171; padding: 12px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; margin-bottom: 20px; border: 1px solid rgba(239, 68, 68, 0.4);">
                        {{ session('error') }}
                    </div>
                @endif
                @if (session('success'))
                    <div style="background: rgba(16, 185, 129, 0.2); color: #34D399; padding: 12px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; margin-bottom: 20px; border: 1px solid rgba(16, 185, 129, 0.4);">
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('status'))
                    <div style="background: rgba(16, 185, 129, 0.2); color: #34D399; padding: 12px 16px; border-radius: 10px; font-size: 13px; font-weight: 600; margin-bottom: 20px; border: 1px solid rgba(16, 185, 129, 0.4);">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group">
                        <label>Email Address</label>
                        <div class="input-group">
                            <span class="material-symbols-outlined">mail</span>
                            <input type="email" name="email" placeholder="name@atelier.com" required autofocus>
                        </div>
                        @error('email')
                            <span style="color: #F87171; font-size: 12px; margin-top: 6px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <button type="submit" class="btn-submit">
                        Send Reset Link
                        <span class="material-symbols-outlined" style="font-size: 20px;">send</span>
                    </button>
                </form>

                <div class="back-to-login">
                    Remember your password? <a href="{{ route('login') }}">Back to Log In</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
