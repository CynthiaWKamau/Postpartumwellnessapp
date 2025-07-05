<?php
// Include database connection
include 'db_connection.php';

// Initialize error message
$login_error = '';

// Process the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $user_id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $password = $_POST["password"]; 

    // Validate required fields
    if (empty($user_id)) {
        $login_error = "Please enter an ID.";
    } elseif (empty($email)) {
        $login_error = "Please enter a valid email.";
    } elseif (empty($password)) {
        $login_error = "Please enter a password.";
    } else {
        //process login
        $stmt = $conn->prepare("SELECT * FROM users WHERE id = ? AND email = ?");
        if ($stmt === false) {
            $login_error = "Database error: " . htmlspecialchars($conn->error);
        } else {
            $stmt->bind_param("is", $user_id, $email);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result && $result->num_rows === 1) {
                $user = $result->fetch_assoc();

                if (password_verify($password, $user['password'])) {
                    // Login success
                    $_SESSION['id'] = $user['id'];
                    $_SESSION['fullname'] = $user['fullname'];
                    $_SESSION['role'] = $user['role'];

                    // Redirect to the correct dashboard
                    switch ($user['role']) {
                        case 'admin':
                            header("Location: Admin/dashboard.php");
                            break;
                        case 'therapist':
                            header("Location: therapist.php");
                            break;
                        case 'postpartum mother':
                            header("Location: postpartummother.php");
                            break;
                        default:
                            $login_error = "Unknown user role.";
                            break;
                    }
                    exit();
                } else {
                    $login_error = "Incorrect password.";
                }
            } else {
                $login_error = "User not found with provided ID and email.";
            }

            $stmt->close();
        }
    }
}

?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="login.css">

<body>
    <div class="login">
        <h2>Login</h2>
        <form action="login.php" method="post" autocomplete="off">
            <label>Id:</label>
            <input type="text" name="id" required><br>

            <label>Email:</label>
            <input type="email" name="email" required><br>

            <label>Password:</label>
            <input type="password" name="password" required><br>

            <button type="submit">Login</button>
        </form>

        <p><a href="forgot_password.php">Forgot Password?</a></p>
        <p><a href="select_role.php">Don't have an account?</a></p>

        <?php if ($login_error): ?>
        <p style="color:red"><?= htmlspecialchars($login_error) ?></p>

        <?php endif; ?>

      </div>
    
</body>
</html>