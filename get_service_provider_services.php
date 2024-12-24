<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(array('message' => 'User not logged in'));
    exit;
}

include 'config_db.php';

$user_id = $_SESSION['user_id'];

$query = "SELECT Services.service_id, Services.title, Services.description, Services.rate, Services.unit, Services.is_available, Category.main_category, Category.sub_category 
          FROM Services 
          INNER JOIN Category ON Services.category_id = Category.category_id
          WHERE Services.service_provider_id = :user_id";

$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($services);
?>
