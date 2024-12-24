<?php

require_once('config_db.php');
require_once('User.php');

header('Content-Type: application/json');
$response = array(); // Initialize a response array

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $type = $_POST['type'];

    $user = new User();
    $user->loadByEmail($email);

    if ($user->getId() != null) {
        $response['success'] = false;
        $response['message'] = "Email address already registered. Please use a different email.";
    } elseif ($password !== $confirm_password) {
        $response['success'] = false;
        $response['message'] = "Password and Confirm Password do not match. Please try again.";
    } elseif (!isStrongPassword($password)) {
        $response['success'] = false;
        $response['message'] = "Your password must be at least 8 characters long, contain at least one number and have a mixture of uppercase and lowercase letters.";
    } else {
        $user->setEmail($email);
        $user->setPassword($password);
        $user->setType($type);
        $user->signUp();

        $response['success'] = true;
        $response['message'] = "Registration successful.";
    }
}

echo json_encode($response);

function isStrongPassword($password) {
    $minLength = 8;
    $hasUppercase = preg_match('/[A-Z]/', $password);
    $hasLowercase = preg_match('/[a-z]/', $password);
    $hasNumber = preg_match('/\d/', $password);
    $hasSpecialChar = preg_match('/[^A-Za-z0-9]/', $password);

    return strlen($password) >= $minLength && $hasUppercase && $hasLowercase && $hasNumber && $hasSpecialChar;
}
?>
