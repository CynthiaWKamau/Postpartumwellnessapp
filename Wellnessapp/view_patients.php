<?php
//include database connection
include 'db_connection.php';

// Fetch postpartum mothers
$sql = "SELECT id, fullname, email FROM users WHERE role = 'postpartum mother'";
$result = $conn->query($sql);

if (!$result) {
    die("Error fetching users: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Therapist Dashboard - Patients</title>
    <style>
        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to bottom right, #fff0f6, #fdf7fa);
            color: #4a3b47;
        }

        .navbar {
            display: flex;
            justify-content: center;
            gap: 1.5rem;
            padding: 1rem 2rem;
            background: linear-gradient(to right, #f99fc9, #d8b0f9);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
            border-bottom: 2px solid #fcdce5;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .navbar a {
            text-decoration: none;
            color: #4a3b47;
            font-weight: 600;
            background-color: #fff0f6;
            padding: 10px 20px;
            border-radius: 30px;
            transition: all 0.3s ease;
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
            margin: 2rem 0 1rem;
        }

        .patient-card {
            background: white;
            padding: 1.5rem 2rem;
            margin: 2rem auto;
            border-left: 6px solid #ba68c8;
            border-radius: 16px;
            box-shadow: 0 6px 16px rgba(106, 27, 154, 0.1);
            max-width: 750px;
            transition: transform 0.2s ease;
        }

        .patient-card:hover {
            transform: scale(1.01);
        }

        h2 {
            margin: 0 0 1rem;
            color: #4a148c;
            font-size: 1.4rem;
        }

        .section {
            margin-top: 1.5rem;
        }

        .toggle-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            cursor: pointer;
            background-color: #f3e5f5;
            padding: 10px 15px;
            border-radius: 8px;
            margin-bottom: 10px;
            font-weight: 600;
        }

        .toggle-arrow {
            transition: transform 0.3s ease;
            font-size: 1.2rem;
        }

        .rotate {
            transform: rotate(90deg);
        }

        .collapsed {
            display: none;
        }

        ul {
            list-style: none;
            padding-left: 0;
        }

        li {
            background: #fce4ec;
            margin-bottom: 8px;
            padding: 12px 14px;
            border-radius: 10px;
            font-size: 0.95rem;
            line-height: 1.4;
        }

        li strong {
            color: #6a1b9a;
        }

        .no-data {
            font-style: italic;
            color: #999;
        }
    </style>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const toggles = document.querySelectorAll(".toggle-header");
            toggles.forEach(toggle => {
                toggle.addEventListener("click", function () {
                    const section = this.nextElementSibling;
                    section.classList.toggle("collapsed");
                    const arrow = this.querySelector(".toggle-arrow");
                    arrow.classList.toggle("rotate");
                });
            });
        });
    </script>
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

    <?php while ($user = $result->fetch_assoc()): ?>
        <div class="patient-card">
            <h2><?= htmlspecialchars($user['fullname']) ?> (<?= htmlspecialchars($user['email']) ?>)</h2>

            <!-- Journals -->
            <div class="section">
                <div class="toggle-header">
                    <h4>📝 Journals</h4>
                    <span class="toggle-arrow">▶</span>
                </div>
                <ul class="collapsed">
                    <?php
                    $user_id = (int)$user['id'];
                    $journal_sql = "SELECT entry, date_logged FROM journal_entries WHERE user_id = '$user_id' ORDER BY date_logged DESC";
                    $journal_entries = $conn->query($journal_sql);
                    if ($journal_entries && $journal_entries->num_rows > 0) {
                        while ($j = $journal_entries->fetch_assoc()) {
                            echo "<li><strong>{$j['date_logged']}</strong>: " . htmlspecialchars($j['entry']) . "</li>";
                        }
                    } else {
                        echo "<li class='no-data'>No journal entries.</li>";
                    }
                    ?>
                </ul>
            </div>

            <!-- Mood Tracker -->
            <div class="section">
                <div class="toggle-header">
                    <h4>💖 Mood Tracker</h4>
                    <span class="toggle-arrow">▶</span>
                </div>
                <ul class="collapsed">
                    <?php
                    $mood_sql = "SELECT mood, influencing_factors, notes, date_logged FROM moodtracker WHERE user_id = '$user_id' ORDER BY date_logged DESC";
                    $mood_entries = $conn->query($mood_sql);
                    if ($mood_entries && $mood_entries->num_rows > 0) {
                        while ($m = $mood_entries->fetch_assoc()) {
                            echo "<li><strong>{$m['date_logged']}</strong>: Mood: <em>{$m['mood']}</em> | Factors: {$m['influencing_factors']}<br>Notes: " . htmlspecialchars($m['notes']) . "</li>";
                        }
                    } else {
                        echo "<li class='no-data'>No mood tracker entries.</li>";
                    }
                    ?>
                </ul>
            </div>

            <!-- Subscriptions -->
            <div class="section">
                <div class="toggle-header">
                    <h4>💳 Subscriptions</h4>
                    <span class="toggle-arrow">▶</span>
                </div>
                <ul class="collapsed">
                    <?php
                    $sub_sql = "SELECT plan, amount, payment_status, transaction_date FROM subscriptions_subscription WHERE user_id = $user_id ORDER BY transaction_date DESC";
                    $subs = $conn->query($sub_sql);
                    if ($subs && $subs->num_rows > 0) {
                        while ($s = $subs->fetch_assoc()) {
                            echo "<li><strong>{$s['transaction_date']}</strong>: {$s['plan']} - KES {$s['amount']} ({$s['payment_status']})</li>";
                        }
                    } else {
                        echo "<li class='no-data'>No subscription records.</li>";
                    }
                    ?>
                </ul>
            </div>

            <!-- Appointments -->
            <div class="section">
                <div class="toggle-header">
                    <h4>📅 Appointments</h4>
                    <span class="toggle-arrow">▶</span>
                </div>
                <ul class="collapsed">
                    <?php
                    $app_sql = "SELECT appointment_date, appointment_time, status FROM book_appointment WHERE user_id = $user_id ORDER BY appointment_date DESC";
                    $apps = $conn->query($app_sql);
                    if ($apps && $apps->num_rows > 0) {
                        while ($a = $apps->fetch_assoc()) {
                            echo "<li><strong>{$a['appointment_date']}</strong> at {$a['appointment_time']} - Status: {$a['status']}</li>";
                        }
                    } else {
                        echo "<li class='no-data'>No appointment history.</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    <?php endwhile; ?>
</body>
</html>
