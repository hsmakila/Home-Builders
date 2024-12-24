<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin Profile</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body>
    <?php include("nav.php") ?>

    <!-- Content Section -->
    <div class="container mt-4">
        <h1>Admin Dashboard</h1>
        <hr>

        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid container mx-auto">
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0" id="links">
                        <li class="nav-item" style="border-right: 1px solid #ccc;">
                            <a class="nav-link" href="admin_hold_payments.php">Hold Payments Management</a>
                        </li>
                        <li class="nav-item" style="border-right: 1px solid #ccc;">
                            <a class="nav-link" href="admin_user_profile.php">User Profile Management</a>
                        </li>
                        <li class="nav-item" style="border-right: 1px solid #ccc;">
                            <a class="nav-link" href="admin_news.php">News Management</a>
                        </li>
                        <li class="nav-item" style="border-right: 1px solid #ccc;">
                            <a class="nav-link disabled" href="admin_faq.php">FAQ Management</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="admin_complaint.php">Complaint Management</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <hr>

        <!-- FAQ Section -->
        <div id="faq" class="mb-4">
            <div class="row">
                <h3>FAQ Management</h3>
                <hr>

                <h5>Add FAQ</h5>
                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="question" placeholder="Enter question">
                    <input type="text" class="form-control" id="answer" placeholder="Enter answer">
                    <button class="btn btn-primary" onclick="addFAQ()">Add</button>
                </div>
                <hr>

                <div class="input-group mb-3">
                    <input type="text" class="form-control" id="faqSearch" placeholder="Search by name">
                    <button class="btn btn-primary" onclick="searchFAQ()">Search</button>
                </div>

                <table class="table" id="faq-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Question</th>
                            <th>Answer</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- FAQs will be dynamically added here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        function searchFAQ() {
            console.log("Searching FAQs...");
            const faqSearchInput = document.getElementById('faqSearch');
            const searchTerm = faqSearchInput.value;

            fetch(`get_faq_admin.php?keyword=${searchTerm}`)
                .then(response => response.json())
                .then(data => {
                    console.log(data);
                    const faqTable = document.getElementById('faq-table').getElementsByTagName('tbody')[0];
                    faqTable.innerHTML = "";

                    data.forEach(faq => {
                        const row = faqTable.insertRow();
                        row.innerHTML = `<td>${faq.faq_id}</td><td>${faq.question}</td><td>${faq.answer}</td><td><a class="btn btn-danger" href="delete_faq_admin.php?faq_id=${faq.faq_id}">Delete</a></td>`;
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        }

        function addFAQ() {
            const questionInput = document.getElementById('question');
            const answerInput = document.getElementById('answer');

            const question = questionInput.value;
            const answer = answerInput.value;

            if (question.trim() === '' || answer.trim() === '') {
                alert('Please enter both question and answer.');
                return;
            }

            fetch('add_faq_admin.php', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/x-www-form-urlencoded',
                    },
                    body: `question=${encodeURIComponent(question)}&answer=${encodeURIComponent(answer)}`,
                })
                .then(response => response.text())
                .then(result => {
                    questionInput.value = '';
                    answerInput.value = '';
                    searchFAQ();
                })
                .catch(error => console.error('Error adding FAQ:', error));
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('faqSearch').addEventListener('input', searchFAQ);
            searchFAQ();
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>

</html>