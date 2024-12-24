<?php
$response = array();

session_start();
if (isset($_SESSION['user_id'])) {
    include('config_db.php');

    $user_id = $_SESSION['user_id'];

    $query = "SELECT * FROM Notification WHERE notification_to_user_id = " . $user_id . " AND notification_read = 0 LIMIT 1";

    $stmt = $conn->prepare($query);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $response = array("newNotifications" => true);
    } else {
        $response = array("newNotifications" => false);
    }
} else {
    $response = array("newNotifications" => false);
}

header('Content-Type: application/json');
echo json_encode($response);
