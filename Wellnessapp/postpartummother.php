<?php
session_start();
include 'auth.php';
require_role('postpartum mother');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Welcome Mama 💕</title>
    <style>
    body {
        margin: 0;
        font-family: 'Poppins', 'Segoe UI', sans-serif;
        background: linear-gradient(to bottom right, #fff0f6, #fdf7fa);
        color: #4a3b47;
    }

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

    .nav-item {
        text-decoration: none;
        color: white;
        font-weight: 600;
        font-size: 17px;
        padding: 8px 16px;
        border-radius: 20px;
        transition: background 0.3s ease;
    }

    .nav-item:hover {
        background-color: #f772a7;
    }

    .navbar {
        background-color: #f9c5d1;
        padding: 1rem 2rem;
        display: flex;
        justify-content: center;
        gap: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border-bottom: 2px solid #fcdce5;
    }

    .navbar {
        background-color: #f9c5d1;
        padding: 1rem 2rem;
        display: flex;
        justify-content: center;
        gap: 2rem;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.06);
        border-bottom: 2px solid #fcdce5;
    }

    .navbar a {
        text-decoration: none;
        color: #4a3b47;
        font-weight: 600;
        background-color: #fff0f6;
        padding: 10px 20px;
        border-radius: 30px;
        transition: all 0.3s ease-in-out;
        box-shadow: 0 2px 6px rgba(255, 192, 203, 0.3);
    }

    .navbar a:hover {
        background-color: #ffb6c1;
        color: white;
    }

    .hero {
        text-align: center;
        padding: 4rem 1rem 2rem;
    }

    .hero h1 {
        font-size: 2.8rem;
        color: #d63384;
        margin-bottom: 1rem;
    }

    .hero p {
        font-size: 1.15rem;
        max-width: 650px;
        margin: auto;
        color: #6e5d67;
    }

    .features {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 2rem;
        padding: 2rem 3%;
    }

    .features a {
        text-decoration: none;
        color: inherit;
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
        font-size: 1.3rem;
    }

    .feature-card p {
        font-size: 0.98rem;
        color: #5f4b50;
        margin-top: 0.5rem;
    }

    .cta-button {
        text-align: center;
        margin: 2.5rem 0;
    }

    .cta-button a {
        background: linear-gradient(to right, #ff85a2, #ffb6c1);
        color: white;
        padding: 0.85rem 2.2rem;
        text-decoration: none;
        border-radius: 30px;
        font-size: 1.1rem;
        font-weight: 600;
        transition: background 0.3s ease;
        box-shadow: 0 6px 16px rgba(255, 160, 180, 0.3);
    }

    .cta-button a:hover {
        background: linear-gradient(to right, #f06292, #f48fb1);
    }
    </style>
</head>

<body>

    <!-- Navigation -->
    <nav class="navbar">

        <a href="http://localhost/Postpartumwellnessapp/Wellnessapp/postpartummother.php">🏠 Dashboard</a>
        <a href="http://localhost/Postpartumwellnessapp/Wellnessapp/mood_tracker.php">🧠 Mood Tracker</a>
        <a href="http://localhost/Postpartumwellnessapp/Wellnessapp/journal.php">📔 Journal</a>
        <a href="http://127.0.0.1:8000/api/subscribe/">💳 Subscription</a>
        <a href="http://localhost/Postpartumwellnessapp/Wellnessapp/book_appointment.php">📅 Book Appointment</a>
        <a href="http://localhost/Postpartumwellnessapp/Wellnessapp/login.php">🔐 Login</a>
        <a href="http://localhost/Postpartumwellnessapp/Wellnessapp/login.php">🚪 Logout</a>

    </nav>

    <!-- Hero Section -->
    <section class="hero">
        <h1>Welcome, <?= htmlspecialchars($_SESSION['fullname']) ?> 💕</h1>
        <p>Your soft and strong space for support, healing, and flourishing motherhood.</p>
    </section>

    <!-- Features Section -->
    <section class="features">
        <a href="mood_tracker.php">
            <div class="feature-card">
                <div class="feature-icon">💗</div>
                <h3>Track Your Mood</h3>
                <p>Record your daily feelings and observe your emotional patterns over time.</p>
            </div>
        </a>

        <a href="journal.php">
            <div class="feature-card">
                <div class="feature-icon">📖</div>
                <h3>Journal Entries</h3>
                <p>Write your heart out — express, reflect, and heal in a secure journal.</p>
            </div>
        </a>

        <a href="subscribe.html">
            <div class="feature-card">
                <div class="feature-icon">💳</div>
                <h3>Manage Subscription</h3>
                <p>Choose or update your care plan and explore the support that's right for you.</p>
            </div>
        </a>

        <a href="book_appointment.php">
            <div class="feature-card">
                <div class="feature-icon">📅</div>
                <h3>Book a Therapist</h3>
                <p>Connect with professionals ready to listen and support your journey.</p>
            </div>
        </a>
    </section>

    <!-- CTA Button -->
    <div class="cta-button">
        <a href="book_appointment.php">Start Your Wellness Journey 💫</a>
    </div>

</body>

</html>