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
        $query = "SELECT user_id, username FROM users WHERE username = '" . $_POST['username'] . "' AND password = '" . $_POST['password'] . "';";
        $result = $dbConn->query($query);
        if ($result->num_rows === 1) {
            unset($_SESSION['message']);
            $row = $result->fetch_assoc();
            $_SESSION['uid'] = $row['user_id'];
            $_SESSION['user'] = $row['username'];
            header('Location: index.php');
            exit();
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