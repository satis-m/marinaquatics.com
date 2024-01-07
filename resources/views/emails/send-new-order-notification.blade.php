<!DOCTYPE html>
<html>
<head>
    <title>New Order Notification</title>
</head>
<body style="font-family: -apple-system, BlinkMacSystemFont, sans-serif;">
<header style="display: flex; justify-content: center; background: #0a0a0a; padding: 10px 0; ">
    <a href="{{url('/')}}" style="margin: 0 auto;"><img width="150px"  src="{{getAppInfo('favIconDark')}}" alt="logo of man"/></a>
</header>
<hr>
<p style="padding-bottom: .36em;">Dear Admin,</p>
<p style="padding-bottom: .36em;">You have received a new Purchase Order:</p>
<ul>
    <li><b>Order No:</b> {{$orderInfo->orderNo}}</li>
    <li><b>Order Amount:</b> {{$orderInfo->orderAmount}}</li>
    <li><b>Payment Method:</b> {{$orderInfo->paymentMethod}}</li>
    <li><b>Delivery Type:</b> {{$orderInfo->deliveryType}}</li>
</ul>
<hr>
<footer style="font-size: 14px; color: #565656;"> If you have any questions or concerns, please do not hesitate to contact us at {{getAppInfo('contact')}}.</footer>
</body>
</html>
