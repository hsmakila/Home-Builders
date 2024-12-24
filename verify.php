<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Home Builders - Email Verification</title>
</head>

<body>
    <?php include 'nav.php'; ?>

    <div class="container mt-5 text-center">
        <?php
        if (isset($_GET['user_id'])) {
            $user_id = filter_var($_GET['user_id'], FILTER_SANITIZE_NUMBER_INT);
            require_once('config_db.php');
            require_once('User.php');
            $user = new User();
            $user->loadById($user_id);
            $user->sendVerificationCode();
        }
        ?>
        <h1 class="text-center">Verify Your Email Address</h1>
        <hr>
        <div>A verification code has been sent to</div>
        <h5><?php echo $user->getEmail(); ?></h5>
        <br>
        <div>Please check your inbox and enter the verification</div>
        <div>code below to verify your email address.</div>
        <br>
        <div class="col-md-4 mx-auto">
            <form id="verification-form" action="verify_email.php" method="post">
                <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                <div class="mb-3">
                    <label for="verification_code" class="form-label">Verification Code</label>
                    <input type="text" class="form-control text-center" id="verification_code" name="verification_code" required>
                </div>
                <div class="mb-3 text-center">
                    <button type="button" class="btn btn-primary" onclick="verifyEmail()">Verify</button>
                </div>
            </form>
            <div class="text-center">
                <a href="#" onclick="reloadPage()">Resend code</a>
            </div>
            <!-- Response message div -->
            <div id="response-message" class="mt-3 text-center"></div>
        </div>
    </div>

    <script>
        function reloadPage() {
            location.reload();
        }

        function verifyEmail() {
            var formData = new FormData(document.getElementById('verification-form'));

            fetch('verify_email.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    var responseMessageDiv = document.getElementById('response-message');
                    responseMessageDiv.innerHTML = '<div class="alert ' + (data.success ? 'alert-success' : 'alert-danger') + '" role="alert">' + data.message + '</div>';

                    if (data.success) {
                        window.location.href = 'signin.php';
                    }
                })
                .catch(error => console.error('Error:', error));
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>