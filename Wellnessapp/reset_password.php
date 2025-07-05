<?php
require 'db_connection.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

//Get token from URL or POST
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
       $stmt = $conn->prepare("SELECT email FROM users WHERE reset_token = ? AND token_expiry >= NOW()");
        $stmt->bind_param("s", $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $email = $row['email'];

            // Update password and clear token
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $update = $conn->prepare("UPDATE users SET password = ? WHERE email = ?");
            $update->bind_param("ss", $hashed_password, $email);

        if ($update->execute()) {
                $success = "✅ Password updated successfully. <a href='login.php'>Click here to login</a>";
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
         <!-- Show success or error -->
        <?php if ($success): ?>
            <p style="color: green;"><?php echo $success; ?></p>
        <?php elseif ($error): ?>
            <p style="color: red;"><?php echo $error; ?></p>
        <?php endif; ?>

        <!-- Hide form if success -->
        <?php if (!$success): ?>

        <form action="reset_password.php" method="post">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">

            <label>New Password:</label>
            <input type="password" name="new_password" required><br>

            <label>Confirm Password:</label>
            <input type="password" name="confirm_password" required><br>

            <button type="submit">Update Password</button>
        </form>
        <?php endif; ?>
    </div>
</body>
</html>
