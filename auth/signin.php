<?php
date_default_timezone_set('Etc/GMT-3');
include '../config.php';
include '../helpers/helpers.php';

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
    // Extract form data
    $username_or_email = strtolower($_POST['usernameOrEmail']);
    $password = $_POST['password'];

    // Check if email and username already exist
    $emailExists = isExistsDB($username_or_email);
    $usernameExists = isExistsDB($username_or_email, 'username');

    // If email or username already exist, redirect back with error message
    if ($emailExists || $usernameExists) {
        $query = "SELECT statuses.*, users.* FROM users
        INNER JOIN statuses ON users.status_id = statuses.status_id
        WHERE users.username = ? or users.email = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$username_or_email, $username_or_email]);
        $userData = $stmt->fetch();

        if (strtolower($userData['status_type']) == 'suspended') {
            // flash an error , suspended account
            flash('error', 'Suspended account.');
            redirectBack();
        }

        $userId = $userData['user_id'];
        $username = $userData['username'];
        $isAdmin = $userData['is_admin'];
        $profile_pic = $userData['profile_pic'];
        $hashedPassword = $userData['passwrd'];

        // Verify if the entered password matches the hashed password
        if (password_verify($password, $hashedPassword)) {
            // Set success flash message and redirect to index page 
            $_SESSION['USER']['user_id'] = $userId;
            $_SESSION['USER']['username'] = $username;
            $_SESSION['USER']['is_admin'] = $isAdmin;
            $_SESSION['USER']['profile_pic'] = $profile_pic;
            flash('success', 'Welcome Back, ' . $username);
            header('Location: ../index.php');
            exit();
        } else {
            // flash Password is incorrect
            flash('error', 'Incorrect password.');
            redirectBack();
        }
    } else {
        // flash a message that username or email does not exist.
        flash('error', 'Email or username does not exist.');
        redirectBack();
    }
} catch (Exception $e) {
    header("Location: " . asset('404.php'));
    exit();
}
