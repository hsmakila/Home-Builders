<?php
include 'config_db.php';

session_start();

$user_id = $_SESSION['user_id'];

$query = "SELECT Job.*, Users.name FROM Job
          JOIN Services ON Job.job_service_id = Services.service_id
          JOIN Users ON Services.service_provider_id = Users.user_id
          WHERE Job.job_customer_id = :user_id";

$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($services);



