<?php
session_start();
$style = "./css/style.css";
$script = "./js/analytics.js";
if (isset($_SESSION['uid'])) {
    require ('authheader.php');
} else {
    require ('header.php');
} ?>
<div class="ajaxtest"></div>
<input type="submit" class="ajax">

<?php require ('footer.php') ?>

<!-- <script>
    const ajaxDiv = document.querySelector('.ajaxtest');
    const ajaxButton = document.querySelector('.ajax');

    function updateField() {
        let xml = new XMLHttpRequest();
        xml.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                ajaxDiv.innerHTML = this.responseText;
            }
        };
        xml.open("GET", "helloworld.php", true);
        xml.send();
    }
</script> -->