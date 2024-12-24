<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile Information</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>

    <?php include 'nav.php'; ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <h3>Edit Profile Information</h3>
                        <form action="update_service_provider_profile.php" method="POST" enctype="multipart/form-data">
                            <!-- Profile Picture -->
                            <div class="mb-3">
                                <label for="profilePic" class="form-label">Profile Picture</label>
                                <input type="file" class="form-control" id="profilePic" name="profilePic">
                            </div>

                            <!-- Name -->
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" class="form-control" id="name" name="name">
                            </div>

                            <!-- Phone -->
                            <div class="mb-3">
                                <label for="phone" class="form-label">Phone</label>
                                <input type="tel" class="form-control" id="phone" name="phone">
                            </div>

                            <!-- Discription -->
                            <div class="mb-3">
                                <label for="discription" class="form-label">Discription</label>
                                <input type="tel" class="form-control" id="discription" name="discription">
                            </div>

                            <select class="form-control mb-3" id="location_id" name="location_id">
                                <?php
                                include('config_db.php');

                                $query = "SELECT * FROM Locations";
                                $stmt = $conn->prepare($query);
                                $stmt->execute();

                                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                                    echo '<option value="' . $row['location_id'] . '">' . $row['location'] . '</option>';
                                }
                                ?>
                            </select>

                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        window.addEventListener("DOMContentLoaded", () => {
            fetch("get_current_user.php")
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
                    if (data.success) {
                        if (data.name != null) {
                            document.getElementById("name").value = `${data.name}`;
                        }
                        if (data.phone != null) {
                            document.getElementById("phone").value = `${data.phone}`;
                        }
                        if (data.description != null) {
                            document.getElementById("discription").value = `${data.description}`;
                        }
                    }
                    document.getElementById('location_id').value = data.location_id;
                });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>