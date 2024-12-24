<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Home Builders - Sign In</title>
</head>

<body>
    <?php include 'nav.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center">Forgot Password</h1>
        <div class="col-md-6 mx-auto">
            <form id="forgot-password-form">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary">Send Reset Link</button>
                </div>
            </form>
            <!-- Response message div -->
            <div id="response-message" class="col-md-6 mx-auto text-center"></div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const forgotPasswordForm = document.getElementById('forgot-password-form');
            const responseMessage = document.getElementById('response-message');

            forgotPasswordForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(forgotPasswordForm);

                fetch('forgot_password_process.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        // Display the response message to the user
                        responseMessage.textContent = data.message;
                        responseMessage.className = data.success ? 'alert alert-success' : 'alert alert-danger';
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