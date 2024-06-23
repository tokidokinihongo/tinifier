<?php

$url = $_SERVER['REQUEST_URI'];
$trimmed_url = explode('/', $url);

try {
    require ('dbconn.php');
    $query = "SELECT link_input FROM links WHERE link_output LIKE '%$trimmed_url[3]';";
    $result = $dbConn->query($query);
    if ($result->num_rows >= 1) {
        while ($row = $result->fetch_assoc()) {
            $link = $row['link_input'];
        }
    }
    header("Location: $link");
} catch (err) {
    echo "There was an error: " . $err;
}

?>