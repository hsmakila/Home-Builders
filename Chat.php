<?php

class Chat {
    private $chat_id;
    private $from_id;
    private $to_id;
    private $message;
    private $date_time;
    private $seen;

    public function getChatId() {
        return $this->chat_id;
    }

    public function setChatId($chat_id) {
        $this->chat_id = $chat_id;
    }

    public function getFromId() {
        return $this->from_id;
    }

    public function setFromId($from_id) {
        $this->from_id = $from_id;
    }

    public function getToId() {
        return $this->to_id;
    }

    public function setToId($to_id) {
        $this->to_id = $to_id;
    }

    public function getMessage() {
        return $this->message;
    }

    public function setMessage($message) {
        $this->message = $message;
    }

    public function getDateTime() {
        return $this->date_time;
    }

    public function setDateTime($date_time) {
        $this->date_time = $date_time;
    }

    public function getSeen() {
        return $this->seen;
    }

    public function setSeen($seen) {
        $this->seen = $seen;
    }

    public function insert() {
        global $conn;

        $stmt = $conn->prepare("INSERT INTO Chat (from_id, to_id, message, date_time, seen) 
                  VALUES (:from_id, :to_id, :message, NOW(), 0)");

        $stmt->bindParam(':from_id', $this->from_id);
        $stmt->bindParam(':to_id', $this->to_id);
        $stmt->bindParam(':message', $this->message);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
