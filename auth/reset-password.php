<?php
date_default_timezone_set('Etc/GMT-3');
include '../config.php';
include '../helpers/helpers.php';
// Redirect to the index page if the request method is not POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ' . asset('index.php'));
    exit();
}

$new_password = $_POST['new_password'];
$confirm_passwrod = $_POST['confirm_password'];

if ($new_password === $confirm_passwrod) {
    $hashedPassword = password_hash($new_password, PASSWORD_BCRYPT);

    $query = "UPDATE users SET expiry = NOW(), passwrd = ? WHERE email= ?";
    $stmt = $conn->prepare($query);
    $stmt->execute([$hashedPassword,  $_POST['email']]);

    flash('success', 'Password changed successfully.');
    header("Location: " . asset('auth/login.php'));
    exit();
} else {
    flash('error', 'Password mismatch! Please try again.');
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
