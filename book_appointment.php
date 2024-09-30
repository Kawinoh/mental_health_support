<?php
session_start();
require 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $date = htmlspecialchars($_POST['date']);
    $time = htmlspecialchars($_POST['time']);
    $description = htmlspecialchars($_POST['description']);

    $sql = "INSERT INTO appointments (user_id, date, time, description) VALUES (?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);

    if ($stmt->execute([$user_id, $date, $time, $description])) {
        // Redirect with success message
        header("Location: appointments.html?status=success");
    } else {
        // Redirect with error message
        header("Location: appointments.html?status=error");
    }
} else {
    // Redirect with login required message
    header("Location: appointments.html?status=login_required");
}
exit();
?>
