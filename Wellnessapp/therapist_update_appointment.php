<?php
session_start();
include 'db_connection.php';

// Check if ID and status are provided
if (isset($_GET['id']) && isset($_GET['status'])) {
    $id = intval($_GET['id']);
    $status = $_GET['status'];

    // Define allowed statuses for safety
    $allowed_statuses = ['Pending', 'Approved', 'Cancelled', 'Completed'];

    if (!in_array($status, $allowed_statuses)) {
        die("Invalid status value.");
    }

    // Prepare the SQL query
    $sql = "UPDATE book_appointment SET status = ? WHERE entry_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $id);

    // Execute and check
    if ($stmt->execute()) {
        // Redirect back to the therapist appointments page
        header("Location: view_appointments.php");
        exit;
    } else {
        echo "Failed to update appointment status. Please try again.";
    }
} else {
    echo "Invalid request. Appointment ID or status missing.";
}
?>
