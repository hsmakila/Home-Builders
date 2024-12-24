<?php
include('config_db.php');

$rooms = isset($_GET['rooms']) ? (int)$_GET['rooms'] : 0;
$bathrooms = isset($_GET['bathrooms']) ? (int)$_GET['bathrooms'] : 0;
$floors = isset($_GET['floors']) ? (int)$_GET['floors'] : 0;
$minarea = isset($_GET['minarea']) ? (int)$_GET['minarea'] : 0;
$maxarea = isset($_GET['maxarea']) ? (int)$_GET['maxarea'] : 0;
$minprice = isset($_GET['minprice']) ? (int)$_GET['minprice'] : 0;
$maxprice = isset($_GET['maxprice']) ? (int)$_GET['maxprice'] : 0;

$query = "SELECT Home_Design.*, Users.name FROM Home_Design
          JOIN Services ON Home_Design.Home_Design_service_id = Services.service_id
          JOIN Users ON Services.service_provider_id = Users.user_id
          WHERE 1";

// Add location filtering if location_id is provided
if ($rooms > 0) {
    $query .= " AND home_design_no_of_rooms = " . $rooms;
}
if ($bathrooms > 0) {
    $query .= " AND home_design_no_of_bathrooms = " . $bathrooms;
}
if ($floors > 0) {
    $query .= " AND home_design_no_of_floors = " . $floors;
}
if ($minarea > 0) {
    $query .= " AND home_design_area >= " . $minarea;
}
if ($maxarea > 0) {
    $query .= " AND home_design_area <= " . $maxarea;
}
if ($minprice > 0) {
    $query .= " AND home_design_price >= " . $minprice;
}
if ($maxprice > 0) {
    $query .= " AND home_design_price <= " . $maxprice;
}

$query .= " LIMIT 100";

$stmt = $conn->prepare($query);

$stmt->execute();
$services = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Content-Type: application/json');
echo json_encode($services);
