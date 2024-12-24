<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <title>Home Builders - Sign Up</title>
</head>

<body>
    <?php include 'nav.php'; ?>

    <div class="container mt-5">
        <h1 class="text-center">Sign Up</h1>
        <form class="col-md-6 mx-auto" id="signup-form">
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
            </div>
            <div class="mb-3">
                <label class="form-label">User Type</label>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="type" value="CUSTOMER" id="customer" checked>
                    <label class="form-check-label" for="customer">Customer</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="type" value="CONSTRUCTOR" id="material_provider">
                    <label class="form-check-label" for="material_provider">Constructor</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="type" value="DESIGNER" id="designer">
                    <label class="form-check-label" for="designer">Designer</label>
                </div>
                <div class="form-check">
                    <input type="radio" class="form-check-input" name="type" value="SUPPLIER" id="service_provider">
                    <label class="form-check-label" for="service_provider">Supplier</label>
                </div>
            </div>
            <div class="mb-3 text-center">
                <button type="submit" class="btn btn-primary">Sign Up</button>
            </div>
            <!-- Response message div -->
            <div id="response-message" class="col-md-6 mx-auto text-center"></div>
        </form>
        <div class="text-center">
            <p>Already have an account? <a href="signin.php">Sign In</a></p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const signupForm = document.getElementById('signup-form');
            const responseMessage = document.getElementById('response-message');

            signupForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(signupForm);

                fetch('signup_process.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        console.log(data);
                        if (data.success) {
                            // Registration was successful, show a success message
                            responseMessage.textContent = data.message;
                            responseMessage.className = 'alert alert-success';
                            // Optionally, you can redirect after a delay
                            window.location.href = 'signin.php';
                        } else {
                            // Registration failed, show an error message
                            responseMessage.textContent = data.message;
                            responseMessage.className = 'alert alert-danger';
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