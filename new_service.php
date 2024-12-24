<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Service</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <?php include 'nav.php'; ?>

    <div class="container mt-4">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-body">
                        <h3>Add New Service</h3>
                        <form action="add_new_service.php" method="POST">
                            <!-- Category -->
                            <div class="mb-3">
                                <label for="category" class="form-label">Category:</label>
                                <select class="form-control" id="category" name="category">
                                    <!-- This dropdown will be populated dynamically based on the selected main category -->
                                </select>
                            </div>

                            <!-- Service Name -->
                            <div class="mb-3">
                                <label for="title" class="form-label">Title:</label>
                                <input type="text" class="form-control" id="title" name="title" required>
                            </div>

                            <!-- Description -->
                            <div class="mb-3">
                                <label for="description" class="form-label">Description:</label>
                                <textarea class="form-control" id="description" name="description" rows="4" cols="50" required></textarea>
                            </div>

                            <!-- Rate -->
                            <div class="mb-3">
                                <label for="rate" class="form-label">Rate:</label>
                                <div class="input-group">
                                    <input type="number" class="form-control" id="rate" name="rate" required>
                                    <select class="form-select" id="unit" name="unit">
                                        <option value="hour">Per Hour</option>
                                        <option value="sq ft">Per Square Feet</option>
                                        <option value="linear ft">Per Linear Feet</option>
                                        <option value="unit">Per Unit</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script>
        window.addEventListener("DOMContentLoaded", () => {
            const categoryDropdown = document.getElementById("category");

            fetch("get_categories.php")
                .then((response) => response.json())
                .then((data) => {
                    categoryDropdown.innerHTML = "";
                    data.forEach((category) => {
                        const option = document.createElement("option");
                        option.value = category.category_id;
                        option.textContent = category.sub_category;
                        categoryDropdown.appendChild(option);
                    });
                });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>
