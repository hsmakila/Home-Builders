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
                            <a class="nav-link" href="admin_hold_payments.php">Hold Payments Management</a>
                        </li>
                        <li class="nav-item" style="border-right: 1px solid #ccc;">
                            <a class="nav-link disabled" href="admin_user_profile.php">User Profile Management</a>
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

        <!-- User Profiles Section -->
        <div id="user-profiles" class="mb-4">
            <h3>User Profile Management</h3>
            <hr>
            <div class="input-group mb-3">
                <input type="text" class="form-control" id="userSearch" placeholder="Search by email or name">
                <button class="btn btn-primary" onclick="searchUsers()">Search</button>
            </div>

            <table class="table" id="user-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <!-- User profiles will be dynamically added here -->
                </tbody>
            </table>
        </div>
    </div>
    </div>

    <script>
        function searchUsers() {
            const userSearchInput = document.getElementById('userSearch');
            const searchTerm = userSearchInput.value;

            fetch(`get_users_admin.php?keyword=${searchTerm}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    const userTable = document.getElementById('user-table').getElementsByTagName('tbody')[0];
                    userTable.innerHTML = "";

                    data.forEach(user => {
                        const row = userTable.insertRow();
                        row.innerHTML = `<td>${user.user_id}</td><td>${user.name}</td><td>${user.email}</td><td><a class="btn ${user.blocked == 0 ? 'btn-danger' : 'btn-success'} " href="troggle_user_blocked.php?user_id=${user.user_id}">${user.blocked == 0 ? 'Block' : 'Unblock'}</a></td>`;
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('userSearch').addEventListener('input', searchUsers);
            searchUsers();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>