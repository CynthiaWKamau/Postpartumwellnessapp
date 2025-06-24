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
        </form>  

    </div> 

    <?php
    
// Connect to MySQL database
require 'db_connection.php';

 if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($_POST["fullname"], $_POST["id"], $_POST["email"], $_POST["password"], $_POST["confirm_password"],$_POST["role"])) {

            $fullname = $_POST["fullname"];
            $id = $_POST["id"];
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



 