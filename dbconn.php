<?php

$server = "localhost\\sqlexpress";
$connectionInfo = array("Database" => "tinifier");

try {
    $dbConn = sqlsrv_connect($server, $connectionInfo);
} catch (Error $err) {
    die(print_r(sqlsrv_errors(), true));
}

?>