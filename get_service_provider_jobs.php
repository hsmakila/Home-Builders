<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(array('message' => 'User not logged in'));
    exit;
}

include 'config_db.php';

$user_id = $_SESSION['user_id'];

$query = "SELECT Job.*, Users.name FROM Job
          JOIN Services ON Job.job_service_id = Services.service_id
          JOIN Users ON Job.job_customer_id = Users.user_id
          WHERE Services.service_provider_id = :user_id";

$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($services);
?>
