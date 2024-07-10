<?php


// $query = "CREATE TABLE users (user_id INT AUTO_INCREMENT PRIMARY KEY, username VARCHAR(40), password VARCHAR(40));";
// $query = "DROP TABLE users";
// $sql = "ALTER TABLE links ADD user_id INT, ADD CONSTRAINT fk_user_id FOREIGN KEY (user_id) REFERENCES users (user_id);";
// $query = "DELETE FROM links";
// $query = "ALTER TABLE links DROP COLUMN user_id";

echo "File Opened";

require ('dbconn.php');

$sql = "DELETE FROM links; DELETE FROM users";
$sql = sqlsrv_prepare($dbConn, $sql);
// $sql = sqlsrv_prepare($dbConn, $sql, array(2, 5, 7));

try {
    if (sqlsrv_execute($sql)) {
        echo "Successful";
    }
} catch (Exception $e) {
    echo $e;
}

// try {
//     $dbConn->query($sql);
//     echo "Successfully added table";
// } catch (err) {
//     echo "There was an error " . $err;
// }

?>