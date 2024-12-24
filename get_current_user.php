<?php

require_once('config_db.php');
require_once('User.php');
require_once('Location.php');

$response = array();

header('Content-Type: application/json');
session_start();

// Check if the user is logged in
if (isset($_SESSION['user_id'])) {
    $user = new User();
    $user->loadById($_SESSION['user_id']);
    
    // Check if user data was successfully loaded
    if ($user->getId() != null) {
        $response['success'] = true;
        $response['id'] = $user->getId();
        $response['email'] = $user->getEmail();
        $response['name'] = $user->getName();
        $response['type'] = $user->getType();
        $response['phone'] = $user->getPhone();
        $response['description'] = $user->getDescription();
        $location = new Location();
        $location->loadById($user->getLocationId());
        $response['location_id'] = $location->getId();
        $response['location_name'] = $location->getLocationName();
    } else {
        $response['success'] = false;
        $response['error'] = 'User data could not be loaded.';
    }
} else {
    $response['success'] = false;
    $response['error'] = 'User is not logged in.';
}

echo json_encode($response);
