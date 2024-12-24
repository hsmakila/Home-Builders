<?php
include 'config_db.php';

$notification_id = $_GET['notification_id'];

$query = "UPDATE Notification SET notification_read = 1 WHERE notification_id = " . $notification_id;

$stmt = $conn->prepare($query);
$stmt->execute();


