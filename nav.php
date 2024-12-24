<!-- <html lang="en"> -->
<html lang="en" data-bs-theme="dark">
    
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.1/css/all.min.css">

<!-- <style>
    body {
        background-color: #1b0e3d;
    }
</style> -->

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid container">
        <a class="navbar-brand" href="home.php">
            <img src="asserts/logo.png" alt="Logo" width="30" height="30" class="d-inline-block align-text-top">
            Home Builders
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0" id="links">
                <li class="nav-item">
                    <a class="nav-link" href="search.php">Search</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="designs.php">Designs</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="news.php">News</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="faq.php">FAQ</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="about_us.php">About Us</a>
                </li>
                <li class="nav-item align-items-center d-flex">
                    <a class="nav-link" href="chats.php"><i class="fas fa-comment" id="chat_icon"></i></a>
                </li>
                <!-- Notification icon and dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" id="nav-notifications">
                        <i class="fas fa-bell" id="notification_icon"></i>
                    </a>
                    <ul id="notifications" class="dropdown-menu dropdown-menu-end">
                        <li class="dropdown-header" style="width: 500px;">Notifications</li>
                        <!-- Notifications will be loaded by JS -->
                    </ul>
                </li>
            </ul>

            <!-- Search form -->
            <form class="navbar-nav d-flex" role="search" action="search.php" method="get">
                <input class="form-control me-2" type="search" name="filter" placeholder="Search" aria-label="Search">
            </form>

            <!-- User profile icon and dropdown -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false" id="nav-username">
                        Guest
                        <img src="asserts/default-profile-pic.png" alt="Profile" width="24" height="24" class="d-inline-block align-text-top">
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li><a id="signin" class="dropdown-item" href="signin.php">Sign In</a></li>
                        <li><a id="signup" class="dropdown-item" href="signup.php">Sign Up</a></li>
                        <li><a id="signout" class="dropdown-item" href="signout.php">Sign Out</a></li>
                        <li><a id="profile" class="dropdown-item" href="profile.php">Profile</a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", () => {
        fetch("get_current_user.php")
            .then((response) => response.json())
            .then((data) => {
                if (data.success) {
                    // User logged in
                    document.getElementById("nav-username").innerHTML = `${data.name} <img src="profile-pic/p${data.id}.jpg" alt="Profile" width="24" height="24"
                            class="d-inline-block align-text-top rounded-circle" onerror="this.src='asserts/default-profile-pic.png'">`;

                    // Hide Sign In and Sign Up buttons
                    document.getElementById('signin').style.display = 'none';
                    document.getElementById('signup').style.display = 'none';
                } else {
                    // User not logged in
                    // Hide Sign Out and Profile buttons
                    document.getElementById('signout').style.display = 'none';
                    document.getElementById('profile').style.display = 'none';
                }
            });

        fetch("get_user_notifications.php")
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                if (data.status == "success") {
                    const notificationsDropdown = document.getElementById("notifications");
                    data.data.forEach((notification) => {
                        const notificationItem = document.createElement("li");

                        notificationItem.innerHTML = `
                        <div class="row mx-2">
                            <div class="col-2">
                                <img src="profile-pic/p${notification.notification_from_user_id}.jpg" alt="Contact 1" class="rounded-circle" style="width: 50px;">
                            </div>
                            <div class="col-8 justify-content-center align-items-center">
                                <p>${notification.notification_title}</p>
                            </div>
                        </div>
                        <hr>`
                        notificationItem.onclick = function() {
                            mark_notification_as_read(notification.notification_id)
                        };
                        notificationsDropdown.appendChild(notificationItem);
                    });
                }
            });


        fetch("isNewChat.php")
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                const chat_icon = document.getElementById("chat_icon");
                if (data.status) {
                    chat_icon.style.color = "green";
                }

            });

        fetch("areNewNotifications.php")
            .then((response) => response.json())
            .then((data) => {
                console.log(data);
                const notification_icon = document.getElementById("notification_icon");
                if (data.newNotifications) {
                    notification_icon.style.color = "green";
                }
            });

        function mark_notification_as_read(notification_id) {
            console.log("Marking Notification with id:" + notification_id + " as read.")
            fetch(`read_notification.php?notification_id=${notification_id}`);
        }

    });
</script>