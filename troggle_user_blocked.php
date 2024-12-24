<?php
require_once('config_db.php');
require_once('User.php');

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $user_id = $_GET['user_id'];

    $user = new User();
    $user->loadById($user_id);
    if ($user->isBlocked()) {
        $user->unblock();
    } else {
        $user->block();
    }

    header("Location: admin_user_profile.php");
}
