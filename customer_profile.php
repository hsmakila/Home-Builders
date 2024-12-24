<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home Builders - Customer Profile</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

    <?php include 'nav.php'; ?>

    <div class="container mt-4">
        <div class="row">
            <!-- User Information Box -->
            <div class="col-md-6">
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
                                <!-- Add more user information here -->
                                <a href="customer_profile_edit.php" class="btn btn-primary">Edit Profile</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
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
        function confirmWithdraw(jobId) {
            Swal.fire({
                title: 'Confirm Withdrawal',
                text: 'Are you sure you want to withdraw this job?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, withdraw',
                cancelButtonText: 'Cancel',
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = `job_withdraw.php?job_id=${jobId}`;
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
                    }
                });



            fetch('get_customer_jobs.php')
                .then((response) => response.json())
                .then((data) => {
                    console.log(data);
                    const new_list = document.getElementById("new_list");
                    const accepted_list = document.getElementById("accepted_list");
                    const scheduled_list = document.getElementById("scheduled_list");
                    const ongoing_list = document.getElementById("ongoing_list");
                    const done_list = document.getElementById("done_list");
                    const declined_list = document.getElementById("declined_list");

                    data.forEach(job => {
                        const list_item = document.createElement('div');
                        list_item.className = "list-group-item list-group-item-action";
                        if (job.job_status == 'new') {
                            list_item.innerHTML = `
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">${job.job_title}</h5>
                                    <button class="btn btn-danger" onclick="confirmWithdraw(${job.job_id})">Withdraw</button>
                                </div>
                                <small class="mb-1">Service Provider: ${job.name}<br></small>
                                <small class="mb-1">${job.job_description}<br></small>
                                <small class="mb-1">${job.job_required_date}</small>
                            `;
                            new_list.append(list_item);
                        } else if (job.job_status == 'accepted') {
                            list_item.innerHTML = `
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">${job.job_title}</h5>
                                    <a href="payment_gateway.php?job_id=${job.job_id}" class="btn btn-primary">Pay Advance</a>
                                </div>
                                <small class="mb-1">Service Provider: ${job.name}<br></small>
                                <small class="mb-1">Rs. ${job.job_estimation}<br></small>
                                <small class="mb-1">${job.job_from_date} - ${job.job_to_date}</small>
                            `;
                            accepted_list.append(list_item);
                        } else if (job.job_status == "scheduled") {
                            list_item.innerHTML = `
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">${job.job_title}</h5>
                                    <button class="btn btn-danger">Cancel</button>
                                </div>
                                <small class="mb-1">Service Provider: ${job.name}<br></small>
                                <small class="mb-1">Rs. ${job.job_estimation}<br></small>
                                <small class="mb-1">${job.job_from_date} - ${job.job_to_date}</small>
                            `;
                            scheduled_list.append(list_item);
                        } else if (job.job_status == "ongoing") {
                            list_item.innerHTML = `
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">${job.job_title}</h5>
                                </div>
                                <small class="mb-1">Service Provider: ${job.name}<br></small>
                                <small class="mb-1">Rs. ${job.job_estimation}<br></small>
                                <small class="mb-1">${job.job_from_date} - ${job.job_to_date}</small>
                            `;
                            ongoing_list.append(list_item);
                        } else if (job.job_status == "done") {
                            if (job.job_customer_rating > 0) {
                                list_item.innerHTML = `
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">${job.job_title}</h5>
                                        <i class="fas fa-star text-warning"> ${job.job_customer_rating}/5</i>
                                    </div>
                                    <small class="mb-1">Service Provider: ${job.name}<br></small>
                                    <small class="mb-1">Rs. ${job.job_estimation}<br></small>
                                    <small class="mb-1">${job.job_from_date} - ${job.job_to_date}<br></small>
                                    <small class="mb-1 text-info">Feedback: ${job.job_customer_feedback}</small>
                                `;
                            } else {
                                list_item.innerHTML = `
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">${job.job_title}</h5>
                                        <a class="btn btn-primary" href="rate.php?job_id=${job.job_id}">Rate</a>
                                    </div>
                                    <small class="mb-1">Service Provider: ${job.name}<br></small>
                                    <small class="mb-1">Rs. ${job.job_estimation}<br></small>
                                    <small class="mb-1">${job.job_from_date} - ${job.job_to_date}</small>
                                `;
                            }

                            done_list.append(list_item);
                        } else if (job.job_status == "declined") {
                            list_item.innerHTML = `
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1">${job.job_title}</h5>
                                </div>
                                <small class="mb-1">Service Provider: ${job.name}<br></small>
                                <small class="mb-1">${job.job_description}</small>
                            `;
                            declined_list.append(list_item);
                        }
                    });

                });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>