<?php
// forgot_password.php
?>

<!DOCTYPE html>
<html>
<head>
    <title>Forgot Password</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login">
        <h2>Reset Your Password</h2>
       <form action="forgot_password.php" method="post">
    <label>Enter your registered email:</label>
    <input type="email" name="email" required><br>

    <label>New Password:</label>
    <input type="password" name="new_password" required><br>

    <label>Confirm New Password:</label>
    <input type="password" name="confirm_password" required><br>

    <button type="submit">Reset Password</button>
    </form>

    </div>
   <?php
require 'db_connection.php';

$reset_error='';
$reset_success='';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"] ?? '';
    $new_password = $_POST["new_password"] ?? '';
    $confirm_password = $_POST["confirm_password"] ?? '';

    if ($new_password !== $confirm_password) {
        echo "<script>alert('Passwords do not match'); window.history.back();</script>";
        exit;
    }

    // Check if email exists in users table
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {

        // Update password
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
        $update->bind_param("ss", $hashed_password, $email);

        if ($update->execute()) {
            echo "<script>alert('Password reset successful!'); window.location.href='login.php';</script>";
        } else {
            echo "<script>alert('Failed to reset password.'); window.history.back();</script>";
        }
        $update->close();
    } else {
        echo "<script>alert('Email not found.'); window.history.back();</script>";
    }
    $stmt->close();
}
?>

</body>
</html>
