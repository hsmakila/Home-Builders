<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SESSION['user_id'])) {
    require_once('config_db.php');
    require_once('Complaint.php');

    $customer_id = $_SESSION['user_id'];
    $service_provider_id = $_POST['service_provider_id'];
    $complaint_text = $_POST['complaint'];

    $complaint = new Complaint();
    $complaint->setComplaintCustomerId($customer_id);
    $complaint->setComplaintServiceProviderId($service_provider_id);
    $complaint->setComplaintText($complaint_text);

    $complaint_id = $complaint->insert();

    if (isset($_FILES['complaintImage']) && $_FILES['complaintImage']['error'] == UPLOAD_ERR_OK) {
        $targetDir = 'complaints-pic/';
        $targetFile = $targetDir . 'c' . $complaint_id . '.jpg';
        move_uploaded_file($_FILES['complaintImage']['tmp_name'], $targetFile);
    }

    if ($complaint_id > 0) {
        $response = array('status' => 'success', 'message' => 'Complaint submitted successfully');
        echo json_encode($response);
        exit();
    } else {
        $response = array('status' => 'error', 'message' => 'Error submitting complaint. Please try again.');
        echo json_encode($response);
        exit();
    }
} else {
    $response = array('status' => 'error', 'message' => 'Invalid request');
    echo json_encode($response);
    exit();
}
