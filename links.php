<?php
session_start();
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
        $query = "SELECT links.user_id, links.link_input, links.link_output FROM links JOIN users ON users.user_id = links.user_id WHERE links.user_id = '" . $_SESSION['uid'] . "';";
        try {
            require ('dbconn.php');
            $results = $dbConn->query($query);
            if ($results->num_rows >= 1) {
                while ($row = $results->fetch_assoc()) {
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
        } catch (err) {
            echo "Error occured: " . $err;
        }
        echo $_SESSION['uid'];
        ?>
    </table>

    <?php
    $total_array = [0, 0, 0, 0, 0];
    try {
        for ($x = 0; $x < 5; $x++) {
            $number_of_clicks = "SELECT times_clicked FROM links WHERE user_id = '" . $_SESSION['uid'] . "' AND date_added = '2024-06-" . getDate()["mday"] - $x . "'";
            $result = $dbConn->query($number_of_clicks);
            if ($result) {
                while ($row = $result->fetch_assoc()) {
                    $total_array[$x] += $row['times_clicked'];
                }
            }
            $result->close();
        }
    } catch (err) {
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
                    backgroundColor: 'purple',
                    data: yValues
                }]
            },
            options: {
                legend: { display: false },
            }
        })
    </script>";
    }
    ?>
</div>

<?php require ('footer.php'); ?>