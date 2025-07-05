<?php
session_start();
include 'db_connection.php'; 

// Ensure user is logged in
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Set timezone for consistency
date_default_timezone_set('Africa/Nairobi');

// Sanitize and fetch inputs
$user_id   = $_SESSION['id'];
$fullname  = $_POST['fullname'] ?? '';
$email     = $_POST['email'] ?? '';
$phone     = $_POST['phone'] ?? '';
$date      = $_POST['date'] ?? '';
$time      = $_POST['time'] ?? '';
$notes     = $_POST['notes'] ?? '';

// Prepare and bind
$sql = "INSERT INTO book_appointment (user_id, fullname, email, phone, appointment_date, appointment_time, notes)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL error: " . $conn->error);
}

$stmt->bind_param("issssss", $user_id, $fullname, $email, $phone, $date, $time, $notes);

// Execute
if ($stmt->execute()) {
   header("Location: appointment_success.php");

    exit();
} else {
    echo "Error saving appointment: " . $stmt->error;
}
?>
