<?php
session_start();
if ($_SESSION['role'] !== 'therapist') {
    header("Location: ../login.php");
    exit();
}
?>
<h2>Welcome Therapist <?= htmlspecialchars($_SESSION['fullname']) ?></h2>
