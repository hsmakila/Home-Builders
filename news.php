<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Builders - News</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <?php include 'nav.php'; ?>

    <div class="container mt-5">
        <h1>Latest News</h1>
        <div class="row">
            <?php
            include 'config_db.php';

            $sql = "SELECT * FROM News ORDER BY added_date DESC LIMIT 50";
            $result = $conn->query($sql);

            $lastColSize = 0;
            $currentColSize = 0;

            if ($result->rowCount() > 0) {
                $columnSizes = [6];
                $currentIndex = 0;

                while ($row = $result->fetch()) {
                    $currentColSize = $columnSizes[$currentIndex];
                    $currentIndex = ($currentIndex + 1) % count($columnSizes);

            ?>
                    <div class="col-md-<?php echo $currentColSize; ?> mb-3">
                        <div class="card">
                            <div class="row no-gutters">
                                <div class="col-md-4">
                                    <img src="news-pic/n<?php echo $row["news_id"]; ?>.jpg" class="img-fluid" height="10px" alt="News Image" onerror="this.src='news-pic/n<?php echo rand(1, 9); ?>.jpg'">
                                </div>
                                <div class="col-md-8">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo $row["title"]; ?></h5>
                                        <p class="card-text"><?php echo $row["description"]; ?></p>
                                        <p class="card-text"><?php echo $row["added_date"]; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo "No news available.";
            }
            ?>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>