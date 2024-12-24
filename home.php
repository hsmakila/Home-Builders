<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Builders - Home</title>

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

    <!-- Banner -->
    <div class="container-md mt-5">
        <div class="row align-items-center">
            <div class="col-lg-6 pe-5">
                <h1 class="mb-5" id="x">Home Builders</h1>
                <h4 class="mb-4">Together We Build..Connecting Home Creators</h4>
                <p>
                    Your ultimate destination for seamless home construction. We bring
                    together experienced builders, talented designers, and reliable
                    suppliers all in one place, empowering you to turn your dream home
                    into a reality..
                </p>
            </div>
            <div class="col-lg-6 d-none justify-content-end d-lg-block">
                <img src="asserts/banner.jpg" alt="" class="rounded-circle" width="550" height="550" />
            </div>
        </div>
        <!-- <img src="asserts/banner.jpg" alt="" width="100%" /> -->
    </div>

    <!-- "What we provide?" Section with Cards -->
    <div class="container mt-3 pt-5 pb-5">
        <div class="row d-flex align-items-center justify-content-center">
            <div class="col-lg-3">
                <h2>What we provide?</h2>
                <p class="pe-3">
                    At Home Builders, we are your comprehensive home construction and
                    design facilitators, offering a one-of-a-kind platform that connects
                    you with top-notch builders, innovative designers, and trusted
                    suppliers, all under a single virtual roof. Our mission is to
                    empower homeowners like you to bring their dream homes to life
                    effortlessly.
                </p>
            </div>
            <div class="col-lg-3">
                <a href="search.php?type=CONSTRUCTOR" style="text-decoration: none;">
                    <div class="card">
                        <img src="asserts/construction.png" class="card-img-top" alt="Image 1" height="200" />
                        <div class="card-body">
                            <h5 class="card-title">CONSTRUCTORS</h5>
                            <p class="card-text mb-4">
                                Experienced builders bringing your vision to life with quality
                                and precision for on-time, on-budget results.
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3">
                <a href="search.php?type=DESIGNER" style="text-decoration: none;">
                    <div class="card">
                        <img src="asserts/designing.jpg" class="card-img-top" alt="Image 2" height="200" />
                        <div class="card-body">
                            <h5 class="card-title">DESIGNERS</h5>
                            <p class="card-text">
                                Talented team crafting inspiring blueprints for homes, offices,
                                and retail spaces that capture your unique style.
                            </p>
                        </div>
                    </div>
                </a>
            </div>
            <div class="col-lg-3">
                <a href="search.php?type=SUPPLIER" style="text-decoration: none;">
                    <div class="card">
                        <img src="asserts/materials.webp" class="card-img-top" alt="Image 3" height="200" />
                        <div class="card-body">
                            <h5 class="card-title">SUPPLIERS</h5>
                            <p class="card-text mb-4">
                                Trusted sources for high-quality, sustainable construction
                                materials, shaping a greener future.
                            </p>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>