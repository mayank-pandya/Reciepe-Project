<?php
require_once "./controls/functions.php";

$signup_message = "";
$signup_status = ""; // success or error

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $first_name = trim($_POST['first_name']);
    $last_name = trim($_POST['last_name']);
    $gender = $_POST['gender'];
    $email = trim($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Secure password

    // **Check if phone number exists**
    $existing_user = fetchRow("SELECT id FROM users WHERE email = ?", [$email], "s");

    if ($existing_user) {
        $signup_message = "⚠️ This Email is already registered!";
        $signup_status = "error";
    } else {
        // **Insert new user**
        executeQuery(
            "INSERT INTO users (first_name, last_name, gender, email, password) VALUES (?, ?, ?, ?, ?)",
            [$first_name, $last_name, $gender, $email, $password],
            "sssss"
        );

        $signup_message = "✅ Registration successful!";
        $signup_status = "success";

        // Get the newly created user info
        $new_user = fetchRow("SELECT id, first_name, last_name FROM users WHERE email = ?", [$email], "s");

        // Prepare JS response for storing in localStorage
        echo "<script>
            localStorage.setItem('user_id', '{$new_user['id']}');
            localStorage.setItem('first_name', '" . addslashes($new_user['first_name']) . "');
            localStorage.setItem('last_name', '" . addslashes($new_user['last_name']) . "');
        </script>";
    }
}
?>

<?php if (!empty($signup_message)): ?>
    <script>
        Swal.fire({
            icon: "<?php echo $signup_status; ?>",
            title: "<?php echo $signup_message; ?>",
            showConfirmButton: false,
            timer: 2000
        }).then(() => {
            <?php if ($signup_status === 'success'): ?>
                window.location.href = "dashboard.php";
            <?php endif; ?>
        });
    </script>
<?php endif; ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <link rel="stylesheet" href="signup.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> <!-- Include SweetAlert2 -->
</head>

<body>
    <div class="signup-container">
        <h2>Sign up</h2>
        <form action="" method="post">
            <input type="text" name="first_name" placeholder="First name" required minlength="4" maxlength="12">
            <input type="text" name="last_name" placeholder="Last name" required minlength="4" maxlength="12">

            <select name="gender" required>
                <option value="" disabled selected>Gender</option>
                <option value="male">Male</option>
                <option value="female">Female</option>
                <option value="other">Other</option>
            </select>

            <input type="email" name="email" placeholder="Email Address" required>
            <input type="password" name="password" placeholder="Password" required>

            <button type="submit">Sign Up</button>

            <p>Already have an account? <a href="login.php">Login</a></p>
        </form>
    </div>

    <?php if (!empty($signup_message)): ?>
        <script>
            Swal.fire({
                icon: "<?php echo $signup_status; ?>",
                title: "<?php echo $signup_message; ?>",
                showConfirmButton: false,
                timer: 2500
            });
        </script>
    <?php endif; ?>

</body>

</html>