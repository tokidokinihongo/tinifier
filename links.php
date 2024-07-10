<?php
session_start();
$style = "./css/links.css";
$script = "./js/links.js";
if (isset($_SESSION['uid'])) {
    require ('authheader.php');
} else {
    require ('header.php');
} ?>

<div class="personal-links generated-links">
    <div>
        <h1 class="insights-table-user"><?php echo $_SESSION['user'] . "'s generated links"; ?></h1>
    </div>
    <div class="table-body"></div>
</div>
<div class="personal-links insights-graph">
    <?php
    require ('dbconn.php');
    $total_array = [0, 0, 0, 0, 0];
    try {
        for ($i = 0; $i < 5; $i++) {
            $year = getdate()["year"];
            $mon = getdate()["mon"];
            $day = getdate()["mday"];
            if ($day - $i <= 0) {
                $day = 33; #compensates for the counter
                $mon = getdate()["mon"] - 1;
            }
            $date_full = $year . "-" . $mon . "-" . $day - $i;
            $sql = "SELECT times_clicked FROM links WHERE user_id = ? AND date_added = ?";
            $sql = sqlsrv_prepare($dbConn, $sql, array($_SESSION['uid'], $date_full));
            if (sqlsrv_execute($sql)) {
                while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
                    $total_array[$i] += $row['times_clicked'];
                }
            }
        }
    } catch (Exception $err) {
        echo $err;
    } finally {
        echo "
    <h1>Link analaytics for $_SESSION[user]</h1>
    <canvas id='link_analytics' style='width: 100%; max-width:700px'></canvas>
    <script>
        const xValues =
            Array.from({ length: 5 }, (_, i) => {
                let date = new Date();
                date.setDate(date.getDate() - i);
                return date.toISOString().split('T')[0];
            });
        const yValues = [$total_array[0], $total_array[1], $total_array[2], $total_array[3], $total_array[4]];
        const chart = new Chart('link_analytics', {
            type: 'bar',
            data: {
                labels: xValues,
                datasets: [{
                    data: yValues,
                    backgroundColor: [
                  'rgba(255, 99, 132, 0.5)',
                  'rgba(255, 159, 64, 0.5)',
                  'rgba(255, 205, 86, 0.5)',
                  'rgba(75, 192, 192, 0.5)',
                  'rgba(54, 162, 235, 0.5)',
                  'rgba(153, 102, 255, 0.5)',
                  'rgba(201, 203, 207, 0.5)'
                ],
            }],
        },
            options: {
                legend: { display: false },
            }
        })
    </script>";
        sqlsrv_close($dbConn);
    }
    ?>
</div>

<?php require ('footer.php'); ?>