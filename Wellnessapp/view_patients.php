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
<html>
<head>
    <title>Therapist Dashboard - Patients</title>
    <style>
    body {
        font-family: 'Segoe UI', sans-serif;
        background: linear-gradient(to right, #fbe4ff, #f4f4ff);
        margin: 0;
        padding: 2rem;
        color: #333;
    }

    h1 {
        text-align: center;
        color: #6a1b9a;
        font-size: 2rem;
        margin-bottom: 3rem;
    }

    .patient-card {
        background: white;
        padding: 1.5rem 2rem;
        margin-bottom: 2rem;
        border-left: 6px solid #ba68c8;
        border-radius: 12px;
        box-shadow: 0 4px 8px rgba(106, 27, 154, 0.1);
        transition: transform 0.2s ease;
    }

    .patient-card:hover {
        transform: scale(1.01);
    }

    h2 {
        margin: 0;
        color: #4a148c;
    }

    .section {
        margin-top: 1.5rem;
    }

    h4 {
        color: #8e24aa;
        margin-bottom: 0.5rem;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    li {
        background: #f3e5f5;
        margin-bottom: 8px;
        padding: 10px 12px;
        border-radius: 8px;
        font-size: 0.95rem;
    }

    li strong {
        color: #6a1b9a;
    }

    .error {
        background-color: #ffebee;
        color: #c62828;
        border-left: 4px solid #e53935;
        padding: 10px;
        margin: 10px 0;
        border-radius: 5px;
    }

    .no-data {
        font-style: italic;
        color: #999;
    }
</style>

</head>
<body>

<?php while ($user = $result->fetch_assoc()): ?>
    <div class="patient-card">
        <h2><?= htmlspecialchars($user['fullname']) ?> (<?= htmlspecialchars($user['email']) ?>)</h2>

        <!-- Journals -->
        <div class="section">
            <h4>📝 Journals & Mood Entries</h4>
            <ul>
                <?php
                $user_id = $user['id'];
                $journal_sql = "SELECT mood, factors, entry_date FROM journal_entries WHERE user_id = $user_id ORDER BY entry_date DESC";
                $journal_entries = $conn->query($journal_sql);
                if ($journal_entries && $journal_entries->num_rows > 0) {
                    while ($j = $journal_entries->fetch_assoc()) {
                        echo "<li><strong>{$j['entry_date']}:</strong> Mood: {$j['mood']}, Factors: {$j['factors']}</li>";
                    }
                } else {
                    echo "<li>No journal entries.</li>";
                }
                ?>
            </ul>
        </div>

        <!-- Subscriptions -->
        <div class="section">
            <h4>💳 Subscriptions</h4>
            <ul>
                <?php
                $sub_sql = "SELECT amount, payment_status, transaction_date FROM subscriptions WHERE user_id = $user_id ORDER BY transaction_date DESC";
                $subs = $conn->query($sub_sql);
                if ($subs && $subs->num_rows > 0) {
                    while ($s = $subs->fetch_assoc()) {
                        echo "<li>{$s['transaction_date']}: {$s['plan']} - KES {$s['amount']} ({$s['payment_status']})</li>";
                    }
                } else if (!$subs) {
                    echo "<li>Error fetching subscriptions: " . $conn->error . "</li>";
                } else {
                    echo "<li>No subscription records.</li>";
                }
                ?>
            </ul>
        </div>

        <!-- Appointments -->
        <div class="section">
            <h4>📅 Appointments</h4>
            <ul>
                <?php
                $app_sql = "SELECT date, time, therapist_name, status FROM book_appointment WHERE user_id = $user_id ORDER BY date DESC";
                $apps = $conn->query($app_sql);
                if ($apps && $apps->num_rows > 0) {
                    while ($a = $apps->fetch_assoc()) {
                        echo "<li>{$a['date']} at {$a['time']} with {$a['therapist_name']} - Status: {$a['status']}</li>";
                    }
                } else {
                    echo "<li>No appointment history.</li>";
                }
                ?>
            </ul>
        </div>
    </div>
<?php endwhile; ?>

</body>
</html>