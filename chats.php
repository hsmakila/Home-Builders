<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Home Builders - Chat</title>
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">
</head>

<body>
	<?php include("nav.php"); ?>

	<div class="container">
		<div class="row mt-5">
			<div class="col-md-4">
				<div class="p-3" >
					<div class="d-flex flex-row align-items-center">
						<div>
							<img src="profile-pic/p1.jpg" class="rounded-circle" style="width: 50px;" id="current_user_profile_pic">
						</div>
						<div class="ms-3">
							<h5 id="current_user_name">Me</h5>
						</div>
					</div>
				</div>
				<!-- List of contacts -->
				<div class=" list-group" id="contact_list">
					<!-- will be loaded by JS -->
				</div>
			</div>
			<div class="col-md-8">
				<div class="p-3">
					<div class="d-flex flex-row align-items-center">
						<img src="asserts/default-profile-pic.png" class="rounded-circle" style="width: 50px;" id="selected_user_profile_pic">
						<h5 class="ms-3" id="selected_user_name"></h5>
					</div>
				</div>
				<!-- List of chats -->
				<div class="list-group" id="chat_list" style="max-height: 100hv; overflow-y: auto;">
					<!-- will be loaded by JS -->
				</div>

				<!-- Input box for new message and Icon for sending -->
				<form class="d-flex flex-row" id="new_message_box">
					<input type="text" class="form-control d-inline-flex" placeholder="Type your message" id="new_message">
					<button type="submit" class="btn btn-success d-inline-flex" id="new_message_send_button">Send</button>
				</form>
			</div>
		</div>
	</div>

	<script>
		let current_user;
		let chats;

		async function fetchCurrentUser() {
			fetch('get_current_user.php')
				.then((response) => response.json())
				.then((data) => {
					console.log(data);
					if (data.success) {
						current_user = data;
						updateCurrentUserDetails();
						fetchChats();
					} else {
						window.location.href = "signin.php";
					}
				});
		}

		async function fetchChats() {
			fetch('get_chats.php')
				.then((response) => response.json())
				.then((data) => {
					console.log(data);
					chats = data;
					loadUsers();
				});
		}

		// Function to update the current user's details
		function updateCurrentUserDetails() {
			document.getElementById("current_user_profile_pic").src = `profile-pic/p${current_user.id}.jpg`;
			document.getElementById("current_user_name").textContent = current_user.name;
		}

		// Function to load chats
		function loadChats(selected_user_id) {
			let chat_list = document.getElementById("chat_list");
			chat_list.innerHTML = "";
			chats.forEach(chat => {
				if (chat.from_id == selected_user_id || chat.to_id == selected_user_id) {
					const list_item = document.createElement('div');
					list_item.className = "list-group-item d-flex";

					const messageTime = new Date(chat.timestamp).toLocaleString();

					if (chat.from_id == current_user.id) {
						list_item.classList.add("justify-content-end");
						list_item.innerHTML = `
							<div class="me-2 ms-5">
								<div class="text-end p-2 rounded-4" style="background-color: #808080; color: white;">
									<p class="message">${chat.message}</p>
									<small class="text-muted d-flex justify-content-end">${chat.date_time}</small>
								</div>
							</div>
							<img src="profile-pic/p${chat.from_id}.jpg" class="rounded-circle d-inline-flex" style="width: 25px; height: 25px;">
						`;
					} else {
						list_item.innerHTML = `
							<img src="profile-pic/p${chat.from_id}.jpg" class="rounded-circle d-inline-flex" style="width: 25px; height: 25px;">
							<div class="ms-2 me-5">
								<div class="p-2 rounded-4" style="background-color: #808080; color: white;">
									<p class="message">${chat.message}</p>
									<small class="text-muted d-flex">${chat.date_time}</small>
								</div>
							</div>
						`;
					}

					chat_list.appendChild(list_item);
				}
			});
			document.getElementById("chat_list").style.maxHeight = (window.innerHeight - 300) + "px";
			document.getElementById("chat_list").scrollTop = document.getElementById("chat_list").scrollHeight;
		}

		function showChat(chat_user_id, chat_user_name) {
			document.getElementById("selected_user_profile_pic").src = `profile-pic/p${chat_user_id}.jpg`;
			document.getElementById("selected_user_profile_pic").alt = `${chat_user_id}`;
			document.getElementById("selected_user_name").textContent = `${chat_user_name}`;
			loadChats(chat_user_id);

			fetch("seen.php?from_id=" + chat_user_id);
		}

		// Function to load the users
		function loadUsers() {
			let contact_list = document.getElementById("contact_list");
			contact_list.innerHTML = '';
			let addedUsers = new Set();
			[...chats].reverse().forEach(chat => {
				let chat_user_id = chat.from_id;
				let chat_user_name = chat.from_user_name;
				if (chat_user_id == current_user.id) {
					chat_user_id = chat.to_id;
					chat_user_name = chat.to_user_name;
				}
				if (!addedUsers.has(chat_user_id)) {
					const list_item = document.createElement('div');
					list_item.className = "list-group-item list-group-item-action";
					list_item.innerHTML = `
						<div class="row align-items-center">
							<div class="col-2">
								<img src="profile-pic/p${chat_user_id}.jpg" alt="Contact 1" class="rounded-circle" style="width: 50px;">
							</div>
							<div class="col-8 justify-content-center align-items-center">
								<p>${chat_user_name}</p>
							</div>
							<div class="col-2">
								<i id="unread_mark_${chat_user_id}" class="fa-solid fa-circle"></i>
							</div>
						</div>
					`;

					list_item.addEventListener("click", () => {
						showChat(chat_user_id, chat_user_name);
					});

					contact_list.append(list_item);
					addedUsers.add(chat_user_id);
				}
				if (chat.to_id == current_user.id && chat.seen == 0) {
					document.getElementById(`unread_mark_${chat_user_id}`).style.color = "green";
				}
			});
			const lastChatFromId = chats[chats.length - 1].from_id;
			const lastChatFromName = chats[chats.length - 1].from_user_name;
			const lastChatToId = chats[chats.length - 1].to_id;
			const lastChatToName = chats[chats.length - 1].to_user_name;
			if (lastChatFromId == current_user.id) {
				showChat(lastChatToId, lastChatToName);
			} else {
				showChat(lastChatFromId, lastChatFromName);
			}
		}

		window.addEventListener("DOMContentLoaded", () => {
			fetchCurrentUser();
		});

		document.getElementById("new_message_send_button").addEventListener("click", function(event) {
			event.preventDefault();

			const message = document.getElementById("new_message").value;

			if (message.trim() !== "") {
				const date = new Date();
				const newChat = {
					from_id: current_user.id,
					to_id: document.getElementById("selected_user_profile_pic").alt,
					message: message,
					date_time: `${date.getFullYear()}-${date.getMonth() + 1}-${date.getDate()} ${date.getHours()}:${date.getMinutes()}:${date.getSeconds()}`
				};

				chats.push(newChat);

				loadChats(document.getElementById("selected_user_profile_pic").alt);

				sendMessageToBackend(newChat);

				document.getElementById("new_message").value = "";
			}
		});

		function sendMessageToBackend(newChat) {
			fetch('send_message.php', {
					method: 'POST',
					body: JSON.stringify(newChat),
					headers: {
						'Content-Type': 'application/json'
					}
				})
				.then(response => response.json())
				.then(data => {
					console.log(data);
				})
				.catch(error => {
					console.error('Error:', error);
				});
		}
	</script>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>