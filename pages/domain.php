<?php
include_once $_SERVER['DOCUMENT_ROOT'].'/api/db.php';
include_once $_SERVER['DOCUMENT_ROOT'].'/api/init.php';
$userInfo = getUserInfo($_COOKIE['PHPSESSID']);
$pdo = db_pdo();

if (isset($_GET['did'])) {
    $domainId = $_GET['did'];

} else {
    echo "<body><script>alert('Invalid domain.'); window.location.href='/pages/domainList.php'</script></body>";
}

$domainInfo = getDomainInfo($domainId, $userInfo['aid']);
if ($domainInfo == -1 or $domainInfo == 0) {
    echo "<body><script>alert('Invalid domain.'); window.location.href='/pages/domainList.php'</script></body>";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Domain | Counter</title>
    <link rel="stylesheet" href="/css/domain.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <link rel="icon" href="/img/logo.png" type="image/x-icon">

</head>
<body>
    <script src="/js/visitor.js"></script>
    <div id="navbar">

    </div>
    <div id="body">
        <div id="title"><?=$domainInfo['domain']?></div>
        <div id="dashboard-grid">
            <div id="dashboard-grid-top">
                <div id="dashboard-grid-top-title">Manage your sites registered to Counter.</div>
                <div id="dashboard-grid-top-desc">Keep track and analyze your daily visitors with Counter.</div>
            </div>
            <div id="dashboard-grid-middle">
                <div id="dashboard-grid-middle-left">
                    <div id="dashboard-grid-middle-left-title">Statistics</div>
                    <div id="dashboard-grid-middle-left-container">
                        <div class="dashboard-grid-middle-left-item">
                            <div class="dashboard-grid-middle-left-number"><?php
                                $todayVisitorQuery = $pdo->prepare("SELECT COUNT(*) FROM visitors
                                    WHERE applicationID = ? AND domainID = ? AND isUniqueVisit = 1 AND visitDate BETWEEN NOW() - INTERVAL 1 DAY AND NOW();");
                                $todayVisitorQuery -> execute([$userInfo['aid'], $domainId]);
                                $todayVisitor = $todayVisitorQuery -> fetchColumn();
                                echo $todayVisitor;
                            ?></div>
                            <div class="dashboard-grid-middle-left-desc">Today's visitors</div>
                        </div>
                        <div class="dashboard-grid-middle-left-item">
                            <div class="dashboard-grid-middle-left-number"><?php
                                $todayVisitorQuery = $pdo->prepare("SELECT COUNT(*) FROM visitors
                                    WHERE applicationID = ? AND domainID = ? AND visitDate BETWEEN NOW() - INTERVAL 1 DAY AND NOW();");
                                $todayVisitorQuery -> execute([$userInfo['aid'], $domainId]);
                                $todayVisitor = $todayVisitorQuery -> fetchColumn();
                                echo $todayVisitor;
                            ?></div>
                            <div class="dashboard-grid-middle-left-desc">Today's visits</div>
                        </div>
                        <div class="dashboard-grid-middle-left-item">
                            <div class="dashboard-grid-middle-left-number"><?php
                                $todayVisitorQuery = $pdo->prepare("SELECT COUNT(*) FROM visitors
                                    WHERE applicationID = ? AND domainID = ? AND isUniqueVisit = 1;");
                                $todayVisitorQuery -> execute([$userInfo['aid'], $domainId]);
                                $todayVisitor = $todayVisitorQuery -> fetchColumn();
                                echo $todayVisitor;
                            ?></div>
                            <div class="dashboard-grid-middle-left-desc">Unique visitors</div>
                        </div>
                        <div class="dashboard-grid-middle-left-item">
                            <div class="dashboard-grid-middle-left-number"><?php
                                $todayVisitorQuery = $pdo->prepare("SELECT COUNT(*) FROM visitors
                                    WHERE applicationID = ? AND domainID = ?;");
                                $todayVisitorQuery -> execute([$userInfo['aid'], $domainId]);
                                $todayVisitor = $todayVisitorQuery -> fetchColumn();
                                echo $todayVisitor;
                            ?></div>
                            <div class="dashboard-grid-middle-left-desc">Total visits</div>
                        </div>
                    </div>
                </div>
                <div id="dashboard-grid-middle-right">
                    <div id="dashboard-grid-middle-right-title">Manage</div>
                    <div id="dashboard-grid-middle-right-reset" class="dashboard-grid-middle-right-buttons">Reset Statistics</div>
                    <div id="dashboard-grid-middle-right-delete" class="dashboard-grid-middle-right-buttons">Remove Domain</div>

                </div>
            </div>
            <div id="dashboard-grid-info">
                <div id="dashboard-grid-info-left">
                <?php
                        $recentQuery = $pdo->prepare("SELECT
                            DATE(visitDate) AS date,
                            COUNT(*) AS row_count
                            FROM visitors
                            WHERE applicationID = ? AND domainID = ? AND visitDate >= CURDATE() - INTERVAL 6 DAY
                            GROUP BY DATE(visitDate)
                            ORDER BY date ASC;");
                            $recentQuery -> execute([$userInfo['aid'], $domainId]);
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
                        $dayCount = count($res) - 1;
                        foreach ($res as $row) {
                            $date = date("m-d", strtotime("-$dayCount days"));
                            echo "<div class='graph-bottom-labelItem'>$date</div>";
                            $dayCount = $dayCount - 1;
                        }
                        ?>
                    </div>
                </div>
                <div id="dashboard-grid-info-right">
                    <div id="dashboard-grid-info-right-title">Page visits</div>
                    <?php
                        $pageQuery = $pdo->prepare("SELECT 
                            location, 
                            COUNT(*) AS total_rows, 
                            SUM(isUniqueVisit = 1) AS unique_visits
                        FROM visitors
                        WHERE domainID = ?
                        GROUP BY location ORDER BY total_rows DESC; ");
                        $pageQuery -> execute([$domainId]);
                        $pageRes = $pageQuery -> fetchAll(PDO::FETCH_ASSOC);
                        foreach ($pageRes as $row) {
                            $loc = $row['location'];
                            $tot = $row['total_rows'];
                            $uni = $row['unique_visits'];
                            echo "<div class='domain-item'>
                                <div class='domain-title'>$loc</div>
                                <div class='domain-bottom'>
                                    <span><b>$tot</b> total visits</span>
                                    <span><b>$uni</b> unique visitors</span>
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