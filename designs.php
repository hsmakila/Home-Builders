<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Builders - Find Home Designs</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <style>
        .card:hover {
            transform: scale(1.05);
            transition: transform 0.3s ease;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.2);
        }
    </style>

</head>

<body>
    <?php include 'nav.php'; ?>

    <div class="container mt-4">
        <!-- Filters -->
        <div class="input-group mb-3">
            <input type="number" class="form-control" id="roomsFilter" placeholder="No of Rooms">
            <input type="number" class="form-control" id="bathroomsFilter" placeholder="No of Bathrooms">
            <input type="number" class="form-control" id="floorsFilter" placeholder="No of Floors">
            <input type="number" class="form-control" id="minAreaFilter" placeholder="Min area">
            <input type="number" class="form-control" id="maxAreaFilter" placeholder="Max area">
            <input type="number" class="form-control" id="minPriceFilter" placeholder="Min price">
            <input type="number" class="form-control" id="maxPriceFilter" placeholder="Max price">
            <button class="btn btn-primary" id="searchButton" onClick="updatePage()">Search</button>
        </div>
    </div>

    <div class="container">
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
        let rooms;
        let bathrooms;
        let floors;
        let minarea;
        let maxarea;
        let minprice;
        let maxprice;

        function updatePage() {
            rooms = document.getElementById("roomsFilter").value;
            bathrooms = document.getElementById("bathroomsFilter").value;
            floors = document.getElementById("floorsFilter").value;
            minarea = document.getElementById("minAreaFilter").value;
            maxarea = document.getElementById("maxAreaFilter").value;
            minprice = document.getElementById("minPriceFilter").value;
            maxprice = document.getElementById("maxPriceFilter").value;

            const url = `designs.php?rooms=${rooms}&bathrooms=${bathrooms}&floors=${floors}&minarea=${minarea}&maxarea=${maxarea}&minprice=${minprice}&maxprice=${maxprice}`;

            window.location.href = url;
        }

        function loadResults() {
            rooms = document.getElementById("roomsFilter").value;
            bathrooms = document.getElementById("bathroomsFilter").value;
            floors = document.getElementById("floorsFilter").value;
            minarea = document.getElementById("minAreaFilter").value;
            maxarea = document.getElementById("maxAreaFilter").value;
            minprice = document.getElementById("minPriceFilter").value;
            maxprice = document.getElementById("maxPriceFilter").value;

            const url = `search_designs.php?rooms=${rooms}&bathrooms=${bathrooms}&floors=${floors}&minarea=${minarea}&maxarea=${maxarea}&minprice=${minprice}&maxprice=${maxprice}`;

            console.log(url);

            const col1 = document.getElementById("image_col_1");
            const col2 = document.getElementById("image_col_2");
            const col3 = document.getElementById("image_col_3");

            fetch(url)
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);

                    let col = 1;
                    data.forEach(design => {
                        const card = document.createElement("a");
                        card.className = "card mb-3";
                        card.href = `service_page.php?service_id=${design.home_design_service_id}`;
                        card.style = "text-decoration: none;"

                        card.innerHTML = `
                            <img class="card-img-top" src="design-pic/${design.home_design_id}.jpg">
                            <div class="card-body">
                                <div class="card-text">Designed By: ${design.name}</div>
                                <div class="card-text">Rooms: ${design.home_design_no_of_rooms}</div>
                                <div class="card-text">Bathrooms: ${design.home_design_no_of_bathrooms}</div>
                                <div class="card-text">Floors: ${design.home_design_no_of_floors}</div>
                                <div class="card-text">Area: ${design.home_design_area.toLocaleString()} sq feet</div>
                                <div class="card-text">Rs. ${design.home_design_price.toLocaleString()}</div>
                            </div>`

                        if (col == 1) {
                            col1.appendChild(card);
                        } else if (col == 2) {
                            col2.appendChild(card);
                        } else if (col == 3) {
                            col3.appendChild(card);
                        }
                        col++;
                        if (col == 4) {
                            col = 1;
                        }
                    });
                });
        }

        window.addEventListener("DOMContentLoaded", () => {
            const urlParams = new URLSearchParams(window.location.search);

            rooms = urlParams.has('rooms') ? urlParams.get('rooms') : 0
            bathrooms = urlParams.has('bathrooms') ? urlParams.get('bathrooms') : 0
            floors = urlParams.has('floors') ? urlParams.get('floors') : 0
            minarea = urlParams.has('minarea') ? urlParams.get('minarea') : 0
            maxarea = urlParams.has('maxarea') ? urlParams.get('maxarea') : 0
            minprice = urlParams.has('minprice') ? urlParams.get('minprice') : 0
            maxprice = urlParams.has('maxprice') ? urlParams.get('maxprice') : 0

            if (rooms > 0) {
                document.getElementById("roomsFilter").value = rooms;
            }
            if (bathrooms > 0) {
                document.getElementById("bathroomsFilter").value = bathrooms;
            }
            if (floors > 0) {
                document.getElementById("floorsFilter").value = floors;
            }
            if (minarea > 0) {
                document.getElementById("minAreaFilter").value = minarea;
            }
            if (maxarea > 0) {
                document.getElementById("maxAreaFilter").value = maxarea;
            }
            if (minprice > 0) {
                document.getElementById("minPriceFilter").value = minprice;
            }
            if (maxprice > 0) {
                document.getElementById("maxPriceFilter").value = maxprice;
            }

            loadResults();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</body>

</html>