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
    <title>Dashboard | Counter</title>
    <link rel="stylesheet" href="/css/dashboard.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="icon" href="/img/logo.png" type="image/x-icon">
</head>
<body>
    <script src="/js/visitor.js"></script>
    <div id="navbar">

    </div>
    <div id="body">
        <div id="title">Dashboard</div>
        <div id="dashboard-grid">
            <div id="dashboard-grid-top">
                <div id="dashboard-grid-top-title">Welcome to Counter.</div>
                <div id="dashboard-grid-top-desc">Keep track and analyze your daily visitors with Counter.</div>

            </div>
            <div id="dashboard-grid-info">
                <div id="dashboard-grid-info-left">
                    <div id="dashboard-grid-info-left-title">Statistics</div>
                    <div id="dashboard-grid-info-left-bottom">
                        <div class="dashboard-grid-info-left-item">
                            <div class="dashboard-grid-info-left-number"><?php
                                $todayVisitorQuery = $pdo->prepare("SELECT COUNT(*) FROM visitors
                                    WHERE applicationID = ? AND isUniqueVisit = 1 AND visitDate BETWEEN NOW() - INTERVAL 1 DAY AND NOW();");
                                $todayVisitorQuery -> execute([$userInfo['aid']]);
                                $todayVisitor = $todayVisitorQuery -> fetchColumn();
                                echo $todayVisitor;
                            ?></div>
                            <div class="dashboard-grid-info-left-desc">Today's visitors</div>
                        </div>
                        <div class="dashboard-grid-info-left-item">
                            <div class="dashboard-grid-info-left-number"><?php
                                $totalVisitQuery = $pdo->prepare("SELECT COUNT(*) FROM visitors
                                    WHERE applicationID = ?");
                                $totalVisitQuery -> execute([$userInfo['aid']]);
                                $totalVisit = $totalVisitQuery -> fetchColumn();
                                echo $totalVisit;
                            ?>

                            </div>
                            <div class="dashboard-grid-info-left-desc">Total visits</div>
                        </div>
                    </div>
                </div>
                <div id="dashboard-grid-info-right">
                    <?php
                        $recentQuery = $pdo->prepare("SELECT
                            DATE(visitDate) AS date,
                            COUNT(*) AS row_count
                            FROM visitors
                            WHERE applicationID = ? AND visitDate >= CURDATE() - INTERVAL 6 DAY
                            GROUP BY DATE(visitDate)
                            ORDER BY date ASC;");
                            $recentQuery -> execute([$userInfo['aid']]);
                            $res = $recentQuery -> fetchAll();
                        $max = 0;
                        foreach ($res as $row) {
                            if ($row['row_count'] > $max) {
                                $max = $row['row_count'];
                            }
                        }
                    ?>
                    <div id="graph-top-div">

                        <?php
                        foreach ($res as $row) {
                            $curCount = $row['row_count'];
                            echo "
                            <div class='graph-top-barItem'>
                                <div class='graph-top-barInfo'>
                                    <div class='graph-top-barInfo-title'>$curCount</div>
                                    <div class='graph-top-barInfo-desc'>visits</div>
                                </div>
                                <div class='graph-top-barContainer'>
                                    <div class='graph-top-bar' style='height: calc(100% * $curCount / $max);'>
                                    </div>
                                </div>
                            </div>";
                        }
                        ?>
                    </div>
                    <div id="graph-bottom-div">
                        <?php
                        $dayCount = count($res)-1;
                        foreach ($res as $row) {
                            $date = date("m-d", strtotime("-$dayCount days"));
                            echo "<div class='graph-bottom-labelItem'>$date</div>";
                            $dayCount = $dayCount - 1;
                        }
                        ?>
                    </div>
                </div>
            </div>
            <div id="dashboard-grid-bottom">
                <div id="dashboard-grid-bottom-left">
                    <div id="dashboard-grid-bottom-left-ad1" onclick="window.location.href='https://xsorexia.com'" >
                        <img src="/img/xsorexia_thick@4x.png">
                        <div id="dashboard-grid-bottom-left-ad1-right">
                            <div id="dashboard-grid-bottom-left-ad1-right-title">Hi, I'm xsorexia.</div>
                            <div id="dashboard-grid-bottom-left-ad1-right-desc">Check out my projects on <b>xsorexia.com</b>!.</div>
                        </div>
                    </div>
                </div>
                <div id="dashboard-grid-bottom-right">
                    <div id="dashboard-grid-bottom-right-title">My domains</div>
                    <?php
                        $myDomainQuery = $pdo->prepare("SELECT * FROM domains WHERE applicationID = ?");
                        $myDomainQuery -> execute([$userInfo['aid']]);
                        $myDomains = $myDomainQuery -> fetchAll(PDO::FETCH_ASSOC);
                        foreach ($myDomains as $row) {
                            $domainName = $row['domain'];
                            $domainID = $row['did'];
                            $totalVisit = $row['totalVisitCount'];
                            $uniqueCount = $row['uniqueVisitorCount'];
                            echo "
                                <div class='domain-item' onclick='window.location.href=`/pages/domain.php?did=$domainID`'>
                                    <div class='domain-title'>$domainName</div>
                                    <div class='domain-bottom'>
                                        <span><b>$totalVisit</b> total visits</span>
                                        <span><b>$uniqueCount</b> unique visitors</span>
                                    </div>
                                </div>";
                        }
                        if (count($myDomains) == 0 ) {
                            echo "
                                <div class='domain-item' onclick='moveTo(`nav-2`, `/pages/domainList.php`)' style='margin-top: 20px; color: #00000040;'>
                                    <div class='domain-title'>+ Add a domain to get started</div>
                                    <div class='domain-bottom'>
                                    </div>
                                </div>";
                        }
                    ?>

                </div>
            </div>
        </div>
    </div>
</body>
<script src="/modules/loadNavbar.js"></script>
</html>