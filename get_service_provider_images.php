<?php


$directory = 'service-pic/';
$files = scandir($directory);
$imageFilenames = [];

if (!isset($_GET['service_provider_id'])) {
    session_start();
    if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
        foreach ($files as $file) {
            if (is_file($directory . $file) && strpos($file, 's' . $_SESSION['user_id'] . '_') === 0) {
                $imageFilenames[] = $file;
            }
        }

        header('Content-Type: application/json');
        echo json_encode($imageFilenames);
    }
} else {
    foreach ($files as $file) {
        if (is_file($directory . $file) && strpos($file, 's' . $_GET['service_provider_id'] . '_') === 0) {
            $imageFilenames[] = $file;
        }
    }

    header('Content-Type: application/json');
    echo json_encode($imageFilenames);
}
