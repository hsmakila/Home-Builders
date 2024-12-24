<?php
require_once('config_db.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $news_id = $_GET['news_id'];
    $stmt = $conn->prepare("DELETE FROM News WHERE news_id = ?");
    $stmt->execute([$news_id]);

    header("Location: admin_news.php");
}
