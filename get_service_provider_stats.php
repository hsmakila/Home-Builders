<?php
include('config_db.php');

$service_provider_id = isset($_GET['service_provider_id']) ? $_GET['service_provider_id'] : null;

if ($service_provider_id != null) {

    $query_no_of_jobs = "SELECT COUNT(*) as job_count FROM Job
          JOIN Services ON Job.job_service_id = Services.service_id
          JOIN Users ON Services.service_provider_id = Users.user_id
          WHERE Services.service_provider_id = :service_provider_id
            AND Job.job_status IN ('scheduled', 'ongoing', 'done')";

    $query_total_account_value = "SELECT SUM(Job.job_estimation) as account_value FROM Job
          JOIN Services ON Job.job_service_id = Services.service_id
          JOIN Users ON Services.service_provider_id = Users.user_id
          WHERE Services.service_provider_id = :service_provider_id
            AND Job.job_status IN ('scheduled', 'ongoing', 'done')";

    $query_rating = "SELECT CAST(AVG(Job.job_customer_rating) AS DECIMAL(10,1)) as avarage_rating FROM Job
        JOIN Services ON Job.job_service_id = Services.service_id
        JOIN Users ON Services.service_provider_id = Users.user_id
        WHERE Services.service_provider_id = :service_provider_id
        AND Job.job_status = 'done'";

    $stmt_no_of_jobs = $conn->prepare($query_no_of_jobs);
    $stmt_no_of_jobs->bindParam(':service_provider_id', $service_provider_id, PDO::PARAM_INT);
    $stmt_no_of_jobs->execute();
    $no_of_jobs_result = $stmt_no_of_jobs->fetch(PDO::FETCH_ASSOC);

    $stmt_account_value = $conn->prepare($query_total_account_value);
    $stmt_account_value->bindParam(':service_provider_id', $service_provider_id, PDO::PARAM_INT);
    $stmt_account_value->execute();
    $account_value_result = $stmt_account_value->fetch(PDO::FETCH_ASSOC);

    $stmt_rating = $conn->prepare($query_rating);
    $stmt_rating->bindParam(':service_provider_id', $service_provider_id, PDO::PARAM_INT);
    $stmt_rating->execute();
    $rating_result = $stmt_rating->fetch(PDO::FETCH_ASSOC);

    $response = [
        'service_provider_id' => $service_provider_id,
        'job_count' => $no_of_jobs_result['job_count'],
        'total_account_value' => $account_value_result['account_value'],
        'avarage_rating' => $rating_result['avarage_rating']
    ];

    header('Content-Type: application/json');
    echo json_encode($response);
}
