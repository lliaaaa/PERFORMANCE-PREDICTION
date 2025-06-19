<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['login'])) {
    $userId = trim($_POST['user_id']);
    $password = $_POST['password'];

    $users = file('../data/users.txt', FILE_IGNORE_NEW_LINES);

    foreach ($users as $userLine) {
        list($savedUserId, $fullname, $email, $hashedPassword, $role) = explode('|', $userLine);

        if ($userId === $savedUserId && password_verify($password, $hashedPassword)) {
            $_SESSION['user'] = [
                'user_id' => $savedUserId,
                'fullname' => $fullname,
                'email' => $email,
                'role' => $role
            ];
            header("Location: ../index.php?page=home");
            exit;
        }
    }

    header("Location: ../index.php?page=login&error=Invalid+credentials");
    exit;
}
