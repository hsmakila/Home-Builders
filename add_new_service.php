<?php

require_once('config_db.php');
require_once('User.php');
require_once('Service.php');

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_SESSION['user_id'])) {
        $user = new User();
        $user->loadById($_SESSION['user_id']);

        $category = $_POST["category"];
        $title = $_POST["title"];
        $description = $_POST["description"];
        $rate = $_POST["rate"];
        $unit = $_POST["unit"];

        $service = new Service();
        $service->setServiceProviderId($user->getId());
        $service->setCategoryId($category);
        $service->setTitle($title);
        $service->setDescription($description);
        $service->setRate($rate);
        $service->setUnit($unit);
        $service->setIsAvailable(true);
        $service->addService();

        header("Location: profile.php");
    } else {
        header("Location: signin.php");
    }
}
