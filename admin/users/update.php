<?php
// Include necessary files
include '../../config.php';
include '../../helpers/helpers.php';

// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Directory for image uploads
    $dir = '../../assets/uploads/';

    // Retrieve old image path
    $oldImagePath = $_POST['old_path_image'];

    // Retrieve and sanitize input data
    $userId = $_POST['user_id'];
    $image = $_FILES['image'];
    $diseases = isset($_POST['diseases']) ? $_POST['diseases'] : [];
    $name = $_POST['name'];
    $username = strtolower($_POST['username']);
    $email = strtolower($_POST['email']);
    $city = $_POST['city'];
    $phoneNumber = $_POST['phone'];
    $gender = $_POST['gender'];
    $birthday = $_POST['birthday'];
    $status_id = $_POST['status_id'];
    $bloodGroupId = $_POST['blood_group'];
    $isAdmin = $_POST['is_admin'];

    // Check if email and username already exist
    $emailExists = isExistsDB($email, 'email', true, $userId);
    $usernameExists = isExistsDB($username, 'username', true, $userId);

    if (!$emailExists && !$usernameExists) {
        // Upload new image and handle image update
        $newImagePath = uploadImage($image, $dir);
        if ($newImagePath) {
            $profile_pic = $newImagePath;
            deleteImage($dir, $oldImagePath);
        } else {
            $profile_pic = $oldImagePath;
        }

        DeleteUserDiseases($userId);
        InsertUserDiseases($userId, $diseases);

        UpdateUser([
            $username, $name, $email, $phoneNumber,
            $gender, $birthday, $profile_pic,
            $city, $status_id, $bloodGroupId,
            $isAdmin, $userId
        ]);

        flash('success', 'Updated Successfully.');
        header('Location: index.php');
        exit();
    } else {
        // Redirect back if email or username already exists
        // with flash an error
        flash('error', 'email or username already exists');
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
} else {
    // Redirect if request method is not POST
    header('Location: index.php');
    exit();
}
