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
    $job->setJobStatus('cancelled');
    $job->update();

    $service = new Service();
    $service->loadById($job->getJobServiceId());

    $service_provider = new User();
    $service_provider->loadById($service->getServiceProviderId());

    $notification_to_customer = new Notification();
    $notification_to_customer->setNotificationFromUserId(1);
    $notification_to_customer->setNotificationToUserId($job->getJobCustomerId());
    $notification_to_customer->setNotificationTitle($job->getJobTitle() . ' has been cancelled by the admin and your advance payment will be return within 3 working days');
    $notification_to_customer->pushNotification();

    $notification_to_service_provider = new Notification();
    $notification_to_service_provider->setNotificationFromUserId(1);
    $notification_to_service_provider->setNotificationToUserId($service_provider->getId());
    $notification_to_service_provider->setNotificationTitle($job->getJobTitle() . ' has been cancelled by the admin and advance payment will return to the customer');
    $notification_to_service_provider->pushNotification();

    echo json_encode(['status' => 'success', 'message' => 'Job cancelled']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
