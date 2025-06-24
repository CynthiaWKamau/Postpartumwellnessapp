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
        <form action="reset_password.php" method="post">
            <label>Enter your registered email:</label>
            <input type="email" name="email" required><br>
            <button type="submit">Reset Password</button>
        </form>
    </div>
</body>
</html>
