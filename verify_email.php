<?php

require_once('config_db.php');
require_once('User.php');

header('Content-Type: application/json'); // Set the response content type to JSON

$response = array(); // Initialize a response array

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['user_id']) && isset($_POST['verification_code'])) {
        $user_id = filter_var($_POST['user_id'], FILTER_SANITIZE_NUMBER_INT);
        $verification_code = filter_var($_POST['verification_code'], FILTER_SANITIZE_STRING);

        $user = new User();
        $user->loadById($user_id);

        if ($user->getVerificationCode() == $verification_code) {
            $user->verify();
            $response['success'] = true;
            $response['message'] = "Email verification successful";
        } else {
            $response['success'] = false;
            $response['message'] = "Invalid verification code";
        }

    } else {
        $response['success'] = false;
        $response['message'] = "Invalid request";
    }
} else {
    $response['success'] = false;
    $response['message'] = "Invalid request method";
}

// Send the JSON response
echo json_encode($response);
