<?php
class Job {
    private $job_id;
    private $job_customer_id;
    private $job_service_id;
    private $job_title;
    private $job_description;
    private $job_quantity;
    private $job_required_date;
    private $job_from_date;
    private $job_to_date;
    private $job_estimation;
    private $job_advance_paid;
    private $job_status;
    private $job_customer_rating;
    private $job_customer_feedback;

    public function getJobId() {
        return $this->job_id;
    }

    public function setJobId($job_id) {
        $this->job_id = $job_id;
    }

    public function getJobCustomerId() {
        return $this->job_customer_id;
    }

    public function setJobCustomerId($job_customer_id) {
        $this->job_customer_id = $job_customer_id;
    }

    public function getJobServiceId() {
        return $this->job_service_id;
    }

    public function setJobServiceId($job_service_id) {
        $this->job_service_id = $job_service_id;
    }

    public function getJobTitle() {
        return $this->job_title;
    }

    public function setJobTitle($job_title) {
        $this->job_title = $job_title;
    }

    public function getJobDescription() {
        return $this->job_description;
    }

    public function setJobDescription($job_description) {
        $this->job_description = $job_description;
    }

    public function getJobQuantity() {
        return $this->job_quantity;
    }

    public function setJobQuantity($job_quantity) {
        $this->job_quantity = $job_quantity;
    }

    public function getJobRequiredDate() {
        return $this->job_required_date;
    }

    public function setJobRequiredDate($job_required_date) {
        $this->job_required_date = $job_required_date;
    }

    public function getJobFromDate() {
        return $this->job_from_date;
    }

    public function setJobFromDate($job_from_date) {
        $this->job_from_date = $job_from_date;
    }

    public function getJobToDate() {
        return $this->job_to_date;
    }

    public function setJobToDate($job_to_date) {
        $this->job_to_date = $job_to_date;
    }

    public function getJobEstimation() {
        return $this->job_estimation;
    }

    public function setJobEstimation($job_estimation) {
        $this->job_estimation = $job_estimation;
    }

    public function getJobAdvancePaid() {
        return $this->job_advance_paid;
    }

    public function setJobAdvancePaid($job_advance_paid) {
        $this->job_advance_paid = $job_advance_paid;
    }

    public function getJobStatus() {
        return $this->job_status;
    }

    public function setJobStatus($job_status) {
        $this->job_status = $job_status;
    }

    public function getJobCustomerRating() {
        return $this->job_customer_rating;
    }

    public function setJobCustomerRating($job_customer_rating) {
        $this->job_customer_rating = $job_customer_rating;
    }

    public function getJobCustomerFeedback() {
        return $this->job_customer_feedback;
    }

    public function setJobCustomerFeedback($job_customer_feedback) {
        $this->job_customer_feedback = $job_customer_feedback;
    }

    public function loadById($job_id) {
        global $conn;

        $stmt = $conn->prepare("SELECT * FROM Job WHERE job_id = ?");
        $stmt->execute([$job_id]);

        $job = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($job) {
            $this->job_id = $job['job_id'];
            $this->job_customer_id = $job['job_customer_id'];
            $this->job_service_id = $job['job_service_id'];
            $this->job_title = $job['job_title'];
            $this->job_description = $job['job_description'];
            $this->job_quantity = $job['job_quantity'];
            $this->job_required_date = $job['job_required_date'];
            $this->job_from_date = $job['job_from_date'];
            $this->job_to_date = $job['job_to_date'];
            $this->job_estimation = $job['job_estimation'];
            $this->job_advance_paid = $job['job_advance_paid'];
            $this->job_status = $job['job_status'];
            $this->job_customer_rating = $job['job_customer_rating'];
            $this->job_customer_feedback = $job['job_customer_feedback'];

            return true;
        } else {
            return false;
        }
    }

    public function insertJob() {
        global $conn;

        $stmt = $conn->prepare("INSERT INTO Job (job_customer_id, job_service_id, job_title, job_description, job_quantity, job_required_date, job_status)
                VALUES (:job_customer_id, :job_service_id, :job_title, :job_description, :job_quantity, :job_required_date, :job_status)");

        $stmt->bindParam(':job_customer_id', $this->job_customer_id);
        $stmt->bindParam(':job_service_id', $this->job_service_id);
        $stmt->bindParam(':job_title', $this->job_title);
        $stmt->bindParam(':job_description', $this->job_description);
        $stmt->bindParam(':job_quantity', $this->job_quantity);
        $stmt->bindParam(':job_required_date', $this->job_required_date);
        $stmt->bindParam(':job_status', $this->job_status);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteJob() {
        global $conn;
        $stmt = $conn->prepare("DELETE FROM Job WHERE job_id = ?");
        $stmt->execute([$this->job_id]);
    }

    public function update() {
        global $conn;
        $stmt = $conn->prepare("UPDATE Job SET job_customer_id = :job_customer_id, job_service_id = :job_service_id, job_title = :job_title, job_description = :job_description, job_quantity = :job_quantity, job_required_date = :job_required_date,
            job_from_date = :job_from_date, job_to_date = :job_to_date, job_estimation = :job_estimation, job_advance_paid = :job_advance_paid, job_status = :job_status,
            job_customer_rating = :job_customer_rating, job_customer_feedback = :job_customer_feedback
        WHERE job_id = :job_id");

        $stmt->bindParam(':job_customer_id', $this->job_customer_id);
        $stmt->bindParam(':job_service_id', $this->job_service_id);
        $stmt->bindParam(':job_title', $this->job_title);
        $stmt->bindParam(':job_description', $this->job_description);
        $stmt->bindParam(':job_quantity', $this->job_quantity);
        $stmt->bindParam(':job_required_date', $this->job_required_date);
        $stmt->bindParam(':job_from_date', $this->job_from_date);
        $stmt->bindParam(':job_to_date', $this->job_to_date);
        $stmt->bindParam(':job_estimation', $this->job_estimation);
        $stmt->bindParam(':job_advance_paid', $this->job_advance_paid);
        $stmt->bindParam(':job_status', $this->job_status);
        $stmt->bindParam(':job_customer_rating', $this->job_customer_rating);
        $stmt->bindParam(':job_customer_feedback', $this->job_customer_feedback);
        $stmt->bindParam(':job_id', $this->job_id);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
