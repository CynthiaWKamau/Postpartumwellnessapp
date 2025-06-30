<?php
session_start();
if ($_SESSION['role'] !== 'postpartum mother') {
    header("Location: ../login.php");
    exit();
}
?>
<h2>Welcome, Mama <?= htmlspecialchars($_SESSION['fullname']) ?></h2>
