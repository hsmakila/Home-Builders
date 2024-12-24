<?php
include 'config_db.php';

session_start();

$user_id = $_SESSION['user_id'];
$from_id = $_GET['from_id'];

$query = "UPDATE Chat SET seen = 1 WHERE from_id = " . $from_id . " AND to_id = " . $user_id;

$stmt = $conn->prepare($query);
$stmt->execute();


