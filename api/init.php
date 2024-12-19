<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/api/db.php';
session_start();

if (!isset($_COOKIE['PHPSESSID'])) {
    echo "<body><script>
    window.location.href = '/pages/login.php';
    </script></body>
    ";
} else {
    $result = getUserInfo($_COOKIE['PHPSESSID']);
    if ($result == 0) {
        echo "<body><script>
        window.location.href = '/pages/login.php';
        </script></body>
        ";
    }
}