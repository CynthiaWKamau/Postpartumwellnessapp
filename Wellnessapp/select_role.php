<!--select_role.php -->
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Select Role-Wellness Application</title>
          <style>
    body {
      background: #ffe6f0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      margin: 0;
      padding: 0;
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }

    .signup-box {
      background-color: #fff0f5;
      border-radius: 20px;
      padding: 40px 60px;
      text-align: center;
      box-shadow: 0 8px 20px rgba(255, 105, 180, 0.2);
      border: 2px solid #ffc0cb;
    }

    .signup-box h2 {
      color: #d63384;
      margin-bottom: 25px;
      font-size: 24px;
    }

    .signup-box a {
      display: block;
      margin: 12px auto;
      width: 80%;
      padding: 12px;
      background-color: #f8bbd0;
      color: #4a004a;
      text-decoration: none;
      border-radius: 30px;
      font-weight: bold;
      transition: all 0.3s ease-in-out;
    }

    .signup-box a:hover {
      background-color: #ec407a;
      color: #fff;
      transform: scale(1.05);
    }
  </style>
    </head>
    <body>
        <div class="signup-box">
            <h2>Choose your role</h2>
       <a href="signup.php?role=postpartum mother">Postpartum Mother</a><br>
       <a href="signup.php?role=therapist">Therapist</a><br>
       <a href="signup.php?role=admin">Admin</a><br>
</div>
</body>
</html>
        