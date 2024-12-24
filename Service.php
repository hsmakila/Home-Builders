<?php

class Service {
    private $id;
    private $service_provider_id;
    private $category_id;
    private $title;
    private $description;
    private $rate;
    private $unit;
    private $is_available;

    // Getter and Setter for id
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    // Getter and Setter for ServiceProviderId
    public function getServiceProviderId() {
        return $this->service_provider_id;
    }

    public function setServiceProviderId($service_provider_id) {
        $this->service_provider_id = $service_provider_id;
    }

    // Getter and Setter for CategoryId
    public function getCategoryId() {
        return $this->category_id;
    }

    public function setCategoryId($category_id) {
        $this->category_id = $category_id;
    }

    // Getter and Setter for Title
    public function getTitle() {
        return $this->title;
    }

    public function setTitle($title) {
        $this->title = $title;
    }

    // Getter and Setter for Description
    public function getDescription() {
        return $this->description;
    }

    public function setDescription($description) {
        $this->description = $description;
    }

    // Getter and Setter for Rate
    public function getRate() {
        return $this->rate;
    }

    public function setRate($rate) {
        $this->rate = $rate;
    }

    public function getUnit() {
        return $this->unit;
    }

    public function setUnit($unit) {
        $this->unit = $unit;
    }

    // Getter and Setter for Rate
    public function getIsAvailable() {
        return $this->is_available;
    }

    public function setIsAvailable($is_available) {
        $this->is_available = $is_available;
    }

    public function addService() {
        global $conn;
        $stmt = $conn->prepare("INSERT INTO Services (service_provider_id, category_id, title, description, rate, unit, is_available) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$this->service_provider_id, $this->category_id, $this->title, $this->description, $this->rate, $this->unit, $this->is_available]);
    }

    public function loadById($id) {
        global $conn;
        $stmt = $conn->prepare("SELECT * FROM Services WHERE service_id = ?");
        $stmt->execute([$id]);
        $service = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($service) {
            $this->id = $service['service_id'];
            $this->service_provider_id = $service['service_provider_id'];
            $this->category_id = $service['category_id'];
            $this->title = $service['title'];
            $this->description = $service['description'];
            $this->rate = $service['rate'];
            $this->unit = $service['unit'];
            $this->is_available = $service['is_available'];
            return true;
        } else {
            return false;
        }
    }

    public function deleteService() {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM Services WHERE service_id = ?");
        $stmt->execute([$this->id]);
    }

    public function toggleAvailable() {
        $this->is_available = !$this->is_available;
    }

    public function update() {
        global $conn;
        $stmt = $conn->prepare("UPDATE Services SET service_provider_id = ?, category_id = ?, title = ?, description = ?, rate = ?, unit = ?, is_available = ? WHERE service_id = ?");

        $stmt->execute([
            $this->service_provider_id,
            $this->category_id,
            $this->title,
            $this->description,
            $this->rate,
            $this->unit,
            $this->is_available,
            $this->id
        ]);
    }
}
