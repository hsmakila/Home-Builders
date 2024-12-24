<?php
require_once('config_db.php');
require_once('Job.php');
require_once('User.php');
require_once('Notification.php');

session_start();
if (isset($_SESSION['user_id'])) {
    $service_provider_id = $_SESSION['user_id'];
    $service_provider = new User();
    $service_provider->loadById($service_provider_id);
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $job_id = $_GET['job_id'];

        $job = new Job();
        $job->loadById($job_id);
        $job->setJobStatus('done');
        $job->update();

        $notification = new Notification();
        $notification->setNotificationFromUserId($service_provider->getId());
        $notification->setNotificationToUserId($job->getJobCustomerId());
        $notification->setNotificationTitle('"' . $job->getJobTitle() . '" job mark as completed by ' . $service_provider->getName());
        $notification->pushNotification();

        header("Location: profile.php");
    }
} else {
    header("Location: signin.php");
}