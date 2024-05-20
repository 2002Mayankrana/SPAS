<?php
        session_start();
        ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Project Approval Requests</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('/mmm/images/w.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
        }

        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
            animation: slideIn 1s ease forwards;
            padding: 20px;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-100px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            0% { transform: translateX(-100px); opacity: 0; }
            100% { transform: translateX(0); opacity: 1; }
        }

        @keyframes fadeOut {
            0% { opacity: 1; }
            100% { opacity: 0; }
        }

        .card {
            animation: fadeIn 0.5s ease-in-out;
            position: relative;
            width: 350px;
            margin: 20px;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s, box-shadow 0.2s;
            display: flex;
            flex-direction: column;
            background-color: rgba(17, 37, 23, 0.836);
            border: 2px solid white;
            backdrop-filter: blur(10px);
        }

        .card.fade-out {
            opacity: 0.5;
            pointer-events: none;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.8);
            background-color: #295c34;
        }

        .card h3 {
            margin-top: 0;
            color: white;
            font-size: 1.2rem;
            margin-bottom: 5px;
        }

        .card h1 {
            margin-top: 0.5px;
            color: white;
            font-size: 1rem;
            position: absolute;
            top: 10px;
            right: 10px;
        }

        .card p {
            margin-bottom: 10px;
            color: white;
            font-size: 1rem;
        }

        .card .status {
            margin-top: auto;
            margin-bottom: 10px;
            color: white;
            font-size: 0.9rem;
        }

        .actions {
            margin-top: auto;
            display: flex;
            justify-content: space-around;
        }

        .actions button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s, transform 0.2s;
            color: black;
            font-size: 1rem;
        }

        .actions button.accept {
            background-color: #fff;
        }

        .actions button.decline {
            background-color: #fff;
        }

        .actions button.suggest {
            background-color: #fff;
        }

        .actions button:hover {
            transform: translateY(-3px);
        }

        .actions button:active {
            transform: translateY(1px);
        }

        .actions button.accept:hover {
            background-color: lightgreen;
        }

        .actions button.decline:hover {
            background-color: #EE4E4E;
        }

        .actions button.suggest:hover {
            background-color: #FFC94A;
        }

        .home-link {
            position: fixed;
            top: 5px;
            right: 5px;
            background-color: rgba(17, 37, 23, 0.836);
            border-radius: 1rem;
            border: 1px solid white;
            color: white;
            padding: 5px 10px;
            text-decoration: none;
            font-weight: bold;
            transition: background-color 0.3s;
        }

        .home-link:hover {
            background-color: lightgreen;
        }

        /* Modal Styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(5px);
            justify-content: center;
            align-items: center;
        }

        .modal-content {
            background-color: #fefefe;
            margin: auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
            border-radius: 10px;
            text-align: center;
        }

        .modal-content h2 {
            margin-top: 0;
        }

        .modal-content input {
            width: 90%;
            padding: 10px;
            margin: 10px 0;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .modal-content button {
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s;
            font-size: 1rem;
        }

        .modal-content button.save {
            background-color: #4CAF50;
            color: white;
        }

        .modal-content button.close {
            background-color: #E74C3C;
            color: white;
        }

        .modal-content button.save:hover {
            background-color: #45a049;
        }

        .modal-content button.close:hover {
            background-color: #c0392b;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="/mmm/welcomeM.php" class="home-link">«</a>

        <?php


        // Database configuration
        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "spas";

        // Create connection
        $conn = new mysqli($servername, $username, $password, $database);

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $mentor_id = $_SESSION['mentor_id'];
        // Fetch data from database
        $sql = "SELECT student_info.*, mentor_student_relationships.status 
        FROM student_info 
        JOIN mentor_student_relationships ON student_info.student_id = mentor_student_relationships.student_id
        WHERE mentor_student_relationships.mentor_id = '$mentor_id';
        ";
        $result = $conn->query($sql);

        // Display data as cards
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo '<div class="card" id="card_' . $row['student_id'] . '">';
                echo '<h3>' . $row['project_name'] . '</h3>';
                echo '<h1>Team: ' . $row['grp'] . '</h1>';
                echo '<p>' . $row['summarized_text'] . '</p>';
                echo '<div class="status">Status: ' . $row['status'] . '</div>';
                echo '<div class="actions">';
                echo '<button class="accept" onclick="updateStatus(' . $row['student_id'] . ', \'Accepted\')">Accept</button>';
                echo '<button class="decline" onclick="updateStatus(' . $row['student_id'] . ', \'Declined\')">Decline</button>';
                echo '<button class="suggest" onclick="suggestIdea(' . $row['student_id'] . ')">Suggest Idea</button>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo '<div class="card">';
            echo '<h3>No Request Pending</h3>';
            echo '</div>';
        }

        // Close connection
        $conn->close();
        ?>
    </div>

    <!-- Modal for suggesting ideas -->
    <div id="suggestionModal" class="modal">
        <div class="modal-content">
            <h2>Suggest an Idea</h2>
            <input type="text" id="ideaInput" placeholder="Your suggestion (Max 100 words)" maxlength="100">
            <button class="save" onclick="saveIdea()">Save</button>
            <button class="close" onclick="closeModal()">Close</button>
        </div>
    </div>

    <script>
        var currentStudentId;

        function updateStatus(id, action) {
            var card = document.getElementById("card_" + id);
            card.classList.add("fade-out");
            disableCardActions(id);

            // Send AJAX request to update status
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    location.reload();
                }
            };
            xhr.send("id=" + id + "&action=" + action);
        }

        function suggestIdea(id) {
            currentStudentId = id;
            var modal = document.getElementById("suggestionModal");
            modal.style.display = "flex";
        }

        function saveIdea() {
            var ideaText = document.getElementById("ideaInput").value;
            var card = document.getElementById("card_" + currentStudentId);
            card.classList.add("fade-out");
            disableCardActions(currentStudentId);

            // Send AJAX request to save idea to the database
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    closeModal();
                    location.reload();
                }
            };
            xhr.send("id=" + currentStudentId + "&action=Idea Suggested&suggested_idea=" + ideaText);
        }

        function closeModal() {
            var modal = document.getElementById("suggestionModal");
            modal.style.display = "none";
            document.getElementById("ideaInput").value = ""; // Clear the input field
        }

        function disableCardActions(id) {
            var card = document.getElementById("card_" + id);
            var buttons = card.querySelectorAll("button");
            buttons.forEach(function(button) {
                button.disabled = true;
            });
        }
    </script>
</body>
</html>
