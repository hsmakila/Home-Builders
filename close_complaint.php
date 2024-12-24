<?php
include_once('config_db.php');
include_once('Complaint.php');

if (isset($_GET['complaint_id'])) {
    $complaint_id = $_GET['complaint_id'];

    $stmt = $conn->prepare("UPDATE complaints SET complaint_status = :newStatus WHERE complaint_id = :complaintId");

    $newStatus = 'closed';
    $stmt->bindParam(':newStatus', $newStatus, PDO::PARAM_STR);
    $stmt->bindParam(':complaintId', $complaint_id, PDO::PARAM_INT);

    $stmt->execute();

    header("Location: admin_complaint.php");
}
