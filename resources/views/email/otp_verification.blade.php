<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>DarziDesk - Verification Code</title>
  <style>
    @import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap');
    
    body {
      margin: 0;
      padding: 0;
      width: 100% !important;
      background-color: #F8FAFC;
      font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
      -webkit-font-smoothing: antialiased;
      color: #1E293B;
    }

    table {
      border-spacing: 0;
      border-collapse: collapse;
    }

    td {
      padding: 0;
    }

    img {
      border: 0;
    }

    .wrapper {
      width: 100%;
      table-layout: fixed;
      background-color: #F8FAFC;
      padding: 40px 0;
    }

    .main-table {
      background-color: #FFFFFF;
      margin: 0 auto;
      width: 100%;
      max-width: 580px;
      border-radius: 20px;
      overflow: hidden;
      border: 1px solid #E2E8F0;
      box-shadow: 0 20px 40px -15px rgba(0, 121, 107, 0.08);
    }

    .header {
      background: linear-gradient(135deg, #004D40 0%, #00796B 100%);
      padding: 38px 30px;
      text-align: center;
    }

    .logo-img {
      max-height: 52px;
      width: auto;
      max-width: 220px;
      display: inline-block;
    }

    .brand-title {
      font-size: 26px;
      font-weight: 800;
      color: #FFFFFF;
      letter-spacing: 0.5px;
      margin: 0;
      text-decoration: none;
    }

    .brand-subtitle {
      font-size: 13px;
      color: rgba(255, 255, 255, 0.85);
      margin-top: 6px;
      font-weight: 500;
      letter-spacing: 1px;
      text-transform: uppercase;
    }

    .content-body {
      padding: 40px 36px;
    }

    .greeting {
      font-size: 20px;
      font-weight: 800;
      color: #0F172A;
      margin: 0 0 12px 0;
    }

    .description {
      font-size: 15px;
      line-height: 1.6;
      color: #475569;
      margin: 0 0 30px 0;
    }

    .otp-container {
      background-color: #F8FAFC;
      border: 1px solid #E2E8F0;
      border-radius: 16px;
      padding: 30px 20px;
      text-align: center;
      margin-bottom: 30px;
    }

    .otp-heading {
      font-size: 12px;
      font-weight: 800;
      text-transform: uppercase;
      letter-spacing: 1.5px;
      color: #00796B;
      margin-bottom: 16px;
    }

    .digit-row {
      display: inline-block;
      text-align: center;
      margin-bottom: 16px;
    }

    .digit-box {
      display: inline-block;
      width: 44px;
      height: 54px;
      line-height: 54px;
      background-color: #FFFFFF;
      border: 2px solid #00796B;
      border-radius: 10px;
      font-size: 26px;
      font-weight: 800;
      color: #0F172A;
      margin: 0 4px;
      box-shadow: 0 4px 10px rgba(0, 121, 107, 0.1);
      vertical-align: middle;
      text-align: center;
    }

    .expiry-badge {
      display: inline-block;
      padding: 6px 16px;
      background-color: #E0F2FE;
      color: #0369A1;
      font-size: 12px;
      font-weight: 700;
      border-radius: 20px;
    }

    .security-card {
      background-color: #FFFBEB;
      border: 1px solid #FDE68A;
      border-left: 4px solid #F59E0B;
      border-radius: 10px;
      padding: 16px 20px;
      margin-bottom: 28px;
    }

    .security-title {
      font-size: 13px;
      font-weight: 700;
      color: #92400E;
      margin-bottom: 4px;
    }

    .security-text {
      font-size: 13px;
      color: #B45309;
      line-height: 1.5;
      margin: 0;
    }

    .footer {
      background-color: #F1F5F9;
      padding: 28px 30px;
      text-align: center;
      font-size: 12.5px;
      color: #64748B;
      border-top: 1px solid #E2E8F0;
    }

    .footer a {
      color: #00796B;
      text-decoration: none;
      font-weight: 600;
    }
  </style>
</head>
<body>
  <div class="wrapper">
    <table class="main-table" align="center">
      <!-- Header -->
      <tr>
        <td class="header">
          <a href="https://darzidesk.shop" target="_blank" style="text-decoration: none;">
            <img src="https://darzidesk.shop/storage/upload/logo/light_logo.png" alt="DarziDesk Logo" class="logo-img" onerror="this.style.display='none'; document.getElementById('alt-logo').style.display='block';">
            <div id="alt-logo" class="brand-title" style="display: none;">✂️ DarziDesk</div>
          </a>
          <div class="brand-subtitle">Tailoring Management System</div>
        </td>
      </tr>

      <!-- Body Content -->
      <tr>
        <td class="content-body">
          <div class="greeting">Hello {{ $user_name ?? 'there' }}, 👋</div>
          <div class="description">
            We received a request to verify your account for <strong>{{ ($purpose ?? 'registration') == 'forgot_password' ? 'Password Reset' : 'DarziDesk Registration' }}</strong>. Please use the 6-digit verification code below to proceed:
          </div>

          <!-- OTP Card -->
          <div class="otp-container">
            <div class="otp-heading">Your Security Verification Code</div>
            
            <div class="digit-row">
              @php
                $digits = str_split((string)$otp_code);
              @endphp
              @foreach($digits as $digit)
                <span class="digit-box">{{ $digit }}</span>
              @endforeach
            </div>

            <div>
              <span class="expiry-badge">⏱️ Valid for 10 Minutes</span>
            </div>
          </div>

          <!-- Security Tip -->
          <div class="security-card">
            <div class="security-title">🛡️ Security Notice</div>
            <p class="security-text">
              Never share this code with anyone. DarziDesk support executives will never ask for your OTP. If you did not request this verification, you can safely ignore this email.
            </p>
          </div>

          <div class="description" style="margin-bottom: 0; font-size: 13.5px; color: #64748B;">
            Need help? Contact our support team at <a href="mailto:info@darzidesk.shop" style="color: #00796B; text-decoration: underline;">info@darzidesk.shop</a>.
          </div>
        </td>
      </tr>

      <!-- Footer -->
      <tr>
        <td class="footer">
          &copy; {{ date('Y') }} <strong>DarziDesk TMS</strong>. All rights reserved.<br>
          <span style="display: inline-block; margin-top: 6px;">Empowering Modern Boutiques & Atelier Craftsmanship</span>
        </td>
      </tr>
    </table>
  </div>
</body>
</html>
