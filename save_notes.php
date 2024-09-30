<?php
session_start();
require 'db.php'; // Include your database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html'); // Redirect to login if not logged in
    exit();
}

// Get user ID and notes from the form
$user_id = $_SESSION['user_id'];
$personal_notes = $_POST['personal_notes'];

// Update the user's notes in the database
$query = "UPDATE users SET personal_notes = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param('si', $personal_notes, $user_id);

if ($stmt->execute()) {
    // Redirect back to the profile page with success message
    echo "<script>
            alert('Notes saved successfully!');
            window.location.href = 'profile.html';
          </script>";
} else {
    // Handle errors
    echo "Error saving notes.";
}

// Close the database connection
$stmt->close();
$conn->close();
?>
