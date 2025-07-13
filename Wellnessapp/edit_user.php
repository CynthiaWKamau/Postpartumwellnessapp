<?php
session_start();
include 'auth.php';
require_role('admin');
include 'db_connection.php';

$user = null;
$error = '';

// Step 1: Get user ID from URL
$id = $_GET['id'] ?? null;
if (!$id || !is_numeric($id)) {
    $error = "User ID is missing or invalid.";
} else {
    // Step 2: Fetch user
    $sql = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        $error = "User not found.";
    }
}

// Step 3: Update user
if ($_SERVER["REQUEST_METHOD"] === "POST" && $user) {
    $fullname = $_POST['fullname'];
    $email = $_POST['email'];
    $role = $_POST['role'];

    $update = "UPDATE users SET fullname=?, email=?, role=? WHERE id=?";
    $stmt = $conn->prepare($update);
    $stmt->bind_param('sssi', $fullname, $email, $role, $id);

    if ($stmt->execute()) {
        header("Location: manage_users.php");
        exit;
    } else {
        $error = "Update failed: " . $conn->error;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit User</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom right, #fff0f6, #fdf7fa);
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .edit-form {
            background: #ffffff;
            padding: 2rem;
            border-radius: 20px;
            box-shadow: 0 6px 20px rgba(255, 182, 193, 0.3);
            width: 400px;
        }

        h2 {
            text-align: center;
            color: #d63384;
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 6px;
            color: #4a3b47;
            font-weight: 500;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 10px;
            border: 1px solid #f5c2d7;
            border-radius: 12px;
            background: #fdf2f8;
            margin-bottom: 1.2rem;
            font-size: 1rem;
        }

        button {
            background-color: #d07ac9;
            color: white;
            padding: 12px;
            width: 100%;
            border: none;
            border-radius: 25px;
            font-size: 1rem;
            font-weight: bold;
            cursor: pointer;
            transition: background 0.3s ease;
        }

        button:hover {
            background-color: #c253b0;
        }

        .back-link {
            display: block;
            text-align: center;
            margin-top: 1rem;
            color: #b03060;
            text-decoration: none;
            font-size: 0.9rem;
        }

        .back-link:hover {
            text-decoration: underline;
        }

        .error {
            color: red;
            text-align: center;
            margin-bottom: 1rem;
        }
    </style>
</head>
<body>

<div class="edit-form">
    <h2>✏️ Edit User</h2>

    <?php if ($error): ?>
        <p class="error"><?= htmlspecialchars($error) ?></p>
    <?php elseif ($user): ?>
        <form method="post">
            <label>Full Name:</label>
            <input type="text" name="fullname" value="<?= htmlspecialchars($user['fullname']) ?>" required>

            <label>Email:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

            <label>Role:</label>
            <select name="role" required>
                <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                <option value="therapist" <?= $user['role'] === 'therapist' ? 'selected' : '' ?>>Therapist</option>
                <option value="postpartum mother" <?= $user['role'] === 'postpartum mother' ? 'selected' : '' ?>>Postpartum Mother</option>
            </select>

            <button type="submit">💾 Save Changes</button>
        </form>
    <?php endif; ?>

    <a href="manage_users.php" class="back-link">← Back to User Management</a>
</div>

</body>
</html>
