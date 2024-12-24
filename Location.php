<?php

class Location {
    private $location_id;
    private $location_name;

    // Getter and Setter for id
    public function getId() {
        return $this->location_id;
    }

    public function setId($location_id) {
        $this->location_id = $location_id;
    }

    // Getter and Setter for location
    public function getLocationName() {
        return $this->location_name;
    }

    public function setLocationName($location_name) {
        $this->location_name = $location_name;
    }

    public function loadById($location_id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM Locations WHERE location_id = ?");
        $stmt->execute([$location_id]);
        $location = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($location) {
            $this->location_id = $location['location_id'];
            $this->location_name = $location['location'];
            return true;
        } else {
            return false;
        }
    }
}
