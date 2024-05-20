<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Dashboard</title>
    
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
            max-width: 800px;
            margin: 20px auto;
            padding: 20px;
            background-color: hsla(0, 0%, 10%, 0.1);
            backdrop-filter: blur(8px);
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            border: 2px solid white;
            animation: slideIn 1s ease forwards;
        }

        .task_container {
            background-color: rgba(255, 255, 255, 0.8);
            margin: 20px auto;
            padding: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            border-radius: 10px;
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

        .task {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 10px;
            border-radius: 10px;
            background-color: #f4f4f4;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .task:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        }

        .task h3 {
            margin-top: 0;
            color: #333;
        }

        .task p {
            margin-bottom: 5px;
            color: #666;
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

        /* Style for hover effect */
        .home-link:hover {
            background-color: lightgreen;
        }

        /* Add disabled style for buttons */
        .button[disabled] {
            background-color: #ccc;
            cursor: not-allowed;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="/mmm/welcomeS.php" class="home-link">«</a>
        
        <div class="task_container">
            <h2>Student Dashboard</h2>
            <div id="tasks-container">
                <!-- Tasks will be displayed here dynamically -->
                <?php
                session_start();
                // Establish database connection (replace the placeholders with your actual database credentials)
                $servername = "localhost";
                $username = "root";
                $password = "";
                $database = "spas";

                $conn = new mysqli($servername, $username, $password, $database);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                // Fetch tasks assigned to the student
                $student_id = $_SESSION['student_id']; // Assuming the student_id is stored in a session variable
                $sql = "SELECT * FROM assigned_tasks WHERE student_id = '$student_id'";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo '<div class="task">';
                        echo '<h3>' . $row['task_description'] . '</h3>';
                        echo '<p>Status: ' . $row['task_status'] . '</p>';
                        echo '<p>Deadline: ' . $row['task_deadline'] . '</p>';
                        if ($row['acknowledge']) {
                            // If acknowledged, disable all buttons
                            echo '<form method="post" action="update_task.php" enctype="multipart/form-data">';
                            echo '<input type="hidden" name="task_id" value="' . $row['task_id'] . '">';
                            echo '<button type="button" class="button" disabled>Initiate</button>';
                            echo '<input type="file" name="file" class="button" disabled>';
                            echo '<button type="button" class="button" disabled>Completed</button>';
                            echo '</form>';
                        } else {
                            // If not acknowledged, display buttons normally
                            echo '<form method="post" action="update_task.php" enctype="multipart/form-data">';
                            echo '<input type="hidden" name="task_id" value="' . $row['task_id'] . '">';
                            echo '<button type="submit" name="initiate" class="button">Initiate</button>';
                            echo '<input type="file" name="file" class="button">';
                            echo '<button type="submit" name="completed" class="button">Completed</button>';
                            echo '</form>';
                        }
    
                        echo '</div>';
                    }
                } else {
                    echo "No tasks assigned to the student.";
                }
    
                $conn->close();
                ?>
            </div>
        </div>
    </div>
    <script>
        function confirmSubmit() {
            return confirm("Are you sure you want to submit this task?");
        }
    </script>
</body>
</html>



