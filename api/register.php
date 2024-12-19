<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/api/db.php';

$pdo = db_pdo();
if (isset($_POST['username']) && isset($_POST['password'])  && isset($_POST['name'])  && isset($_POST['password-confirm'])) {
    if ($_POST['password'] != $_POST['password-confirm']) {
        echo "<body><script>alert('Password does not match.');window.location.href='/pages/register.php';</script></body>";
    }
    $check = $pdo->prepare("SELECT * FROM applications WHERE username = ?");
    $check -> execute([$_POST['username']]);
    if ($check -> rowCount() != 0) {
        echo "<body><script>alert('Username is taken.');window.location.href='/pages/register.php';</script></body>";
        return 0;
    } else {
        $ins = $pdo->prepare("INSERT INTO applications (name, username, password, regDate) VALUES (?, ?, ?, ?)");
        $ins -> execute([$_POST['name'], $_POST['username'], $_POST['password'], date("Y-m-d H:i:s")]);
        try {
            $query = $pdo->prepare("SELECT * FROM applications WHERE username = ? AND password = ?");
            $query -> execute([$_POST['username'], $_POST['password']]);
            if ($query -> rowCount() == 1) {
                $res = $query -> fetch();
                addSession($res['aid']);
                echo "<body><script>window.location.href='/pages/dashboard.php';</script></body>";
    
            } else {
                echo "<body><script>alert('Sorry, an error occured..');window.location.href='/pages/login.php';</script></body>";
                
            }
        } catch (PDOException $e) {
            echo $e;
        }
    }

} else {
    echo "<body><script>alert('Information not fullfilled.');window.location.href='/pages/register.php';</script></body>";
    
}