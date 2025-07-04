<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Choose Your Wellness Plan</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: linear-gradient(to bottom right, #ffe0ec, #fff0f7);
      margin: 0;
      padding: 2rem;
    }

    h1 {
      text-align: center;
      color: #e75480;
      margin-bottom: 2rem;
    }

    .plans {
      display: flex;
      justify-content: center;
      gap: 2rem;
      flex-wrap: wrap;
    }

    .plan-card {
      background-color: #fff;
      border: 2px solid #ffc1da;
      border-radius: 20px;
      box-shadow: 0 12px 35px rgba(255, 105, 180, 0.1);
      padding: 2rem;
      width: 300px;
      text-align: center;
    }

    .plan-card h2 {
      color: #d6336c;
      margin-bottom: 0.5rem;
    }

    .price {
      font-size: 1.6rem;
      color: #e75480;
      margin-bottom: 1rem;
    }

    ul {
      list-style: none;
      padding: 0;
      margin-bottom: 1.2rem;
      color: #555;
    }

    ul li {
      margin-bottom: 0.5rem;
    }

    input[type="text"],
    input[type="tel"] {
      width: 100%;
      padding: 0.6rem;
      margin-bottom: 0.8rem;
      border: 1px solid #f5b3cb;
      border-radius: 10px;
      background-color: #fff8fb;
      font-size: 0.95rem;
    }

    button {
      background-color: #e75480;
      color: white;
      border: none;
      padding: 0.8rem 1.2rem;
      border-radius: 12px;
      font-size: 1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    button:hover {
      background-color: #d6336c;
    }

    @media (max-width: 960px) {
      .plans {
        flex-direction: column;
        align-items: center;
      }
    }
  </style>
</head>
<body>

  <h1>Subscribe to Your Wellness Plan</h1>

  <div class="plans">

    <!-- Basic Plan -->
    <div class="plan-card">
      <h2>Basic Plan</h2>
      <p class="price">KES 1000</p>
      <ul>
        <li>✔ Monthly check-ins</li>
        <li>✔ Access to wellness tips</li>
        <li>✔ Access to community forums (read-only)</li>
         <li>✔ Personalized daily affirmations</li>
      </ul>
      <form class="subscription-form" data-plan="basic">
        <input type="hidden" name="plan" value="basic">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="tel" name="phone" placeholder="2547XXXXXXXX" required>
        <button type="submit">Choose Basic</button>
      </form>
    </div>

    <!-- Premium Plan -->
    <div class="plan-card">
      <h2>Premium Plan</h2>
      <p class="price">KES 2500</p>
      <ul>
        <li>✔ Everything in Basic</li>
        <li>✔ Weekly expert tips</li>
        <li>✔ Access to member-only community Q&A threads</li>
      </ul>
      <form class="subscription-form" data-plan="basic">
        <input type="hidden" name="plan" value="premium">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="tel" name="phone" placeholder="2547XXXXXXXX" required>
        <button type="submit">Choose Premium</button>
      </form>
    </div>

    <!-- Pro Plan -->
    <div class="plan-card">
      <h2>Pro Plan</h2>
      <p class="price">KES 5000</p>
      <ul>
        <li>✔ Everything in Premium</li>
        <li>✔ Weekly therapist sessions</li>
        <li>✔ Group coaching & live Q&A</li>
        <li>✔ Private mother’s network group (Pro-only)</li>
        <li>✔ Add partner access (father or caregiver)</li>
      </ul>
     <form class="subscription-form" data-plan="basic">
        <input type="hidden" name="plan" value="pro">
        <input type="text" name="name" placeholder="Your Name" required>
        <input type="tel" name="phone" placeholder="2547XXXXXXXX" required>
        <button type="submit">Choose Pro</button>
      </form>
    </div>

  </div>

  <script>
  document.querySelectorAll('.subscription-form').forEach(form => {
    form.addEventListener('submit', function(e) {
      e.preventDefault();

      const plan = this.dataset.plan;
      const phone = this.querySelector('input[name="phone"]').value;

      fetch('/api/initiate-payment/', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({
          phone_number: phone,
          plan: plan
        })
      })
      .then(response => response.json())
      .then(data => {
        console.log(data);
        if (data.CustomerMessage) {
          alert(data.CustomerMessage);
        } else {
          alert("STK push sent or simulated.");
        }
      })
      .catch(error => {
        console.error('Error:', error);
        alert("Something went wrong.");
      });
    });
  });
</script>

</body>
</html>
