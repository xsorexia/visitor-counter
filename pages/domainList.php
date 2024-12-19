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
    <title>Domain | Counter</title>
    <link rel="stylesheet" href="/css/domainList.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="icon" href="/img/logo.png" type="image/x-icon">

</head>
<body>
    <script src="/js/visitor.js"></script>
    <div id="navbar">

    </div>
    <div id="body">
        <div id="title">Domains</div>
        <div id="dashboard-grid">
            <div id="dashboard-grid-top">
                <div id="dashboard-grid-top-title">Manage your sites registered to Counter.</div>
                <div id="dashboard-grid-top-desc">Keep track and analyze your daily visitors with Counter.</div>

            </div>
            <div id="dashboard-grid-middle">
                <div id="dashboard-grid-middle-left">
                    <div id="dashboard-grid-middle-left-title">Registered Domains</div>
                    <?php
                        $myDomainQuery = $pdo->prepare("SELECT * FROM domains WHERE applicationID = ?");
                        $myDomainQuery -> execute([$userInfo['aid']]);
                        $myDomains = $myDomainQuery -> fetchAll(PDO::FETCH_ASSOC);
                        $totalVisits = 0;
                        foreach ($myDomains as $row) {
                            $domainName = $row['domain'];
                            $domainID = $row['did'];
                            $totalVisit = $row['totalVisitCount'];
                            $uniqueCount = $row['uniqueVisitorCount'];
                            $totalVisits = $totalVisits + $totalVisit;
                            echo "
                                <div class='domain-item' onclick='window.location.href=`/pages/domain.php?did=$domainID`'>
                                    <div class='domain-title'>$domainName</div>
                                    <div class='domain-bottom'>
                                        <span><b>$totalVisit</b> total visits</span>
                                        <span><b>$uniqueCount</b> unique visitors</span>
                                    </div>
                                </div>";
                        }
                    ?>
                </div>
                <div id="dashboard-grid-middle-right">
                    <div id="dashboard-grid-middle-right-top">
                    <div class="dashboard-grid-middle-right-top-title">
                            <?=count($myDomains)?> <span>domains</span>
                        </div>
                        <div class="dashboard-grid-middle-right-top-title">
                            <?=$totalVisits?> <span>visitors</span>
                        </div>
                        <form id="add-domain-input" style="display: none;" method="POST" action="/api/addDomain.php">
                            <input name="domain" type="text" placeholder="Domain" id="add-domain-input-field" required>
                            <div id="add-domain-submit-button" onclick="document.querySelector('#add-domain-input').submit()">+ Add</div>
                            <input type="submit" id="add-domain-submit-pseudo" style="display: none">
                        </form>
                        <div id="add-domain-button" onclick="toggleAddBtn()">+ Add domain</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="/modules/loadNavbar.js"></script>
<script>
    var isAddBtnToggled = false;
    function toggleAddBtn() {
        if (!isAddBtnToggled) {
            document.querySelector("#add-domain-button").style.display = "none";
            document.querySelector("#add-domain-input").style.display = "block";
        }
    }
</script>

</html>