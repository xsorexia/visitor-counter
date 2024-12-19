<?php

function db_pdo(): PDO
{
    $host = 'ls-01a0b9b473f3c721b3dcc576f6306b11154b1879.cdym2mu2g0w1.ap-northeast-2.rds.amazonaws.com';
    $port = '3306';
    $dbname = 'visitorCount';
    $charset = 'utf8';
    $username = 'xsorexia';
    $db_pw = "Nism0421!";
    $dsn = "mysql:host=$host;port=$port;dbname=$dbname;charset=$charset";
    $pdo = new PDO($dsn, $username, $db_pw);
    return $pdo;
}

function getUserInfo($sessionId) {
    $pdo = db_pdo();
    try {
        $query = $pdo->prepare("SELECT U.* FROM applications as U INNER JOIN sessions as S WHERE S.sessionId=:sessionId AND S.applicationID=U.aid");
        $query->execute(array(':sessionId'=>$sessionId));
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if ($query->rowCount() == 0) {
            return 0;
        }
    } catch (PDOException $e) {
        global $ISDEBUG;
        if($ISDEBUG)
            echo "Error: " . $e->getMessage();
        return -1; //DB connection ERROR
    }

    return array("name" => $result["name"], "aid" => $result["aid"], "username" => $result["username"]);
}

function getDomainInfo($did, $aid) {
    $pdo = db_pdo();
    try {
        $query = $pdo -> prepare("SELECT * FROM domains WHERE did = ?");
        $query -> execute([$did]);
        $res = $query -> fetch(PDO::FETCH_ASSOC);
        if ($query -> rowCount() == 0) {
            //empty
            return 0;
        } 
        if ($res['applicationID'] == $aid) {
            return $res;
        } else {
            return -1; // don't have access
        }

    } catch (PDOException $e) {
        echo $e;
    }
}

function addSession($id) {
    $pdo = db_pdo();

    session_start();
    try {
        $query = $pdo->prepare("INSERT INTO sessions (applicationID, sessionId) VALUES (:uid, :sessionId)");
        $query -> execute(array(
            ':uid'=>$id,
            ':sessionId'=>$_COOKIE['PHPSESSID']
        ));
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
        $status = -1; // -1 :: DB connection ERROR
    }


}

function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
        // Check if IP is passed from shared internet
        return $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
        // Check if the IP is passed from a proxy
        return $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        // Fallback to REMOTE_ADDR
        return $_SERVER['REMOTE_ADDR'];
    }
}