<?php
session_start();

// Database configuration
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$database = "spas"; // Replace with your MySQL database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$mentor_id = $_POST['id'];
$student_id = $_SESSION['student_id'];
$action = $_POST['action'];

// Insert data into mentor_student_relationships table
$sql = "INSERT INTO mentor_student_relationships (student_id, mentor_id, status) VALUES ('$student_id', '$mentor_id', '$action')";

// Check if SQL query was successful
if ($conn->query($sql) === TRUE) {
    // If request sent successfully, echo message
    echo "Sent Request Successfully";   

    // Fetch mentor's email from the database
    $mentor_email_query = "SELECT email FROM mentors WHERE mentor_id = '$mentor_id'";
    $mentor_email_result = $conn->query($mentor_email_query);

    // Check if mentor's email is found
    if ($mentor_email_result->num_rows > 0) {
        $mentor_row = $mentor_email_result->fetch_assoc();
        $mentor_email = $mentor_row['email'];

        // Pass mentor's email to mail.php
        include 'mail.php';
    } else {
        echo "Error: Mentor email not found";
    }
} else {
    // If SQL query fails, display error message
    echo "Error: " . $sql . "<br>" . $conn->error;
}

// Close connection
$conn->close();
?>
