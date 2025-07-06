<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Select Your Role | Luna Care</title>
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      background: linear-gradient(135deg, #ffe6f0, #fff6f9);
    }
    .role-container {
      background: #ffffff;
      border-radius: 20px;
      padding: 2rem 3rem;
      box-shadow: 0 12px 30px rgba(220, 51, 132, 0.15);
      text-align: center;
      max-width: 360px;
      width: 100%;
    }
    .role-container h2 {
      margin-bottom: 2rem;
      color: #d63384;
      font-size: 1.8rem;
    }
    .roles {
      display: flex;
      flex-direction: column;
      gap: 1rem;
    }
    .roles a {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 0.75rem;
      padding: 0.9rem;
      border-radius: 30px;
      text-decoration: none;
      font-size: 1rem;
      font-weight: bold;
      color: #4a004a;
      background: #f8bbd0;
      transition: all 0.3s ease;
    }
    .roles a:hover,
    .roles a:focus {
      background: #ec407a;
      color: white;
      transform: translateY(-2px);
      outline: none;
    }
    .roles a .icon {
      font-size: 1.2rem;
    }
    @media (max-width: 480px) {
      .role-container {
        padding: 1.5rem 2rem;
      }
      .role-container h2 {
        font-size: 1.5rem;
      }
      .roles a {
        font-size: 0.95rem;
        padding: 0.8rem;
      }
    }
  </style>
</head>
<body>
  <div class="role-container" role="region" aria-labelledby="role-heading">
    <h2 id="role-heading">Choose Your Role</h2>
    <div class="roles">
      <a href="signup.php?role=postpartum+mother">
        <span class="icon">🤱</span> Postpartum Mother
      </a>
      <a href="signup.php?role=therapist">
        <span class="icon">🧑‍⚕️</span> Therapist
      </a>
      <a href="signup.php?role=admin">
        <span class="icon">🛠️</span> Admin
      </a>
    </div>
  </div>
</body>
</html>
