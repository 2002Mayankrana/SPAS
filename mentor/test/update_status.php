<?php
// Start the session
session_start();

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

// Retrieve parameters from the AJAX request
$id = $_POST['id'];
$action = $_POST['action'];

// Retrieve mentor's ID and project name from the session
$mentor_id = $_SESSION['mentor_id'];


if ($action === 'Idea Suggested') {
    // Retrieve suggested idea text from the POST request
    $suggested_idea = $_POST['suggested_idea'];

    // Construct the SQL query to update the status and store suggested idea text
    $sql = "UPDATE mentor_student_relationships SET status = '$action', suggested_idea = '$suggested_idea' WHERE student_id = '$id' AND mentor_id ='$mentor_id'";
    if ($conn->query($sql) === TRUE) {
        
    
        // Fetch mentor's email from the database
        $mentor_email_query = "SELECT email FROM student_info WHERE student_id = '$id'";
        $mentor_email_result = $conn->query($mentor_email_query);
    
        // Check if mentor's email is found
        if ($mentor_email_result->num_rows > 0) {
            $mentor_row = $mentor_email_result->fetch_assoc();
            $mentor_email = $mentor_row['email'];
    
            // Pass mentor's email to mail.php
            include 'mails/S_mail.php';
        } else {
            echo "Error: Mentor email not found";
        }
    } else {
        // If SQL query fails, display error message
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} elseif ($action === 'Accepted') {
    // Update the status in mentor_student_relationships table
    $sql = "DELETE FROM mentor_student_relationships WHERE student_id = '$id' AND mentor_id ='$mentor_id'";
    
    if ($conn->query($sql) !== TRUE) {
        echo "Error deleting data from mentor_student_relationships table: " . $conn->error;
        exit;
    }
    
    // Update mentor_id in student_info table
    $update_student_info_sql = "UPDATE student_info SET mentor_id = '$mentor_id' WHERE student_id = '$id'";
    if ($conn->query($update_student_info_sql) !== TRUE) {
        echo "Error updating mentor_id in student_info table: " . $conn->error;
        exit;
    }
    
    // Insert into approved_projects table
    $insert_sql = "INSERT INTO approved_projects (student_id, mentor_id) VALUES ('$id', '$mentor_id')";
    if ($conn->query($sql) === TRUE) {
       
        // Fetch mentor's email from the database
        $mentor_email_query = "SELECT email FROM student_info WHERE student_id = '$id'";
        $mentor_email_result = $conn->query($mentor_email_query);
    
        // Check if mentor's email is found
        if ($mentor_email_result->num_rows > 0) {
            $mentor_row = $mentor_email_result->fetch_assoc();
            $mentor_email = $mentor_row['email'];
    
            // Pass mentor's email to mail.php
            include 'mails/A_mail.php';
        } else {
            echo "Error: Mentor email not found";
        }
    }
    if ($conn->query($insert_sql) !== TRUE) {
        echo "Error inserting into approved_project table: " . $conn->error;
        exit;
    }
} else {
    // Construct the SQL query to update the status without storing suggested idea text
    $sql = "DELETE FROM mentor_student_relationships WHERE student_id = '$id' AND mentor_id ='$mentor_id'";
    $insert_sql = "INSERT INTO declined_projects (student_id, mentor_id) VALUES ('$id', '$mentor_id')";
    if ($conn->query($insert_sql) === TRUE) {
       
    
        // Fetch mentor's email from the database
        $mentor_email_query = "SELECT email FROM student_info WHERE student_id = '$id'";
        $mentor_email_result = $conn->query($mentor_email_query);
    
        // Check if mentor's email is found
        if ($mentor_email_result->num_rows > 0) {
            $mentor_row = $mentor_email_result->fetch_assoc();
            $mentor_email = $mentor_row['email'];
    
            // Pass mentor's email to mail.php
            include 'mails/D_mail.php';
        } else {
            echo "Error: Mentor email not found";
        }
    } 
    if ($conn->query($insert_sql) !== TRUE) {
        echo "Error inserting into approved_project table: " . $conn->error;
        exit;
    }
}

// Execute the update query
if ($conn->query($sql) === TRUE) {
    echo "Status updated successfully";
} else {
    echo "Error updating status: " . $conn->error;
}

// Close connection
$conn->close();
?> 

