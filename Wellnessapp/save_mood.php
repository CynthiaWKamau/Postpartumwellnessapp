<?php
session_start();
include 'db_connect.php'; // make sure this file contains your DB connection code

// For demo: assuming user_id is hardcoded
$user_id = 1;

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $mood = $_POST['mood'] ?? '';
    $notes = $_POST['notes'] ?? '';
    $mood_date = date('Y-m-d');

    if (empty($mood)) {
        die("Please select a mood.");
    }

    // Check if already submitted today
    $check = $conn->prepare("SELECT id FROM moods WHERE user_id = ? AND mood_date = ?");
    $check->bind_param("is", $user_id, $mood_date);
    $check->execute();
    $check->store_result();

    if ($check->num_rows > 0) {
        echo "You already submitted your mood today.";
    } else {
        $stmt = $conn->prepare("INSERT INTO moods (user_id, mood, notes, mood_date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("isss", $user_id, $mood, $notes, $mood_date);

        if ($stmt->execute()) {
            echo "Mood and notes saved successfully!";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    }

    $check->close();
    $conn->close();
}
?>