<?php
session_start();
if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_FILES["image"])) {
        $uploadDirectory = "service-pic/";
        $uploadedFile = $_FILES["image"];

        if ($uploadedFile["error"] === UPLOAD_ERR_OK) {
            $currentDateTime = date("Y-m-d_His");

            $fileName = $uploadDirectory . "s" . $_SESSION['user_id'] . "_" . $currentDateTime . "_" . basename($uploadedFile["name"]);

            if (move_uploaded_file($uploadedFile["tmp_name"], $fileName)) {
                echo json_encode(["success" => true]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to move the uploaded file."]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Upload error: " . $uploadedFile["error"]]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid request."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "User not sign in."]);
}
