<?php
include('config_db.php');

$filter = isset($_GET['filter']) ? '%' . $_GET['filter'] . '%' : "";
$type = isset($_GET['type']) ? $_GET['type'] : "ALL";
$loc = isset($_GET['loc']) ? (int)$_GET['loc'] : 0;
$minrate = isset($_GET['minrate']) ? (int)$_GET['minrate'] : 0;
$maxrate = isset($_GET['maxrate']) ? (int)$_GET['maxrate'] : 0;

$query = "SELECT * FROM Services
          JOIN Users ON Services.service_provider_id = Users.user_id
          JOIN Category ON Services.category_id = Category.category_id
          JOIN Locations ON Users.location_id = Locations.location_id
          WHERE (Services.Title LIKE '" . $filter . "'
            OR Services.Description LIKE '" . $filter . "'
            OR Users.name LIKE '" . $filter . "'
            OR Category.Main_Category LIKE '" . $filter . "'
            OR Category.Sub_Category LIKE '" . $filter . "') AND Services.is_available = 1";

// Add location filtering if location_id is provided
if ($type != "ALL") {
    $query .= " AND Users.type = '" . $type . "'";
}
if ($loc > 0) {
    $query .= " AND Locations.location_id = " . $loc;
}
if ($minrate > 0) {
    $query .= " AND Services.rate >= " . $minrate;
}
if ($maxrate > 0) {
    $query .= " AND Services.rate <= " . $maxrate;
}

$stmt = $conn->prepare($query);

$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($services);
