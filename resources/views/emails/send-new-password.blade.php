<!DOCTYPE html>
<html>
<head>
    <title>OTP Code</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, sans-serif;">
<header style="display: flex; justify-content: center; background: #0a0a0a; padding: 10px 0; ">
    <a href="{{url('/')}}" style="margin: 0 auto;"><img width="150px"  src="{{getAppInfo('favIconDark')}}" alt="logo of man"/></a>
</header>
<hr>
<p style="padding-bottom: .36em;">Dear Customer,</p>
<p style="padding-bottom: .36em;">You recently requested to reset the password for your account. We're pleased to inform you that your password has been successfully reset</p>
<p><b>Your New Password</b>: {{ $newPassword }}</p>
<p>For security reasons, we recommend changing your password after logging in.</p>
<p>
If you did not initiate this password reset request, please contact our support team immediately.
</p>
<p>
Thank you for choosing our service.
</p>
<hr>
<footer style="font-size: 14px; color: #565656;"> If you have any questions or concerns, please do not hesitate to contact us at {{getAppInfo('contact')}}.</footer>
</body>
</html>
