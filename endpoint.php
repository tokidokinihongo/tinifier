<?php

$url = $_SERVER['REQUEST_URI'];
$trimmed_url = explode('/', $url);
$trimmed_url = "%" . $trimmed_url[3] . "%";

try {
    require ('dbconn.php');
    $sql = $dbConn->prepare("SELECT link_input, link_output, times_clicked FROM links WHERE link_output LIKE ?");
    $sql->bind_param("s", $trimmed_url);
    $sql->execute();
    $result = $sql->get_result();
    if ($result->num_rows >= 1) {
        while ($row = $result->fetch_assoc()) {
            $link_output = $row['link_output'];
            $link = $row['link_input'];
            $times_clicked = $row['times_clicked'];
        }
        $times_clicked++;
        $update_times_clicked = $dbConn->prepare("UPDATE links SET times_clicked = ? WHERE link_output = ?");
        $update_times_clicked->bind_param('is', $times_clicked, $link_output);
        $update_times_clicked->execute();
        header("Location: " . $link);
    }
} catch (err) {
    echo "There was an error: " . $err;
} finally {
    $sql->close();
    $update_times_clicked->close();
}

?>