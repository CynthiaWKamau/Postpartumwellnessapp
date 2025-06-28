<?php
// Include database connection
include 'db_connection.php';

// Initialize error message
$login_error = '';

// Process the form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input
    $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
    $password = $_POST["password"]; 
     $role = $_POST["role"] ?? '';

    // Validate required fields
    if (empty($id)) {
        $login_error = "Please enter an ID.";
    } elseif (empty($email)) {
        $login_error = "Please enter a valid email.";
    } elseif (empty($password)) {
        $login_error = "Please enter a password.";
        } elseif (empty($role)) {
        $login_error = "Please select a role.";
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        // Insert into the login table
        $sql = "INSERT INTO login (id, email, password,role) VALUES (?, ?, ?,?)";
        $stmt = $conn->prepare($sql);

        if ($stmt === false) {
            $login_error = "Prepare failed: " . htmlspecialchars($conn->error);
        } else {
            $stmt->bind_param("ssss", $id, $email, $hashed_password,$role);

            if ($stmt->execute()) {
                echo "<script>alert('Registration Successful');</script>";
                header("Location: index.php");
                exit();
            } else {
                $login_error = "Error: " . htmlspecialchars($stmt->error);
            }

            $stmt->close();
        }
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
</head>
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
            
            <input type="hidden" name="role" value="<?= htmlspecialchars($role) ?>">
            
            <button type="submit">Login</button>
        </form>

        <p><a href="forgot_password.php">Forgot Password?</a></p>
        
        <?php if ($login_error): ?>
            <p style="color:red"><?= htmlspecialchars($login_error) ?></p>
            
        <?php endif; ?>
    </div>
</body>
</html>