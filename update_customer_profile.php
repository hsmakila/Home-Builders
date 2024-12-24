<?php

require_once('config_db.php');
require_once('User.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_id'])) {
        $user = new User();
        $user->loadById($_SESSION['user_id']);

        $name = $_POST["name"];
        $phone = $_POST["phone"];

        $user->setName($name);
        $user->setPhone($phone);
        $user->update();

        if ($_FILES["profilePic"]["error"] == UPLOAD_ERR_OK) {
            $uploadDir = "profile-pic/";
            $uploadFile = $uploadDir . "p" . $user->getId() . ".jpg";

            $allowedTypes = ["jpg", "jpeg", "png"];
            $fileType = strtolower(pathinfo($uploadFile, PATHINFO_EXTENSION));

            if (in_array($fileType, $allowedTypes)) {
                move_uploaded_file($_FILES["profilePic"]["tmp_name"], $uploadFile);
            }
        }

        header("Location: profile.php");
    } else {
        header("Location: signup.php");
    }
}
