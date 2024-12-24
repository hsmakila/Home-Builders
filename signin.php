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
        <h1 class="text-center">Sign In</h1>
        <div class="col-md-6 mx-auto">
            <form id="signin-form">
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="mb-3 form-check">
                    <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
                    <label class="form-check-label" for="rememberMe">Remember Me</label>
                </div>
                <div class="mb-3 text-center">
                    <button type="submit" class="btn btn-primary">Sign In</button>
                </div>
            </form>
            <div class="text-center">
                <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
                <a href="forgot_password.php">Forgot your password?</a>
            </div>
            <!-- Response message div -->
            <div id="response-message" class="col-md-6 mx-auto text-center"></div>
        </div>


    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const signupForm = document.getElementById('signin-form');
            const responseMessage = document.getElementById('response-message');

            signupForm.addEventListener('submit', function(event) {
                event.preventDefault();
                const formData = new FormData(signupForm);

                fetch('signin_process.php', {
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
                            window.location.href = 'home.php';
                        } else {
                            // Registration failed, show an error message
                            responseMessage.textContent = data.message;
                            responseMessage.className = 'alert alert-danger';

                            if (data.message == "Not verified.") {
                                window.location.href = 'verify.php?user_id=' + data.user_id;
                            }
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                    });
            });
        });

        document.addEventListener("DOMContentLoaded", function() {
            // Check if the "Remember Me" checkbox is checked and populate the email field if a cookie exists
            var rememberMeCheckbox = document.getElementById("rememberMe");
            var emailField = document.getElementById("email");

            if (rememberMeCheckbox && emailField) {
                rememberMeCheckbox.addEventListener("change", function() {
                    if (this.checked) {
                        // Set a cookie with the email
                        document.cookie = "rememberedEmail=" + encodeURIComponent(emailField.value) + "; expires=Thu, 31 Dec 2037 12:00:00 UTC; path=/";
                    } else {
                        // Clear the cookie
                        document.cookie = "rememberedEmail=; expires=Thu, 01 Jan 1970 00:00:00 UTC; path=/";
                    }
                });

                // Check for the existence of the cookie on page load
                var rememberedEmail = getCookie("rememberedEmail");
                if (rememberedEmail !== "") {
                    emailField.value = decodeURIComponent(rememberedEmail);
                    rememberMeCheckbox.checked = true;
                }
            }

            // Helper function to get the value of a cookie by name
            function getCookie(name) {
                var cookieValue = "";
                var cookies = document.cookie.split(";");

                cookies.forEach(function(cookie) {
                    var parts = cookie.split("=");
                    var cookieName = parts.shift().trim();
                    if (cookieName === name) {
                        cookieValue = parts.join("=");
                    }
                });

                return cookieValue;
            }
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
</body>

</html>