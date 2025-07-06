<?php
session_start();
include 'db_connection.php';


// Fetch appointments linked to this therapist
$sql = "SELECT a.*, u.fullname AS patient_name, u.email AS patient_email
        FROM book_appointment a
        JOIN users u ON a.user_id = u.id
        WHERE u.role = 'postpartum mother'
        ORDER BY a.appointment_date ASC";

$result = $conn->query($sql);

if (!$result) {
    die("<p class='error'>Error fetching appointments: " . $conn->error . "</p>");
}
?>


<!DOCTYPE html>
<html>
<head>
    <title>Therapist Dashboard - Appointments</title>
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
            color: #6a1b9a;
            font-size: 2rem;
            margin: 3rem 0 2rem;
        }

        .appointment-table {
            width: 90%;
            margin: 0 auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 0 15px rgba(186, 104, 200, 0.1);
            border-radius: 12px;
            overflow: hidden;
        }

        .appointment-table th, .appointment-table td {
            padding: 1rem;
            border-bottom: 1px solid #f3e5f5;
            text-align: left;
        }

        .appointment-table th {
            background-color: #f3e5f5;
            color: #6a1b9a;
        }

        .appointment-table tr:nth-child(even) {
            background-color: #fdf6fc;
        }

        .no-data {
            text-align: center;
            margin-top: 3rem;
            color: #999;
            font-style: italic;
        }
.approve-btn {
    background-color: #28a745;
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    text-decoration: none;
    display: inline-block;
    margin-top: 6px;
    font-size: 0.85rem;
}
.approve-btn:hover {
    background-color: #218838;
}

.complete-btn {
    background-color: #007bff;
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    text-decoration: none;
    display: inline-block;
    margin-top: 6px;
    font-size: 0.85rem;
}
.complete-btn:hover {
    background-color: #0069d9;
}

.cancel-btn {
    background-color: #dc3545;
    color: white;
    padding: 5px 12px;
    border-radius: 20px;
    text-decoration: none;
    display: inline-block;
    margin-top: 6px;
    font-size: 0.85rem;
}
.cancel-btn:hover {
    background-color: #c82333;
}

         table {
      width: 90%;
      margin: 0 auto;
      border-collapse: collapse;
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 10px 25px rgba(245, 160, 200, 0.2);
      animation: fadeIn 0.6s ease-in-out;
    }

    th, td {
      padding: 1rem;
      text-align: left;
      border-bottom: 1px solid #f3e5f5;
      font-size: 0.95rem;
    }

    th {
      background-color: #fbe0f0;
      color: #6a1b9a;
      position: sticky;
      top: 0;
      z-index: 1;
    }

    tr:nth-child(even) {
      background-color: #fff7fb;
    }

    tr:hover {
      background-color: #fce4ec;
      transition: 0.3s;
    }

    .no-data {
      text-align: center;
      margin-top: 2rem;
      font-style: italic;
      color: #999;
    }

    @keyframes fadeIn {
      from { opacity: 0; transform: translateY(20px); }
      to { opacity: 1; transform: translateY(0); }
    }
    </style>
</head>
<body>
      <!-- Navbar -->
  <nav class="navbar">
    <a href="therapist.php">🏠 Dashboard</a>
    <a href="view_patients.php">👩‍🍼 View Patients</a>
    <a href="view_appointments.php">📅 Appointments</a>
    <a href="login.php">🔐 Login</a>
   <a href="index.php">🚪 Logout</a>
  </nav>
    <h1>Appointments with Postpartum Mothers</h1>

    <?php if ($result->num_rows > 0): ?>
    <table>
        <tr>
            <th>Mother's Name</th>
            <th>Email</th>
            <th>Date</th>
            <th>Time Slot</th>
            <th>Status</th>
          
        </tr>
       <?php while ($row = $result->fetch_assoc()): ?>
<tr>
    <td><?= htmlspecialchars($row['patient_name']) ?></td>
    <td><?= htmlspecialchars($row['patient_email']) ?></td>
    <td><?= htmlspecialchars($row['appointment_date']) ?></td>
    <td><?= htmlspecialchars($row['appointment_time']) ?></td>
    <td>
        <?php
            $status = strtolower($row['status']);
            $id = $row['entry_id'];

            // Display status badge only
            echo "<span class='status-badge status-$status'></span>";

            // Display appropriate action buttons based on status
            if ($status !== 'cancelled') {
                if ($status === 'pending') {
                    echo "<a class='approve-btn' href='therapist_update_appointment.php?id=$id&status=Approved'>✅ Approve</a> ";
                }

                if ($status === 'approved') {
                    echo "<a class='complete-btn' href='therapist_update_appointment.php?id=$id&status=Completed'>✔ Completed</a> ";
                }

                echo "<a class='cancel-btn' href='therapist_update_appointment.php?id=$id&status=Cancelled' onclick='return confirm(\"Cancel this appointment?\");'>❌ Cancel</a>";
            } else {
                echo "<span style='color: #999;'>—</span>";
            }
        ?>
    </td>
</tr>
<?php endwhile; ?>

    </table>
    <?php else: ?>
        <p>No appointments found.</p>
    <?php endif; ?>
</body>
</html>
