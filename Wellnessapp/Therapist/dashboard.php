<?php
include '../auth.php';
require_role('therapist');
?>

<h2>Welcome Therapist <?= htmlspecialchars($_SESSION['fullname']) ?></h2>
