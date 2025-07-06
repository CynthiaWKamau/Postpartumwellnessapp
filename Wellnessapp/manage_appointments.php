<?php
session_start();
include 'auth.php';
require_role('admin');
include 'db_connection.php';

// Fetch all appointments with patient info
$sql = "SELECT entry_id, appointment_date, appointment_time, fullname, email, status
        FROM book_appointment 
        ORDER BY appointment_date DESC, appointment_time DESC";

$result = $conn->query($sql);
if (!$result) {
    die("Query failed: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Manage Appointments</title>
    <style>
       body {
        margin: 0;
        font-family: 'Poppins', 'Segoe UI', sans-serif;
        background: linear-gradient(to bottom right, #fff0f6, #fdf7fa);
        color: #4a3b47;
    }

    .navbar {
        display: flex;
        justify-content: center;
        gap: 25px;
        padding: 1rem;
        background: linear-gradient(to right, #f99fc9, #d8b0f9);
        border-bottom: 3px solid #fff0f8;
        border-radius: 0 0 16px 16px;
        box-shadow: 0 5px 15px rgba(255, 182, 193, 0.25);
    }

    .nav-item {
        text-decoration: none;
        color: white;
        font-weight: 600;
        font-size: 17px;
        padding: 8px 16px;
        border-radius: 20px;
        transition: background 0.3s ease;
    }

    .nav-item:hover {
        background-color: #f772a7;
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

        .apt-table {
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

        .note {
            text-align: center;
            font-style: italic;
            color: #777;
            margin-top: 1rem;
        }

        .actions a {
            text-decoration: none;
            padding: 6px 12px;
            margin: 0 4px;
            border-radius: 20px;
            font-size: 0.85rem;
            font-weight: 600;
            display: inline-block;
        }

        .cancel-btn {
            background-color: #f26d8c;
            color: white;
        }

        .cancel-btn:hover {
            background-color: #d94a6a;
        }
        .approve-btn {
    background-color: #28a745;
    color: white;
}
.approve-btn:hover {
    background-color: #218838;
}

.complete-btn {
    background-color: #007bff;
    color: white;
}
.complete-btn:hover {
    background-color: #0069d9;
}

.cancel-btn {
    background-color: #dc3545;
    color: white;
}
.cancel-btn:hover {
    background-color: #c82333;
}

    </style>
</head>
<body>
   <!-- Navigation -->
  <nav class="navbar">
    <a href="admin.php">🏠 Dashboard</a>
    <a href="manage_users.php">👥 Manage Users</a>
    <a href="manage_appointments.php">📅 Appointments</a>
    <a href="login.php">🔐 Login</a>
    <a href="index.php">🚪 Logout</a>
  </nav>

    <h1>📅 Appointment Management</h1>

    <div class="apt-table">
           <?php if ($result->num_rows > 0): ?>
    <table>
        <tr>
            <th>Patient</th>
            <th>Email</th>
            <th>Date</th>
            <th>Time</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= htmlspecialchars($row['fullname']) ?></td>
            <td><?= htmlspecialchars($row['email']) ?></td>
            <td><?= htmlspecialchars($row['appointment_date']) ?></td>
            <td><?= htmlspecialchars($row['appointment_time']) ?></td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td class="actions">
    <?php if ($row['status'] !== 'Cancelled'): ?>
        <?php if ($row['status'] === 'Pending'): ?>
            <a class="approve-btn" href="update_appointment_status.php?id=<?= $row['entry_id'] ?>&status=Approved">✅ Approve</a>
        <?php endif; ?>
        <?php if ($row['status'] === 'Approved'): ?>
            <a class="complete-btn" href="update_appointment_status.php?id=<?= $row['entry_id'] ?>&status=Completed">✔ Completed</a>
        <?php endif; ?>
        <a class="cancel-btn" href="update_appointment_status.php?id=<?= $row['entry_id'] ?>&status=Cancelled"
           onclick="return confirm('Cancel this appointment?');">❌ Cancel</a>
    <?php else: ?>
        <span style="color: #777;">—</span>
    <?php endif; ?>
</td>


        
        <?php endwhile; ?>
    </table>
<?php else: ?>
    <p class="note">No appointments found.</p>
<?php endif; ?>

    </div>

</body>
</html>
