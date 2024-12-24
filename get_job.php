<?php
include 'config_db.php';

if (isset($_GET['job_id'])) {
    $job_id = $_GET['job_id'];
    
    $query = "SELECT Job.*, Users.name FROM Job
              JOIN Services ON Job.job_service_id = Services.service_id
              JOIN Users ON Job.job_customer_id = Users.user_id
              WHERE Job.job_id = :job_id";
    
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':job_id', $job_id, PDO::PARAM_INT);
    $stmt->execute();
    $service = $stmt->fetch(PDO::FETCH_ASSOC);
    
    header('Content-Type: application/json');
    echo json_encode($service);
}
