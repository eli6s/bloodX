<?php
date_default_timezone_set('Etc/GMT-3');
include '../config.php';
include '../helpers/helpers.php';

global $conn;

// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to the index page if the request method is not POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: index.php');
    exit();
}

try {
    $user_id = $_POST['user_id'];

    $query = "SELECT passwrd FROM users WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$user_id]);
    $hashedPassword = $stmt->fetchColumn();

    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // Verify if the entered password matches the hashed password
    if (password_verify($current_password, $hashedPassword)) {
        if ($new_password === $confirm_password) {
            $new_hashed_password = password_hash($new_password, PASSWORD_BCRYPT);

            // Update user's password
            $query = 'UPDATE users SET passwrd = ? WHERE user_id = ?';
            $updateStmt = $conn->prepare($query);
            $updateStmt->execute([$new_hashed_password, $user_id]);

            flash('success', 'Password Changed Successfully.');
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        } else {
            // flash that Password doesnot match 
            flash('error', 'Password Unmatched.');
            header("Location: {$_SERVER['HTTP_REFERER']}");
            exit();
        }
    } else {
        // flash Password is incorrect
        flash('error', 'Invalid Password.');
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
} catch (Exception $e) {
    header("Location: " . asset('404.php'));
    exit();
}
