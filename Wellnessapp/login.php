<?php
session_start();
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
   
    // Validate required fields
    if (empty($id)) {
        $login_error = "Please enter an ID.";
    } elseif (empty($email)) {
        $login_error = "Please enter a valid email.";
    } elseif (empty($password)) {
        $login_error = "Please enter a password.";
    } else {    
    // Insert into the login table
    $role = $_POST["role"] ?? '';
$stmt = $conn->prepare("SELECT * FROM users WHERE id = ? AND email = ? AND role = ?");
if ($stmt === false) {
    $login_error = "Database error: " . htmlspecialchars($conn->error);
} else {
    $stmt->bind_param("sss", $id, $email, $role);

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
                        header("Location: Therapist/dashboard.php");
                        break;
                    case 'postpartum mother':
                        header("Location: Mother/dashboard.php");
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

    $conn->close();
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Login</title>
    <link rel="stylesheet" href="login.css">
    <style>
          select {
      width: 100%;
      padding: 12px;
      border: 1px solid #f8bbd0;
      border-radius: 8px;
      margin-bottom: 15px;
      background-color: #fff;
      color: #555;
      font-size: 15px;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      appearance: none;
      background-image: url("data:image/svg+xml;charset=US-ASCII,%3Csvg%20xmlns='http://www.w3.org/2000/svg'%20width='16'%20height='16'%20fill='%23ec407a'%20viewBox='0%200%2016%2016'%3E%3Cpath%20d='M7.247%2011.14l-4.796-5.481C1.885%205.234%202.318%204.5%203.07%204.5h9.858c.752%200%201.185.734.62%201.159l-4.796%205.481a1%201%200%200%201-1.505%200z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 12px center;
      background-size: 16px 16px;
    }

    select:focus {
      border-color: #ec407a;
      outline: none;
    }
    
    </style>
</head>

<body>
    <div class="login">
        <h2>Login</h2>
        <form action="login.php" method="post" autocomplete="off">
           <label for="role">Select Role:</label>
            <select name="role" id="role"required>
            <option value="">--Select Role--</option>
            <option value="mother">Postpartum Mother</option>
            <option value="therapist">Therapist</option>
            <option value="admin">Admin</option>
         </select>

            <label>Id:</label>
            <input type="text" name="id" required><br>

            <label>Email:</label>
            <input type="email" name="email" required><br>

            <label>Password:</label>
            <input type="password" name="password" required><br>

            <button type="submit">Login</button>
        </form>

        <p><a href="forgot_password.php">Forgot Password?</a></p>

        <?php if ($login_error): ?>
        <p style="color:red"><?= htmlspecialchars($login_error) ?></p>

        <?php endif; ?>

      </div>
    
</body>
</html>