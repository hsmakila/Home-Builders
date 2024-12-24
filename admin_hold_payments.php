<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Profile</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <?php include("nav.php") ?>

    <!-- Content Section -->
    <div class="container mt-4">
        <h1>Admin Dashboard</h1>
        <hr>

        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid container mx-auto">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0" id="links">
                        <li class="nav-item" style="border-right: 1px solid #ccc;">
                            <a class="nav-link disabled" href="admin_hold_payments.php">Hold Payments Management</a>
                        </li>
                        <li class="nav-item" style="border-right: 1px solid #ccc;">
                            <a class="nav-link" href="admin_user_profile.php">User Profile Management</a>
                        </li>
                        <li class="nav-item" style="border-right: 1px solid #ccc;">
                            <a class="nav-link" href="admin_news.php">News Management</a>
                        </li>
                        <li class="nav-item" style="border-right: 1px solid #ccc;">
                            <a class="nav-link" href="admin_faq.php">FAQ Management</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin_complaint.php">Complaint Management</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <hr>

        <!-- Hold Payments Section -->
        <div id="hold-payments" class="mb-4">
            <h3>Hold Payments Management</h3>
            <div>(Job completed by service provider but user not yet confirmed)</div>
            <hr>
            <table class="table" id="hold-payments-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Title</th>
                        <th>Service</th>
                        <th>Customer</th>
                        <th>Completed Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Hold payments will be dynamically added here -->
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <script>
        function searchHoldPayments() {
            fetch(`get_pending_review_admin.php`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    const userTable = document.getElementById('hold-payments-table').getElementsByTagName('tbody')[0];
                    userTable.innerHTML = "";

                    data.forEach(job => {
                        const row = userTable.insertRow();
                        row.innerHTML = `
                            <td>${job.job_id}</td>
                            <td>${job.job_title}</td>
                            <td>${job.title}</td>
                            <td>${job.name}</td>
                            <td>${job.job_to_date}</td>
                            <td>
                                <button class="btn btn-success" onclick=releaseAdvance(${job.job_id})>Release</button>
                                <button class="btn btn-danger" onclick=cancelJob(${job.job_id})>Return</button>
                            </td>`;
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        function releaseAdvance(job_id) {
            fetch(`set_rating.php?job_id=${job_id}&rating=5&comment=`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.status == 'success') {
                        location.reload();
                    }
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        function cancelJob(job_id) {
            fetch(`job_cancel.php?job_id=${job_id}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    if (data.status == 'success') {
                        location.reload();
                    }
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        document.addEventListener('DOMContentLoaded', function() {
            searchHoldPayments();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>