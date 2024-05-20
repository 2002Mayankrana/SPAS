<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: /mmm/login.php"); // Redirect to login page if not logged in
    exit();
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Establish database connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "spas";

    $conn = new mysqli($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $task_id = $_POST['task_id'];
    

    // Handle initiate button
    if (isset($_POST['initiate'])) {
        // Update task status to "in progress"
        $sql = "UPDATE assigned_tasks SET task_status = 'in_progress' WHERE task_id = '$task_id'";
        if ($conn->query($sql) === TRUE) {
            
            header("Location: /mmm/student/test/student_dashboard.php");
        } else {
            echo "Error updating task status: " . $conn->error;
        }
    }

    // Handle completed button
    if (isset($_POST['completed'])) {
        // Handle file upload
        if (isset($_FILES['file']) && $_FILES['file']['error'] == 0) {
            $upload_dir = "uploads/"; // Directory where uploaded files will be stored
            $file_name = basename($_FILES['file']['name']);
            $file_tmp = $_FILES['file']['tmp_name'];
            $file_path = $upload_dir . $file_name;

            // Move uploaded file to specified directory
            if (move_uploaded_file($file_tmp, $file_path)) {
                // Get the current timestamp
                $completion_time = date('Y-m-d');

                // Update database with file path, task status, and completion time
                $sql = "UPDATE assigned_tasks SET task_status = 'completed', uploads = '$file_path', completion_time = '$completion_time' WHERE task_id = '$task_id'";
                if ($conn->query($sql) === TRUE) {
                    header("Location: /mmm/student/test/student_dashboard.php");
                } else {
                    echo "Error updating task status: " . $conn->error;
                }
            } else {
                echo "Error uploading file";
            }
        } else {

            echo '<script>alert("No file uploaded and you cannot complete tha task"); window.location.href = "student_dashboard.php";</script>';
        }
    }

    $conn->close();
}
?>
