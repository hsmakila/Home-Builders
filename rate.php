<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <style>
        .feedback-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .star-rating i {
            font-size: 24px;
            color: #b2beb5;
            cursor: pointer;
        }

        .star-rating i:hover,
        .star-rating i.active {
            color: #ffac00;
        }
    </style>
</head>

<body>

    <?php include("nav.php"); ?>

    <div class="feedback-container">
        <h2 class="mb-4">Leave your feedback</h2>

        <?php
        $job_id = $_GET['job_id'];
        ?>

        <!-- Star Rating -->
        <div class="mb-4">
            <label for="starRating" class="form-label">Rate us:</label>
            <div id="starRating" class="star-rating">
                <i class="fas fa-star" data-index="0"></i>
                <i class="fas fa-star" data-index="1"></i>
                <i class="fas fa-star" data-index="2"></i>
                <i class="fas fa-star" data-index="3"></i>
                <i class="fas fa-star" data-index="4"></i>
            </div>
            <input type="hidden" name="rating" id="rating" value="0">
        </div>

        <div class="mb-4">
            <label for="userComment" class="form-label">Your comment:</label>
            <textarea class="form-control" id="userComment" rows="4"></textarea>
        </div>

        <button type="button" class="btn btn-primary" onclick="submitFeedback('<?php echo $job_id; ?>')">Submit Feedback</button>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star-rating i');
            const ratingInput = document.getElementById('rating');

            stars.forEach((star, index) => {
                star.addEventListener('click', () => {
                    ratingInput.value = index + 1;
                    updateStarRating(index);
                });
            });
        });

        function updateStarRating(index) {
            const stars = document.querySelectorAll('.star-rating i');
            stars.forEach((star, i) => {
                star.classList.toggle('active', i <= index);
            });
        }

        function submitFeedback(job_id) {
            const rating = document.getElementById('rating').value;
            const comment = document.getElementById('userComment').value;

            if (!rating || !comment) {
                alert('Please provide both a rating and a comment.');
                return;
            }

            fetch(`set_rating.php?job_id=${job_id}&rating=${rating}&comment=${comment}`, {
                    method: 'GET',
                })
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    window.location.href = "profile.php";
                })
                .catch(error => {
                    console.error('Error submitting feedback:', error);
                });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>