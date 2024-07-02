<?php
session_start();
$style = "links.css";
if (isset($_SESSION['uid'])) {
    require ('authheader.php');
} else {
    require ('header.php');
} ?>

<div class="personal-links">
    <h1><?php echo $_SESSION['user'] . "'s generated links"; ?></h1>
    <table>
        <tr>
            <th>Link Input</th>
            <th>Link Output</th>
        </tr>
        <?php
        try {
            require ('dbconn.php');
            $sql = "SELECT links.user_id, links.link_input, links.link_output FROM links JOIN users ON users.user_id = links.user_id WHERE links.user_id = ?;";
            $sql = sqlsrv_prepare($dbConn, $sql, array($_SESSION['uid']));
            if (sqlsrv_execute($sql)) {
                while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
                    $inp = $row['link_input'];
                    $out = $row['link_output'];
                    echo "
                    <tr>
                        <td>$inp</td>
                        <td>$out</td>
                    </tr>
                        ";
                }
            }
        } catch (Exception $err) {
            echo "Error occured: " . $err;
        }
        ?>
    </table>
</div>
<div class="personal-links">
    <?php
    $total_array = [0, 0, 0, 0, 0];
    try {
        for ($i = 0; $i < 5; $i++) {
            $year = getdate()["year"];
            $mon = getdate()["mon"];
            $day = getdate()["mday"];
            // echo "The first day is: $day<br>";
            if ($day - $i <= 0) {
                $day = 33; #compensates for the counter
                $mon = getdate()["mon"] - 1;
            }
            // echo "The counter is: $i<br>";
            // echo "The adjusted day is: $day<br>";
            $date_full = $year . "-" . $mon . "-" . $day - $i;
            // echo "The subtracted day is: " . $day - $i . "<br>" . "";
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
                    backgroundColor: 'skyblue',
                    data: yValues
                }]
            },
            options: {
                legend: { display: false },
            }
        })
    </script>";
        echo $total_array[0], $total_array[1], $total_array[2], $total_array[3], $total_array[4];
        sqlsrv_close($dbConn);
    }
    ?>
</div>

<?php require ('footer.php'); ?>