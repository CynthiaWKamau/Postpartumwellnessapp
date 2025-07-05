<?php
include '../auth.php';
require_role('postpartum mother');
?>

<h2>Welcome, Mama <?= htmlspecialchars($_SESSION['fullname']) ?></h2>
