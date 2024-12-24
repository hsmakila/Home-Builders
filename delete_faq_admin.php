<?php
require_once('config_db.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $faq_id = $_GET['faq_id'];
    $stmt = $conn->prepare("DELETE FROM FAQ WHERE faq_id = ?");
    $stmt->execute([$faq_id]);

    header("Location: admin_faq.php");
}
