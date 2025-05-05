<?php
require_once "./controls/functions.php";

$login_message = "";
$login_status = ""; // success or error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $user = fetchRow("SELECT * FROM users WHERE email = ?", [$email], "s");

    if ($user && password_verify($password, $user['password'])) {
        session_start();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['first_name'] = $user['first_name'];

        $login_message = "✅ Login successful! Redirecting...";
        $login_status = "success";
    } else {
        $login_message = "❌ Invalid Email or Password!";
        $login_status = "error";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Include SweetAlert2 -->


    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const user = JSON.parse(localStorage.getItem("user"));
            if (user && user.id) {
                // User is already logged in, redirect
                window.location.href = "dashboard.php";
            }
        });
    </script>

</head>

<body>
    <div class="wrapper">
        <form action="" method="post">
            <h1>Login</h1>
            <div class="input-box">
                <input type="email" name="email" placeholder="Email Address" required>
            </div>

            <div class="input-box">
                <input type="password" name="password" placeholder="Password" required>
            </div>

            <div class="remember-forgot">
                <label><input type="checkbox">Remember me</label>
                <a href="forgot.html">Forgot password?</a>
            </div>

            <button type="submit" class="btn bg-danger text-white" id="login">Login</button>

            <div class="register-link">
                <p>Don't have an account? <a href="signup.php">Register</a></p>
            </div>
        </form>
    </div>

    <?php if (!empty($login_message)): ?>
        <script>
            <?php if ($login_status === "success"): ?>
                // Store necessary user data in localStorage
                localStorage.setItem("user", JSON.stringify({
                    id: "<?php echo $_SESSION['user_id']; ?>",
                    first_name: "<?php echo $_SESSION['first_name']; ?>"
                }));
            <?php endif; ?>

            Swal.fire({
                icon: "<?php echo $login_status; ?>",
                title: "<?php echo $login_message; ?>",
                showConfirmButton: false,
                timer: 2000
            }).then(() => {
                <?php if ($login_status === "success") { ?>
                    window.location.href = "dashboard.php";
                <?php } ?>
            });
        </script>

    <?php endif; ?>

</body>

</html>