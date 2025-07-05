<?php
$role = $_SESSION['role'] ?? '';
$name = $_SESSION['fullname'] ?? '';
?>

<style>
.sidebar {
  position: fixed;
  top: 0;
  left: 0;
  height: 100%;
  width: 220px;
  background-color: #fff0f5;
  color: #4a004a;
  padding: 20px;
  box-shadow: 4px 0 10px rgba(0, 0, 0, 0.1);
  font-family: 'Segoe UI', sans-serif;
}

.sidebar h3 {
  color: #d63384;
  margin-bottom: 25px;
}

.sidebar a {
  display: block;
  padding: 10px 15px;
  margin-bottom: 10px;
  text-decoration: none;
  color: #4a004a;
  border-radius: 8px;
  transition: 0.3s;
  background-color: #ffe6f0;
}

.sidebar a:hover {
  background-color: #d63384;
  color: white;
}

.main-content {
  margin-left: 240px;
  padding: 30px;
}
</style>

<div class="sidebar">
  <h3><?= ucwords($role) ?> Panel</h3>
  <p>Welcome, <?= htmlspecialchars($name) ?> 👋</p>

  <?php if ($role === 'admin'): ?>
    <a href="dashboard.php">Dashboard</a>
    <a href="view_mothers.php">View Mothers</a>
    <a href="view_therapists.php">View Therapists</a>
    <a href="manage_users.php">Manage Users</a>
  
  <?php elseif ($role === 'therapist'): ?>
    <a href="dashboard.php">Dashboard</a>
    <a href="assigned_mothers.php">Assigned Mothers</a>
    <a href="submit_resources.php">Submit Resources</a>

  <?php elseif ($role === 'postpartum mother'): ?>
    <a href="dashboard.php">Home</a>
    <a href="wellness_materials.php">Wellness Materials</a>
    <a href="my_therapist.php">My Therapist</a>
    <a href="support_forum.php">Support Forum</a>

  <?php endif; ?>

  <a href="../logout.php">Logout</a>
</div>
