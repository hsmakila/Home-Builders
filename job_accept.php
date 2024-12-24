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
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $job_id = $_POST['job_id'];
        $startDate = $_POST['startDate'];
        $endDate = $_POST['endDate'];
        $estimate = $_POST['estimate'];

        $job = new Job();
        $job->loadById($job_id);
        $job->setJobFromDate($startDate);
        $job->setJobToDate($endDate);
        $job->setJobEstimation($estimate);
        $job->setJobStatus('accepted');
        $job->update();

        $notification = new Notification();
        $notification->setNotificationFromUserId($service_provider->getId());
        $notification->setNotificationToUserId($job->getJobCustomerId());
        $notification->setNotificationTitle($job->getJobTitle() . ' has accepted by ' . $service_provider->getName() . ' with estimate: ' . $job->getJobEstimation());
        $notification->pushNotification();

        header("Location: profile.php");
    }
} else {
    header("Location: signin.php");
}
