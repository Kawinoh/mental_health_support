<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars($_POST['email']);
    $password = $_POST['password'];

    // Check if the user exists in the database
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // Verify the password
        if (password_verify($password, $user['password'])) {
            // Password is correct, set the session and redirect to the home page
            $_SESSION['user_id'] = $user['id'];
            header("Location: home.html");
            exit();
        } else {
            // Password is incorrect
            echo "<script>alert('Incorrect password! Please try again.'); window.location.href = 'login.html';</script>";
        }
    } else {
        // User does not exist, redirect to the registration page
        echo "<script>alert('User does not exist. Please register.'); window.location.href = 'register.html';</script>";
    }
}
?>
