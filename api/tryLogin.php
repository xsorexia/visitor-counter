<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/api/db.php';

$pdo = db_pdo();
if (isset($_POST['username']) && isset($_POST['password'])) {
    try {
        $query = $pdo->prepare("SELECT * FROM applications WHERE username = ? AND password = ?");
        $query -> execute([$_POST['username'], $_POST['password']]);
        if ($query -> rowCount() == 1) {
            $res = $query -> fetch();
            addSession($res['aid']);
            echo "<body><script>window.location.href='/pages/dashboard.php';</script></body>";

        } else {
            echo "<body><script>alert('Please check your username or password.');window.location.href='/pages/login.php';</script></body>";
            
        }
    } catch (PDOException $e) {
        echo $e;
    }
}