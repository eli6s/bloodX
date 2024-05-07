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

// Store form data in session for validation
$_SESSION['OLD_DATA_FRONTEND'] = $_POST;

// Validate and process form data
try {
    // Extract form data
    $name = $_POST['name'];
    $diseases = $_POST['diseases'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['passwrd'];
    $phone_number = $_POST['phone'];
    $gender = $_POST['gender'];
    $city = $_POST['city'];
    $birthday = $_POST['birthday'];
    $blood_group_id = $_POST['blood_group_id'];


    $checkedUsername = validateUser('username', $username);
    $checkedPassword = validateUser('password', $password);

    if (!$checkedPassword || !$checkedUsername) {
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }
    // Hash the password
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Check if email and username already exist
    $emailExists = isExistsDB($email);
    $usernameExists = isExistsDB($username, 'username');

    // If email or username already exist, redirect back with error message
    if ($emailExists || $usernameExists) {
        flash('error', 'Email or username already exists.');
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }

    $data = [
        $name, $username, $email,
        $hashedPassword, $phone_number, $gender,
        $city, $birthday, $blood_group_id
    ];

    // Insert user data into the database
    $query = 'INSERT INTO users (
        name, username, email, passwrd,
        phone_number, gender,
        city, birthday, blood_group_id 
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?);';

    $stmt = $conn->prepare($query);
    $stmt->execute($data);

    $user_id = $conn->lastInsertId();

    // Insert diseases associated with the user
    InsertUserDiseases($user_id,  $diseases);

    // Unset old form data from session
    unset($_SESSION['OLD_DATA_FRONTEND']);
    $_SESSION['USER']['username'] = $username;
    $_SESSION['USER']['is_admin'] = 0;
    $_SESSION['USER']['profile_pic'] = 'default.png';
    $_SESSION['USER']['user_id'] = $user_id;

    // Set success flash message and redirect to index page
    flash('success', 'Welcome, ' . $username);
    header('Location: ../index.php');
    exit();
} catch (PDOException $e) {
    flash('error', 'All fields are required.');
    header("Location: {$_SERVER['HTTP_REFERER']}");
    exit();
}
