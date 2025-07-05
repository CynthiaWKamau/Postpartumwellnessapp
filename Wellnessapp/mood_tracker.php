<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Mood Tracker | Luna Care</title>
    <link rel="stylesheet" href="mood_tracker.css" />
</head>

<body>
    <!-- NAVIGATION BAR -->
    <nav class="navbar">
        <a href="index.php" class="nav-item">🏠 Home</a>
        <a href="mood.php" class="nav-item">💗 Mood Tracker</a>
        <a href="journal.php" class="nav-item">📖 Journal Entries</a>
        <a href="wallet.php" class="nav-item">👛 Personal Wallet</a>


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



    <div class="mood-section-wrapper">

        <!-- Influencing Factors -->
        <section class="influencing-factors">
            <h2>What might have influenced your mood?</h2>
            <div class="tags">
                <span>Sleep deprivation</span>
                <span>Feeding challenges</span>
                <span>Hormonal changes</span>
                <span>Social support</span>
                <span>Baby crying</span>
                <span>Physical discomfort</span>
                <span>Partner relationship</span>
                <span>Self-care time</span>
                <span>Family stress</span>
                <span>Body changes</span>
                <span>Milestone worries</span>
                <span>Financial concerns</span>
            </div>
        </section>

        <form action="save_mood.php" method="POST">
            <!-- Hidden input to store selected mood -->
            <input type="hidden" name="mood" id="moodInput">

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
        </form>

        <script>
        function showSection(id) {
            const sections = document.querySelectorAll('.mood-section');
            sections.forEach(section => section.style.display = 'none');
            document.getElementById(id).style.display = 'block';
        }
        </script>



</body>

</html>