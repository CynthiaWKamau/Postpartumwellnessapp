<?php
require 'db_connection.php';
// reset_password.php
$token = $_GET['token'] ?? '';
$success = '';
$error = '';

// If form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST["token"] ?? '';
    $new_password = $_POST["new_password"] ?? '';
    $confirm_password = $_POST["confirm_password"] ?? '';

    if ($new_password !== $confirm_password) {
        $error = "❌ Passwords do not match.";
    } else {
        // Find user with the token
       $stmt = $conn->prepare("SELECT email FROM users WHERE token = ? AND created_at >= NOW() - INTERVAL 1 HOUR");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $email = $row['email'];

            // Update password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $update->bind_param("ss", $hashed_password, $email);

            if ($update->execute()) {
                $success = "✅ Password updated successfully. <a href='login.php'>Click here to login</a>";
                // Delete the token
                $delete = $conn->prepare("DELETE FROM password_resets WHERE token = ?");
                $delete->bind_param("s", $token);
                $delete->execute();
            } else {
                $error = "❌ Failed to update password.";
            }
        } else {
            $error = "❌ Invalid or expired token.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Set New Password</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <div class="login">
        <h2>Set New Password</h2>
        <form action="reset_password.php" method="post">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

            <label>New Password:</label>
            <input type="password" name="new_password" required><br>

            <label>Confirm Password:</label>
            <input type="password" name="confirm_password" required><br>

            <button type="submit">Update Password</button>
        </form>
    </div>
</body>
</html>
