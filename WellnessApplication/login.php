<?php
    // Include database connection
    include 'db_connection.php';

    // Initialize variables to store user input
    $id = $email = $password = '' ;
    $login_error='';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize and validate input
        $id = filter_input(INPUT_POST, "id", FILTER_SANITIZE_SPECIAL_CHARS);
        $email = filter_input(INPUT_POST, "email", FILTER_VALIDATE_EMAIL);
        $password = $_POST["password"]; 

        // Validate required fields
        if (empty($id)) {
            echo "<script>alert('Please enter a username');</script>";
        } elseif (empty($email)) {
            echo "<script>alert('Please enter a valid email');</script>";
        } elseif (empty($password)) {
            echo "<script>alert('Please enter a password');</script>";
        } else {
            // Prepare and execute the SQL query
            $sql = "INSERT INTO login (id, email, password) VALUES (?, ?, ?)";
            $stmt = $conn->prepare($sql);

            if ($stmt === false) {
                die("Prepare failed: " . htmlspecialchars($conn->error));
            }
            // Bind parameters and execute query
            $stmt->bind_param("sss", $id, $email, $password); 

            if ($stmt->execute()) {
                echo "<script>alert('Registration Successful');</script>";
                header("Location: index.php");
                exit();
            } else {
                echo "<script>alert('Error: " . htmlspecialchars($stmt->error) . "');</script>";
            }

            // Close statement
            $stmt->close();
        }
    }

    // Close connection
    $conn->close();
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
            <label>Email:</label>
            <input type="email" name="email" required><br>

            <label>Password:</label>
            <input type="password" name="password" required><br>

            <button type="submit">Login</button>
        </form>

        <?php if ($login_error): ?>
            <p style="color:red"><?= htmlspecialchars($login_error) ?></p>
        <?php endif; ?>
    </div>
</body>
</html>