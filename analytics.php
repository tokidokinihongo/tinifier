<?php
session_start();
if (isset($_SESSION['uid'])) {
    require ('authheader.php');
} else {
    require ('header.php');
} ?>


<?php require ('footer.php') ?>