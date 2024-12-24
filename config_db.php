<?php
$servername = 'localhost';
$dbUsername = 'root';
$dbPassword = '';
$dbname = 'home_builders';

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $dbUsername, $dbPassword);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
