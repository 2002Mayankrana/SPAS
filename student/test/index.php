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
        /* Your CSS styles remain unchanged */
        body {
    font-family: Arial, sans-serif;
    background-image: url('/mmm/images/w.jpg');
    background-repeat: no-repeat;
    background-attachment: fixed;  
    background-size: cover;
}

.container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center;
    animation: slideIn 1s ease forwards;
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
        backdrop-filter: blur(8px); /* Use rgba to set opacity */
    border: 2px solid white;
     /* Apply backdrop filter for blur effect */
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
            position: absolute; /* Position the team (grp) */
            top: 10px; /* Adjust as needed */
            right: 10px; /* Adjust as needed */
        }

        .card p {
            margin-bottom: 10px;
            color: white;
            font-size: 1rem;
        }

        .card .status {
            margin-top: auto; /* Push the status to the top */
            margin-bottom: 10px; /* Add margin for spacing */
            color: white;
            font-size: 0.9rem;
        }

        .actions {
            margin-top: auto;
            display: flex;
            justify-content: space-around;
        }

        .actions button {
            margin-top: 5px;
            padding: 8px 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s, color 0.3s; /* Add transition effects */
        }

        .actions button:hover {
            background-color: #ddd; /* Darken the background on hover */
            color: #333; /* Darken the text color on hover */
        }
        /* Add a new style for the pending button */
        .actions button.pending {
            background-color: #FFD700; /* Light orange */
            cursor: not-allowed; /* Change cursor to indicate the button is disabled */

        }

        .actions button.declined {
            background-color: lightcoral; /* Light orange */
            cursor: not-allowed; /* Change cursor to indicate the button is disabled */
        }

        /* Add a new style for the faded card */
        .card.faded {
            opacity: 0.5; /* Reduce opacity to make the card appear faded */
            pointer-events: none; /* Disable pointer events on the faded card */
        }
        
        .suggested-idea-popup {
    position: absolute;
    bottom: -25%; /* Adjust as needed */
    left: 50%;
    border-radius: 8px;
    transform: translateX(-50%);
    background-color: #f9f9f9;
    border: 1px solid #ccc;
    padding: 10px;
    box-shadow: 0 12px 12px rgba(0, 0, 0, 0.5);
    z-index: 999;
    display: none;
        }

        .card:hover .suggested-idea-popup {
            display: block;
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
    

</style>
</head>
<body>
    <div class="container">
    <a href="/mmm/welcomeS.php" class="home-link">«</a>
    <?php


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

$student_id = $_SESSION['student_id'];

$sql_check_grp = "SELECT grp FROM student_info WHERE student_id = '$student_id'";
$result_check_grp = $conn->query($sql_check_grp);

if ($result_check_grp->num_rows > 0) {
    $row = $result_check_grp->fetch_assoc();
    $grp_value = $row['grp'];

    if (empty($grp_value)) {
        echo '<div class="card">';
    echo "<h3>You have not submitted your idea yet</h3>";
    echo '</div>';

    } else {

// Check if the student has an approved project
$check_approved_sql = "SELECT * FROM mentors
                       JOIN approved_projects ON mentors.mentor_id = approved_projects.mentor_id
                       WHERE approved_projects.student_id = '$student_id'";

$check_approved_result = $conn->query($check_approved_sql);

if ($check_approved_result->num_rows > 0) {
    // If the student has an approved project, fetch the mentor_id
    $approved_row = $check_approved_result->fetch_assoc();
    $approved_mentor_name = $approved_row['username'];

    echo '<div class="card">';
    echo '<h3>You cannot request anymore because your project idea has been approved by  ' . $approved_mentor_name . '!!</h3>';
    echo '</div>';
}  else {
    // Check if there are mentors with a relationship to the student
    $check_relationship_sql = "SELECT * FROM mentor_student_relationships WHERE student_id = '$student_id'";
    $check_relationship_result = $conn->query($check_relationship_sql);

    if ($check_relationship_result->num_rows > 0) {
        // Fetch mentors who have a relationship with the student
        $sql = "SELECT * FROM mentors
                JOIN mentor_student_relationships ON mentors.mentor_id = mentor_student_relationships.mentor_id
                WHERE mentor_student_relationships.student_id = '$student_id'";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '<h3>' . $row['username'] . '</h3>';
                echo '<p>' . $row['designation'] . '</p>';
                echo '<p>Expertise : ' . $row['expertise_in'] . '</p>';

                // Fetch and display the status if available
                if (isset($row['status']) && $row['status'] == 'Idea Suggested') {
                    echo '<div class="status">Status: ' . $row['status'] . '</div>';
                    // Display suggested idea on hover
                    echo '<div class="card-info">';
                    echo '<div class="suggested-idea-popup">';
                    echo '<span class="suggested-idea-text">';
echo '<span style="color: grey;">Suggestion:</span><br>';
echo $row['suggested_idea'] . '<br>';
echo '<span style="color: grey;">( Re-submit idea )</span>';
echo '</span>';

                    echo '</div>';
                    echo '</div>';
                }
                

                echo '<div class="actions">';
                // Check if the mentor ID exists in mentor_student_relationships table for the student
                $check_request_sql = "SELECT * FROM mentor_student_relationships WHERE student_id = '$student_id' AND mentor_id = '" . $row['mentor_id'] . "'";
                $check_request_result = $conn->query($check_request_sql);
                
                // Check if the mentor's project is declined
                $check_declined_sql = "SELECT * FROM declined_projects WHERE student_id = '$student_id' AND mentor_id = '" . $row['mentor_id'] . "'";
                $check_declined_result = $conn->query($check_declined_sql);
                
                if ($check_request_result->num_rows > 0) {
                    // If request exists, display "Pending" button
                    echo '<button class="pending">Pending</button>';
                } else {
                    // If request doesn't exist, display "Request approval" button
                    echo '<button onclick="updateStatus(' . $row['mentor_id'] . ', \'Requested\', this)">Request approval</button>';
                }
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "No mentors found.";
        }
    } else {
        // No mentors found with a relationship to the student, display all mentors
        $sql = "SELECT * FROM mentors";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="card">';
                echo '<h3>' . $row['username'] . '</h3>';
                echo '<p>' . $row['designation'] . '</p>';
                echo '<p>Expertise : ' . $row['expertise_in'] . '</p>';
                echo '<div class="actions">';
                // Check if the mentor's project is declined
                $check_declined_sql = "SELECT * FROM declined_projects WHERE student_id = '$student_id' AND mentor_id = '" . $row['mentor_id'] . "'";
                $check_declined_result = $conn->query($check_declined_sql);
                
                if ($check_declined_result->num_rows > 0) {
                    // If the mentor's project is declined, disable the button
                    echo '<button class="declined">Declined</button>';
                }
                else{
                    echo '<button onclick="updateStatus(' . $row['mentor_id'] . ', \'Requested\', this)">Request approval</button>';
                }
               
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "No mentors found.";
        }
    }
}}}


// Close connection
$conn->close();
?>
</div>

    <script>
        function updateStatus(id, action, button) {
            button.innerText = "Pending";
            button.classList.add("pending");
            var buttons = document.querySelectorAll(".actions button:not(.pending)");
                    buttons.forEach(function(btn) {
                        btn.disabled = true;
                        btn.parentNode.parentNode.classList.add("faded");
                    });
            // Send AJAX request to update status
            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onreadystatechange = function() {
                if (xhr.readyState === 4 && xhr.status === 200) {
                    alert(xhr.responseText);
                    // Change button text and style to "Pending"

                    // Disable all buttons
                    var buttons = document.querySelectorAll(".actions button:not(.pending)");
                    buttons.forEach(function(btn) {
                        btn.disabled = true;
                        btn.parentNode.parentNode.classList.add("faded");
                    });
                }
            };
            xhr.send("id=" + id + "&action=" + action);
        }
    </script>
</body>
</html>


