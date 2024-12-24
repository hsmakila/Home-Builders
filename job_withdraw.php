<?php
require_once('config_db.php');
require_once('Job.php');
require_once('Notification.php');

session_start();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $job_id = $_GET['job_id'];

    $job = new Job();
    $job->loadById($job_id);
    $job->deleteJob();

    header("Location: profile.php");
}