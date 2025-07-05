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
      <h2>Forgot Your Password?</h2>
<form action="forgot_password.php" method="post">
    <label>Enter your registered email:</label>
    <input type="email" name="email" required><br>
    <button type="submit">Send Reset Link</button>
</form>

    </div>
   <?php
require 'db_connection.php';
require 'vendor/autoload.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$reset_error='';
$reset_success='';

// Process form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"] ?? '';

    // Check if email exists in users table
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
          $token = bin2hex(random_bytes(32));
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour"));

          // Save token
        $update = $conn->prepare("UPDATE users SET reset_token = ?, token_expiry = ? WHERE email = ?");
        $update->bind_param("sss", $token, $expiry, $email);
        $update->execute();

         // Email reset link
        $reset_link = "http://localhost/Postpartumwellnessapp/Wellnessapp/reset_password.php?token=$token";

        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ck697315@gmail.com';  // replace with yours
            $mail->Password = 'nxhejtxupexkwegm';
            $mail->SMTPSecure = 'tls';
            $mail->Port = 587;

            $mail->setFrom('ck697315@gmail.com', 'Lunacaremailer');
            $mail->addAddress($email);
            $mail->isHTML(true);
            $mail->Subject = 'Reset Your Luna Care Password';
            $mail->Body = "Click the link below to reset your password:<br><br>
                <a href='$reset_link'>$reset_link</a><br><br>
                This link will expire in 1 hour.";

            $mail->send();
            echo "<script>alert('Reset link sent to your email'); window.location.href='login.php';</script>";
        } catch (Exception $e) {
            echo "❌ Email could not be sent. Error: {$mail->ErrorInfo}";
        }
    } else {
        echo "<script>alert('Email not found'); window.history.back();</script>";
    }
}
?>
</body>
</html>
