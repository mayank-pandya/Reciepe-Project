<?php
session_start();
require_once './controls/functions.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $enteredOtp = $_POST['otp'];
    $newPassword = $_POST['new_password'];

    // OTP check
    if ($enteredOtp == $_SESSION['otp']) {
        $email = $_SESSION['email'];

        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_BCRYPT);

        // Update query
        $query = "UPDATE users SET password = ? WHERE email = ?";
        $params = [$hashedPassword, $email];
        $types = "ss";

        executeQuery($query, $params, $types);

        // Clear session
        unset($_SESSION['otp']);
        unset($_SESSION['email']);

        echo "Password reset successful. <a href='login.php'>Login now</a>";
        header("Location: login.php");
        exit;
    } else {
        $error = "Invalid OTP. Please try again.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Verify OTP</title>
  <link rel="stylesheet" href="forgot.css" />
</head>
<body>
  <div class="container">
    <h2>Verify OTP</h2>
    <form method="POST">
      <input
        type="number"
        name="otp"
        placeholder="Enter OTP"
        required
      />
      <input
        type="password"
        name="new_password"
        placeholder="Enter New Password"
        required
      />
      <button type="submit">Reset Password</button>
    </form>
    <?php if (isset($error)) { echo "<p style='color:red;'>$error</p>"; } ?>
    <a href="login.php">Back to Login</a>
  </div>
</body>
</html>
