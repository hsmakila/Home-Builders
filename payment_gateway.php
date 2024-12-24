<?php
require_once("config_db.php");
$order_id = $_GET["job_id"];
// using a prepared statement to avoid SQL injection
$stmt_get = $conn->prepare("SELECT * FROM job WHERE job_id = :order_id");
$stmt_get->bindParam(':order_id', $order_id, PDO::PARAM_INT);
$stmt_get->execute();

$order_details = $stmt_get->fetch(PDO::FETCH_ASSOC);

$amount = $order_details['job_estimation'];
$pay_amount = $amount * 10 / 100;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Builders - Advance Payment</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>


</head>

<body>
    <?php include 'nav.php'; ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 offset-3">
                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">Job Summary</h5>
                    </div>
                    <div class="card-body">
                        <h3 id="job_title"></h3>
                        <h5 id="job_description"></h5>
                        <p id="job_estimation"></p>
                        <p id="job_advance"></p>
                        <hr>
                        <h3 class="text-success" id="total_amount"></h3>
                        <input type="hidden" id="total_value" name="total_value">

                        <form method="post" action="https://sandbox.payhere.lk/pay/checkout">
                            <?php
                            $merchant_id = "1222985";
                            $amount = number_format($pay_amount, 2);
                            $currency = "LKR";
                            $merchant_secret = "MzkyMjI0Mzg5NDMyOTczNDE1MTkyMjM4NjcyOTUxOTIyNzk3NjM3";

                            $first_name = "Udaya";
                            $last_name = "De Zoysa";
                            $email = "unzoysa.un@gmail.com";
                            $phone = "+94715375179";
                            $blocation = "Ratnapura";

                            $hash = strtoupper(
                                md5(
                                    $merchant_id .
                                    $order_id .
                                    number_format($amount, 2, '.', '') .
                                    $currency .
                                    strtoupper(md5($merchant_secret))
                                )
                            );
                            ?>

                            <input type="hidden" name="merchant_id" value="<?php echo $merchant_id ?>">
                            <input type="hidden" name="return_url"
                                value="<?php echo "http://localhost/home_builders/pay_here_return_url.php" ?>">
                            <input type="hidden" name="cancel_url" value="<?php echo "http://localhost/home_builders/profile.php" ?>">
                            <input type="hidden" name="notify_url"
                                value="<?php echo "http://localhost/home_builders/pay_here_notify_url.php" ?>">
                            <input type="hidden" name="order_id" value="<?php echo $order_id ?>">
                            <input type="hidden" name="items" value="Iranama Horascope Report">
                            <input type="hidden" name="currency" value="<?php echo $currency ?>">
                            <input type="hidden" id="amount" name="amount" value="<?php echo $amount ?>">
                            <input type="hidden" name="first_name" value="<?php echo $first_name ?>">
                            <input type="hidden" name="last_name" value="<?php echo $last_name ?>">
                            <input type="hidden" name="email" value="<?php echo $email ?>">
                            <input type="hidden" name="phone" value="<?php echo $phone ?>">
                            <input type="hidden" name="address" value="Gonapitiya Road, Kuruwita">
                            <input type="hidden" name="city" value="<?php echo $blocation ?>">
                            <input type="hidden" name="country" value="Sri Lanka">
                            <input type="hidden" name="hash" value="<?php echo $hash ?>">
                            <input type="submit" value="Card Payment" class="btn btn-primary btn-block"
                                id="btnCardPayment" style="width: 100%;">


                            <img class="mx-2 payment-icon" src="assets/img/icons/visa.png" alt="">
                            <img class="mx-2 payment-icon master-card" src="assets/img/icons/master.png" alt="">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    <script>
        const job_id = new URLSearchParams(window.location.search).get("job_id");
        if (job_id) {
            fetch(`get_job.php?job_id=${job_id}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    document.getElementById('job_title').textContent = `Title: ${data.job_title}`;
                    document.getElementById('job_description').textContent = `Description: ${data.job_description}`;
                    document.getElementById('job_estimation').textContent = `Total Estimate: ${data.job_estimation}`;
                    document.getElementById('job_advance').textContent = `Advance: Rs. ${data.job_estimation * 0.1} (10%)`;
                    document.getElementById('total_amount').textContent = `Total: Rs. ${data.job_estimation * 0.1}`;

                    // Assuming data.job_estimation is a numeric value
                    var calculatedValue = data.job_estimation * 0.1;

                    // Convert the calculated value to a string and add ".00"
                    var formattedValue = calculatedValue.toFixed(2);

                    // Set the text content of the element with id "total_value"
                    document.getElementById('amount').textContent = formattedValue;
                });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
</body>

</html>