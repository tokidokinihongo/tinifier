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
        $query = "SELECT links.link_input, links.link_output FROM links JOIN users ON users.user_id = links.user_id;";
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
        ?>
    </table>
</div>

<?php require ('footer.php'); ?>