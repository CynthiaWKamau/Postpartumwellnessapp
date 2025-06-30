<?php
session_start();
if ($_SESSION['role'] !== 'admin') {
    header("Location: ../login.php");
    exit();
}
?>
<h2>Welcome Admin <?= htmlspecialchars($_SESSION['fullname']) ?></h2>
