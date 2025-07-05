<?php
session_start();
include 'db_connection.php';

$user_id = $_SESSION['id']; 
$mood = $_POST['mood'] ?? '';
$notes = $_POST['note'] ?? '';
$influencing_factors = $_POST['factors'] ?? [];
$factors_string = implode(", ", $influencing_factors);
$date_logged = date("Y-m-d H:i:s");


$sql = "INSERT INTO moodtracker (user_id, mood, influencing_factors, notes, date_logged) 
        VALUES (?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL error: " . $conn->error);
}

$stmt->bind_param("issss", $user_id, $mood, $factors_string, $notes, $date_logged);

if ($stmt->execute()) {
    header("Location: mood_tracker.php?from_mood=1");
    exit();
} else {
    echo "Error saving mood: " . $stmt->error;
}
?>
