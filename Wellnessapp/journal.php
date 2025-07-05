<?php
session_start();
if (!isset($_SESSION['id'])) {
    header("Location: login.php");
    exit();
}
include 'db_connection.php'; 

$user_id = $_SESSION['id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Your Journal | Luna Care</title>
  <link rel="stylesheet" href="journal.css" />
  <style>
  * {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: 'Segoe UI', sans-serif;
  background: linear-gradient(to bottom right, #ffe0f0, #fbefff);
  color: #663366;
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

/* Journal Section */
.journal-section {
  max-width: 800px;
  margin: 60px auto;
  padding: 30px;
  background: #fff6fc;
  border: 1px solid #ffcce6;
  border-radius: 20px;
  box-shadow: 0 4px 20px rgba(246, 180, 212, 0.3);
  text-align: center;
}

.journal-section h1 {
  color: #c94fa8;
  font-size: 2.5rem;
  margin-bottom: 15px;
}

.journal-section p {
  font-size: 1.1rem;
  color: #7e4c74;
  margin-bottom: 30px;
}

.previous-entry {
  background: #fff0fa;
  border-left: 5px solid #d484c4;
  padding: 20px;
  margin-bottom: 20px;
  border-radius: 12px;
  box-shadow: 0 2px 8px rgba(244, 182, 218, 0.2);
}


textarea {
  width: 100%;
  min-height: 200px;
  border: 1px solid #e6bbe3;
  border-radius: 12px;
  padding: 20px;
  font-size: 16px;
  background-color: #fff;
  color: #5a3e6b;
  resize: vertical;
  outline: none;
  box-shadow: 0 3px 6px rgba(241, 141, 204, 0.1);
}

textarea:focus {
  border-color: #d184ec;
  box-shadow: 0 0 8px rgba(218, 128, 215, 0.2);
}

/* Button */
.btn-area {
  margin-top: 20px;
}

.btn-area button {
  padding: 12px 30px;
  font-size: 16px;
  background: linear-gradient(to right, #f875b8, #c052cc);
  color: white;
  border: none;
  border-radius: 30px;
  cursor: pointer;
  transition: 0.3s ease;
  box-shadow: 0 5px 15px rgba(225, 116, 178, 0.3);
}

.btn-area button:hover {
  opacity: 0.9;
}
</style>
</head>
<body>

   <!-- Navigation -->
  <nav class="navbar">
   <a href="postpartummother.php">🏠 Main Page</a>
<a href="mood_tracker.php">🧠 Mood Tracker</a>
<a href="journal.php">📔 Journal</a>
<a href="subscribe.php">💳 Subscription</a>
<a href="book_appointment.php">📅 Book Appointment</a>
<a href="login.php">🔐 Login</a>
<a href="logout.php">🚪 Logout</a>

  </nav>
  <section class="journal-section">
    <h1>📝 Reflect & Release</h1>
    <p>Write freely about your thoughts, emotions, and experiences. This is your safe space to heal and grow.</p>

      <?php if (isset($_GET['success'])): ?>
  <p style="text-align:center; color:green;">Your journal entry has been saved 💖</p>
<?php elseif (isset($_GET['error']) && $_GET['error'] === 'empty'): ?>
  <p style="text-align:center; color:red;">Journal entry cannot be empty.</p>
<?php endif; ?>

    <form action="save_journal.php" method="POST">
      <textarea name="entry" placeholder="Start writing your thoughts here..."></textarea>
      <div class="btn-area">
        <button type="submit">Save Journal Entry</button>
      </div>

    </form>
  </section>

   <!-- Start of Previous Journal Entries Section -->
  <?php
  // Fetch previous entries
  $entries_query = $conn->prepare("SELECT entry, date_logged FROM journal_entries WHERE user_id = ? ORDER BY date_logged DESC");
  $entries_query->bind_param("i", $user_id);
  $entries_query->execute();
  $entries_result = $entries_query->get_result();
  ?>
  <section class="journal-section">
    <h2 style="margin-top: 40px;">📚 Previous Journal Entries</h2>

    <?php if ($entries_result->num_rows > 0): ?>
      <?php while ($row = $entries_result->fetch_assoc()): ?>
        <div style="text-align: left; margin-top: 20px; padding: 20px; background-color: #fff0fa; border-left: 5px solid #d484c4; border-radius: 12px;">
          <p><strong>Date:</strong> <?= date("F j, Y - g:i a", strtotime($row['date_logged'])) ?></p>
          <p><?= nl2br(htmlspecialchars($row['entry'])) ?></p>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <p style="color: gray;">You haven’t written any journal entries yet.</p>
    <?php endif; ?>
  </section>
  <!-- 🌸 End of Previous Journal Entries Section -->

</body>
</html>
