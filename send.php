<?php

require 'common.php';
require 'phpmailer/PHPMailerAutoload.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $mail = new PHPMailer;

    $name = (empty($_POST['name']) ? null : $_POST['name']);
    $email = (empty($_POST['email']) ? null : $_POST['email']);
    $message = (empty($_POST['message']) ? null : $_POST['message']);

    if (is_empty($name)) {
        http_response_code(400);
        die("Please enter your name.");
    } else if (is_empty($email)) {
        http_response_code(400);
        die("Please enter your e-mail address.");
    } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        die("The e-mail address you entered is invalid.");
    } else if (is_empty($message)) {
        http_response_code(400);
        die("Please enter a message.");
    }

    $mail->From = $email;
    $mail->FromName = $name;
    $mail->addAddress('jonathan@abbett.org');
    $mail->Subject = "Kosher Cheese Inquiry from " . $name;
    $mail->Body = "Name: " . $name . "\r\n" .
        "E-mail: " . $email . "\r\n\r\n" .
        $message;

    if ($mail->send()) {
        echo 'TRUE';
    } else {
        http_response_code(500);
        echo "Sorry, we could not submit your message. Please e-mail jonathan@abbett.org";
    }
}

?>