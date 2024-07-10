<?php
session_start();
try {
    $array = [];
    $i = 0;
    require ('dbconn.php');
    $sql = "SELECT links.user_id, links.link_input, links.link_output FROM links JOIN users ON users.user_id = links.user_id WHERE links.user_id = ?;";
    $sql = sqlsrv_prepare($dbConn, $sql, array($_SESSION['uid']));
    if (sqlsrv_execute($sql)) {
        while ($row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC)) {
            $array['input'][$i] = $row['link_input'];
            $array['output'][$i] = $row['link_output'];
            $i++;
        }
    }
    echo json_encode($array);
} catch (Exception $err) {
    echo "Error occured: " . $err;
}
?>