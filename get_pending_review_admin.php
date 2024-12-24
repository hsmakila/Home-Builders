<?php
include('config_db.php');

$query = 'SELECT * FROM Job 
JOIN Services ON Services.service_id = Job.job_service_id
JOIN Users ON Users.user_id = Job.job_customer_id
WHERE job_status = "done" AND job_customer_rating is NULL ORDER BY job_to_date LIMIT 5';
$stmt = $conn->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($users);
