<?php
include('config_db.php');
include('Service.php');

if (isset($_GET['service_id'])) {
    $serviceId = $_GET['service_id'];

    $service = new Service();
    $service->loadById($serviceId);
    $service->deleteService();
    header("Location: profile.php");
}
