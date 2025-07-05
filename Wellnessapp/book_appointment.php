<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Book Therapist Appointment</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      margin: 0;
      background: linear-gradient(to bottom right, #ffeef5, #fff5fa);
      color: #4a3b47;
    }

    .container {
      max-width: 800px;
      margin: 0 auto;
      padding: 40px 20px;
    }

    h1 {
      text-align: center;
      font-family: 'Georgia', serif;
      color: #d63384;
      margin-bottom: 30px;
    }

    .appointment-form {
      background-color: #ffeaf4;
      border-radius: 15px;
      padding: 30px;
      box-shadow: 0 6px 20px rgba(255, 182, 193, 0.3);
    }

    .form-group {
      margin-bottom: 20px;
    }

    .form-group label {
      display: block;
      margin-bottom: 8px;
      font-weight: 500;
      color: #4a3b47;
    }

    .form-group input,
    .form-group select,
    .form-group textarea {
      width: 100%;
      padding: 12px;
      border: 1px solid #dca6bc;
      border-radius: 10px;
      font-size: 1rem;
      background-color: #fff;
      box-shadow: inset 0 2px 4px rgba(255, 182, 193, 0.2);
    }

    .form-group textarea {
      resize: vertical;
      height: 100px;
    }

    .form-group button {
      width: 100%;
      padding: 12px;
      background-color: #d63384;
      border: none;
      color: white;
      font-size: 1.1rem;
      border-radius: 25px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .form-group button:hover {
      background-color: #b03060;
    }

    .footer-note {
      text-align: center;
      font-size: 0.9rem;
      margin-top: 20px;
      color: #7a5e67;
    }
  </style>
</head>
<body>

  <div class="container">
    <h1>💬 Book a Therapy Appointment</h1>

    <div class="appointment-form">
      <form method="POST" action="submit_appointment.php">
        <div class="form-group">
          <label for="fullname">Full Name</label>
          <input type="text" id="fullname" name="fullname" required>
        </div>

        <div class="form-group">
          <label for="email">Email Address</label>
          <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
          <label for="phone">Phone Number</label>
          <input type="tel" id="phone" name="phone" required>
        </div>

        <div class="form-group">
          <label for="date">Preferred Date</label>
          <input type="date" id="date" name="date" required>
        </div>

        <div class="form-group">
          <label for="time">Preferred Time</label>
          <select id="time" name="time" required>
            <option value="">Select a time</option>
            <option>09:00 AM</option>
            <option>10:30 AM</option>
            <option>12:00 PM</option>
            <option>02:00 PM</option>
            <option>03:30 PM</option>
            <option>05:00 PM</option>
          </select>
        </div>

        <div class="form-group">
          <label for="notes">Anything you'd like your therapist to know?</label>
          <textarea id="notes" name="notes" placeholder="Your message..."></textarea>
        </div>

        <div class="form-group">
          <button type="submit">Confirm Appointment 💖</button>
        </div>
      </form>
    </div>

    <div class="footer-note">
      Need help? Reach us anytime via support@lunacare.com
    </div>
  </div>

</body>
</html>
