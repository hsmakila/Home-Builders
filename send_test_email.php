<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include library files 
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

$mail = new PHPMailer;

$mail->isSMTP();
$mail->Host = 'smtp.gmail.com';
$mail->SMTPAuth = true;
$mail->Username = '';
$mail->Password = '';
$mail->SMTPSecure = 'ssl';
$mail->Port = 465;

$mail->setFrom('', 'Home Builders');
$mail->addReplyTo('', 'Home Builders');

$mail->addAddress('');

$mail->isHTML(true);

$mail->Subject = "Home Builders - Email Verification Code";

$mail->IsHTML(true);
$mail->Body = "
            <html>
            <head>
                <style>
                    body {
                        font-family: 'Arial', sans-serif;
                        line-height: 1.6;
                    }
                    .container {
                        max-width: 600px;
                        margin: 0 auto;
                    }
                    .header {
                        background-color: #f0f0f0;
                        padding: 20px;
                        text-align: center;
                    }
                    .content {
                        padding: 20px;
                    }
                </style>
            </head>
            <body>
                <div class='container'>
                    <div class='header'>
                        <h1>Welcome to Home Builders</h1>
                    </div>
                    <div class='content'>
                        <p>Hi,</p>
                        <p>We received a request to create a new Home Builders account using your email address: <strong>Example@gmail.com</strong>.</p>
                        <p>Your verification code is: <strong>12345678</strong></p>
                    </div>
                </div>
            </body>
            </html>
        ";

if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message has been sent successfully";
}
