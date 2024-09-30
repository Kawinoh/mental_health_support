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

// Fetch appointment history
$queryAppointments = "SELECT date, time, description, status FROM appointments WHERE user_id = ?";
$stmtAppointments = $pdo->prepare($queryAppointments);
$stmtAppointments->execute([$user_id]);
$appointments = $stmtAppointments->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="profile.css">
    <link rel="stylesheet" href="navbar.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <title>My Profile</title>
</head>
<body>
    <nav>
        <ul>
            <li><a href="home.html">Home</a></li>
            <li><a href="services.html">Services</a></li>
            <li><a href="contact.html">Contact</a></li>
            <li><a href="appointments.html">Appointments</a></li>
            <li><a href="profile.php">Profile</a></li> 
        </ul>
    </nav>
    <div class="profile-container">
        <h2>Welcome to Your Profile</h2>
        <p>Here you can book appointments, view your mental health progress, and connect with our specialists.</p>
        
        <section class="user-info">
            <h3>Your Information</h3>
            <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
            <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
            <p><strong>Joined on:</strong> <?php echo htmlspecialchars($user['date_joined']); ?></p>
            <button onclick="location.href='edit_profile.php'">Edit Profile</button>
        </section>
        
        <section class="appointment-history">
            <h3>Your Appointment History</h3>
            <table>
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Description</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($appointments as $appointment): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($appointment['date']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['time']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['description']); ?></td>
                        <td><?php echo htmlspecialchars($appointment['status']); ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </section>
        
        <section class="mental-health-resources">
            <h3>Mental Health Resources</h3>
            <ul>
                <li><a href="https://www.nami.org/Home">National Alliance on Mental Illness (NAMI)</a></li>
                <li><a href="https://www.mentalhealth.gov/">MentalHealth.gov</a></li>
                <li><a href="https://www.psychologytoday.com/us">Psychology Today</a></li>
            </ul>
        </section>
        
        <section class="personal-notes">
            <h3>Your Personal Notes</h3>
            <form action="save_notes.php" method="POST">
                <textarea name="personal_notes" rows="5" placeholder="Write your thoughts here..." required></textarea>
                <button type="submit">Save Notes</button>
            </form>
        </section>
        
        <div class="profile-actions">
            <button onclick="location.href='appointments.html'" style="background-color: blue;color: #ffff;">Book an Appointment</button>
            <button onclick="location.href='logout.php'" style="background-color: blue;color: #ffff;">Logout</button>
        </div>
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
