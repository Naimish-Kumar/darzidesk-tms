<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Reset Your DarziDesk Password</title>
    <style>
        body { font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f4f7f6; color: #333; margin: 0; padding: 40px 0; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header { background: #006A67; color: #ffffff; padding: 30px; text-align: center; }
        .header h1 { margin: 0; font-size: 24px; font-weight: 700; letter-spacing: 1px; }
        .content { padding: 35px 30px; text-align: center; }
        .otp-box { display: inline-block; background: #E6F4F1; border: 2px dashed #006A67; color: #006A67; font-size: 32px; font-weight: 800; letter-spacing: 6px; padding: 14px 28px; margin: 25px 0; border-radius: 8px; }
        .btn { display: inline-block; background: #006A67; color: #ffffff !important; text-decoration: none; padding: 14px 28px; border-radius: 6px; font-weight: 600; margin-top: 15px; }
        .footer { background: #fafafa; padding: 20px; text-align: center; font-size: 12px; color: #888888; border-top: 1px solid #eeeeee; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>DarziDesk</h1>
            <p style="margin: 5px 0 0 0; font-size: 14px; opacity: 0.9;">Tailoring Management System</p>
        </div>
        <div class="content">
            <h2>Password Reset Request</h2>
            <p>Hello {{ $user->name }},</p>
            <p>We received a request to reset your password. Use the secure reset code below to authorize your password change:</p>

            <div class="otp-box">{{ $token }}</div>

            <p style="font-size: 13px; color: #666;">This code is valid for 15 minutes. If you did not request a password reset, please ignore this email.</p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} DarziDesk TMS. All rights reserved.
        </div>
    </div>
</body>
</html>
