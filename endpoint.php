<?php

$url = $_SERVER['REQUEST_URI'];
$trimmed_url = explode('/', $url);
$trimmed_url = "%" . $trimmed_url[3] . "%";

try {
    require ('dbconn.php');
    $sql = "SELECT link_input, link_output, times_clicked FROM links WHERE link_output LIKE ?;";
    $query = sqlsrv_prepare($dbConn, $sql, array($trimmed_url));
    if (sqlsrv_execute($query)) {
        while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
            $link_output = $row['link_output'];
            $link = $row['link_input'];
            $times_clicked = $row['times_clicked'];
            $times_clicked++;
            $update_times_clicked = "UPDATE links SET times_clicked = ? WHERE link_output = ?";
            $query = sqlsrv_prepare($dbConn, $update_times_clicked, array($times_clicked, $link_output));
            sqlsrv_execute($query);
        }
        header("Location: " . $link);
    }
} catch (err) {
    echo "There was an error: " . $err;
} finally {
    sqlsrv_close($dbConn);
}

?>