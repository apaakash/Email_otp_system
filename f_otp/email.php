
<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_REQUEST['to'])) {
    $to = $_REQUEST['to'];
    $subject = $_REQUEST['subject'];
    $content = $_REQUEST['message'];
    // Call the send_otp function instead of send_email
    send_otp($to, $subject, $content);
}

function send_otp($to, $subject, $content)
{
    // Load Composer's autoloader
    require 'vendor/autoload.php';

    // Create an instance; passing `true` enables exceptions
    $mail = new PHPMailer(true);

    try {
        // Server settings
        // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            // Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                        // Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                    // Enable SMTP authentication
        $mail->Username   = 'demowork10001@gmail.com';                     // SMTP username
        $mail->Password   = 'ahzkmvqzvvmhklok';                         // SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;             // Enable implicit TLS encryption
        $mail->Port       = 465;                                     // TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        // Recipients
        $mail->setFrom('demowork10001@gmail.com', 'OTP For Login');
        $mail->addAddress($to, 'Verify Email');                      // Add a recipient
        // $mail->addAttachment('./iics.txt');

        // Content
        $mail->isHTML(true);                                         // Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = "<font color='green' size='4'>Your OTP For Login: " . $content . "<br>
    This OTP is Valid For Only One Time.</font>";

        // Send the email
        $mail->send();
        echo 'OTP has been sent successfully';
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
