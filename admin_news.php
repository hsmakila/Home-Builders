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
                            <a class="nav-link" href="admin_user_profile.php">User Profile Management</a>
                        </li>
                        <li class="nav-item" style="border-right: 1px solid #ccc;">
                            <a class="nav-link disabled" href="admin_news.php">News Management</a>
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

        <!-- News Section -->
        <div id="news" class="mb-4">
            <div class="row">
                <h3>News Management</h3>
                <hr>

                <h5>Add News</h5>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="newsTitle" placeholder="Enter news title">
                    <input type="text" class="form-control" id="newsDescription" placeholder="Enter news description">
                    <input type="file" class="form-control" id="newsImage" accept="image/*">
                    <button class="btn btn-primary" onclick="addNews()">Add</button>
                </div>
                <hr>
                
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="newsSearch" placeholder="Search by name">
                    <button class="btn btn-primary" onclick="searchNews()">Search</button>
                </div>

                <table class="table" id="news-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- News will be dynamically added here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function searchNews() {
            const newsSearchInput = document.getElementById('newsSearch');
            const searchTerm = newsSearchInput.value;

            fetch(`get_news_admin.php?keyword=${searchTerm}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    const newsTable = document.getElementById('news-table').getElementsByTagName('tbody')[0];
                    newsTable.innerHTML = "";

                    data.forEach(news => {
                        const row = newsTable.insertRow();
                        row.innerHTML = `<td>${news.news_id}</td><td>${news.title}</td><td>${news.description}</td><td><a class="btn btn-danger" href="delete_news_admin.php?news_id=${news.news_id}">Delete</a></td>`;
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        function addNews() {
            const titleInput = document.getElementById('newsTitle');
            const descriptionInput = document.getElementById('newsDescription');
            const imageInput = document.getElementById('newsImage');

            const title = titleInput.value;
            const description = descriptionInput.value;
            const imageFile = imageInput.files[0];

            if (title.trim() === '' || description.trim() === '' || !imageFile) {
                alert('Please enter both title, description, and select an image.');
                return;
            }

            const formData = new FormData();
            formData.append('title', title);
            formData.append('description', description);
            formData.append('image', imageFile);

            fetch('add_news_admin.php', {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.text())
                .then(result => {
                    titleInput.value = '';
                    descriptionInput.value = '';
                    imageInput.value = '';
                    searchNews();
                })
                .catch(error => console.error('Error adding News:', error));
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('newsSearch').addEventListener('input', searchNews);
            searchNews();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>