<?php
include('config_db.php');

$query = 'SELECT Complaints.*, Customer.email AS customer_email, ServiceProvider.email AS service_provider_email FROM Complaints 
JOIN Users AS Customer ON Customer.user_id = Complaints.complaint_customer_id
JOIN Users AS ServiceProvider ON ServiceProvider.user_id = Complaints.complaint_service_provider_id
WHERE complaint_status != "closed" ORDER BY complaint_date LIMIT 20';

$stmt = $conn->prepare($query);
$stmt->execute();
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($users);
