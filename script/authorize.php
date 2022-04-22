<?php


// 检查 $_GET中是否https://domain.com/authorize.php?code=微信给的授权码&state=STATE


// 检测用户是否登录
// 如果未登录，就显示授权登录的按钮

?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>用户授权测试Demo</title>
</head>
<body>

<div style="text-align: center">
    <input type="button" value="授权登录" onclick="login()">
</div>

<script>
    function login() {
        // window.location = window.location.origin + '/authorize.php?' + 'action=login'

        // 跳转授权
        window.location = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=我们appid&redirect_uri=跳转回来的链接&response_type=code&scope=snsapi_userinfo&state=STATE#wechat_redirect"
    }
</script>
</body>
</html>
