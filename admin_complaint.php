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

    <div class="container mt-4">
        <h1>Admin Dashboard</h1>
        <hr>

        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid container mx-auto">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0" id="links">
                        <li class="nav-item" style="border-right: 1px solid #ccc;">
                            <a class="nav-link" href="admin_hold_payments.php">Hold Payments Management</a>
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
                            <a class="nav-link disabled" href="admin_complaint.php">Complaint Management</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <hr>

        <!-- Complaint Section -->
        <div class="mb-4">
            <h3>Complaint Management</h3>
            <hr>

            <table class="table" id="complaint-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer Email</th>
                        <th>Service Provider Email</th>
                        <th>Complaint</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Complaint will be dynamically added here -->
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <script>
        function searchComplaints() {
            fetch(`get_complaint_admin.php`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    const userTable = document.getElementById('complaint-table').getElementsByTagName('tbody')[0];
                    userTable.innerHTML = "";

                    data.forEach(complaint => {
                        const row = userTable.insertRow();
                        row.innerHTML = `
                            <td>${complaint.complaint_id}</td>
                            <td>${complaint.customer_email}</td>
                            <td>${complaint.service_provider_email}</td>
                            <td>${complaint.complaint_text}</td>
                            <td>${complaint.complaint_date}</td>
                            <td>
                                <a class="btn btn-primary" href="complaints-pic/c${complaint.complaint_id}.jpg">Image</a>    
                                <a class="btn btn-success" href="close_complaint.php?complaint_id=${complaint.complaint_id}">Close</a>
                            </td>`;
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        document.addEventListener('DOMContentLoaded', function() {
            searchComplaints();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>