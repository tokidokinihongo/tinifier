<?php
session_start();
require ('header.php');
?>

<form class="login-form" action="login.php" method="post">
    <label for="username">Username</label><br>
    <input type="text" id="username" name="username"><br>
    <label for="password">Password</label><br>
    <input type="password" id="password" name="password"><br><br>
    <div class="err-field"><?php if (isset($_SESSION['bad-credentials'])) {
        echo $_SESSION['bad-credentials'];
    } ?></div>
    <input type="submit" name="login-submit" value="Login" class="login-submit">
</form>

<?php
if (isset($_POST['login-submit'])) {
    try {
        require ('dbconn.php');
        $sql = "SELECT user_id, username FROM users WHERE username = ? AND password = ?";
        $sql = sqlsrv_prepare($dbConn, $sql, array($_POST['username'], $_POST['password']));
        if (sqlsrv_execute($sql)) {
            unset($_SESSION['message']);
            $row = sqlsrv_fetch_array($sql, SQLSRV_FETCH_ASSOC);
            $_SESSION['uid'] = $row['user_id'];
            $_SESSION['user'] = $row['username'];
            header('Location: index.php');
        } else {
            $_SESSION['bad-credentials'] = "Bad username or password entered, please try again";
            header("Location: login.php");
        }
    } catch (err) {
        echo "Error: " . $err;
    }
}

?>

<?php require ('footer.php'); ?>