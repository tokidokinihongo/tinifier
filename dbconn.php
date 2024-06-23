<?php

$server = "localhost";
$user = "root";
$password = "";
$db = "test";

$dbConn = new mysqli($server, $user, $password, $db);

if ($dbConn->connect_error) {
    echo "There was an issue connecting to the database " . $err;
}


?>