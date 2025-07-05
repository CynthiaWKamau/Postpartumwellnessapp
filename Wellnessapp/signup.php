<!--signup.php-->
<?php
$role = $_GET['role'] ?? $_POST['role'] ?? '';
$signup_error = '';
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
        <form action="signup.php" method="post" autocomplete="off">

            <label for="fullname">Full Name:</label>
            <input type="text" name="fullname" id="fullname" required><br>

            <label for="id">Id:</label>
            <input type="text" name="id" id="id" required><br>

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

    <?php
    
// Connect to MySQL database
require 'db_connection.php';

 if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["submit"])) {
        if (isset($_POST["fullname"], $_POST["id"], $_POST["email"], $_POST["password"], $_POST["confirm_password"],$_POST["role"])) {

        $fullname = trim($_POST["fullname"]);
        $id = trim($_POST["id"]);
        $email = trim($_POST["email"]);
        $password = $_POST["password"];
        $confirm_password = $_POST["confirm_password"];
        $role = $_POST["role"];
        $created_at = date("Y-m-d H:i:s");

            //Password match validation
            if ($password !== $confirm_password) {
                echo "<script>alert('Passwords do not match');</script>";
                exit();
            } 
            
            //Hash password for security
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            //Check if username or email already exists 
                $stmt = $conn->prepare("SELECT * FROM users WHERE id=? OR email=?");
                $stmt->bind_param("ss", $id, $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<script>alert('Username or Email has been taken');</script>";
                } else {
                    //Insert new user into database
                    $stmt = $conn->prepare("INSERT INTO users (fullname, id, email, password, role,created_at) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssss", $fullname, $id, $email, $hashed_password,$role, $created_at);

                    if ($stmt->execute()) {
                       header("Location: login.php");
                       exit();
                    } else {
                        echo "<script>alert('Registration Failed');</script>";
                    }
                }
                $stmt->close();
            }
        }
    ?>
</body>

</html>