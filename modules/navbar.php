<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/api/db.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/api/init.php';
$userInfo = getUserInfo($_COOKIE['PHPSESSID']);
?>


<div id="navbar-top">
            <div id="navbar-top-logo" onclick="window.location.href='/index.php'">
                <img src="/img/logo.png" id="navbar-top-logo-img">
                <div id="navbar-top-logo-title">Counter</div>
            </div>
            <div id="navbar-top-menu">
                <div class="navbar-menu-item"  id="nav-1" onclick="moveTo('nav-1', '/pages/dashboard.php')">
                    <img class="navbar-menu-item-icon" src="/img/dashboard.png">
                    <div class="navbar-menu-item-title">Dashboard</div>
                </div>
                <div class="navbar-menu-item"  id="nav-2" onclick="moveTo('nav-2', '/pages/domainList.php');">
                    <img class="navbar-menu-item-icon" src="/img/domains.png">
                    <div class="navbar-menu-item-title">Domains</div>
                </div>
                <div class="navbar-menu-item" id="nav-3" onclick="moveTo('nav-3', '/pages/setup.php');">
                    <img class="navbar-menu-item-icon" src="/img/docs.png">
                    <div class="navbar-menu-item-title">Setup</div>
                </div>
            </div>
        </div>
        <div id="navbar-bottom">
            <div id="navbar-bottom-left">
                <!--<img id="navbar-bottom-profile-img" src="/img/profile.png">-->
                <style>
                    #navbar-bottom-left {
                        background-image: url('/img/profile.png');
                        background-size: cover;
                    }
                </style>
            </div>
            <div id="navbar-bottom-right">
                <div id="navbar-bottom-name"><?=$userInfo['name']?></div>
                <div id="navbar-bottom-buttons"><span>Profile</span><span onclick="window.location.href='/api/logout.php'">Log out</span></div>
            </div>
        </div>

    <script>
    function moveTo(e, urlLink) {
        sessionStorage.setItem("xso-nav", e);
        window.location.href = urlLink;
    }

    if (sessionStorage.getItem("xso-nav")) {
        document.querySelector(`#${sessionStorage.getItem("xso-nav")}`).classList.add("navbar-selected-menu-item");
    } else {
        document.querySelector(`#nav-1`).classList.add("navbar-selected-menu-item");
    }
</script>