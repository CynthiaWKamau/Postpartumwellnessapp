<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mood Tracker | Luna Care</title>
    <link rel="stylesheet" href="mood_tracker.css" />
</head>

<body>
    <!-- Navigation -->
  <nav class="navbar">
    <a href="postpartummother.php">💗 Main Page</a>
    <a href="mood_tracker.php">💗 Mood Tracker</a>
    <a href="journal.php">📖 Journal</a>
    <a href="subscribe.php">💳 Subscription</a>
    <a href="book_appointment.php">📅 Book Appointment</a>
  </nav>


    <!-- MAIN SECTION -->
    <section class="mood-section">
        <h1><em>Mood Tracker</em></h1>

        <p>
            Track your emotional journey as a new mother. Understanding your mood <br>
            patterns helps create awareness and supports your wellbeing during this <br>
            transformative time.
        </p>
    </section>
    <!-- Mood Navigation -->
    <section class="mood-selector">
        <div class="mood-nav">
            <button onclick="showSection('today')">💗 Today's Mood</button>
            <button onclick="showSection('history')">📅 Mood History</button>
            <button onclick="showSection('insight')">📈 Insights</button>
        </div>
    </section>


  <form action="save_mood.php" method="POST">
            <!-- Hidden input to store selected mood -->
            <input type="hidden" name="mood" id="moodInput">
            
    <div class="mood-section-wrapper">
<!-- Mood Selection -->
<section class="mood-box">
  <h3>How are you feeling today?</h3>
  <div class="mood-options">
    <div class="mood-card" data-mood="Happy">😊 <span>Happy</span></div>
    <div class="mood-card" data-mood="Okay">😐 <span>Okay</span></div>
    <div class="mood-card" data-mood="Sad">😢 <span>Sad</span></div>
    <div class="mood-card" data-mood="Anxious">😰 <span>Anxious</span></div>
    <div class="mood-card" data-mood="Angry">😠 <span>Angry</span></div>
    <div class="mood-card" data-mood="Excited">🤩 <span>Excited</span></div>
  </div>
</section>

        <!-- Influencing Factors -->
        <section class="influencing-factors">
            <h2>What might have influenced your mood?</h2>
            <div class="tags">
            <label><input type="checkbox" name="factors[]" value="Sleep deprivation"> Sleep deprivation</label>
           <label><input type="checkbox" name="factors[]" value="Feeding Challenges"> Feeding Challenges</label>
           <label><input type="checkbox" name="factors[]" value="Hormonal Changes"> Hormonal Changes</label>
           <label><input type="checkbox" name="factors[]" value="Social Support"> Social Support</label>
           <label><input type="checkbox" name="factors[]" value="Baby Crying"> Baby Crying</label>
           <label><input type="checkbox" name="factors[]" value="Physical Discomfort"> Physical Discomfort</label>
           <label><input type="checkbox" name="factors[]" value="Partner Relationship"> Partner Relationship</label>
           <label><input type="checkbox" name="factors[]" value="Self-care Time"> Self-care Time</label>
           <label><input type="checkbox" name="factors[]" value="Family Stress"> Family Stress</label>
           <label><input type="checkbox" name="factors[]" value="Body Changes"> Body Changes</label>
           <label><input type="checkbox" name="factors[]" value="Milestone Worries"> Milestone Worries</label>
           <label><input type="checkbox" name="factors[]" value="Financial Concerns"> Financial Concerns</label>
        </div>
    </section>
        

            <!-- Additional Notes -->
            <section class="notes-section">
                <h2>Additional Notes (Optional)</h2>
                <textarea name="note"
                    placeholder="How are you feeling? What's on your mind today? Remember, every feeling is valid..."></textarea>
            </section>

            <!-- Save Button -->
            <div class="save-button">
                <button type="submit">Save Today's Mood 💕</button>
                <a href="journal.php" class="journal-link">Reflect in Journal ✍️</a>
            </div>
        </form>
<script>
  const moodCards = document.querySelectorAll(".mood-card");
  const moodInput = document.getElementById("moodInput");

  moodCards.forEach(card => {
    card.addEventListener("click", () => {
      // Remove active from others
      moodCards.forEach(c => c.classList.remove("selected"));
      // Add active to this one
      card.classList.add("selected");
      // Set value to hidden input
      moodInput.value = card.dataset.mood;
    });
  });
</script>

</body>

</html>