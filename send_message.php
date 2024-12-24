<?php
require_once('config_db.php');
require_once('Chat.php');

session_start();

if (isset($_SESSION['user_id']) && !empty($_SESSION['user_id'])) {
    $from_id = $_SESSION['user_id'];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents('php://input'));

        if ($data) {
            $to_id = $data->to_id;
            $message = $data->message;

            $chat = new Chat();
            $chat->setFromId($from_id);
            $chat->setToId($to_id);
            $chat->setMessage($message);

            if ($chat->insert()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => 'Message insertion failed']);
            }
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid JSON data']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid request method']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Sign In to contact service provider!']);
}
