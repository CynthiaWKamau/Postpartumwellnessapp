<?php
include '../auth.php';
require_role('admin');
include '../components/sidebar.php';
?>

<div class="main-content">
<h2>Welcome Admin <?= htmlspecialchars($_SESSION['fullname']) ?></h2>
 <p>This is your admin dashboard. You can view and manage mothers, therapists, and more.</p>
</div>