<?php
session_start();

// Logout functionality
if (isset($_GET['logout'])) {
    // Destroy session
    if (session_destroy()) {
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

// Function to check for new requests
function checkNewRequests($conn)
{
    // Get the mentor_id of the logged-in mentor
    $mentor_id = $_SESSION['mentor_id'];

    // Query to check for new entries in mentor_student_relationship table
    $sql = "SELECT COUNT(*) AS new_requests_count FROM mentor_student_relationships WHERE mentor_id = '$mentor_id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $newRequestsCount = $row['new_requests_count'];

        // Return the count of new requests
        return $newRequestsCount;
    } else {
        return 0;
    }
}

// Call the function to get the count of new requests
$newRequestsCount = checkNewRequests($conn);
?>
<!DOCTYPE html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Mentor Dashboard </title>
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
        #hero-area {
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

<!-- 
Header start
==================== -->
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
        <!-- Collect the nav links, forms, and other content for toggling -->
        <nav class="collapse navbar-collapse" id="navbar">
            <ul class="nav navbar-nav navbar-right" id="top-nav">

                <li><a href="mentor/test/index.php">Requests <?php echo ($newRequestsCount > 0) ? '<span id="new-request-dot">&bull;</span>' : ''; ?></a></li>
                <li><a href="mentor/test/mentor_dashboard.php">Dashboard</a></li>


                <?php if (isset($_SESSION['username'])) { ?>
                    <li><a href="?logout=true">Logout</a></li>
                <?php } ?>
            </ul>

        </nav><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</div>

<section id="hero-area">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <div class="form">

                    <div class="block">
                        <?php if (isset($_SESSION['username'])) { ?>
                            <h1 class="wow fadeInDown">Namaste! <br><?php echo $_SESSION['username']; ?></h1>
                            <p class="wow fadeInDown" data-wow-delay="0.3s">Empower your students with the gift of knowledge and guidance; every step you take with them today shapes the innovators and leaders of tomorrow.</p>
                            <div class="wow fadeInDown" data-wow-delay="0.3s">
                                <!--<button class="btn btn-default btn-home" >Available</button> -->
                            </div><br>

                        <?php } else { ?>
                            <p>You are not logged in.</p>
                            <p><a href="login.php">Login</a></p>
                        <?php } ?>
                    </div>

                </div>
            </div>
            <br>
            <div class="col-md-6 wow zoomIn">
                <img src="images\Live collaboration-cuate.svg" alt="" style="height: 100%; width: 100%; background-color: hsla(0, 0%, 10%, 0.1);
          border: 2px solid white;
          margin-top: 2%;
          border-radius: 1rem;
          backdrop-filter: blur(15px);">
            </div>
        </div><!-- .row close -->
    </div><!-- .container close -->
</section><!-- header close -->


<!-- Js -->
<script>
    // Function to check for new requests and update the red dot
    function checkNewRequests() {
        // Simulated count of new requests
        var newRequestsCount = <?php echo $newRequestsCount; ?>; // Retrieve the count of new requests from PHP

        if (newRequestsCount > 0) {
            $('#new-request-dot').show(); // Show the red dot if there are new requests
        } else {
            $('#new-request-dot').hide(); // Hide the red dot if there are no new requests
        }
    }

    // Call the function on page load
    $(document).ready(function () {
        checkNewRequests();
    });
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


















