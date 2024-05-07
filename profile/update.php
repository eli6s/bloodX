<?php
// Include necessary files
include '../config.php';
include '../helpers/helpers.php';

// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Directory for image uploads
    $dir = '../assets/uploads/';

    // Retrieve old image path
    $oldImagePath = $_POST['old_path_image'];

    // Retrieve and sanitize input data
    $userId = $_POST['user_id'];
    $name = $_POST['name'];
    $status_id = $_POST['status_id'];
    $username = strtolower($_POST['username']);
    $email = strtolower($_POST['email']);
    $phoneNumber = $_POST['phone_number'];
    $gender = $_POST['gender'];
    $city = $_POST['city'];
    $birthday = $_POST['birthday'];
    $bloodGroupId = $_POST['bgroup'];
    $isAdmin = $_POST['is_admin'];
    $diseases = isset($_POST['diseases']) ? $_POST['diseases'] : [];

    // Check if email and username already exist
    $emailExists = isExistsDB($email, 'email', true, $userId);
    $usernameExists = isExistsDB($username, 'username', true, $userId);

    if (!$emailExists && !$usernameExists) {

        // Upload new image and handle image update
        $newImagePath = uploadImage($_FILES['image'], $dir);

        if ($newImagePath) {
            $profile_pic = $newImagePath;
            deleteImage($dir, $oldImagePath);
        } else {
            $profile_pic = $oldImagePath;
        }
        DeleteUserDiseases($userId);

        $diseases = explode(",", $diseases[0]);
        InsertUserDiseases($userId, $diseases);

        UpdateUser([
            $username, $name, $email, $phoneNumber,
            $gender, $birthday, $profile_pic,
            $city, $status_id, $bloodGroupId,
            $isAdmin, $userId
        ]);

        if ($_SESSION['USER']['user_id'] == $userId) {
            $_SESSION['USER']['user_id'] = $userId;
            $_SESSION['USER']['username'] = $username;
            $_SESSION['USER']['is_admin'] = $isAdmin;
            $_SESSION['USER']['profile_pic'] = $profile_pic;
        }

        // Set success flash message and redirect
        flash('success', 'Updated Profile Successfully.');
        header('Location: index.php?id=' . $userId);
        exit();
    } else {
        // Redirect back if email or username already exists
        flash('error', 'Email or Username already exists.');
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
} else {
    // Redirect if request method is not POST
    header('Location: index.php?id=' . $userId);
    exit();
}
