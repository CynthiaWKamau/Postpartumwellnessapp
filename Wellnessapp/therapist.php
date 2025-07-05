<?php
session_start();
include 'auth.php';
require_role('therapist');
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Therapist Dashboard | Luna Care</title>
  <link rel="stylesheet" href="therapist_dashboard.css" />
</head>
<style>
    body {
  margin: 0;
  font-family: 'Poppins', 'Segoe UI', sans-serif;
  background: linear-gradient(to bottom right, #fff0f6, #fdf7fa);
  color: #4a3b47;
}

/* Navbar */
.navbar {
  display: flex;
  justify-content: center;
  gap: 25px;
  padding: 1rem;
  background: linear-gradient(to right, #f99fc9, #d8b0f9);
  border-bottom: 3px solid #fff0f8;
  border-radius: 0 0 16px 16px;
  box-shadow: 0 5px 15px rgba(255, 182, 193, 0.25);
}

.navbar a {
  text-decoration: none;
  color: white;
  font-weight: 600;
  font-size: 16px;
  padding: 10px 18px;
  border-radius: 25px;
  transition: background 0.3s;
}

.navbar a:hover {
  background-color: #f77fbb;
}

/* Hero Section */
.hero {
  text-align: center;
  padding: 4rem 1rem 2rem;
}

.hero h1 {
  font-size: 2.6rem;
  color: #d63384;
  margin-bottom: 0.5rem;
}

.hero p {
  font-size: 1.1rem;
  max-width: 600px;
  margin: auto;
  color: #6e5d67;
}

/* Dashboard Feature Cards */
.features {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
  gap: 2rem;
  padding: 2rem 3%;
}

.feature-card {
  background: rgba(255, 240, 246, 0.8);
  border: 1px solid #ffe0ec;
  border-radius: 20px;
  padding: 2rem;
  text-align: center;
  box-shadow: 0 8px 24px rgba(255, 182, 193, 0.3);
  transition: transform 0.3s ease, box-shadow 0.3s ease;
  backdrop-filter: blur(6px);
  text-decoration: none;
  color: #4a3b47;
}

.feature-card:hover {
  transform: translateY(-7px);
  box-shadow: 0 12px 32px rgba(255, 160, 180, 0.4);
}

.feature-icon {
  font-size: 3rem;
  margin-bottom: 1rem;
}

.feature-card h3 {
  color: #b03060;
  font-size: 1.2rem;
  margin-bottom: 0.5rem;
}

.feature-card p {
  font-size: 0.95rem;
  color: #6e5d67;
}

    </style>

<body>

  <!-- Navbar -->
  <nav class="navbar">
    <a href="therapist_dashboard.php">🏠 Dashboard</a>
    <a href="patients.php">👩‍🍼 View Patients</a>
    <a href="appointments.php">📅 Appointments</a>
    <a href="reports.php">📊 Reports</a>
    <a href="payments.php">💰 Payments</a>
  </nav>

  <!-- Welcome Section -->
  <section class="hero">
    <h1>Welcome, <?= htmlspecialchars($_SESSION['fullname']) ?> 🌸</h1>
    <p>Support, guide, and empower your mothers with empathy and insight.</p>
  </section>

  <!-- Functional Cards -->
  <section class="features">
    <a href="patients.php" class="feature-card">
      <div class="feature-icon">👩‍🍼</div>
      <h3>Patient Info</h3>
      <p>Access patient profiles, notes, and mood history.</p>
    </a>

    <a href="appointments.php" class="feature-card">
      <div class="feature-icon">📅</div>
      <h3>Appointments</h3>
      <p>View and manage upcoming sessions.</p>
    </a>

    <a href="reports.php" class="feature-card">
      <div class="feature-icon">📊</div>
      <h3>Generate Reports</h3>
      <p>Analyze emotional patterns and generate progress reports.</p>
    </a>

    <a href="payments.php" class="feature-card">
      <div class="feature-icon">💰</div>
      <h3>Receive Payments</h3>
      <p>Track session payments and earnings securely.</p>
    </a>
  </section>

</body>
</html>
