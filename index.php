<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/api/db.php';
if (isset($_COOKIE['PHPSESSID'])) {
    $userInfo = getUserInfo($_COOKIE['PHPSESSID']);
} else {
    $userInfo = 0;
}
$pdo = db_pdo();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Counter</title>
    <link rel="stylesheet" href="/css/index.css">
    <link rel="icon" href="/img/logo.png" type="image/x-icon">

</head>
<body>
    <div id="navbar-div">
        <?php
            if ($userInfo == 0 or $userInfo == -1) {
                ?>
                <div id="navbar-login" onclick="window.location.href='/pages/login.php'">Sign In</div>
                <div id="navbar-register" onclick="window.location.href='/pages/register.php'">Register</div>
                <?php
            } else {
                ?>
                <div id="navbar-dash" onclick="window.location.href='/pages/dashboard.php'">Hello, <?=$userInfo['name']?></div>
                <?php
            }
        ?>  

    </div>
    <div id="index-body">
        <div id="index-body-left">
            <div id="index-body-div">
                <img src="/img/logo.png">
                <div id="index-body-left-title">Counter</div>
            </div>
        </div>
        <div id="index-body-right">
            <div id="index-body-right-title">Keeping track of your impact to the world of internet.</div>
            <div id="index-body-right-desc"><br><b>Counter</b> is an intuitive solution for keeping track of users that visit your website.<br><br>
            With Counter, you can easily check and manage visitors to multiple sites through the administrator dashboard. 
            </div>
            <?php
            if ($userInfo == 0 or $userInfo == -1) {
            ?>
            <div id="index-body-button" onclick="window.location.href='/pages/login.php'">Get Started</div>
            <?php
            } else {
                ?>
            <div id="index-body-button" onclick="window.location.href='/pages/dashboard.php'">My Dashboard</div>
                <?php
            }
            ?>
        </div>
    </div>
</body>
</html>