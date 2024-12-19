<?php

include_once $_SERVER['DOCUMENT_ROOT'].'/api/db.php';
$pdo = db_pdo();

$query = $pdo -> prepare("INSERT INTO domains (applicationID, domain, totalVisitCount, uniqueVisitorCount) VALUES (
    (
        SELECT A.aid FROM applications as A INNER JOIN sessions AS S ON S.applicationID = A.aid WHERE S.sessionID = ?
    ), ?, 0, 0)");
$query -> execute([$_COOKIE['PHPSESSID'], $_POST['domain']]);
echo "<body><script>window.location.href = '/pages/domainList.php'</script></body>";