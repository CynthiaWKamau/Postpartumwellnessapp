<?php
session_start();
include 'auth.php';
require_role('admin'); // Make sure only admins access this page
include 'db_connection.php';

// Fetch all users
$sql = "SELECT id, fullname, email, role FROM users ORDER BY role, fullname";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Users</title>
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', 'Segoe UI', sans-serif;
            background: linear-gradient(to bottom right, #fff0f6, #fdf7fa);
            color: #4a3b47;
        }

        .navbar {
            background-color: #f9c5d1;
            padding: 1rem 2rem;
            display: flex;
            justify-content: center;
            gap: 2rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
            border-bottom: 2px solid #fcdce5;
        }

        .navbar a {
            text-decoration: none;
            color: #4a3b47;
            font-weight: 600;
            background-color: #fff0f6;
            padding: 10px 20px;
            border-radius: 30px;
            transition: all 0.3s ease-in-out;
            box-shadow: 0 2px 6px rgba(255, 192, 203, 0.3);
        }

        .navbar a:hover {
            background-color: #ffb6c1;
            color: white;
        }

        h1 {
            text-align: center;
            color: #d63384;
            margin-top: 2rem;
        }

        .user-table {
            margin: 2rem auto;
            width: 90%;
            background: #fff;
            border-radius: 16px;
            padding: 1rem;
            box-shadow: 0 5px 20px rgba(255, 182, 193, 0.3);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.95rem;
        }

        th, td {
            padding: 12px 16px;
            text-align: left;
            border-bottom: 1px solid #f0d3e6;
        }

        th {
            background-color: #fce4ec;
            color: #b03060;
        }

        .actions a {
            text-decoration: none;
            padding: 6px 12px;
            margin: 0 4px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
        }

        .edit-btn {
            background-color: #cda4f4;
            color: white;
        }

        .delete-btn {
            background-color: #f26d8c;
            color: white;
        }

        .edit-btn:hover {
            background-color: #ab73e6;
        }

        .delete-btn:hover {
            background-color: #d94a6a;
        }

        .note {
            text-align: center;
            font-style: italic;
            color: #777;
            margin-top: 1rem;
        }
    </style>
</head>
<body>

    <!-- Navigation -->
    <nav class="navbar">
        <a href="admin.php">🏠 Dashboard</a>
        <a href="manage_users.php">👥 Manage Users</a>
        <a href="manage_appointments.php">📅 Appointments</a>
        <a href="manage_subscriptions.php">💳 Subscriptions</a>
        <a href="login.php">🔐 Login</a>
        <a href="logout.php">🚪 Logout</a>
    </nav>

    <h1>👥 User Management</h1>

    <div class="user-table">
        <?php if ($result->num_rows > 0): ?>
        <table>
            <tr>
                <th>Full Name</th>
                <th>Email</th>
                <th>Role</th>
                <th>Actions</th>
            </tr>
            <?php while($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($row['fullname']) ?></td>
                <td><?= htmlspecialchars($row['email']) ?></td>
                <td><?= htmlspecialchars($row['role']) ?></td>
                <td class="actions">
                    <a class="edit-btn" href="edit_user.php?id=<?= $row['id'] ?>">✏️ Edit</a>
                    <a class="delete-btn" href="delete_user.php?id=<?= $row['id'] ?>" onclick="return confirm('Are you sure you want to delete this user?')">🗑️ Delete</a>
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <?php else: ?>
            <p class="note">No users found.</p>
        <?php endif; ?>
    </div>

</body>
</html>
