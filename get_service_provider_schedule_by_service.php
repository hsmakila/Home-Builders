<?php
include('config_db.php');
include('Service.php');
include('User.php');

$service_id = $_GET['service_id'];

$service = new Service();
$service->loadById($service_id);

$service_provider = new User();
$service_provider->loadById($service->getServiceProviderId());
$service_provider_id = $service_provider->getId();

$query = "SELECT Job.job_from_date, Job.job_to_date FROM Job
          JOIN Services ON Job.job_service_id = Services.service_id
          JOIN Users ON Services.service_provider_id = Users.user_id
          WHERE Services.service_provider_id = :service_provider_id AND Job.job_status IN ('accepted', 'scheduled', 'ongoing')";

$stmt = $conn->prepare($query);
$stmt->bindParam(':service_provider_id', $service_provider_id, PDO::PARAM_INT);
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($services);
