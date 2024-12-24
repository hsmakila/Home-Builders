<?php
include('config_db.php');

$keyword = $_POST['keyword'];

$query = "SELECT * FROM faq WHERE Question LIKE :keyword";

$stmt = $conn->prepare($query);
$keywordWithWildcards = '%' . $keyword . '%';
$stmt->bindParam(':keyword', $keywordWithWildcards, PDO::PARAM_STR);
$stmt->execute();
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);

header("Content-Type: application/json");
echo json_encode($results);
?>