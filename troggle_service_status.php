<?php
include_once('config_db.php');
include_once('Service.php');

if (isset($_GET['service_id'])) {
    $serviceId = $_GET['service_id'];

    $service = new Service();
    $service->loadById($serviceId);
    $service->toggleAvailable();
    $service->update();

    header("Location: profile.php");
}

