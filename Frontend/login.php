<!DOCTYPE html>
<html>

<head>
    <title>Sign Up</title>
    <link rel="stylesheet" href="signup.css">
</head>

<body>

    <div class="signup">
        <h2>Sign up as <?= htmlspecialchars($role) ?></h2>

        <?php if (!empty($signup_error)): ?>
        <p style="color:red"><?= htmlspecialchars($signup_error) ?></p>
        <?php endif; ?>

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

</body>

</html>