<?php
$response = array();

session_start();
if (isset($_SESSION['user_id'])) {
    include 'config_db.php';

    $user_id = $_SESSION['user_id'];

    $query = "SELECT * FROM Chat WHERE to_id = :user_id AND seen = 0 LIMIT 1";

    $stmt = $conn->prepare($query);
    $stmt->bindParam(":user_id", $user_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $response = array("status" => true);
    } else {
        $response = array("status" => false);
    }
} else {
    $response = array("status" => false);
}

header('Content-Type: application/json');

echo json_encode($response);
