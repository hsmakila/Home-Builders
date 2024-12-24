<?php
include('config_db.php');

if (isset($_GET['keyword'])) {
    $keyword = $_GET['keyword'];

    $query = "SELECT * FROM FAQ WHERE question LIKE :keyword OR answer LIKE :keyword ORDER BY faq_id DESC LIMIT 50";
    $stmt = $conn->prepare($query);
    $stmt->bindValue(':keyword', '%' . $keyword . '%', PDO::PARAM_STR);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($users);
} else {
    $query = "SELECT * FROM FAQ ORDER BY faq_id DESC LIMIT 5";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);

    header('Content-Type: application/json');
    echo json_encode($users);
}
