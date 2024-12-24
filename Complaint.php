<?php

class Complaint {
    private $complaint_id;
    private $complaint_customer_id;
    private $complaint_service_provider_id;
    private $complaint_text;
    private $complaint_date;
    private $complaint_status;


    // Getter and setter methods for each property

    public function getComplaintId() {
        return $this->complaint_id;
    }

    public function getComplaintCustomerId() {
        return $this->complaint_customer_id;
    }

    public function setComplaintCustomerId($complaint_customer_id) {
        $this->complaint_customer_id = $complaint_customer_id;
    }

    public function getComplaintServiceProviderId() {
        return $this->complaint_service_provider_id;
    }

    public function setComplaintServiceProviderId($complaint_service_provider_id) {
        $this->complaint_service_provider_id = $complaint_service_provider_id;
    }

    public function getComplaintText() {
        return $this->complaint_text;
    }

    public function setComplaintText($complaint_text) {
        $this->complaint_text = $complaint_text;
    }

    public function getComplaintDate() {
        return $this->complaint_date;
    }

    public function getComplaintStatus() {
        return $this->complaint_status;
    }

    public function changeComplaintStatus($newStatus) {
        $this->complaint_status = $newStatus;
    }

    public function insert() {
        global $conn;

        $stmt = $conn->prepare("INSERT INTO complaints (complaint_customer_id, complaint_service_provider_id, complaint_text) VALUES (:complaint_customer_id, :complaint_service_provider_id, :complaint_text)");

        $stmt->bindParam(':complaint_customer_id', $this->complaint_customer_id);
        $stmt->bindParam(':complaint_service_provider_id', $this->complaint_service_provider_id);
        $stmt->bindParam(':complaint_text', $this->complaint_text);

        $stmt->execute();

        return $conn->lastInsertId();
    }
}
