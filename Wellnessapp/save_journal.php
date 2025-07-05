<?php
session_start();
include 'db_connection.php';

if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Set timezone
date_default_timezone_set('Africa/Nairobi');

$user_id = $_SESSION['id'];
$entry = $_POST['entry'] ?? '';
$date_logged = date("Y-m-d H:i:s");

if (!empty(trim($entry))) {
    $stmt = $conn->prepare("INSERT INTO journal_entries (user_id, entry, date_logged) VALUES (?, ?, ?)");
    $stmt->bind_param("iss", $user_id, $entry, $date_logged);

    if ($stmt->execute()) {
        header("Location: journal.php?success=1");
        exit();
    } else {
        echo "Error saving journal: " . $stmt->error;
    }
    $stmt->close();
} else {
    header("Location: journal.php?error=empty");
    exit();
}
?>
