<?php
require_once('config_db.php');
require_once('User.php');

header('Content-Type: application/json');
$response = array();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];

    $user = new User();
    if ($user->loadByEmail($email)) {
        $user->sendResetToken();
        $response = ['success' => true, 'message' => 'Password reset link sent to your email.'];
    } else {
        $response = ['success' => false, 'message' => 'Email not registered.'];
    }
} else {
    $response = ['success' => false, 'message' => 'Invalid request method.'];
}

echo json_encode($response);