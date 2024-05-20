<?php
session_start();
// Establish database connection (replace the placeholders with your actual database credentials)
$servername = "localhost";
$username = "root";
$password = "";
$database = "spas";

$conn = new mysqli($servername, $username, $password, $database);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted and task description is provided
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['task_description'])) {
    // Escape user inputs for security
    $task_description = $conn->real_escape_string($_POST['task_description']);
    $task_deadline = $conn->real_escape_string($_POST['deadline_date']);
    $student_id = $conn->real_escape_string($_POST['student_id']);
    
    // Fetch mentor_id from session
    if(isset($_SESSION['mentor_id'])){
        $mentor_id = $_SESSION['mentor_id'];
        
        // Prepare an SQL statement to insert the task into the assigned_tasks table
        $sql = "INSERT INTO assigned_tasks (student_id, mentor_id, task_description, task_status, task_deadline) VALUES ('$student_id', '$mentor_id', '$task_description', 'pending', '$task_deadline')";

        if ($conn->query($sql) === TRUE) {
            
            // Redirect back to the mentor dashboard after saving the task
            header("Location: /mmm/mentor/test/mentor_dashboard.php");
            exit();
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    } else {
        echo "Mentor ID not found in session!";
    }
} else {
    echo "Invalid request!";
}

$conn->close();
?>


