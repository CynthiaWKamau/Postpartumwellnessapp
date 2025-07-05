<?php
include '../auth.php';
require_role('therapist');
include '../components/sidebar.php';
?>

<div class="main-content">
<h2>Welcome Therapist <?= htmlspecialchars($_SESSION['fullname']) ?></h2>
 <p>This is your therapist dashboard where you can support mothers and share resources.</p>
 </div>