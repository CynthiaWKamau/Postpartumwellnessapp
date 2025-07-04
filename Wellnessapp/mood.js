// mood.js

document.addEventListener("DOMContentLoaded", () => {
  const form = document.getElementById("mood-form");
  const dateElement = document.getElementById("current-date");
  const savedMessage = document.getElementById("saved-message");

  const today = new Date().toISOString().split("T")[0];
  dateElement.textContent = new Date().toDateString();

  // Load previous mood if already saved
  const savedData = JSON.parse(localStorage.getItem("mood-" + today));
  if (savedData) {
    document.querySelector(`input[value="${savedData.mood}"]`).checked = true;
    document.querySelector("textarea").value = savedData.notes;
    savedMessage.textContent = "Today's mood is already saved!";
  }

  form.addEventListener("submit", (e) => {
    e.preventDefault();

    const mood = form.mood.value;
    const notes = form.notes.value;

    if (!mood) {
      savedMessage.textContent = "Please select a mood.";
      return;
    }

    const data = {
      mood,
      notes,
      date: today,
    };

    localStorage.setItem("mood-" + today, JSON.stringify(data));
    savedMessage.textContent = "Mood saved successfully!";
  });
});
