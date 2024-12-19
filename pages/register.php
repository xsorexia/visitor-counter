<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/api/db.php';
session_start();
if (isset($_COOKIE['PHPSESSID'])) {
    $userInfo = getUserInfo($_COOKIE['PHPSESSID']);
} else {
    $userInfo = 0;
}if ($userInfo != -1 and $userInfo != 0) {
    echo "<body><script>window.location.href='/pages/dashboard.php'</script></body>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | Counter</title>
    <link rel="stylesheet" href="/css/register.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="icon" href="/img/logo.png" type="image/x-icon">

</head>
<body>
    <script>
        sessionStorage.removeItem("xso-nav");
    </script>
    <script src="/js/visitor.js"></script>
    <form action="/api/register.php" method="POST">
        <div id="top-div">
            <img src="/img/logo.png" id="top-logo-img">
        </div>
        <div id="input-div">
            <input type="text" placeholder="Name" name="name" id="input-name" required>
            <input type="text" placeholder="Username" name="username" id="input-username" required>
            <input type="password" placeholder="Password" name="password" id="input-password" required>
            <input type="password" placeholder="Confirm Password" name="password-confirm" id="input-passwordConfirm" required>
        </div>
        <div id="button-div">
            <input type="submit" value="Create my account">
            <button id="register-button" onclick="window.location.href='/pages/login.php'">Sign in instead</button>
        </div>
    </form>

    <script>
        function checkPW() {
            if (document.querySelector("#input-password").value != document.querySelector("#input-passwordConfirm").value) {
                document.querySelector("#input-passwordConfirm").style.borderBottom = "2px solid red";
            } else {
                document.querySelector("#input-passwordConfirm").style.borderBottom = "2px solid #0000000a";
            }
        }
        document.querySelector("#input-password").addEventListener("change", checkPW)
        document.querySelector("#input-passwordConfirm").addEventListener("change", checkPW)

    </script>
</body>
</html>