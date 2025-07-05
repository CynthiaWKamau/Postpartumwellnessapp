<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Journal | Luna Care</title>
    <link rel="stylesheet" href="journal.css" />
</head>

<body>
    <!-- Journal Header -->
    <header class="journal-header">
        <h1><em>Dear Me,</em></h1>
        <p>Your daily space to reflect, express, and grow 💫</p>
    </header>

    <!-- Journal Entry Form -->
    <section class="journal-form">
        <form id="entryForm">
            <label for="entryDate">Date:</label>
            <input type="date" id="entryDate" required />

            <label for="entryText">Your thoughts:</label>
            <textarea id="entryText" rows="8" placeholder="Write what’s on your mind..."></textarea>

            <button type="submit">Save Entry 📖</button>
        </form>
    </section>

    <!-- Journal History -->
    <section class="journal-history">
        <h2>📚 Past Entries</h2>
        <div id="entriesContainer"></div>
    </section>

    <script>
    const form = document.getElementById("entryForm");
    const container = document.getElementById("entriesContainer");

    form.addEventListener("submit", function(e) {
        e.preventDefault();
        const date = document.getElementById("entryDate").value;
        const text = document.getElementById("entryText").value.trim();

        if (!text) return alert("Please write something in your journal.");

        const entryDiv = document.createElement("div");
        entryDiv.className = "entry";
        entryDiv.innerHTML = `<h3>${date}</h3><p>${text}</p>`;

        container.prepend(entryDiv); // add new on top
        form.reset();
    });
    </script>
</body>

</html>