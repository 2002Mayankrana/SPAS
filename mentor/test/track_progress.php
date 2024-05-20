<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Track Progress</title>
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
        .card {
            border: 1px solid #ccc;
            padding: 20px;
            margin-bottom: 20px;
            border-radius: 10px;
            background-color: #fff;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }
        .card h3 {
            margin-top: 0;
            font-size: 1.5em;
            color: #333;
        }
        .card p {
            margin: 10px 0;
            color: #555;
        }
        .uploads a {
            color: #3498db;
            text-decoration: none;
        }
        .uploads a:hover {
            text-decoration: underline;
        }
        .status {
            position: absolute;
            top: 10px;
            right: 10px;
            font-weight: bold;
            padding: 5px 10px;
            border-radius: 5px;
        }
        .status.on-time {
            background-color: #4CAF50;
            color: white;
        }
        .status.late {
            background-color: #E74C3C;
            color: white;
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
        .card button[name="acknowledge_task"] {
            background-color: #3498db;
            color: #fff;
            border: none;
            border-radius: 5px;
            padding: 8px 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        .card button[name="acknowledge_task"]:hover {
            background-color: #2980b9;
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="/mmm/mentor/test/mentor_dashboard.php" class="home-link">«</a>
        <h2>Track Progress</h2>
        <?php
        session_start();

        if (!isset($_SESSION['mentor_id'])) {
            header("Location: /mmm/login.php");
            exit();
        }

        $servername = "localhost";
        $username = "root";
        $password = "";
        $database = "spas";

        $conn = new mysqli($servername, $username, $password, $database);

        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['acknowledge_task'])) {
                $task_id = $_POST['task_id'];
                
                $update_sql = "UPDATE assigned_tasks SET acknowledge = true WHERE task_id = '$task_id'";
                if ($conn->query($update_sql) === TRUE) {
                    echo '<script>alert("Task acknowledged successfully."); window.location.href = "/mmm/mentor/test/mentor_dashboard.php";</script>';
                } else {
                    echo '<script>alert("Error acknowledging task: ' . $conn->error . '");</script>';
                }
            }
        }

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $student_id = $_POST['student_id'];
            
            $sql = "SELECT * FROM assigned_tasks WHERE student_id = '$student_id'";
            $result = $conn->query($sql);
            
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="card">';
                    echo '<h3>Task: ' . htmlspecialchars($row['task_description']) . '</h3>';
                    echo '<p>Status: ' . htmlspecialchars($row['task_status']) . '</p>';
                    echo '<p>Deadline: ' . htmlspecialchars($row['task_deadline']) . '</p>';
                    if ($row['uploads']) {
                        echo '<p class="uploads">Uploads: <a href="/mmm/student/test/uploads/' . htmlspecialchars(basename($row['uploads'])) . '" target="_blank">View File</a></p>';
                    } else {
                        echo '<p class="uploads">No uploads yet.</p>';
                    }
                    $completion_time = strtotime($row['completion_time']);
                    $deadline = strtotime($row['task_deadline']);
                    if ($completion_time !== false) {
                        if ($completion_time <= $deadline) {
                            echo '<span class="status on-time">On Time</span>';
                        } else {
                            echo '<span class="status late">Late Submission</span>';
                        }
                    }
                    // Add acknowledge button if task status is 'completed'
                    if ($row['task_status'] === 'completed') {
                        echo '<form method="post" action="' . htmlspecialchars($_SERVER["PHP_SELF"]) . '">';
                        echo '<input type="hidden" name="task_id" value="' . $row['task_id'] . '">';
                        echo '<button type="submit" name="acknowledge_task">Acknowledge</button>';
                        echo '</form>';
                    }
                    echo '</div>';
                }
            } else {
                echo '<div class="card">';
                echo '<h2>No tasks assigned to the student.</h2>';
                echo '</div>';
            }
        } else {
            header("Location: /mmm/welcomeM.php");
            exit();
        }

        $conn->close();
        ?>
    </div>
</body>
</html>
