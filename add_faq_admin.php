<?php
require_once('config_db.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $question = $_POST["question"];
    $answer = $_POST["answer"];

    $stmt = $conn->prepare("INSERT INTO FAQ (question, answer, date_created) VALUES (?, ?, NOW())");
    $stmt->execute([$question, $answer]);
}
