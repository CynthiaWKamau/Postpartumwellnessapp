<?php
session_start();
require_once 'vendor/autoload.php';
include 'db_connection.php';


$role = $_SESSION['role'];

// Fetch relevant data based on role
$appointments = [];
$journals = [];
$moods = [];

if ($role === 'postpartum mother') {
    $apt_sql = "SELECT appointment_date, appointment_time, status FROM book_appointment WHERE user_id = ? ORDER BY appointment_date DESC";
    $stmt = $conn->prepare($appt_sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $appointments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $mood_sql = "SELECT mood, date, factor FROM mood_entries WHERE user_id = ? ORDER BY date DESC";
    $stmt = $conn->prepare($mood_sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $moods = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    $journal_sql = "SELECT entry, created_at FROM journal_entries WHERE user_id = ? ORDER BY created_at DESC";
    $stmt = $conn->prepare($journal_sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $journals = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Report - Wellness Platform</title>
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
            color: #d63384;
            text-align: center;
        }
        .section {
            background: #fff;
            margin: 1rem auto;
            max-width: 800px;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(255, 182, 193, 0.2);
        }
        h2 {
            color: #b03060;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border-bottom: 1px solid #f0d3e6;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #fce4ec;
        }
        .note {
            font-style: italic;
            color: #777;
        }
    </style>
</head>
<body>
       <!-- Navbar -->
  <nav class="navbar">
    <a href="therapist.php">🏠 Dashboard</a>
    <a href="view_patients.php">👩‍🍼 View Patients</a>
    <a href="view_appointments.php">📅 Appointments</a>
    <a href="reports.php">📊 Reports</a>
    <a href="payments.php">💰 Payments</a>
    <a href="login.php">🔐 Login</a>
    <a href="logout.php">🚪 Logout</a>
  </nav>

    <h1>📄 Wellness Report</h1>

    <div class="section">
        <h2>Appointment History</h2>
        <?php if (count($appointments) > 0): ?>
        <table>
            <tr><th>Date</th><th>Time</th></tr>
            <?php foreach ($appointments as $a): ?>
                <tr>
                    <td><?= htmlspecialchars($a['appointment_date']) ?></td>
                    <td><?= htmlspecialchars($a['appointment_time']) ?></td>
                    <td><?= htmlspecialchars($a['status']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
            <p class="note">No appointments found.</p>
        <?php endif; ?>
    </div>

    <div class="section">
        <h2>Mood Tracking</h2>
        <?php if (count($moods) > 0): ?>
        <table>
            <tr><th>Date</th><th>Mood</th><th>Influencing Factor</th></tr>
            <?php foreach ($moods as $m): ?>
                <tr>
                    <td><?= htmlspecialchars($m['date']) ?></td>
                    <td><?= htmlspecialchars($m['mood']) ?></td>
                    <td><?= htmlspecialchars($m['factor']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
            <p class="note">No mood entries yet.</p>
        <?php endif; ?>
    </div>

    <div class="section">
        <h2>Journal Entries</h2>
        <?php if (count($journals) > 0): ?>
        <table>
            <tr><th>Date</th><th>Entry</th></tr>
            <?php foreach ($journals as $j): ?>
                <tr>
                    <td><?= htmlspecialchars($j['created_at']) ?></td>
                    <td><?= nl2br(htmlspecialchars($j['entry'])) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
        <?php else: ?>
            <p class="note">No journal entries found.</p>
        <?php endif; ?>
    </div>
</body>
</html>