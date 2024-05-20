

<?php
// login.php
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

if (isset($_POST['submit'])) {
    // Fetch form data
    $grp = $_POST['grp'];
    $project_name = $_POST['project_name'];
    $tech = implode(", ", $_POST['tech']);
    $idea = $_POST['idea'];

    // Retrieve logged-in student's information from session
    $username = $_SESSION['username']; // Assuming you stored the username in the session

    // Prepare SQL statement
    $sql = "UPDATE student_info SET grp = ?, project_name = ?, tech = ?, idea = ? WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssss", $grp, $project_name, $tech, $idea, $username);

    if ($stmt->execute()) {
        // Call Hugging Face Pegasus API for text summarization
        $api_url = 'https://api-inference.huggingface.co/models/sujayC66/pegasus-summarization_longshort_text_150';
        $data = array('inputs' => $idea);
        $headers = array(
            'Content-Type: application/json',
            'Authorization: Bearer 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'
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $api_url);
        curl_setopt($curl, CURLOPT_POST, true);
        curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $result = curl_exec($curl);
        if ($result === FALSE) {
            echo "Error calling the Hugging Face API";
        } else {
            
            // Decode the JSON response
            $response = json_decode($result, true);

            // Extract the summary text
            $summarized_text = $response[0]['generated_text'];

            // Use prepared statement to update the database with the summarized text
            $update_sql = "UPDATE student_info SET summarized_text = ? WHERE username = ?";
            $update_stmt = $conn->prepare($update_sql);
            $update_stmt->bind_param("ss", $summarized_text, $username);

            if ($update_stmt->execute()) {
                echo '<script>alert("Record updated successfully"); window.location.href = "/mmm/welcomeS.php";</script>';
            } else {
                echo '<script>alert("Error updating record: ' . $conn->error . '");</script>';
            }
            $update_stmt->close();
            
        }
        //header("Location: /mmm/welcomeS.php");

        curl_close($curl);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

// Close connection
$conn->close();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <title>Register</title>
</head>
<body>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@200;300;400;500;600;700&display=swap');
*{
    padding: 0;
    margin: 0;
    box-sizing: border-box;
    font-family: 'Poppins',sans-serif;
}
body{
    background-image: url('/mmm/images/leaves-8413064 (1).jpg');
  background-repeat: no-repeat;
  background-attachment: fixed;  
  background-size: cover;
}
.container{
    display: flex;
    align-items: center;
    justify-content: center;
    min-height: 90vh;
    padding-top: 30px;
    padding-bottom: 30px;
}
.box{
          position: relative;
          background-color: hsla(0, 0%, 10%, 0.1);
          border: 2px solid white;
          margin-inline: 1.5rem;
          padding: 2.5rem 1.5rem;
          border-radius: 1rem;
          
          backdrop-filter: blur(8px);
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
.form-box{
    width: 450px;
    margin: 0px 10px;
}
.form-box header{
    font-size: 25px;
    font-weight: 600;
    padding-bottom: 10px;
    border-bottom: 1px solid #e6e6e6;
    margin-bottom: 10px;
}
.form-box form .field{
    display: flex;
    margin-bottom: 10px;
    flex-direction: column;

}
.form-box form .input input{
    height: 40px;
    width: 100%;
    font-size: 16px;
    padding: 0 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    outline: none;
}
.btn{
    height: 35px;
    background: rgba(76,68,182,0.808);
    border: 0;
    border-radius: 5px;
    color: #fff;
    font-size: 15px;
    cursor: pointer;
    transition: all .3s;
    margin-top: 10px;
    padding: 0px 10px;
}
.btn:hover{
    opacity: 0.82;
}
.submit{
    width: 100%;
}
.links{
    margin-bottom: 15px;
}

/********* Home *****************/

.nav{
    background: #6e5dad;
    display: flex;
    flex-direction: row;
    justify-content: space-around;
    line-height: 60px;
    z-index: 100;
}
.logo{
    font-size: 25px;
    font-weight: 900;
    
}
.logo a{
    text-decoration: none;
    color: #000;
}
.right-links a{
    padding: 0 10px;
}
main{
    display: flex;
    align-items: center;
    justify-content: center;
    margin-top: 60px;
}
.main-box{
    display: flex;
    flex-direction: column;
    width: 70%;
}
.main-box .top{
    display: flex;
    flex-direction: row;
    justify-content: space-between;
}
.bottom{
    width: 100%;
    margin-top: 20px;
}
@media only screen and (max-width:840px){
    .main-box .top{
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .top .box{
        margin: 10px 10px;
    }
    .bottom{
        margin-top: 0;
    }
}
.message{
    text-align: center;
    background: #f9eded;
    padding: 15px 0px;
    border:1px solid #699053;
    border-radius: 5px;
    margin-bottom: 10px;
    color: red;
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

    /* Media queries for responsiveness */
@media only screen and (max-width: 840px) {
    .main-box .top {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }

    .top .box {
        margin: 10px 10px;
    }

    .bottom {
        margin-top: 0;
    }

    .form-box {
        width: 90%; /* Adjust width for smaller screens */
    }
}


    </style>
<div class="container">
<a href="/mmm/welcomeS.php" class="home-link">«</a>
    <div class="box form-box">
        <header>Submit your idea</header>
        <form action="" method="post">

            <div class="field input">
                <label for="grp">Group Id</label>
                <input type="text" name="grp" id="grp" autocomplete="off" required>
            </div>

            <div class="field input">
                <label for="project_name">Project Name</label>
                <input type="text" name="project_name" id="project_name" autocomplete="off" required>
            </div>

            <legend>Tech stack</legend>      
            <input type="checkbox" name="tech[]" value="AI & ML based">  AI & ML based<br>      
            <input type="checkbox" name="tech[]" value="Cyber Security based">  Cyber Security based<br>      
            <input type="checkbox" name="tech[]" value="Block Chain based">  Block Chain based<br>
            <input type="checkbox" name="tech[]" value="Web Development based">  Web Development based<br> 
            <input type="checkbox" name="tech[]" value="IOT based">  IOT based<br> 
            <input type="checkbox" name="tech[]" value="App/IOS Development based">  App/IOS Development based<br> 
            <input type="checkbox" name="tech[]" value="API development">  API development<br> 
            <input type="checkbox" name="tech[]" value="DevOps">  DevOps<br>     
            <br>  

            <div class="field input">
                <label>Idea description</label>
                <textarea cols="80" rows="5" placeholder="(describe in more than 250 words)" name="idea" value="idea" required></textarea>
            </div>

            <div class="field">
                <input type="submit" class="btn" name="submit" value="Submit" required>
            </div>
            
        </form>
    </div>
</div>
</body>
</html>
