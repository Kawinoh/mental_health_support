<?php
session_start();
require 'db.php'; // Include your database connection

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html'); // Redirect to login if not logged in
    exit();
}

// Fetch user data from the session
$user_id = $_SESSION['user_id'];

// Fetch user details from the database
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $pdo->prepare($query);
$stmt->execute([$user_id]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "No user found.";
    exit();
}

// Handle form submission to update the profile
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];

    // Update user details in the database
    $update_query = "UPDATE users SET name = ?, email = ? WHERE id = ?";
    $stmt = $pdo->prepare($update_query);
    
    if ($stmt->execute([$name, $email, $user_id])) {
        // Success, redirect back to profile with a success message
        echo "<script>
                alert('Changes successful!');
                window.location.href = 'profile.html';
              </script>";
    } else {
        // Error
        echo "Error updating profile.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="edit_profile.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
     <title>Edit Profile</title>
</head>
<body>
    
    
    <div class="profile-container">
        <h2>Edit Your Profile</h2>
        <form action="" method="POST">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>
            
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

            <label for="date_joined">Joined on:</label>
            <input type="text" id="date_joined" name="date_joined" value="<?php echo htmlspecialchars($user['date_joined']); ?>" readonly>

            <button type="submit">Update Profile</button>
        </form>
    </div>
    
    <footer>
        <div class="footer-content">
            <p>&copy; 2024 Mental Health Support. All Rights Reserved.</p>
            <p>Contact us: 
                <a href="mailto:info@mentalhealthsupport.org" target="_blank">
                    <i class="fas fa-envelope"></i>info@mentalhealthsupport.org
                </a> 
                | Phone: +254-707-332-850
            </p>
            <p>Follow us: 
            <a href="#" target="_blank">
                <i class="fab fa-facebook"></i>
            </a>
            <a href="#" target="_blank">
                <i class="fab fa-twitter"></i>
            </a>
            <a href="#" target="_blank">
                <i class="fab fa-instagram"></i>
            </a>
            <a href="#" target="_blank">
                <i class="fab fa-linkedin"></i>
            </a>
        </p>
        </div>
    </footer>
    
    <script src="main.js"></script>
</body>
</html>
