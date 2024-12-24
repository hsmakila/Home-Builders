<?php
require_once('config_db.php');
require_once('Job.php');
require_once('Notification.php');
require_once('Service.php');
require_once('User.php');

session_start();
if (isset($_SESSION['user_id'])) {
    $customer_id = $_SESSION['user_id'];
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $service_id = $_POST['service_id'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $required_date = $_POST['required_date'];

        $job = new Job();
        $job->setJobServiceId($service_id);
        $job->setJobCustomerId($customer_id);
        $job->setJobTitle($title);
        $job->setJobDescription($description);
        $job->setJobStatus('new');
        $job->setJobRequiredDate($required_date);
        $job->insertJob();

        $service = new Service();
        $service->loadById($job->getJobServiceId());

        $customer = new User();
        $customer->loadById($customer_id);

        $notification = new Notification();
        $notification->setNotificationFromUserId($customer_id);
        $notification->setNotificationToUserId($service->getServiceProviderId());
        $notification->setNotificationTitle($customer->getName() . ' has sent a request for '. $service->getTitle());
        $notification->pushNotification();

        header("Location: profile.php");
    }
} else {
    header("Location: signin.php");
}
