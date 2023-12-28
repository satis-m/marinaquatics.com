<!DOCTYPE html>
<html>
<head>
    <title>OTP Code</title>
    <link rel="stylesheet" href="{{ asset('/web-site/assets/css/mail.css')}}">
</head>
<body>
<header class="flex">
    <img width="150px"  src="{{getAppInfo('favIconDark')}}" alt="logo of man"/>
</header>
<hr>
<p class="space-bottom">Dear Admin,</p>
<p class="space-bottom">Customer has cancelled Order no: <b>{{$orderInfo->orderNo}}</b>.</p>
<hr>
<footer class="text-sm color-gray"> If you have any questions or concerns, please do not hesitate to contact us at {{getAppInfo('contact')}}.</footer>
</body>
</html>
