<?php
class Notification {
    private $notification_id;
    private $notification_from_user_id;
    private $notification_to_user_id;
    private $notification_title;
    private $notification_description;
    private $notification_read;

    // Getters
    public function getNotificationId() {
        return $this->notification_id;
    }

    public function getNotificationFromUserId() {
        return $this->notification_from_user_id;
    }

    public function getNotificationToUserId() {
        return $this->notification_to_user_id;
    }

    public function getNotificationTitle() {
        return $this->notification_title;
    }

    public function getNotificationDescription() {
        return $this->notification_description;
    }

    public function isNotificationRead() {
        return $this->notification_read;
    }

    // Setters
    public function setNotificationId($notification_id) {
        $this->notification_id = $notification_id;
    }

    public function setNotificationFromUserId($notification_from_user_id) {
        $this->notification_from_user_id = $notification_from_user_id;
    }

    public function setNotificationToUserId($notification_to_user_id) {
        $this->notification_to_user_id = $notification_to_user_id;
    }

    public function setNotificationTitle($notification_title) {
        $this->notification_title = $notification_title;
    }

    public function setNotificationDescription($notification_description) {
        $this->notification_description = $notification_description;
    }

    public function setNotificationRead($notification_read) {
        $this->notification_read = $notification_read;
    }

    public function pushNotification() {
        global $conn;

        $stmt = $conn->prepare("INSERT INTO Notification (notification_from_user_id, notification_to_user_id, notification_title)
                VALUES (:notification_from_user_id, :notification_to_user_id, :notification_title)");

        $stmt->bindParam(':notification_from_user_id', $this->notification_from_user_id);
        $stmt->bindParam(':notification_to_user_id', $this->notification_to_user_id);
        $stmt->bindParam(':notification_title', $this->notification_title);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function readNotification() {
        $this->notification_read = true;
    }
}
