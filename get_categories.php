<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(array('message' => 'User not logged in'));
    exit;
}

include 'config_db.php';
include 'User.php';

$user_id = $_SESSION['user_id'];
$user = new User();
$user->loadById($user_id);
$type = $user->getType();

$query = "SELECT * FROM category WHERE Main_Category = :user_type";
$stmt = $conn->prepare($query);
$stmt->bindParam(':user_type', $type);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($categories);
