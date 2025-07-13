<?php
session_start();
include 'auth.php';
require_role('admin');
include 'db_connection.php';

$id = $_GET['id'] ?? null;

if (!$id) {
    die("User ID not provided.");
}

// Fetch user info to show in confirmation
$sql = "SELECT fullname, email FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param('i', $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    die("User not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Confirm Delete</title>
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom right, #fff0f6, #fdf7fa);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
            margin: 0;
        }

        .delete-box {
            background: white;
            border-radius: 20px;
            padding: 2rem;
            box-shadow: 0 6px 20px rgba(255, 182, 193, 0.3);
            text-align: center;
            max-width: 400px;
        }

        h2 {
            color: #d63384;
        }

        p {
            color: #555;
        }

        .btn {
            text-decoration: none;
            display: inline-block;
            padding: 10px 20px;
            margin: 10px 5px;
            border-radius: 25px;
            font-weight: bold;
            transition: 0.3s ease;
        }

        .confirm-btn {
            background-color: #f26d8c;
            color: white;
        }

        .confirm-btn:hover {
            background-color: #d94a6a;
        }

        .cancel-btn {
            background-color: #cda4f4;
            color: white;
        }

        .cancel-btn:hover {
            background-color: #ab73e6;
        }
    </style>
</head>
<body>

<div class="delete-box">
    <h2>Are you sure?</h2>
    <p>You are about to delete <strong><?= htmlspecialchars($user['fullname']) ?></strong> (<?= htmlspecialchars($user['email']) ?>).</p>

    <a class="delete-btn" href="confirm_delete.php?id=<?= $row['id'] ?>">🗑️ Delete</a>
    <a class="btn cancel-btn" href="manage_users.php">Cancel</a>
</div>

</body>
</html>
