<?php
$to = 'kenzitus13@gmail.com';
$subject = 'Subject of the email';
$message = 'Message content here';
$headers = 'From: kenzitus13@gmail.com' . "\r\n" .
           'Reply-To: kenzitus13@gmail.com' . "\r\n" .
           'X-Mailer: PHP/' . phpversion();

if(mail($to, $subject, $message, $headers)) {
    echo 'Mail sent successfully.';
} else {
    echo 'Mail sending failed.';
}
?>