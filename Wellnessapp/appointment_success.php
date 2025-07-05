<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Appointment Confirmed</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to bottom right, #ffe0ec, #f9e6f2);
      margin: 0;
      padding: 40px;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      color: #4a3b47;
    }

    .confirmation-box {
      background-color: #fff0f6;
      padding: 40px;
      border-radius: 16px;
      box-shadow: 0 4px 12px rgba(255, 192, 203, 0.4);
      text-align: center;
      max-width: 500px;
    }

    .confirmation-box h1 {
      color: #d63384;
      font-family: 'Georgia', serif;
    }

    .confirmation-box p {
      font-size: 1.1rem;
      margin: 20px 0;
    }

    .confirmation-box a {
      display: inline-block;
      margin-top: 25px;
      text-decoration: none;
      background-color: #d63384;
      color: white;
      padding: 12px 25px;
      border-radius: 30px;
      font-weight: 600;
      transition: background 0.3s ease;
    }

    .confirmation-box a:hover {
      background-color: #b03060;
    }
  </style>
</head>
<body>
  <div class="confirmation-box">
    <h1>🎉 Appointment Booked!</h1>
    <p>Thank you for booking your therapy appointment. We’re here to support you.</p>
    <p>You’ll receive a reminder closer to your appointment time.</p>
    <a href="postpartummother.php">Return to Dashboard</a>
  </div>
</body>
</html>
