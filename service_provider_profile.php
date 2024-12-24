<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Builders - Constructor Profile</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        var calendar;
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');
            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
            });
            calendar.render();

            // Function to change calendar view
            function changeCalendarView(view) {
                calendar.changeView(view);
            }

            // Add event listeners for view change buttons
            document.getElementById('viewMonth').addEventListener('click', function() {
                changeCalendarView('dayGridMonth');
            });

            document.getElementById('viewWeek').addEventListener('click', function() {
                changeCalendarView('timeGridWeek');
            });

            document.getElementById('viewDay').addEventListener('click', function() {
                changeCalendarView('timeGridDay');
            });

            document.getElementById('viewList').addEventListener('click', function() {
                changeCalendarView('listWeek');
            });
        });
    </script>
</head>

<body>

    <?php include 'nav.php'; ?>

    <div class="container mt-4">
        <div class="row">
            <!-- Column 1 -->
            <div class="col-md-6">
                <!-- User Information Box -->
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <!-- Left Column - Profile Picture -->
                            <div class="col-md-4">
                                <div class="text-center">
                                    <img alt="Profile Picture" class="img-fluid rounded-circle mb-3" id="profile-pic" onerror="this.src='asserts/default-profile-pic.png'">
                                </div>
                            </div>
                            <!-- Right Column - User Information -->
                            <div class="col-md-8">
                                <h1 id="user-name"></h1>
                                <p><i class="fas fa-user"></i> <span id="user-type"></span></p>
                                <p><i class="fas fa-envelope"></i> <span id="user-email"></span></p>
                                <p><i class="fas fa-phone"></i> <span id="user-phone"></span></p>
                                <p><i class="fas fa-sticky-note"></i> <span id="user-discription"></span></p>
                                <p><i class="fas fa-location"></i> <span id="user-location"></span></p>
                                <a href="service_provider_profile_edit.php" class="btn btn-primary">Edit Profile</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="service-images" class="my-2" style="height: 300px; overflow: hidden;">
                    <div id="slideshow">
                        <!-- Images will be loaded here -->
                    </div>
                </div>
                <a href="gallery.php" id="gallery" class="btn btn-primary">View Gallery</a>

                <!-- Services -->
                <div class="mt-5">
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <h2 class="">Services</h2>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="new_service.php" class="btn btn-primary">New Service</a>
                        </div>
                    </div>

                    <div class="list-group" id="services-list">
                        <!-- will be loaded by JS -->
                    </div>
                </div>
            </div>

            <!-- Column 2 -->
            <div class="col-md-6">
                <!-- User Information Box -->
                <div class="card mb-5">
                    <div class="card-body">
                        <h1>Account Stats</h1>
                        <hr>
                        <h4 class="text-success"><i class="fas fa-money-bill"></i> Total Account Value: Rs. <span id="user-account-total-value"></span></h4>
                        <br>
                        <h4 class="text-info"><i class="fas fa-cart-shopping"></i> No of Jobs: <span id="user-no-of-job"></span></h4>
                        <br>
                        <h4 class="text-warning"><i class="fas fa-star"></i> Rating: <span id="user-rating"></span>/5</h4>
                    </div>
                </div>

                <!-- Calender Buttons -->
                <div id="calendar-buttons">
                    <button id="viewMonth" class="btn btn-primary">Month</button>
                    <button id="viewWeek" class="btn btn-primary">Week</button>
                    <button id="viewDay" class="btn btn-primary">Day</button>
                    <button id="viewList" class="btn btn-primary">List</button>
                </div>

                <!-- Calender -->
                <div id='calendar' class="mb-3"></div>

                <!-- Requests -->
                <div class="mb-4">
                    <h3 class="text-secondary">New</h3>
                    <div class="list-group" id="new_list">
                        <!-- will be loaded by JS -->
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="text-info">Accepted (Advance Paymet Pending)</h3>
                    <div class="list-group" id="accepted_list">
                        <!-- will be loaded by JS -->
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="text-primary">Scheduled</h3>
                    <div class="list-group" id="scheduled_list">
                        <!-- will be loaded by JS -->
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="text-warning">Ongoing/Delivering</h3>
                    <div class="list-group" id="ongoing_list">
                        <!-- will be loaded by JS -->
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="text-success">Done/Delivered</h3>
                    <div class="list-group" id="done_list">
                        <!-- will be loaded by JS -->
                    </div>
                </div>

                <div class="mb-4">
                    <h3 class="text-danger">Declined</h3>
                    <div class="list-group" id="declined_list">
                        <!-- will be loaded by JS -->
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        function loadServiceProviderStats(service_provider_id) {
            fetch(`get_service_provider_stats.php?service_provider_id=${service_provider_id}`)
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
                    
                    if (data.total_account_value == null) {
                        document.getElementById("user-account-total-value").innerText = 0;
                    } else {
                        document.getElementById("user-account-total-value").innerText = Number(data.total_account_value).toLocaleString();
                    }
                    if (data.job_count == null) {
                        document.getElementById("user-no-of-job").innerText = 0;
                    } else {
                        document.getElementById("user-no-of-job").innerText = data.job_count;
                    }
                    if (data.avarage_rating == null) {
                        document.getElementById("user-rating").innerText = 0;
                    } else {
                        document.getElementById("user-rating").innerText = data.avarage_rating;
                    }
                });
        }

        window.addEventListener("DOMContentLoaded", () => {
            fetch("get_current_user.php")
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
                    if (data.success) {
                        document.getElementById("profile-pic").src = `profile-pic/p${data.id}.jpg`;
                        document.getElementById("user-name").innerText = `${data.name}`;
                        document.getElementById("user-type").innerText = `${data.type.charAt(0).toUpperCase() + data.type.slice(1).toLowerCase() + " profile"}`;
                        document.getElementById("user-email").innerText = `Email: ${data.email}`;
                        if (data.phone == null) {
                            document.getElementById("user-phone").innerText = `Phone: Not set`;
                        } else {
                            document.getElementById("user-phone").innerText = `Phone: ${data.phone}`;
                        }
                        if (data.description == null) {
                            document.getElementById("user-discription").innerText = `Discription: Not set`;
                        } else {
                            document.getElementById("user-discription").innerText = `Discription: ${data.description}`;
                        }
                        document.getElementById("user-location").innerText = `Location: ${data.location_name}`;
                        loadServiceProviderStats(data.id);
                    }
                });



            fetch('get_service_provider_services.php')
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
                    if (data.length > 0) {
                        const services_list = document.getElementById("services-list");
                        const tableBody = document.querySelector('#services-table tbody');

                        data.forEach((service) => {
                            const list_item = document.createElement('div');
                            list_item.className = "list-group-item list-group-item-action";
                            list_item.innerHTML = `
                                <div class="d-flex w-100 justify-content-between">
                                    <h5>${service.title}</h5>
                                    <a href=troggle_service_status.php?service_id=${service.service_id} class="btn ${service.is_available == 1 ? 'btn-danger' : 'btn-success'}">${service.is_available == 1 ? 'Deactivate' : 'Activate'}</a>
                                </div>
                                <small class="mb-1">Category: ${service.sub_category}<br></small>
                                <small class="mb-1">Description: ${service.description}<br></small>
                                <small class="mb-1">Rate: ${service.rate}/${service.unit}<br></small>
                                Status: <b><span class="${service.is_available == 1 ? 'text-success' : 'text-warning'}">${service.is_available == 1 ? 'Active' : 'Inactive'}</span></b>
                            `;
                            services_list.append(list_item);
                        });
                    }

                });

            fetch('get_service_provider_jobs.php')
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
                    var today = new Date();
                    data.forEach((Job) => {
                        if (['scheduled', 'ongoing', 'done'].includes(Job.job_status)) {
                            var from_date = new Date(Job.job_from_date);
                            var to_date = new Date(Job.job_to_date);
                            to_date.setDate(to_date.getDate() + 1);
                            var job_status = Job.job_status;

                            var color;
                            if (Job.job_status == "scheduled") {
                                color = 'blue';
                            } else if (job_status == 'ongoing') {
                                color = 'orange';
                            } else if (job_status == 'done') {
                                color = 'green';
                            }

                            var newEvent = {
                                title: Job.job_title,
                                start: from_date,
                                end: to_date,
                                allDay: true,
                                backgroundColor: color,
                                borderColor: color,
                            };
                            calendar.addEvent(newEvent);
                        }

                        const list_item = document.createElement('div');
                        list_item.className = "list-group-item list-group-item-action";
                        list_item_content = `
                                <div class="d-flex w-100 justify-content-between">
                                    <h5>${Job.job_title}</h5>`;

                        if (Job.job_status == 'new') {
                            const new_list = document.getElementById('new_list');

                            list_item_content += `
                                    <a href=review_job.php?job_id=${Job.job_id} class="btn btn-primary">Review</a>
                                </div>
                                <small class="mb-1">Customer: ${Job.name}<br></small>
                                <small class="mb-1">Description: ${Job.job_description}<br></small>
                                <small class="mb-1">Required Date: ${Job.job_required_date}<br></small>
                            `;
                            list_item.innerHTML = list_item_content;
                            new_list.append(list_item);
                        } else if (Job.job_status == 'accepted') {
                            const accepted_list = document.getElementById('accepted_list');

                            list_item_content += `
                                </div>
                                <small class="mb-1">Customer: ${Job.name}<br></small>
                                <small class="mb-1">Description: ${Job.job_description}<br></small>
                                <small class="mb-1">From: ${Job.job_from_date} To: ${Job.job_to_date}<br></small>
                            `;
                            list_item.innerHTML = list_item_content;
                            accepted_list.append(list_item);
                        } else if (Job.job_status == 'scheduled') {
                            const scheduled_list = document.getElementById('scheduled_list');

                            list_item_content += `
                                    <a href="javascript:void(0);" class="btn btn-primary" onclick="showJobStartConfirmation(${Job.job_id})">Start</a>
                                </div>
                                <small class="mb-1">Customer: ${Job.name}<br></small>
                                <small class="mb-1">Description: ${Job.job_description}<br></small>
                                <small class="mb-1">From: ${Job.job_from_date} To: ${Job.job_to_date}<br></small>
                            `;
                            list_item.innerHTML = list_item_content;
                            scheduled_list.append(list_item);
                        } else if (Job.job_status == 'ongoing') {
                            const ongoing_list = document.getElementById('ongoing_list');

                            list_item_content += `
                                    <a href="javascript:void(0);" class="btn btn-primary" onclick="showMarkAsCompletedConfirmation(${Job.job_id})">Mark as Complete</a>
                                </div>
                                <small class="mb-1">Customer: ${Job.name}<br></small>
                                <small class="mb-1">Description: ${Job.job_description}<br></small>
                                <small class="mb-1">From: ${Job.job_from_date} To: ${Job.job_to_date}<br></small>
                            `;
                            list_item.innerHTML = list_item_content;
                            ongoing_list.append(list_item);
                        } else if (Job.job_status == 'done') {
                            const done_list = document.getElementById('done_list');

                            if (Job.job_customer_rating != null) {
                                list_item_content += `
                                    <i class="fas fa-star text-warning"> ${Job.job_customer_rating}/5</i>
                                `
                            }

                            list_item_content += `
                                </div>
                                <small class="mb-1">Customer: ${Job.name}<br></small>
                                <small class="mb-1">Description: ${Job.job_description}<br></small>
                            `;
                            if (Job.job_customer_rating != null) {
                                list_item_content += `
                                <small class="mb-1 text-info">Feedback: ${Job.job_customer_feedback}<br></small>
                                `
                            }
                            list_item.innerHTML = list_item_content;
                            done_list.append(list_item);
                        } else if (Job.job_status == 'declined') {
                            const declined_list = document.getElementById('declined_list');

                            list_item_content += `
                                </div>
                                <small class="mb-1">Customer: ${Job.name}<br></small>
                                <small class="mb-1">Description: ${Job.job_description}<br></small>
                                <small class="mb-1">Required Date: ${Job.job_required_date}<br></small>
                            `;
                            list_item.innerHTML = list_item_content;
                            declined_list.append(list_item);
                        }
                    });


                });
        });

        window.addEventListener("DOMContentLoaded", () => {
            let currentImageIndex = 0;
            const imageContainer = document.getElementById("slideshow");

            function getServiceImages() {
                return fetch("get_service_provider_images.php")
                    .then((response) => response.json())
                    .then((data) => {
                        return data;
                    });
            }

            function displayServiceImages(images) {
                if (images.length === 0) return;

                function showCurrentImage() {
                    imageContainer.innerHTML = "";
                    const imgElement = document.createElement("img");
                    imgElement.src = `service-pic/${images[currentImageIndex]}`;
                    imgElement.className = "img-thumbnail";
                    imageContainer.appendChild(imgElement);
                }

                showCurrentImage();

                function nextImage() {
                    currentImageIndex = (currentImageIndex + 1) % images.length;
                    showCurrentImage();
                }

                const imageSlideshowInterval = setInterval(nextImage, 2000);
            }

            getServiceImages()
                .then((images) => {
                    displayServiceImages(images);
                });
        });

        function showJobStartConfirmation(job_id) {
            Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to start this job?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, start the job',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `Job_start.php?job_id=${job_id}`;
                }
            });
        }

        function showMarkAsCompletedConfirmation(job_id) {
            Swal.fire({
                title: 'Confirmation',
                text: 'Are you sure you want to mark this job as complete?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, mark as complete',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `Job_complete.php?job_id=${job_id}`;
                }
            });
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>