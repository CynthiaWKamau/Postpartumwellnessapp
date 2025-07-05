<?php
session_start();
include 'db_connection.php';

$id = $_SESSION['id']; 
$mood = $_POST['mood'] ?? '';
$notes = $_POST['note'] ?? '';
$influencing_factors = $_POST['factors'] ?? []; 
$date_logged = implode(", ", $factors);

$stmt = $conn->prepare("INSERT INTO mood_entries (id, mood, notes, influencing_factors, date_logged) VALUES (?, ?, ?, ?, ?)");
$stmt->bind_param("isss", $id, $mood, $influencing_factors, $notes);

if ($stmt->execute()) {
    header("Location: journal.php?from_mood=1"); // Redirect to journaling page
    exit();
} else {
    echo "Error saving mood.";
}
?>
