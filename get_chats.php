<?php
include('config_db.php');

session_start();

$user_id = $_SESSION['user_id'];

$query = "SELECT Chat.*, fromUser.name AS from_user_name, toUser.name AS to_user_name FROM Chat
          JOIN Users AS fromUser ON Chat.from_id = fromUser.user_id
          JOIN Users AS toUser ON Chat.to_id = toUser.user_id
          WHERE (Chat.from_id = :user_id OR Chat.to_id = :user_id)
          ORDER BY Chat.date_time";

$stmt = $conn->prepare($query);
$stmt->bindParam(':user_id', $user_id, PDO::PARAM_INT);
$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($services);
