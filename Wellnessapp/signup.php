<!--signup.php-->
<?php
$role = $_GET['role'] ?? $_POST['role'] ?? '';
$signup_error = '';
$signup_success = '';


// Connect to MySQL database
require 'db_connection.php';

 if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
        if (isset($_POST["fullname"], $_POST["user_id"], $_POST["email"], $_POST["password"], $_POST["confirm_password"],$_POST["role"])) {

        $fullname = trim($_POST["fullname"]);
        $user_id = trim($_POST["user_id"]);
        $email = trim($_POST["email"]);
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];
        $role = $_POST["role"];
        $created_at = date("Y-m-d H:i:s");

            //Password match validation
            if ($password !== $confirm_password) {
              $signup_error = "Passwords do not match.";
              
            } else {
            //Hash password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            //Check if username or email already exists 
            $sql_check = "SELECT * FROM users WHERE id=? OR email=?";
$stmt = $conn->prepare($sql_check);

if (!$stmt) {
    die("❌ Prepare failed: " . $conn->error);
} else {
    $stmt->bind_param("ss", $user_id, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows > 0) {
        $signup_error = "User with this ID or Email already exists.";
    } else {
        $stmt = $conn->prepare("INSERT INTO users (fullname, id, email, password, role, created_at) VALUES (?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("ssssss", $fullname, $user_id, $email, $hashed_password, $role, $created_at);

        if ($stmt->execute()) {
            $signup_success = "Signup successful! Redirecting to login...";
            echo "<script>setTimeout(() => { window.location.href = 'login.php'; }, 2000);</script>";
        } else {
            $signup_error = "Registration failed. Please try again.";
        }
    }
}

            $stmt->close();
        }
    }
  }
     ?>     

<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>

</head>
<style>
    body {
  background: #ffe6f0;
  font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
  margin: 0;
  padding: 0;
}

.signup-container {
  background-color: #fff0f5;
  border-radius: 15px;
  box-shadow: 0 0 15px rgba(255, 105, 180, 0.2);
  max-width: 430px;
  margin: 80px auto;
  padding: 40px 35px;
  text-align: center;
  border: 2px solid #ffc0cb;
}

.signup-container h2 {
  color: #d63384;
  margin-bottom: 20px;
  font-size: 24px;
}

label {
  display: block;
  text-align: left;
  margin: 10px 0 5px;
  color: #c2185b;
  font-weight: 500;
  font-size: 14px;
}

input[type="text"],
input[type="email"],
input[type="password"] {
  width: 100%;
  padding: 12px;
  border: 1px solid #f8bbd0;
  border-radius: 8px;
  margin-bottom: 15px;
  background: #fff;
  transition: border 0.3s ease-in-out;
  font-size: 14px;
}

input[type="text"]:focus,
input[type="email"]:focus,
input[type="password"]:focus {
  border-color: #ec407a;
  outline: none;
}

button[type="submit"] {
  background-color: #f06292;
  color: white;
  padding: 12px 25px;
  border: none;
  border-radius: 25px;
  cursor: pointer;
  font-weight: bold;
  font-size: 15px;
  transition: background 0.3s ease;
  margin-top: 10px;
}

button[type="submit"]:hover {
  background-color: #e91e63;
}

.login-link {
  margin-top: 15px;
  font-size: 14px;
}

.login-link a {
  color: #d63384;
  text-decoration: none;
  font-weight: 600;
}

.login-link a:hover {
  text-decoration: underline;
}

</style>

<body>

    <div class="signup-container">
          <h2>Sign Up as <span style="color:#d63384"><?= htmlspecialchars(ucwords($role)) ?></span></h2>
        <br>
        <?php if (!empty($signup_error)): ?>
    <div style="color: #d8000c; background-color: #ffdddd; padding: 10px; border-radius: 8px; margin-bottom: 15px;">
        <?= htmlspecialchars($signup_error) ?>
    </div>
<?php endif; ?>

<?php if (!empty($signup_success)): ?>
    <div style="color: #155724; background-color: #d4edda; padding: 10px; border-radius: 8px; margin-bottom: 15px;">
        <?= htmlspecialchars($signup_success) ?>
    </div>
<?php endif; ?>

        <form action="signup.php" method="post" autocomplete="off">

            <label for="fullname">Full Name:</label>
            <input type="text" name="fullname" id="fullname" required><br>

            <label for="user_id">National Id/Passport Number:</label>
            <input type="text" name="user_id" id="user_id" required><br>

            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required><br>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" required><br>

            <input type="hidden" name="role" value="<?= htmlspecialchars($role) ?>">

            <button type="submit" name="submit">Sign Up</button>
             <p class="login-link">Already have an account? <a href="login.php">Login</a></p>
        </form>

    </div>
                
            
</body>

</html>