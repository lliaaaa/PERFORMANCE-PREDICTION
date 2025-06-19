<?php
require_once '../db/connection.php';  // Make sure path is correct

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($full_name) || empty($email) || empty($password)) {
        header("Location: ../index.php?page=signup&error=All fields are required.");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $user_id = bin2hex(random_bytes(8));

    $stmt = $conn->prepare("INSERT INTO users (user_id, full_name, email, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $user_id, $full_name, $email, $hashedPassword);

    if ($stmt->execute()) {
        // ✅ Start session and set session variables here
        session_start();
        $_SESSION['user_id'] = $user_id;
        $_SESSION['full_name'] = $full_name;

        header("Location: ../index.php?page=home");
        exit();
    } else {
        header("Location: ../index.php?page=signup&error=Registration failed. Try again.");
        exit();
    }
}
?>
