<?php
session_start();

// Logout functionality
if(isset($_GET['logout'])) {
    // Destroy session
    if(session_destroy()) {
        // Redirecting To Home Page
        header("Location: mainindex.php");
    }
}

// Database connection
$servername = "localhost";
$username = "root"; // Replace with your MySQL username
$password = ""; // Replace with your MySQL password
$database = "spas";

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve student's ID
$student_id = $_SESSION['student_id'];

// Function to check for new requests
function checkNewRequests($conn) {
    // Get the student_id of the logged-in student
    $student_id = $_SESSION['student_id'];

    // Query to check for new entries in approved_projects table
    $approved_query = "SELECT COUNT(*) AS approved_count FROM approved_projects WHERE student_id = '$student_id'";
    $approved_result = $conn->query($approved_query);
    $approved_row = $approved_result->fetch_assoc();
    $approved_count = $approved_row['approved_count'];

    // Query to check for new entries in declined_projects table
    $declined_query = "SELECT COUNT(*) AS declined_count FROM declined_projects WHERE student_id = '$student_id'";
    $declined_result = $conn->query($declined_query);
    $declined_row = $declined_result->fetch_assoc();
    $declined_count = $declined_row['declined_count'];

    // Query to check if there is a non-NULL value in the suggested_idea column of mentor_student_relationships table
    $mentor_relationship_query = "SELECT COUNT(*) AS mentor_relationship_count FROM mentor_student_relationships WHERE student_id = '$student_id' AND suggested_idea IS NOT NULL";
    $mentor_relationship_result = $conn->query($mentor_relationship_query);
    $mentor_relationship_row = $mentor_relationship_result->fetch_assoc();
    $mentor_relationship_count = $mentor_relationship_row['mentor_relationship_count'];

    // Calculate total count of new requests
    $newRequestsCount = $approved_count + $declined_count + $mentor_relationship_count;

    // Return the count of new requests
    return $newRequestsCount;
}

// Call the function to get the count of new requests
$newRequestsCount = checkNewRequests($conn);
?>

<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Student Dashboard</title>
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Place favicon.ico and apple-touch-icon.png in the root directory -->
    
    <!-- Fonts -->
    <!-- Lato -->
    <link href='http://fonts.googleapis.com/css?family=Lato:400,300,700' rel='stylesheet' type='text/css'>
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">

    <!-- CSS -->

    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/font-awesome.min.css">
    <link rel="stylesheet" href="css/owl.carousel.css">
    <link rel="stylesheet" href="css/animate.css">
    <link rel="stylesheet" href="css/main1.css">
    <!-- Responsive Stylesheet -->
    <link rel="stylesheet" href="css/responsive.css">
    <style>
        #hero-area{
            background-image: url('/mmm/images/w.jpg');
            background-repeat: no-repeat;
            background-attachment: fixed;  
            background-size: cover;
        }
    </style>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <style>
        /* CSS for the red dot */
        #new-request-dot {
            color: red;
            font-size: 30px;
            position: absolute;
            bottom: 20px;
            right: 0px;
        }
    </style>
</head>

<body id="body">

<div id="preloader">
    <div class="book">
        <div class="book__page"></div>
        <div class="book__page"></div>
        <div class="book__page"></div>
    </div>
</div>

<!-- Header start -->
<div class="navbar-default navbar-fixed-top" id="navigation">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">
                <img class="logo-1" src="images/logospas.png" alt="LOGO" style="height: 40px;">
                <img class="logo-2" src="images/logospas-2.png" alt="LOGO" style="height: 40px;">
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <nav class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav navbar-right" id="top-nav">
                <li><a href="student/test/index.php">Requests <?php echo ($newRequestsCount > 0) ? '<span id="new-request-dot">&bull;</span>' : ''; ?></a></li>
                <li><a href="student/test/student_dashboard.php">Dashboard</a></li>
                <?php if(isset($_SESSION['username'])) { ?>
                    <li><a href="?logout=true">Logout</a></li>
                <?php } ?>
            </ul>
        </nav><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</div><!-- Header close -->

<section id="hero-area">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="form">
                    <div class="block">
                        <?php if(isset($_SESSION['username'])) { ?>
                            <br><h1 class="wow fadeInDown">Namaste! <br><?php echo $_SESSION['username']; ?></h1>
                            <p class="wow fadeInDown" data-wow-delay="0.3s">Embrace the challenge, for within the tension lies the opportunity to shine and create something truly remarkable. You've got this!</p>
                            <div class="wow fadeInDown" data-wow-delay="0.3s">
                            <?php

$con = mysqli_connect("localhost", "root", "", "spas");

if (mysqli_connect_errno()){
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

if (isset($_POST['username'])) {
    // your existing code for handling form submission
} else {
    // Fetch the value of "grp" column for the logged-in student
    $username = $_SESSION['username'];
    $query = "SELECT grp FROM `student_info` WHERE username='$username'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_assoc($result);
    $grp_value = $row['grp'];
    
    // Check if the student's student_id exists in the approved_projects table
    $student_id = $_SESSION['student_id'];
    $check_query = "SELECT * FROM `approved_projects` WHERE student_id='$student_id'";
    $check_result = mysqli_query($con, $check_query);
    
    // Determine the button text based on the value of "grp" and whether the student's idea is approved
    if (mysqli_num_rows($check_result) > 0) {
        $button_text = "Idea Approved";
    } else {
        $button_text = ($grp_value !== null && $grp_value !== '') ? "Re-submit Idea" : "Submit Idea";
    }
?>
<?php if ($button_text !== "Idea Approved") : ?>
    <a class="btn btn-default btn-home" href="/mmm/student/login_S/S_fill_detail.php" role="button"><?php echo $button_text; ?></a>
<?php else : ?>
    <br>
    <p>Your Idea is Approved!!</p>
<?php endif; ?>
<?php
}
?>
                            </div>
                        <?php } else { ?>
                            <p>You are not logged in.</p>
                            <p><a href="login.php">Login</a></p>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <br>
            <div class="col-md-6 wow zoomIn">
                <img src="images\Learning-cuate.svg" alt="" style="height: 80%; width: 80%; background-color: hsla(0, 0%, 10%, 0.1);
          border: 2px solid white;
          margin-left: 10%;
          border-radius: 1rem;
          backdrop-filter: blur(15px);">
            </div>
        </div><!-- .row close -->
    </div><!-- .container close -->
</section><!-- Header close -->

<!-- Js -->
<script>
    // Function to remove the notification dot
    function removeNotificationDot() {
        var notificationDot = document.getElementById('new-request-dot');
        if (notificationDot) {
            notificationDot.style.display = 'none'; // Hide the notification dot
        }
    }

    // Call the function when the page is loaded
    window.onload = function() {
        // Check if the referrer URL contains 'index.php' (request page)
        var referrer = document.referrer;
        if (referrer && referrer.indexOf('index.php') !== -1) {
            removeNotificationDot(); // Call the function to remove the notification dot
        }
    };
</script>

<script>
    // Function to set the flag indicating new notifications
    function setNotificationFlag() {
        sessionStorage.setItem('notificationFlag', '1'); // Set the flag to 1
    }

    // Function to unset the flag indicating new notifications
    function unsetNotificationFlag() {
        sessionStorage.setItem('notificationFlag', '0'); // Set the flag to 0
    }

    // Function to remove the notification dot
    function removeNotificationDot() {
        var notificationDot = document.getElementById('new-request-dot');
        if (notificationDot) {
            notificationDot.style.display = 'none'; // Hide the notification dot
        }
    }

    // Function to check and display notification dot
    function checkAndDisplayNotificationDot() {
        var flag = sessionStorage.getItem('notificationFlag'); // Get the flag value from sessionStorage
        if (flag === '1') {
            var notificationDot = document.getElementById('new-request-dot');
            if (notificationDot) {
                notificationDot.style.display = 'block'; // Show the notification dot
            }
        } else {
            removeNotificationDot(); // Call the function to remove the notification dot
        }
    }

    // Call the function when the page is loaded
    window.onload = function() {
        // Check if the referrer URL contains 'index.php' (request page)
        var referrer = document.referrer;
        if (referrer && referrer.indexOf('index.php') !== -1) {
            unsetNotificationFlag(); // Call the function to unset the flag
        } else {
            checkAndDisplayNotificationDot(); // Call the function to check and display the notification dot
        }
    };
</script>

<script src="js/vendor/modernizr-2.6.2.min.js"></script>
<script src="js/vendor/jquery-1.10.2.min.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
<script src="js/jquery.lwtCountdown-1.0.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/owl.carousel.min.js"></script>
<script src="js/jquery.validate.min.js"></script>
<script src="js/jquery.form.js"></script>
<script src="js/jquery.nav.js"></script>
<script src="js/jquery.sticky.js"></script>
<script src="js/plugins.js"></script>
<script src="js/wow.min.js"></script>
<script src="js/main.js"></script>

</body>
</html>
