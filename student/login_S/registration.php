
<?php
    session_start();
    // Enter your host name, database username, password, and database name.
    // If you have not set database password on localhost then set empty.
    $con = mysqli_connect("localhost", "root", "", "spas");
    // Check connection
    if (mysqli_connect_errno()) {
        echo "Failed to connect to MySQL: " . mysqli_connect_error();
    }
    
    if (isset($_POST['submit'])) {
        $username = mysqli_real_escape_string($con, $_POST['username']);
        $email = mysqli_real_escape_string($con, $_POST['email']);
        $password = mysqli_real_escape_string($con, $_POST['password']);

        // Form validation
        if (empty($username) || empty($email) || empty($password)) {
            echo "<script>alert('Required fields are missing');</script>";
        } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo "<script>alert('Invalid email');</script>";
        } else {
            $query = "INSERT into `student_info` (username, password, email)
                      VALUES ('$username', '" . md5($password) . "', '$email')";
            $result = mysqli_query($con, $query);
            if ($result) {
                echo "<script>alert('Registered successfully');</script>";
                header("Location: login.php");
                      
            } else {
                echo "<script>alert('Required fields are missing');</script>";
            }
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Signup Form </title>

  <style>@import url("https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap");
    :root {
      --white-color: hsl(0,0%,100%);
      --black-color: hsl(0, 0% , 0%);
      --body-font:   "Poppins", sans-serif; 
      --h1-font-size: 1.75rem;
      --normal-font-size: 1rem;
      --small-font-size: .813rem;
       --font-medium: 500; 
       }

       *{
        box-sizing: border-box;
        padding: 0;
        margin: 0;
       }

       body,
       input,
       button {
        font-size:  var(--normal-font-size);
        font-family:  var(--body-font);
       }

       body {
        color:  var(--white-color);
       }

       input,
       button {
        border: none;
        outline: none;
       }

       a {
        text-decoration: none;
       }
         img {
          max-width: 100%;
          height: auto;
         }

         .login {
          position: relative;
          height: 100vh;
          display: grid;
          align-items: center;
         }

         .login__img {
          position: absolute;
          width: 100%;
          height: 100%;
          object-fit: cover;
          object-position: center;
         }
         .login__form {
          position: relative;
          background-color: hsla(0, 0%, 10%, 0.1);
          border: 2px solid var(--white-color);
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

         .login__title {
          text-align: center;
          font-size: var(--h1-font-size);
          font-weight: var(--font-medium);
          margin-bottom: 2rem;
         }
         .login__content, .login__box {
          display: grid;
         }

         .login__content {
          row-gap: 1.75rem;
          margin-bottom: 1.5rem;
         }

         .login__box {
          grid-template-columns: max-content 1fr;
          align-items: center;
          column-gap: 0.75rem;
          border-bottom: 2px solid var(--white-color);
         }
         .login__icon, .login__eye {
          font-size: 1.25rem;
         }
         .login__input {
          width: 100%;
          padding-block: 0.8rem;
          background: none;
          color:  var(--white-color);
          position: relative;
          z-index: 1;
         }
         .login__box-input {
          position: relative;
         }
       
         .login__label {
          position: absolute;
          left: 0;
          top: 13px;
          font-weight: var(--font-medium);
          transition: top 0.3s, font-size 0.3s;
         }
         .login__eye {
          position: absolute;
          right: 0;
          top: 18px;
          z-index: 10;
          cursor: pointer;
         }
         .login__box:nth-child(2) input {
          padding-right: 1.8rem;
         }

         .login__check, .login__check-group {
          display: flex;
          align-items: center;
          justify-content: space-between;
         }
         .login__check {
          margin-bottom: 1.5rem;
         }
          .login__check-label, .login__forgot, .login__register {
            font-size: var(--small-font-size);
          }
          .login__check-group {
            column-gap: 0.5rem;
          }
          .login__check-input {
            width: 16px;
            height: 16px;
          }
          .login__forgot {
            color: var(--white-color);
            margin-left: auto; /* Add this line */
            }
            .login__forgot:hover {
              text-decoration: underline;
            }
            .login__button {
              width: 100%;
              padding: 1rem;
              border-radius: 0.5rem;
              background-color: var(--white-color);
              font-weight: var(--font-medium);
              cursor: pointer;
              margin-bottom: 2rem;
            }
            .login__register  {
                text-align: center ;
            }

            .login__register a {
              color: var(--white-color);
              font-weight: var(--font-medium);
            }
            .login__register a:hover {
              text-decoration: underline;

            }

            .login__input:focus + .login__label {
              top: -12px;
              font-size: var(--small-font-size);
            }

            .login__input:not(:placeholder-shown) .login__input:not(:focus) + .login__label {
              top: -12px;
              font-size: var(--small-font-size);
            }

            /* for medium devices */
            @media screen and (min-width: 576px) {
              .login {
                justify-content: center;
              }
              .login__form {
                width: 432px;
                padding: 4rem 3rem 3.5rem;
                border-radius: 1.5rem;
              }
              .login__title {
                font-size: 2rem;
              }
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
      <div class="login">
        <img src="/mmm/images/4264977_91352 (1).jpg" alt="login image" class="login__img">
        <a href="/mmm/mainindex.php" class="home-link">«</a>

        <form method="post" name="login" class="login__form">
          <h1 class="login__title">Student Sign-up</h1>

          <div class="login__content">
            <div class="login__box">
              <i class="bx bx-lock-alt"></i>

              <div class="login__box-input">
                <input type="text" required class="login__input" name="username" placeholder="username">
              </div>
             
            </div>

            <div class="login__box">
              <i class="bx bx-lock-alt"></i>

              <div class="login__box-input">
                <input type="email" required class="login__input" name="email" placeholder="email">
              </div>
             
            </div>

            <div class="login__box">
              <i class="ri-lock-2-line login__icon"></i>


              <div class="login__box-input">
                <input type="password" required class="login__input" name="password" id="login-pas" placeholder="Password">
                <i class="ri-eye-off-line login__eye"></i>
               </div>
            </div>
          </div>

          <div class="login__check">
            

              <a href="#" class="login__forgot">Forgot Password?</a>
          </div>

          <button type="submit" value="Login" name="submit" class="login__button">sign-up</button>

          <p class="login__register">
            already signed up? <a href="login.php">Login</a>
          </p>
        </form>
      </div>

      <!--<============ Main Js ============-->

      
</body>
</html>

