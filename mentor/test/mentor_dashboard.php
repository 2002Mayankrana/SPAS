<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mentor Dashboard</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-image: url('/mmm/images/w.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;
            background-size: cover;
        }
        .container {
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: hsla(0, 0%, 10%, 0.1);
            backdrop-filter: blur(8px);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 5px;
            border: 2px solid white;
            animation: slideIn 1s ease forwards;
        }
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(-50px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        .project {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 15px;
            border-radius: 10px;
            background-color: #fefefe;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .project:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .project h3 {
            margin-top: 0;
            font-size: 1.5em;
        }
        .project p {
            margin-bottom: 15px;
            color: #555;
        }
        .button {
            background-color: #40A578;
            border: none;
            color: white;
            padding: 10px 20px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin-top: 10px;
            margin-right: 10px;
            cursor: pointer;
            border-radius: 5px;
            transition: background-color 0.3s, transform 0.2s;
        }


        .button:hover {
            background-color: #006769;
            transform: translateY(-3px);
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
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
            transition: opacity 0.3s ease;
        }
        .modal-content {
            background-color: #fff;
            margin: 10% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 60%;
            border-radius: 10px;
            position: relative;
            animation: slideInModal 0.5s ease;
        }
        @keyframes slideInModal {
            from {
                transform: translateY(-50px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }
        .close {
            color: #aaa;
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
        }
        .modal h2 {
            margin-top: 0;
        }
        .modal label {
            font-weight: bold;
        }
        .modal input, .modal textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .modal input[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            cursor: pointer;
            border-radius: 5px;
            padding: 10px 20px;
            font-size: 16px;
        }
        .modal input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="/mmm/welcomeM.php" class="home-link">«</a>
        <h2>Mentor Dashboard</h2>
        <div id="projects-container">
            <!-- Projects will be displayed here dynamically -->
            <?php
        
            // Establish database connection (replace the placeholders with your actual database credentials)
            $servername = "localhost";
            $username = "root";
            $password = "";
            $database = "spas";

            $conn = new mysqli($servername, $username, $password, $database);

            if ($conn->connect_error) {
                die("Connection failed: " . $conn->connect_error);
            }

            // Fetch project information based on mentor_id from session
            $mentor_id = $_SESSION['mentor_id'];

            $sql = "SELECT approved_projects.*, student_info.* 
                    FROM approved_projects 
                    JOIN student_info ON approved_projects.student_id = student_info.student_id 
                    WHERE approved_projects.mentor_id = '$mentor_id'";

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="project">';
                    echo '<h3>' . htmlspecialchars($row['project_name']) . '</h3>';
                    echo '<p>' . htmlspecialchars($row['summarized_text']) . '</p>';
                    echo '<button class="button" onclick="openModal(' . htmlspecialchars($row['student_id']) . ')">Assign Task</button>';
                    echo '<form method="post" action="track_progress.php" style="display:inline-block;">';
                    echo '<input type="hidden" name="student_id" value="' . htmlspecialchars($row['student_id']) . '">';
                    echo '<button type="submit" class="button">Track Progress</button>';
                    echo '</form>';
                    echo '</div>';
                }
            } else {
                echo "No projects found for the student.";
            }
            ?>
        </div>
    </div>
    <div id="myModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Assign Task</h2>
            <form id="taskForm" method="post" action="save_task.php">
                <label for="taskDescription">Task Description:</label><br>
                <textarea id="taskDescription" name="task_description" rows="4" cols="50" required></textarea><br>
                <label for="deadlineDate">Deadline Date:</label><br>
                <input type="date" id="deadlineDate" name="deadline_date" required><br><br>
                <input type="hidden" id="studentId" name="student_id">
                <input type="hidden" name="mentor_id" value="<?php echo htmlspecialchars($mentor_id); ?>">
                <input type="submit" value="Assign Task">
            </form>
        </div>
    </div>
    
    <script>
        // Get the modal
        var modal = document.getElementById("myModal");

        // Function to open modal and set student id
        function openModal(studentId) {
            document.getElementById("studentId").value = studentId;
            modal.style.display = "block";
        }

        // Function to close modal
        function closeModal() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>
</html>
