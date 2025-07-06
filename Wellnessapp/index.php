<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Luna Care | Nurturing You</title>
  <link href="https://fonts.googleapis.com/css2?family=Comfortaa:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      margin: 0;
      font-family: 'Comfortaa', sans-serif;
      background: #fff6f9;
      color: #4a3b47;
      line-height: 1.6;
    }

    .hero {
      background: linear-gradient(to bottom, #ffd6e8, #f8ecff);
      text-align: center;
      padding: 5rem 2rem 4rem;
      border-radius: 0 0 50px 50px;
      animation: fadeIn 1.5s ease-in-out;
    }

    .hero h1 {
      font-size: 3rem;
      color: #b03060;
      margin-bottom: 1rem;
    }

    .hero p {
      font-size: 1.2rem;
      max-width: 600px;
      margin: 0 auto;
      color: #6e5d67;
    }


    .highlight-section {
      display: flex;
      flex-wrap: wrap;
      justify-content: center;
      gap: 2rem;
      padding: 4rem 2rem;
    }

    .highlight {
      background: #ffffff;
      border-radius: 20px;
      padding: 2rem;
      max-width: 300px;
      box-shadow: 0 10px 30px rgba(255, 192, 203, 0.2);
      text-align: center;
      transition: transform 0.3s ease;
    }

    .highlight:hover {
      transform: translateY(-6px);
    }

    .highlight h3 {
      color: #c2185b;
      margin-bottom: 0.5rem;
      font-size: 1.2rem;
    }

    .highlight p {
      color: #5f4b50;
      font-size: 0.95rem;
    }

    .cta {
      background: linear-gradient(to right, #ffbdd3, #d9c7ff);
      padding: 3rem 2rem;
      text-align: center;
      border-radius: 30px;
      margin: 3rem 2rem;
    }

    .cta h2 {
      color: #902b5b;
      font-size: 2rem;
      margin-bottom: 1rem;
    }

    .cta p {
      max-width: 600px;
      margin: 0 auto 2rem;
      color: #4a3b47;
    }

    .cta a {
      display: inline-block;
      background: #ff85a2;
      color: #fff;
      padding: 0.85rem 2rem;
      text-decoration: none;
      font-size: 1.05rem;
      border-radius: 30px;
      font-weight: bold;
      transition: background 0.3s ease;
      box-shadow: 0 6px 18px rgba(255, 160, 180, 0.4);
    }

    .cta a:hover {
      background: #e75480;
    }

    footer {
      text-align: center;
      padding: 1.5rem;
      font-size: 0.95rem;
      color: #7c6f76;
      background: #fce6f1;
      margin-top: 2rem;
    }

    @keyframes fadeIn {
      from {
        opacity: 0;
        transform: translateY(40px);
      }

      to {
        opacity: 1;
        transform: translateY(0);
      }
    }

    @media (max-width: 768px) {
      .highlight {
        width: 100%;
      }
    }
  </style>
</head>

<body>

  <!-- HERO SECTION -->
  <section class="hero">
    <h1>Luna Care</h1>
    <p>Your cozy corner of compassion and calm — gently supporting you through your postpartum journey.</p>
  </section>

  <!-- HIGHLIGHTS -->
  <section class="highlight-section">
    <div class="highlight">
      <h3>🫧 Gentle Practices</h3>
      <p>Unwind with guided breathing, light stretches, and affirmations tailored just for moms.</p>
    </div>
    <div class="highlight">
      <h3>🌟 Safe Reflection</h3>
      <p>Journal how you feel, when you need — no pressure, no judgment, just your voice.</p>
    </div>
    <div class="highlight">
      <h3>🎧 Soft Sounds</h3>
      <p>Listen to calming audio designed to soothe your nervous system and ease your nights.</p>
    </div>
  </section>

  <!-- CALL TO ACTION -->
  <section class="cta">
    <h2>Join Our Gentle Circle</h2>
    <p>Luna Care is here to remind you that *you matter*. Begin your healing journey today and feel deeply supported.</p>
    <a href="select_role.php">Get Started</a>
  </section>

  <!-- FOOTER -->
  <footer>
    &copy; 2025 Luna Care — made with empathy and grace 💜
  </footer>

</body>

</html>
