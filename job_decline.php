<?php
require_once('config_db.php');
require_once('Job.php');
require_once('Notification.php');
require_once('Service.php');
require_once('User.php');

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $job_id = $_GET['job_id'];

    $job = new Job();
    $job->loadById($job_id);
    $job->setJobStatus('declined');
    $job->update();

    $service = new Service();
    $service->loadById($job->getJobServiceId());

    $service_provider = new User();
    $service_provider->loadById($service->getServiceProviderId());
    
    $notification = new Notification();
    $notification->setNotificationFromUserId($service_provider->getId());
    $notification->setNotificationToUserId($job->getJobCustomerId());
    $notification->setNotificationTitle($service_provider->getName().' has decilend your request for ' . $job->getJobTitle());
    $notification->pushNotification();

    header("Location: profile.php");
}
