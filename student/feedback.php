<?php
// Assuming you have a session with student information
?>
<form id="feedbackForm">
<input type="hidden" name="school_id" value="<?php echo isset($_SESSION['school_id']) ? $_SESSION['school_id'] : ''; ?>">
    <div>
        <label for="lecturer_id">Lecturer:</label>
        <select name="lecturer_id" required>
            <?php
            // Fetching lecturers
            $result = $conn->query("SELECT id, CONCAT(firstname, ' ', lastname) AS name FROM faculty_list");
            while ($row = $result->fetch_assoc()) {
                echo "<option value='{$row['id']}'>{$row['name']}</option>";
            }
            ?>
        </select>
    </div>
    <div>
        <label for="feedback">Feedback:</label>
        <textarea name="feedback" required></textarea>
    </div>
    <button type="submit">Submit Feedback</button>
</form>

<script>
document.getElementById('feedbackForm').onsubmit = function(event) {
    event.preventDefault();
    const formData = new FormData(this);
    fetch('ajax.php?action=save_feedback', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data); // Display server response
        this.reset(); // Reset the form
    });
};
</script>
