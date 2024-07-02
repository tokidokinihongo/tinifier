<?php
session_start();
$style = "style.css";
if (isset($_SESSION['uid'])) {
    require ('authheader.php');
} else {
    require ('header.php');
}
 ?>

<form class="contact-form" action="https://formspree.io/f/xovaapbd" method="post">
    <label for="email">E-mail</label>
    <input type="text" id="email" name="email"><br><br>
    <textarea rows="8" cols="80"></textarea>
    <input type="submit" name="submit-button" value="Send Form">
</form>

<?php require ('footer.php'); ?>