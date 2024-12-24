<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Builders - Service Images</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <?php include("nav.php"); ?>

    <div class="container">
        <div class="d-flex my-3">
            <div class="d-flex me-3">
                <input class="form-control" type="file" id="imageUpload" accept="image/*">
            </div>
            <div class="d-flex">
                <button id="uploadButton" class="btn btn-primary">Upload Images</button>
            </div>
        </div>
        <div class="row">
            <div class="col-4" id="image_col_1">
                <!-- Col 1 -->
            </div>
            <div class="col-4" id="image_col_2">
                <!-- Col 2 -->
            </div>
            <div class="col-4" id="image_col_3">
                <!-- Col 3 -->
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const col1 = document.getElementById("image_col_1");
            const col2 = document.getElementById("image_col_2");
            const col3 = document.getElementById("image_col_3");

            fetch("get_service_provider_images.php")
                .then((response) => response.json())
                .then((data) => {
                    data.reverse()
                    let col = 1;
                    data.forEach(filename => {
                        const img = document.createElement("img");
                        img.className = "img-fluid m-2";
                        img.src = "service-pic/" + filename;
                        img.alt = filename;
                        if (col == 1) {
                            col1.appendChild(img);
                        } else if (col == 2) {
                            col2.appendChild(img);
                        } else if (col == 3) {
                            col3.appendChild(img);
                        }
                        col++;
                        if (col == 4) {
                            col = 1;
                        }
                    });
                });
        });

        document.addEventListener("DOMContentLoaded", () => {
            const imageUploadInput = document.getElementById("imageUpload");
            const uploadButton = document.getElementById("uploadButton");

            uploadButton.addEventListener("click", () => {
                const formData = new FormData();
                formData.append("image", imageUploadInput.files[0]);

                fetch("upload_image.php", {
                        method: "POST",
                        body: formData,
                    })
                    .then((response) => response.json())
                    .then((data) => {
                        if (data.success) {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'success',
                                title: 'Image uploaded!',
                                showConfirmButton: false,
                                timer: 1500
                            }).then((results) => {
                                location.reload();
                            });
                        } else {
                            Swal.fire({
                                position: 'top-end',
                                icon: 'error',
                                title: 'Image upload fail!',
                                showConfirmButton: false,
                                timer: 1500
                            });
                        }
                    })
                    .catch((error) => {
                        console.error("Image upload error:", error);
                    });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</body>

</html>