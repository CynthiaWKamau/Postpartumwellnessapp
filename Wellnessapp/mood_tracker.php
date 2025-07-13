<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}

// Database connection
include 'db_connection.php';

$user_id = $_SESSION['id'];

// Fetch mood history
$stmt = $conn->prepare("SELECT mood, notes, influencing_factors, date_logged FROM moodtracker WHERE user_id = ? ORDER BY date_logged DESC");

// Fetch most recent mood entry for insights
$latest_stmt = $conn->prepare("SELECT mood, influencing_factors, notes, date_logged FROM moodtracker WHERE user_id = ? ORDER BY date_logged DESC LIMIT 1");
$latest_stmt->bind_param("i", $user_id);
$latest_stmt->execute();
$latest_result = $latest_stmt->get_result();
$latest_mood = $latest_result->fetch_assoc();


$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mood Tracker | Luna Care</title>
    <link rel="stylesheet" href="mood_tracker.css" />
</head>

<body>
  <body>

    <!-- Navigation -->
  <nav class="navbar">
<a href="postpartummother.php">🏠 Main Page</a>
<a href="mood_tracker.php">🧠 Mood Tracker</a>
<a href="journal.php">📔 Journal</a>
 <a href="http://127.0.0.1:8000/api/subscribe/" target="_blank">💳 Subscription</a>
<a href="book_appointment.php">📅 Book Appointment</a>
<a href="login.php">🔐 Login</a>
<a href="index.php">🚪 Logout</a>

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

    <!-- Mood Selector Navigation -->
    <section class="mood-selector">
  <div class="mood-nav">
    <button onclick="showSection('today')">💗 Today's Mood</button>
    <button onclick="showSection('history')">📅 Mood History</button>
    <button onclick="showSection('insight')">📈 Insights</button>
  </div>
</section>

<!--  Today's Mood Section -->
<div id="today" class="mood-content-section">
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
     </div>
    </div>
  
   </form>
</div>

<!-- 📅 Mood History Section -->
<div id="history" class="mood-content-section" style="display: none;">
  <section class="mood-section">
    <h2>📅 Mood History</h2>
    <?php if ($result->num_rows > 0): ?>
      <?php $i = 0; ?>
      <?php while ($row = $result->fetch_assoc()): ?>
        <?php $i++; ?>
        <div class="mood-history-entry">
          <button class="history-toggle" onclick="toggleMoodDetail(<?= $i ?>)">
            📅 <?= date("F j, Y - g:i A", strtotime($row['date_logged'])) ?>
          </button>
          <div id="mood-detail-<?= $i ?>" class="mood-detail hidden">
            <p><strong>Mood:</strong> <?= htmlspecialchars($row['mood']) ?></p>
            <p><strong>Factors:</strong> <?= htmlspecialchars($row['influencing_factors']) ?></p>
            <p><strong>Notes:</strong> <?= nl2br(htmlspecialchars($row['notes'])) ?></p>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p style="color: gray;">You haven’t tracked any moods yet.</p>
    <?php endif; ?>
  </section>
</div>

<!-- 📈 Insights Section -->
<div id="insight" class="mood-content-section" style="display: none;">
  <section class="mood-section">
    <h2>📈 Mood Insights</h2>
    <?php if (!empty($latest_mood)): ?>
      <div class="mood-history-entry">
        <button class="history-toggle" onclick="toggleInsightDetail()">
          <?= htmlspecialchars($latest_mood['mood']) ?> on <?= date("F j, Y - g:i A", strtotime($latest_mood['date_logged'])) ?>
        </button>
        <div id="insight-detail" class="mood-detail hidden">
          <?php
            $suggestion = "";
            switch ($latest_mood['mood']) {
              case "Sad":
                $suggestion = "It's okay to feel down sometimes. Try journaling, cuddling your baby, or talking to someone you trust.";
                break;
              case "Anxious":
                $suggestion = "Take a few deep breaths. Gentle stretching or stepping outside for a few minutes may help ease anxiety.";
                break;
              case "Happy":
                $suggestion = "Yay! Celebrate this moment. Maybe share it in your journal so you can revisit it later!";
                break;
              case "Okay":
                $suggestion = "You're doing alright. Consider doing one small thing today just for *you*.";
                break;
              case "Angry":
                $suggestion = "Take a moment to pause. It’s okay to feel angry — try expressing it through writing or a short walk.";
                break;
              case "Excited":
                $suggestion = "Hold on to this positive energy! Maybe channel it into a fun activity or creative task.";
                break;
              default:
                $suggestion = "However you're feeling, you're not alone. This space is here for you.";
                break;
            }
          ?>
          <p><strong>Suggestion:</strong> <?= $suggestion ?></p>
        </div>
      </div>
    <?php else: ?>
      <p style="color: gray;">Log your first mood to get personalized suggestions and insights 💡</p>
    <?php endif; ?>
  </section>
</div>


  <script>
  function showSection(sectionId) {
    const sections = document.querySelectorAll(".mood-content-section");
    sections.forEach(section => {
      section.style.display = (section.id === sectionId) ? "block" : "none";
    });
  }

    function toggleMoodDetail(id) {
    const section = document.getElementById('mood-detail-' + id);
    section.classList.toggle('hidden');
  }

  function toggleInsightDetail() {
    const detail = document.getElementById("insight-detail");
    detail.classList.toggle("hidden");
  }

  const moodCards = document.querySelectorAll(".mood-card");
  const moodInput = document.getElementById("moodInput");

  moodCards.forEach(card => {
    card.addEventListener("click", () => {
      moodCards.forEach(c => c.classList.remove("selected"));
      card.classList.add("selected");
      moodInput.value = card.dataset.mood;
    })
  });


</script>

</body>

</html>