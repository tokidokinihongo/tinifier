<?php
session_start();
require ('header.php');
?>

<form class="register-form" action="register.php" method="post">
    <label for="username">Username</label><br>
    <input type="text" id="username" name="username"><br>
    <label for="password">Password</label><br>
    <input type="password" id="password" name="password"><br><br>
    <input type="submit" name="submit-register-form" value="Register" class="register-submit">
</form>

<?php

if (isset($_POST['submit-register-form'])) {
    try {
        require ('dbconn.php');
        $query = $dbConn->prepare("INSERT INTO users (username, password) VALUES(?, ?)");
        $query->bind_param("ss", $_POST['username'], $_POST['password']);
        $query->execute();
    } catch (err) {
        echo "There was an error: " . $err;
    }
}

?>

<?php require ('footer.php'); ?>