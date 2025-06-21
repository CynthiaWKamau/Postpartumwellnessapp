<!--signup.php-->
<?php
$role=$_POST['role']??'';
?>

<!DOCTYPE html>
<html>
<head>
  <title>Sign Up</title>
</head>
<body>
 
  <link rel="stylesheet" href="signup.css">
  
  <div class="signup">
   <h2>Sign up as <?= htmlspecialchars($role) ?></h2> 
  <br>
      <form action="signup.php" method="post" autocomplete="off">
        
            <label for="fullname">Full Name:</label>
            <input type="text" name="name" id="name" required><br>
            
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required><br>
            
            <label for="email">Email:</label>
            <input type="email" name="email" id="email" required><br>
            
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required><br>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" required><br>

            <input type="hidden" name="role" value="<?= htmlspecialchars($role) ?>">

            
            <button type="submit" name="submit">Sign Up</button>
        </form>  

    </div> 

    <?php
// Connect to MySQL database
require 'db_connection.php';

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["name"], $_POST["username"], $_POST["email"], $_POST["password"], $_POST["confirm_password"],$_POST["role"])) {
            $name = $_POST["name"];
            $username = $_POST["username"];
            $email = $_POST["email"];
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
                $stmt = $conn->prepare("SELECT * FROM registration WHERE username=? OR email=?");
                $stmt->bind_param("ss", $username, $email);
                $stmt->execute();
                $result = $stmt->get_result();

                if ($result->num_rows > 0) {
                    echo "<script>alert('Username or Email has been taken');</script>";
                } else {
                    //Insert new user into database
                    $stmt = $conn->prepare("INSERT INTO registration (name, username, email, password, role,created_at) VALUES (?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssss", $name, $username, $email, $hashed_password,$role, $created_at);

                    if ($stmt->execute()) {
                        echo "<script>alert('Registration Successful');</script>";
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



 