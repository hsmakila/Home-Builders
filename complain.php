<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: signin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Home Builders - Customer Complaints</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php include 'nav.php'; ?>

    <?php
    require_once('config_db.php');
    require_once('User.php');
    require_once('Service.php');

    $customer_id = $_SESSION['user_id'];
    $customer = new User();
    $customer->loadById($customer_id);

    $service_provider_id = $_GET['service_provider_id'];
    $service_provider = new User();
    $service_provider->loadById($service_provider_id);
    ?>

    <div class="container mt-5 col-6">
        <h2 class="mb-4">Customer Complaints</h2>
        <form id="complaintForm">
            <input type="hidden" name="customer_id" value="<?= $customer_id ?>">
            <div class="form-group mb-3">
                <label for="customerEmail">Customer Email</label>
                <input type="text" class="form-control" id="serviceProvider" value="<?= $customer->getEmail() ?>" disabled>
            </div>
            <input type="hidden" name="service_provider_id" value="<?= $service_provider_id ?>">
            <div class="form-group mb-3">
                <label for="service_providerEmail">Service Provider Email</label>
                <input type="text" class="form-control" id="serviceProvider" value="<?= $service_provider->getEmail() ?>" disabled>
            </div>
            <div class="form-group mb-3">
                <label for="complaint">Complaint</label>
                <textarea class="form-control" name="complaint" id="complaint" rows="4" placeholder="Enter your complaint" required></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="complaintImage">Attach Image</label>
                <input type="file" class="form-control" id="complaintImage" name="complaintImage" accept="image/*">
            </div>
            <button type="button" class="btn btn-primary" onclick="submitComplaint()">Submit Complaint</button>
        </form>
    </div>

    <script>
        function submitComplaint() {
            var formData = new FormData(document.getElementById('complaintForm'));

            fetch('submit_complaint.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.status == "success") {
                        Swal.fire({
                            icon: 'success',
                            title: 'Complaint Submitted',
                            text: data.message,
                            confirmButtonText: 'OK'
                        }).then(() => {
                            window.history.back();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Operation Failed!',
                            text: data.message,
                            confirmButtonText: 'OK'
                        });
                    }
                })
                .catch(error => {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'There was an error submitting your complaint. Please try again.',
                        confirmButtonText: 'OK'
                    });
                });
        }
    </script>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>