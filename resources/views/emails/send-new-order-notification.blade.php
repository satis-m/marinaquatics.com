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
<p class="space-bottom">You have received a new Purchase Order:</p>
<ul>
    <li><b>Order No:</b> {{$orderInfo->orderNo}}</li>
    <li><b>Order Amount:</b> {{$orderInfo->orderAmount}}</li>
    <li><b>Payment Method:</b> {{$orderInfo->paymentMethod}}</li>
    <li><b>Delivery Type:</b> {{$orderInfo->deliveryType}}</li>
</ul>
<hr>
<footer class="text-sm color-gray"> If you have any questions or concerns, please do not hesitate to contact us at {{getAppInfo('contact')}}.</footer>
</body>
</html>
