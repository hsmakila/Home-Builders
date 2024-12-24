<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Include library files 
require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

class User {
    private $id;
    private $email;
    private $password;
    private $type;
    private $name;
    private $phone;
    private $description;
    private $location_id;
    private $verification_code;
    private $verified;
    private $blocked;
    private $reset_token;

    // Getter and Setter for id
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    // Getter and Setter for email
    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    // Getter and Setter for password
    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = $password;
    }

    // Getter and Setter for name
    public function getName() {
        return $this->name;
    }

    public function setName($name) {
        $this->name = $name;
    }

    // Getter and Setter for type
    public function getType() {
        return $this->type;
    }

    public function setType($type) {
        $this->type = $type;
    }

    // Getter and Setter for phone
    public function getPhone() {
        return $this->phone;
    }

    public function setPhone($phone) {
        $this->phone = $phone;
    }

    // Getter and Setter for description
    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    // Getter and Setter for location
    public function getLocationId() {
        return $this->location_id;
    }

    public function setLocationId($location_id) {
        $this->location_id = $location_id;
    }

    public function getVerificationCode() {
        return $this->verification_code;
    }

    public function setVerificationCode($verification_code) {
        $this->verification_code = $verification_code;
    }

    public function isVerified() {
        return $this->verified;
    }

    public function setBlocked($blocked) {
        $this->blocked = $blocked;
    }

    public function isBlocked() {
        return $this->blocked;
    }

    public function getResetToken() {
        return $this->reset_token;
    }

    public function setResetToken($reset_token) {
        $this->reset_token = $reset_token;
    }

    public function verify() {
        $this->verified = true;
        global $conn;
        $stmt = $conn->prepare("UPDATE Users SET verified = ? WHERE user_id = ?");
        $stmt->execute([true, $this->id]);
    }

    public function block() {
        $this->blocked = true;
        global $conn;
        $stmt = $conn->prepare("UPDATE Users SET blocked = ? WHERE user_id = ?");
        $stmt->execute([true, $this->id]);
    }

    public function unblock() {
        $this->blocked = false;
        global $conn;
        $stmt = $conn->prepare("UPDATE Users SET blocked = ? WHERE user_id = ?");
        $stmt->execute([false, $this->id]);
    }

    public function signUp() {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO Users (email, password, type) VALUES (?, ?, ?)");
        $stmt->execute([$this->email, $this->password, $this->type]);
    }

    public function signIn() {
        session_start();
        $_SESSION['user_id'] = $this->id;
    }

    public function loadByEmail($email) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM Users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $this->id = $user['user_id'];
            $this->email = $user['email'];
            $this->password = $user['password'];
            $this->type = $user['type'];
            $this->name = $user['name'];
            $this->phone = $user['phone'];
            $this->description = $user['description'];
            $this->location_id = $user['location_id'];
            $this->verification_code = $user['verification_code'];
            $this->verified = $user['verified'];
            $this->blocked = $user['blocked'];
            $this->reset_token = $user['reset_token'];
            return true;
        } else {
            return false;
        }
    }

    public function loadById($id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM Users WHERE user_id = ?");
        $stmt->execute([$id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            $this->id = $user['user_id'];
            $this->email = $user['email'];
            $this->password = $user['password'];
            $this->type = $user['type'];
            $this->name = $user['name'];
            $this->phone = $user['phone'];
            $this->description = $user['description'];
            $this->location_id = $user['location_id'];
            $this->verification_code = $user['verification_code'];
            $this->verified = $user['verified'];
            $this->blocked = $user['blocked'];
            $this->reset_token = $user['reset_token'];
            return true;
        } else {
            return false;
        }
    }

    public function update() {
        global $conn;
        $stmt = $conn->prepare("UPDATE Users SET name = ?, phone = ?, description = ?, location_id = ?, password = ? WHERE user_id = ?");
        $stmt->execute([$this->name, $this->phone, $this->description, $this->location_id, $this->password, $this->id]);
    }

    public function sendVerificationCode() {
        $verificationCode = mt_rand(100000, 999999);
        $this->setVerificationCode($verificationCode);
        global $conn;
        $stmt = $conn->prepare("UPDATE Users SET verification_code = ? WHERE user_id = ?");
        $stmt->execute([$this->verification_code, $this->id]);

        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'buildersh67@gmail.com';
        $mail->Password = 'rkcv aoog vpau ajbp';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('buildersh67@gmail.com', 'Home Builders');
        $mail->addReplyTo('buildersh67@gmail.com', 'Home Builders');

        $mail->addAddress($this->email);

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
                        <p>We received a request to create a new Home Builders account using your email address: <strong>" . $this->getEmail() . "</strong>.</p>
                        <p>Your verification code is: <strong>" . $this->getVerificationCode() . "</strong></p>
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
    }

    public function sendResetToken() {
        $token = bin2hex(random_bytes(32));
        $this->setResetToken($token);

        global $conn;
        $stmt = $conn->prepare("UPDATE Users SET reset_token = ? WHERE user_id = ?");
        $stmt->execute([$token, $this->id]);

        $mail = new PHPMailer;

        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'buildersh67@gmail.com';
        $mail->Password = 'rkcv aoog vpau ajbp';
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465;

        $mail->setFrom('buildersh67@gmail.com', 'Home Builders');
        $mail->addReplyTo('buildersh67@gmail.com', 'Home Builders');

        $mail->addAddress($this->email);

        $mail->isHTML(true);

        $mail->Subject = "Home Builders - Password Reset";

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
                        <p>We received a request to reset your password of the account using your email address: <strong>" . $this->getEmail() . "</strong>.</p>
                        <p>Click on this link to reset: <strong>http://localhost/home_builders/reset_password.php?email=" . $this->getEmail() . "&token=" . $token . "</strong></p>
                    </div>
                </div>
            </body>
            </html>
        ";

        if (!$mail->send()) {
            return false;
        } else {
            return true;
        }
    }
}
