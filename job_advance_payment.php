<?php
include('config_db.php');
include('Job.php');
include('User.php');
include('Service.php');
include('Notification.php');

$response = array();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $job_id = $_POST['job_id'];

    $job = new Job();
    if ($job->loadById($job_id)) {
        $job->setJobStatus('scheduled');
        if ($job->update()) {
            $response['status'] = 'success';
        } else {
            $response['status'] = 'fail';
            $response['message'] = 'Failed to update job status';
        }

        $customer = new User();
        $customer->loadById($job->getJobCustomerId());

        $service = new Service();
        $service->loadById($job->getJobServiceId());

        $service_provider = new User();
        $service_provider->loadById($service->getServiceProviderId());

        $notification = new Notification();
        $notification->setNotificationFromUserId($customer->getId());
        $notification->setNotificationToUserId($service_provider->getId());
        $notification->setNotificationTitle($customer->getName() . ' had paid advance for ' . $job->getJobTitle() . ' will be hold till job completion');
        $notification->pushNotification();
    }
}

header('Content-Type: application/json');
echo json_encode($response);
