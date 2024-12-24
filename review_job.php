<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Home Builders - Respond to request</title>
</head>

<body>
    <?php include 'nav.php'; ?>

    <div class="container mt-5 col-md-6">
        <form action="job_accept.php" method="post">
            <input type="hidden" id="job_id" name="job_id">
            <div class="form-group mb-3">
                <label for="title">Customer</label>
                <input type="text" class="form-control" id="customer_name" disabled>
            </div>
            <div class="form-group mb-3">
                <label for="title">Title</label>
                <input type="text" class="form-control" id="title" disabled>
            </div>
            <div class="form-group mb-3">
                <label for="description">Description</label>
                <textarea class="form-control" id="description" rows="3" disabled></textarea>
            </div>
            <div class="form-group mb-3">
                <label for="requestedDate">Requested Date</label>
                <input type="date" class="form-control" id="requestedDate" disabled>
            </div>
            <div class="form-group mb-3">
                <label for="startDate">Starting Date</label>
                <input type="date" class="form-control" id="startDate" name="startDate" required>
            </div>
            <div class="form-group mb-3">
                <label for="endDate">Ending Date</label>
                <input type="date" class="form-control" id="endDate" name="endDate" required>
            </div>
            <div class="form-group mb-3">
                <label for="rate">Estimate</label>
                <input type="number" class="form-control" id="estimate" name="estimate" placeholder="Enter Estimate" required>
            </div>
            <div class="d-flex justify-content-end align-items-center mb-3">
                <button type="button" class="btn btn-info me-1" id="chatButton">Chat</button>
                <button type="button" class="btn btn-danger me-1" id="declineButton">Decline</button>
                <button type="submit" class="btn btn-success">Accept</button>
            </div>
        </form>
    </div>

    <script>
        const queryString = window.location.search;
        const params = new URLSearchParams(queryString);
        const job_id = params.get('job_id');

        let customer_id;

        let info;

        fetch(`get_job.php?job_id=${job_id}`)
            .then(response => response.json())
            .then(data => {
                info = data;
                console.log(data);
                document.getElementById('job_id').value = data.job_id;
                document.getElementById('customer_name').value = data.name;
                document.getElementById('title').value = data.job_title;
                document.getElementById('description').value = data.job_description;
                document.getElementById('requestedDate').value = data.job_required_date;
                customer_id = data.job_customer_id;
            })
            .catch(error => {
                console.error('Error:', error);
            });

        document.getElementById('declineButton').addEventListener('click', function() {
            const confirmation = confirm(`Are you sure you want to decline this request from ${info.name}?`);

            if (confirmation) {
                fetch(`job_decline.php?job_id=${job_id}`)
                    .then(response => {
                        if (response.ok) {
                            history.back();
                        }
                    })
            }
        });

        document.addEventListener("DOMContentLoaded", () => {
            const chatButton = document.getElementById("chatButton");

            chatButton.addEventListener("click", () => {
                Swal.fire({
                    title: 'Contact Customer',
                    text: "Start chat with say \"Hi!\"",
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, send it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        fetch('send_message.php', {
                                method: 'POST',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    to_id: customer_id,
                                    message: "Hi!"
                                })
                            })
                            .then(response => response.json())
                            .then(data => {
                                console.log(data);
                                if (data.success) {
                                    Swal.fire(
                                        'Sent!',
                                        'Your message has successfully sent.',
                                        'success'
                                    ).then((result) => {
                                        window.location.href = "chats.php";
                                    });
                                } else {
                                    Swal.fire(
                                        'Error',
                                        'Message sending failed. ' + data.error,
                                        'error'
                                    );
                                }
                            })
                            .catch(error => {
                                Swal.fire(
                                    'Error',
                                    'An error occurred while sending the message.',
                                    'error'
                                );
                            });
                        Swal.fire(
                            'Sent!',
                            'Your message has succesfully sent.',
                            'success'
                        ).then((result) => {
                            window.location.href = "chats.php";
                        });
                    }
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>