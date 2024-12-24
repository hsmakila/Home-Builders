<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Request</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <?php include 'nav.php'; ?>

    <?php
    require_once('config_db.php');
    require_once('User.php');
    require_once('Service.php');

    $service_id = $_GET['service_id'];
    $service = new Service();
    $service->loadById($service_id);
    $service_provider = new User();
    $service_provider->loadById($service->getServiceProviderId());
    ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <h2>Job Request</h2>
                        <p><?php echo $service->getTitle() ?></p>
                        <p><?php echo $service_provider->getName() ?></p>
                        <p><?php echo $service->getDescription() ?></p>
                        <form action="job_insert.php" method="POST" onsubmit="return validateDate();">
                            <input type="hidden" name="service_id" value="<?php echo $service_id; ?>">
                            <div class="form-group">
                                <label for="title">Title</label>
                                <input type="text" class="form-control mb-3" name="title" placeholder="Enter title" required>
                            </div>
                            <div class="form-group">
                                <label for="required_date">Required Date</label>
                                <input type="date" class="form-control mb-3" name="required_date" id="required_date" required>
                            </div>
                            <div class="form-group">
                                <label for="description">Description</label>
                                <textarea class="form-control mb-3" name="description" rows="4" placeholder="Enter description" required></textarea>
                            </div>
                            <input type="submit" class="btn btn-primary" value="Submit">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function validateDate() {
            var currentDate = new Date();
            var requiredDate = new Date(document.getElementById('required_date').value);

            if (requiredDate <= currentDate) {
                alert('Required Date should be greater than today.');
                return false;
            }

            return true;
        }
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>