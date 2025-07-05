<?php
include '../auth.php';
require_role('admin');
include '../components/sidebar.php';
?>

<h2>Welcome Admin <?= htmlspecialchars($_SESSION['fullname']) ?></h2>
