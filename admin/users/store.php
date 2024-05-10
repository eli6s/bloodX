<?php
include '../../config.php';
include '../../helpers/helpers.php';

// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Make $conn global
global $conn;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $_SESSION['OLD_DATA'] = $_POST;
    $name = $_POST['name'];
    $diseases = $_POST['diseases'] ?? [];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $passwrd = $_POST['passwrd'];
    $phone_number = $_POST['phone'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $status_id = $_POST['status_id'];
    $blood_group_id = $_POST['blood_group'];
    $is_admin = $_POST['is_admin'];
    $city = $_POST['city'];

    $hashedPassword = password_hash($passwrd, PASSWORD_BCRYPT);

    $emailChecked = isExistsDB($email);
    $usernameChecked = isExistsDB($username, 'username');
    // If email or username already exist, redirect back with error message
    if ($emailChecked || $usernameChecked) {
        flash('error', 'Email or username already exists.');
        header("Location: {$_SERVER['HTTP_REFERER']}");
        exit();
    }

    $dir = '../assets/uploads/';
    $imgPath = uploadImage($_FILES['image'], $dir);
    $profile_pic = $imgPath ? $img : $_SESSION['DEFAULT_IMAGE_PATH'];

    $data = [
        $name, $username,
        $email, $hashedPassword,
        $phone_number, $gender, $birthday,
        $profile_pic, $status_id,
        $blood_group_id, $is_admin, $city
    ];

    $query = 'INSERT INTO users(
        name, username, email, passwrd, 
        phone_number, gender, birthday, 
        profile_pic, status_id, blood_group_id, is_admin, city
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?);';

    $stmt = $conn->prepare($query);
    $stmt->execute($data);

    $user_id = $conn->lastInsertId();

    InsertUserDiseases($user_id, $diseases);

    unset($_SESSION['OLD_DATA']);

    flash('success', 'Created successfully.');
    header('Location: index.php?page=1');
} else {
    header('Location: index.php');
}
