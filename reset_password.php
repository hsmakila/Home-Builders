<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Home Builders - Sign In</title>
</head>

<body>
    <?php include 'nav.php'; ?>

    <?php
    $email = $_GET['email'];
    $token = $_GET['token'];
    ?>

    <div class="container mt-5">
        <h1 class="text-center">Reset Password</h1>
        <div class="col-md-6 mx-auto">
            <form id="reset-password-form">
                <input type="hidden" name="email" value="<?php echo $email; ?>">
                <input type="hidden" name="token" value="<?php echo $token; ?>">
                <div class="mb-3">
                    <label for="new-password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="new-password" name="newPassword" required>
                </div>
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </div>
            </form>
            <!-- Response message div -->
            <div id="response-message" class="col-md-6 mx-auto text-center"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const resetPasswordForm = document.getElementById('reset-password-form');
            const responseMessage = document.getElementById('response-message');

            resetPasswordForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(resetPasswordForm);

                fetch('reset_password_process.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        // Display the response message to the user
                        responseMessage.textContent = data.message;
                        responseMessage.className = data.success ? 'alert alert-success' : 'alert alert-danger';

                        // Optionally, redirect the user to the login page after successful password reset
                        if (data.success) {
                            setTimeout(function() {
                                window.location.href = 'signin.php';
                            }, 2000);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>