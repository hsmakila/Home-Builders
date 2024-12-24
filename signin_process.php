<?php

require_once('config_db.php');
require_once('User.php');

header('Content-Type: application/json');
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $user = new User();
    if ($user->loadByEmail($email)) {
        if ($user->isBlocked()) {
            $response['success'] = false;
            $response['message'] = "User blocked.";
        } else if (!$user->isVerified()) {
            $response['success'] = false;
            $response['message'] = "Not verified.";
            $response["user_id"] = $user->getId();
        } else if ($password == $user->getPassword()) {
            $user->signIn();
            $response['success'] = true;
            $response['message'] = "Signed in successfully.";
        } else {
            $response['success'] = false;
            $response['message'] = "Incorrect Password.";
        }
    } else {
        $response['success'] = false;
        $response['message'] = "Email is not registered yet.";
    }
}

echo json_encode($response);
