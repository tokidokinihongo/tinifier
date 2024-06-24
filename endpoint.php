<?php

$url = $_SERVER['REQUEST_URI'];
$trimmed_url = explode('/', $url);
$trimmed_url = "%".$trimmed_url[3]."%";

try {
    require ('dbconn.php');
    $query = $dbConn->prepare("SELECT link_input FROM links WHERE link_output LIKE ?");
    $query->bind_param("s", $trimmed_url);
    $query->execute();
    $result = $query->get_result();
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