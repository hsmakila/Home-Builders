<?php
session_start();

$response = array();

if (isset($_SESSION['user_id'])) {
    include 'config_db.php';

    $user_id = $_SESSION['user_id'];

    $query = "SELECT * FROM Notification WHERE notification_to_user_id = :notification_to_user_id AND notification_read = 0 ORDER BY notification_id DESC";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(':notification_to_user_id', $user_id, PDO::PARAM_STR);

    // Execute the query and check for success
    if ($stmt->execute()) {
        $services = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $response['status'] = 'success';
        $response['data'] = $services;
    } else {
        $response['status'] = 'fail';
        $response['error'] = 'Failed to retrieve notifications.';
    }

    // Close database connection
    $conn = null;
} else {
    $response['status'] = 'fail';
    $response['error'] = 'User not sign in.';
}

// Set the response header
header('Content-Type: application/json');

// Output the JSON response
echo json_encode($response);
