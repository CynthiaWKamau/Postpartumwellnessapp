<!--select_role.php -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup-Wellness Application</title>
    <link rel="stylesheet" href="select_role.css">
</head>

<body>
    <div class="signup-box">
        <h2>Choose your role</h2>
        <form action="signup.php" method="post" autocomplete="off">
            <label for="role">Role:</label>
            <select name="role" id="role" required>
                <option value="">--Select Role--</option>
                <option value="mother">Postpartum Mother</option>
                <option value="therapist">Therapist</option>
                <option value="admin">Admin</option>
            </select>
            <br><br>
            <button type="submit" name="submit">Next</button>
        </form>
</body>

</html>