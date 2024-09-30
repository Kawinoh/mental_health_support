<?php
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if the email already exists
    $checkEmailQuery = "SELECT * FROM users WHERE email = ?";
    $stmt = $pdo->prepare($checkEmailQuery);
    $stmt->execute([$email]);
    $existingUser = $stmt->fetch();

    if ($existingUser) {
        // User already exists, alert and retain input
        echo "<script>alert('User already exists! Please use a different email.'); window.location.href = 'register.html?name=" . urlencode($name) . "&email=" . urlencode($email) . "';</script>";
    } else {
        // Proceed to register the user
        $sql = "INSERT INTO users (name, email, password) VALUES (?, ?, ?)";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$name, $email, $password])) {
            echo "<script>alert('Registration successful! Please log in.'); window.location.href = '../login.html';</script>";
        } else {
            echo "Error registering user!";
        }
    }
}
?>
