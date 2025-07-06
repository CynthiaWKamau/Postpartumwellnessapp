<?php
session_start();
include 'auth.php';
require_role('admin');
include 'db_connection.php';

if (isset($_GET['id'], $_GET['status'])) {
    $id = intval($_GET['id']);
    $status = $_GET['status'];

    $allowed_statuses = ['Pending', 'Approved', 'Cancelled', 'Completed'];
    if (!in_array($status, $allowed_statuses)) {
        die("Invalid status.");
    }

    $sql = "UPDATE book_appointment SET status = ? WHERE entry_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $status, $id);

    if ($stmt->execute()) {
        header("Location: manage_appointments.php");
        exit;
    } else {
        echo "Error updating appointment status.";
    }
} else {
    echo "Invalid request.";
}
?>
