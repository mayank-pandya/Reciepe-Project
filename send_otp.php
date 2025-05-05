<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'PHPMailer/src/Exception.php';

session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $otp = rand(100000, 999999);
    $_SESSION['otp'] = $otp;
    $_SESSION['email'] = $email;

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'interestingplus914@gmail.com';        // your Gmail
        $mail->Password   = 'fofexpgijsixgewq';          // your Gmail App Password
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;

        $mail->setFrom('interestingplus914@gmail.com', 'Recipe Project');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Kitchen Notes - OTP Verification';
        $mail->Body = "
        <div style='
          font-family: Arial, sans-serif;
          background-color: #f9f9f9;
          padding: 20px;
          border-radius: 8px;
          border: 1px solid #ddd;
          max-width: 500px;
          margin: auto;
        '>
          <h2 style='color: #4CAF50;'>Recipe Project - OTP Verification</h2>
          <p>Hi there,</p>
          <p>We received a request to reset your password. Use the OTP below to continue:</p>
          <div style='
            font-size: 24px;
            font-weight: bold;
            color: #333;
            padding: 10px 20px;
            background: #f0f0f0;
            display: inline-block;
            border-radius: 5px;
            margin: 15px 0;
          '>$otp</div>
           <br />
          <p style='font-size: 14px; color: #888;'>– Kitchen Notes </p>
        </div>
      ";


        $mail->send();
        
        // Redirect to OTP page
        header("Location: verify_otp.php");
        exit;
    } catch (Exception $e) {
        echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
?>
