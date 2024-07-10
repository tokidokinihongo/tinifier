<?php
session_start();
require ('dbconn.php');
$link = isset($_GET['input']) ? $_GET['input'] : "";
$uid = $_SESSION['uid'];
$sql = "SELECT times_clicked FROM links WHERE user_id = ? AND link_input = ?";
$query = sqlsrv_prepare($dbConn, $sql, array($uid, $link));

if (sqlsrv_execute($query)) {
    while ($row = sqlsrv_fetch_array($query, SQLSRV_FETCH_ASSOC)) {
        $times_clicked = $row['times_clicked'];
    }
    $response = [
        'times_clicked' => $times_clicked,
    ];
}

echo json_encode($response);
?>