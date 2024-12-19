<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/api/db.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/api/init.php';
$userInfo = getUserInfo($_COOKIE['PHPSESSID']);
$pdo = db_pdo();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Setup | Counter</title>
    <link rel="stylesheet" href="/css/setup.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="icon" href="/img/logo.png" type="image/x-icon">
</head>
<body>
    <script src="/js/visitor.js"></script>
    <div id="navbar">

    </div>
    <div id="body">
        <div id="title">Setup</div>
        <div id="setup-grid">
            <div id="setup-grid-top">
                <div id="setup-grid-top-title">Set up your site.</div>
                <div id="setup-grid-top-desc">Keep track and analyze your daily visitors with Counter.</div>

            </div>
            <div class="setup-item">
                <div class="setup-title">Step 1.</div>
                <div class="setup-desc">Download <b>visitor.js</b> from below and add the file to your project.</div>
                <a href='/js/visitor.js' id="setup-download-button" download>Download visitor.js</a>
            </div>
            <div class="setup-item">
                <div class="setup-title">Step 2.</div>
                <div class="setup-desc">Include <b>visitor.js</b> with a <b>script</b> tag on every page you want to track.</div>
            </div>
            <div class="setup-item">
                <div class="setup-title">Step 3.</div>
                <div class="setup-desc">Register your domain to <b>Counter</b> to keep track of visitors.<br>Now you can manage your site's visitors from the <span id="domains-link" onclick="moveTo('nav-2', '/pages/domainList.php')"><b>Domains</b></span> tab!</div>
            </div>
        </div>


    </div>
</body>
<script src="/modules/loadNavbar.js"></script>