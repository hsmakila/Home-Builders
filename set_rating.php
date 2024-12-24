<?php

require_once('config_db.php');
require_once('Job.php');
require_once('Notification.php');
require_once('User.php');
require_once('Service.php');

session_start();
$customer_id = $_SESSION['user_id'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $job_id = $_GET['job_id'];
    $rating = $_GET['rating'];
    $comment = $_GET['comment'];

    $job = new Job();
    $job->loadById($job_id);
    $job->setJobCustomerRating($rating);
    $job->setJobCustomerFeedback($comment);
    $job->update();

    $service = new Service();
    $service->loadById($job->getJobServiceId());

    $service_provider = new User();
    $service_provider->loadById($service->getServiceProviderId());

    $notification = new Notification();
    $notification->setNotificationFromUserId($customer_id);
    $notification->setNotificationToUserId($service_provider->getId());
    $notification->setNotificationTitle($job->getJobTitle() . ' has rated with ' . $rating . ' and with a comment: ' . $comment . ' and your advance paymment will be deposit into your account.');
    $notification->pushNotification();

    echo json_encode(['status' => 'success', 'message' => 'Feedback submitted successfully']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
