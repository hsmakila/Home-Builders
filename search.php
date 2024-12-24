<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Builders - Search</title>

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
            <!-- Search Bar -->
            <input type="text" id="filterInput" class="form-control" placeholder="Search for service...">
            <select class="form-control" id="typeFilter">
                <option value="ALL">All Types</option>
                <option value="CONSTRUCTOR">Type: Constructor</option>
                <option value="SUPPLIER">Type: Supplier</option>
                <option value="DESIGNER">Type: Designer</option>
            </select>
            <select class="form-control" id="locationFilter">
                <option value="0">Location: All</option>

                <?php
                include('config_db.php');

                $searchQuery = '%' . $_GET['query'] . '%';

                $query = "SELECT * FROM Locations";
                $stmt = $conn->prepare($query);
                $stmt->execute();

                while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo '<option value="' . $row['location_id'] . '">Location: ' . $row['location'] . '</option>';
                }
                ?>
            </select>
            <input type="number" class="form-control" id="minRateFilter" placeholder="Min">
            <input type="number" class="form-control" id="maxRateFilter" placeholder="Max">
            <button class="btn btn-primary" id="searchButton" onClick="updatePage()">Search</button>
        </div>

        <!-- Display Search Results -->
        <div class="mt-4">
            <div class="row" id="search-results">
                <!-- Results will be displayed here as cards -->
            </div>
        </div>
    </div>

    <script>
        let filter;
        let type;
        let loc;
        let minrate;
        let maxrate;

        function updatePage() {
            filter = document.getElementById("filterInput").value;
            type = document.getElementById("typeFilter").value;
            loc = document.getElementById("locationFilter").value;
            minrate = document.getElementById("minRateFilter").value;
            maxrate = document.getElementById("maxRateFilter").value;

            const url = `search.php?filter=${filter}&type=${type}&loc=${loc}&minrate=${minrate}&maxrate=${maxrate}`;

            window.location.href = url;
        }

        function loadResults() {
            filter = document.getElementById("filterInput").value;
            type = document.getElementById("typeFilter").value;
            loc = document.getElementById("locationFilter").value;
            minrate = document.getElementById("minRateFilter").value;
            maxrate = document.getElementById("maxRateFilter").value;

            const url = `search_services.php?filter=${filter}&type=${type}&loc=${loc}&minrate=${minrate}&maxrate=${maxrate}`;

            console.log(url);

            fetch(url)
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
                    const results_body = document.getElementById('search-results');
                    if (data.length > 0) {
                        results_body.innerHTML = "";

                        data.forEach((service) => {
                            const ele = document.createElement('div');
                            ele.classList.add("col-sm-6");
                            ele.classList.add("col-md-4");
                            ele.classList.add("col-lg-3");
                            ele.classList.add("col-xl-2");
                            ele.innerHTML = `
                                <a class="card mb-3" href="service_page.php?service_id=${service.service_id}" style="text-decoration: none;">
                                    <img src="profile-pic/p${service.service_provider_id}.jpg" class="card-img" onerror="this.src='asserts/default-profile-pic.png'">
                                    <div class="card-body">
                                        <h6 class="card-title text-truncate">${service.title}</h6>
                                        <div class="card-text text-truncate">${service.name}</div>
                                        <div class="card-text text-truncate">Rs. ${service.rate}/${service.unit}</div>
                                        <div class="card-text">${service.location}</div>
                                    </div>
                                </a>
                            `;
                            results_body.appendChild(ele);
                        });

                    } else {
                        results_body.innerHTML = '<p>No matching results</p>';
                    }
                });
        }

        window.addEventListener("DOMContentLoaded", () => {
            const urlParams = new URLSearchParams(window.location.search);

            filter = urlParams.has('filter') ? urlParams.get('filter') : "";
            type = urlParams.has('type') ? urlParams.get('type') : "ALL";
            loc = urlParams.has('loc') ? urlParams.get('loc') : 0;
            minrate = urlParams.has('minrate') ? urlParams.get('minrate') : 0;
            maxrate = urlParams.has('maxrate') ? urlParams.get('maxrate') : 0;

            console.log("filter: " + filter);
            console.log("type: " + type);
            console.log("loc: " + loc);
            console.log("minrate: " + minrate);
            console.log("maxrate: " + maxrate);

            document.getElementById("filterInput").value = filter;
            document.getElementById("typeFilter").value = type;
            document.getElementById("locationFilter").value = loc;
            if (minrate > 0) {
                document.getElementById("minRateFilter").value = minrate;
            }
            if (maxrate > 0) {
                document.getElementById("maxRateFilter").value = maxrate;
            }

            loadResults();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>

</body>

</html>