<?php

require_once('config_db.php');
require_once('User.php');

session_start();
if (isset($_SESSION['user_id'])) {
    $user = new User();
    $user->loadById($_SESSION['user_id']);
    if ($user->getId() == null) {
        header("Location: signin.php");
    } else {
        if ($user->getType() == "ADMIN") {
            header("Location: admin_hold_payments.php");
        } elseif ($user->getType() == "CUSTOMER") {
            header("Location: customer_profile.php");
        } elseif (in_array($user->getType(), ["CONSTRUCTOR", "DESIGNER", "SUPPLIER"])) {
            header("Location: service_provider_profile.php");
        } else {
            header("Location: signin.php");
        }
    }
} else {
    header("Location: signin.php");
}
