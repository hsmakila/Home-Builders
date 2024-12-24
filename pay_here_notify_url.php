<?php

require_once("config_db.php");

$merchant_id = $_POST['merchant_id'];
$order_id = $_POST['order_id'];
$payhere_amount = $_POST['payhere_amount'];
$payhere_currency = $_POST['payhere_currency'];
$status_code = $_POST['status_code'];
$md5sig = $_POST['md5sig'];

$merchant_secret = 'MzkyMjI0Mzg5NDMyOTczNDE1MTkyMjM4NjcyOTUxOTIyNzk3NjM3'; // Replace with your Merchant Secret

$local_md5sig = strtoupper(
    md5(
        $merchant_id .
            $order_id .
            $payhere_amount .
            $payhere_currency .
            $status_code .
            strtoupper(md5($merchant_secret))
    )
);

if (($local_md5sig === $md5sig) and ($status_code == 2)) {
    //TODO: Update your database as payment success
    $sql = "UPDATE `job` SET job_advance_paid=?, job_status=? WHERE job_id=?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$pay_amount, 'scheduled', $order_id]);
}
