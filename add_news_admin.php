<?php
require_once('config_db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"];
    $description = $_POST["description"];

    $stmt = $conn->prepare("INSERT INTO News (title, description, added_date) VALUES (?, ?, NOW())");
    $stmt->execute([$title, $description]);

    $lastInsertId = $conn->lastInsertId();

    $uploadDirectory = 'news-pic/';

    $imageFilename = 'n' . $lastInsertId . '.jpg';

    $destinationPath = $uploadDirectory . $imageFilename;

    move_uploaded_file($_FILES['image']['tmp_name'], $destinationPath);
}
