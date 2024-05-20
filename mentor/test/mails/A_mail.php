<?php
// Import PHPMailer classes into the global namespace
require 'PHPMailer\Exception.php'; 
require 'PHPMailer\PHPMailer.php'; 
require 'PHPMailer\SMTP.php'; 

// PHPMailer initialization
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Function to send email
function sendEmail($mentor_email) {
    // Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();                             // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';        // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                    // Enable SMTP authentication
        $mail->Username   = 'team.spas777@gmail.com'; // SMTP username
        $mail->Password   = 'gfko pzjn qfvo rufr';   // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS; // Enable implicit TLS encryption
        $mail->Port       = 465;                     // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        // Recipients
        $mail->setFrom('team.spas777@gmail.com', 'Mailer');
        $mail->addAddress($mentor_email); // Add a recipient - Mentor's email

        // Content
        $mail->isHTML(true);                         // Set email format to HTML
        $mail->Subject = 'Request Accepted';
        $mail->Body    = 'Hello, Your request have been accepted. Please review it.';
        $mail->AltBody = 'Hello, You have received a new request. Please review it.'; // Plain text alternative

        // Send email
        $mail->send();
        
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Usage example: Call the sendEmail function with the mentor's email address
if(isset($mentor_email)) {
    sendEmail($mentor_email);
}
?>
