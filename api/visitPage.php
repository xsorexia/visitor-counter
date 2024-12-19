<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/api/db.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
$pdo = db_pdo();
$input = json_decode(file_get_contents("php://input"), true);

// Check if the required fields are present in the request
if (isset($input['isUniqueVisit']) && isset($input['domain']) && isset($input['location'])) {
    $isUniqueVisit = $input['isUniqueVisit'];
    $domain = $input['domain'];
    $location = $input['location'];
    $ipAdd = getUserIP();
    $appIdQuery = $pdo->prepare("SELECT * FROM domains WHERE domain = ?");
    try {
        echo $domain;
        $appIdQuery->execute([$domain]);
        $sel = $appIdQuery -> fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo $e;
    }
    foreach ($sel as $appId) {
        $query = $pdo->prepare("INSERT INTO visitors (applicationID, domainID, visitDate, location, isUniqueVisit, ipAddress) VALUES (
            ?, ?, ?, ?, ?, ?
        )");
        try {
            $query -> execute([$appId['applicationID'], $appId['did'], date("Y-m-d H:i:s"), $location, $isUniqueVisit, $ipAdd]);
            echo "Operation was successful.";
        } catch (PDOException $e) {
            echo $e;
        }
    
        if ($isUniqueVisit == 1) {
            $updateQuery = $pdo->prepare("UPDATE domains SET totalVisitCount = totalVisitCount + 1, uniqueVisitorCount = uniqueVisitorCount + 1 WHERE did = ?");
        } else {
            $updateQuery = $pdo->prepare("UPDATE domains SET totalVisitCount = totalVisitCount + 1 WHERE did = ?");
    
        }
        try {
            $updateQuery -> execute([$appId['did']]);
            echo "Operation was successful.";
        } catch (PDOException $e) {
            echo $e;
        }
    }

} else {
    echo "Parameters are missing.";
}