 <!DOCTYPE html>
 <html>

 <head>
 	<meta charset="UTF-8">
 	<meta name="viewport" content="width=device-width, initial-scale=1.0">
 	<title>Home Builders - Profile</title>

 	<style>
 		div.scroll-container {
 			overflow: auto;
 			white-space: nowrap;
 			padding: 10px;
 			height: 300px;
 		}

 		div.scroll-container img {
 			padding: 10px;
 			height: 250px;
 		}
 	</style>

 	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
 	<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 	<script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/index.global.min.js'></script>

 	<script>
 		var calendar;
 		document.addEventListener('DOMContentLoaded', function() {
 			var calendarEl = document.getElementById('calendar');
 			calendar = new FullCalendar.Calendar(calendarEl, {
 				initialView: 'dayGridMonth',
 			});
 			calendar.render();
 		});
 	</script>
 </head>

 <body>
 	<?php include 'nav.php'; ?>

 	<?php
		require_once('config_db.php');
		require_once('User.php');
		require_once('Service.php');

		$service_id = $_GET['service_id'];
		$service = new Service();
		$service->loadById($service_id);
		$service_provider = new User();
		$service_provider->loadById($service->getServiceProviderId());
		?>

 	<div class="container mt-5">
 		<div class="row">
 			<div class="col-md-6">
 				<div class="row">
 					<div class="col-md-4">
 						<img class="img-fluid rounded-circle" src=<?php echo "profile-pic/p" . $service_provider->getId() . ".jpg" ?> style="width: 300px">
 					</div>
 					<div class="col-md-8 my-auto">
 						<h2><?php echo $service_provider->getName() ?></h2>
 						<hr>
 						<h4 class="text-info"><i class="fas fa-cart-shopping"></i> No of Jobs Done: <span id="user-no-of-job"></span></h4>
 						<h4 class="text-warning"><i class="fas fa-star"></i> Rating: <span id="user-rating"></span>/5</h4>
 						<hr>
 						Description:
 						<p class="description"><?php echo $service_provider->getDescription() ?></p>
 						<div class="d-flex">
 							<button type="button" class="btn btn-primary me-2" id="chat_button">Chat</button>
 							<a type="button" class="btn btn-warning me-2" id="complain_button" href="complain.php?service_provider_id=<?= $service_provider->getId() ?>">Complain</a>
 						</div>
 					</div>
 				</div>
 				<hr>
 				<div>
 					<h5>Service Info</h5>
 					<h1><?php echo $service->getTitle() ?></h1>
 					<div><?php echo $service->getDescription() ?></div>
 					<div>Rs. <?php echo $service->getRate() ?>/<?php echo $service->getUnit() ?></div>
 					<div>Status: <span style="color: <?php echo ($service->getIsAvailable() == 1) ? 'green' : 'red'; ?>"><?php echo ($service->getIsAvailable() == 1) ? 'Active' : 'Inactive'; ?></span></div>
 					<br>
 					<a type="button" class="btn btn-primary" href="place_job.php?service_id=<?php echo $service_id ?>">Place a Booking</a>
 				</div>
 			</div>
 			<div class="col-md-6">
 				<!-- Calender -->
 				<div id='calendar' class="mb-3"></div>
 			</div>
 		</div>
 	</div>

 	<div class="container">
 		<h3 class="text-center mt-5">Previous Works</h3>
 		<div class="row">
 			<div class="col-4" id="image_col_1">
 				<!-- Col 1 -->
 			</div>
 			<div class="col-4" id="image_col_2">
 				<!-- Col 2 -->
 			</div>
 			<div class="col-4" id="image_col_3">
 				<!-- Col 3 -->
 			</div>
 		</div>
 	</div>

 	<script>
 		let service_provider;

 		window.addEventListener("DOMContentLoaded", () => {
 			fetch("get_current_user.php")
 				.then((response) => response.json())
 				.then((data) => {
 					if (data.success) {
 						service_provider = data;
 						document.getElementById("nav-username").innerHTML = `${data.name} <img src="profile-pic/p${data.id}.jpg" alt="Profile" width="24" height="24"
                            class="d-inline-block align-text-top rounded-circle" onerror="this.src='asserts/default-profile-pic.png'">`;
 					}
 				});

 			fetch(`get_service_provider_stats.php?service_provider_id=<?php echo $service_provider->getId() ?>`)
 				.then((response) => response.json())
 				.then((data) => {
 					console.log(data);

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
 		});

 		document.addEventListener("DOMContentLoaded", () => {
 			const chatButton = document.getElementById("chat_button");

 			chatButton.addEventListener("click", () => {
 				Swal.fire({
 					title: 'Contact Service Provider',
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
 									to_id: <?php echo $service_provider->getId() ?>,
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

 		document.addEventListener("DOMContentLoaded", function() {
 			const col1 = document.getElementById("image_col_1");
 			const col2 = document.getElementById("image_col_2");
 			const col3 = document.getElementById("image_col_3");

 			fetch("get_service_provider_images.php?service_provider_id=<?php echo $service_provider->getId() ?>")
 				.then((response) => response.json())
 				.then((data) => {
 					data.reverse()
 					let col = 1;
 					data.forEach(filename => {
 						const img = document.createElement("img");
 						img.className = "img-fluid m-2";
 						img.src = "service-pic/" + filename;
 						img.alt = filename;
 						if (col == 1) {
 							col1.appendChild(img);
 						} else if (col == 2) {
 							col2.appendChild(img);
 						} else if (col == 3) {
 							col3.appendChild(img);
 						}
 						col++;
 						if (col == 4) {
 							col = 1;
 						}
 					});
 				});
 		});

 		fetch('get_service_provider_schedule_by_service.php?service_id=<?php echo $service_id ?>')
 			.then((response) => response.json())
 			.then((data) => {
 				console.log(data);
 				var today = new Date();
 				data.forEach((Job) => {
 					var from_date = new Date(Job.job_from_date);
 					var to_date = new Date(Job.job_to_date);
 					to_date.setDate(to_date.getDate() + 1);

 					var color = 'orange';

 					var newEvent = {
 						title: 'Busy',
 						start: from_date,
 						end: to_date,
 						allDay: true,
 						backgroundColor: color,
 						borderColor: color,
 					};
 					calendar.addEvent(newEvent);
 				});


 			});
 	</script>

 	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
 </body>

 </html>