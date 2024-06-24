<?php
session_start();
if (isset($_SESSION['uid'])) {
    require ('authheader.php');
} else {
    require ('header.php');
}
if (isset($_POST['submit-button'])) {
    $rnd_id = rand(00000000, 99999999);
    $input = $_POST['link-input'];
    if (!str_contains($input, 'http://') or !str_contains($input, 'https://')) {
        $input = "https://" . $input;
    }
    $output = "localhost/tinifier/endpoint.php/$rnd_id";
    try {
        require ('dbconn.php');
        if (!isset($_SESSION['uid'])) {
            $query = "INSERT INTO links (link_input, link_output) VALUES ('$input', '$output');";
        } else {
            $query = "INSERT INTO links (link_input, link_output, user_id) VALUES ('$input', '$output', '" . $_SESSION['uid'] . "');";
        }
        $dbConn->query($query);
        $_SESSION['output-link'] = $output;
    } catch (err) {
        echo "There was an error: " . $err;
    }
}

?>

<form class="link-generate-form" action="index.php" method="post">
    <label for="link-input"></label>Link</label><br>
    <input type="text" id="link-input" name="link-input" placeholder="Enter Link to Shorten">
    <input type="submit" value="Generate Link" name="submit-button" class="submit-button">
    <div class="link-field"><?php if (isset($_SESSION['output-link'])) {
        echo "Successfully created short link: " . $_SESSION['output-link'];
        unset($_SESSION['output-link']);
    } ?></div>
</form>
<?php require ('footer.php'); ?>