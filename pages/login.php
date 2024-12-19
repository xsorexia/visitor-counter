<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/api/db.php';
session_start();
if (isset($_COOKIE['PHPSESSID'])) {
    $userInfo = getUserInfo($_COOKIE['PHPSESSID']);
} else {
    $userInfo = 0;
}
if ($userInfo != -1 and $userInfo != 0) {
    echo "<body><script>window.location.href='/pages/dashboard.php'</script></body>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | Counter</title>
    <link rel="stylesheet" href="/css/login.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="icon" href="/img/logo.png" type="image/x-icon">

</head>
<body>
    <script>
        sessionStorage.removeItem("xso-nav");
    </script>
    <script src="/js/visitor.js"></script>
    <form action="/api/tryLogin.php" method="POST">
        <div id="top-div">
            <img src="/img/logo.png" id="top-logo-img">
        </div>
        <div id="input-div">
            <input type="text" placeholder="Username" name="username" id="input-username">
            <input type="password" placeholder="Password" name="password" id="input-password">
        </div>
        <div id="button-div">
            <input type="submit" value="Sign in">
            <button type="button" id="register-button" onclick="window.location.href='/pages/register.php'">Create an account</button>
        </div>
    </form>
</body>
</html>