<?php
include '../../config.php';
include '../../helpers/helpers.php';

// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $dir = '../../assets/uploads/';
        $oldImagePath = $_POST['old_path_image'];

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
        $statuts = $_POST['status_id'];
        $bloodGroupId = $_POST['blood_group'];
        $isAdmin = $_POST['is_admin'];

        $emailChecked    = isExistsDB($email, 'email', true, $userId);
        $usernameChecked = isExistsDB($username, 'username', true, $userId);

        if (!$emailChecked && !$usernameChecked) {
            // Upload new image and handle image update
            $newImagePath = uploadImage($_FILES['image'], $dir);

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
                $city, $statuts, $bloodGroupId,
                $isAdmin, $userId
            ]);

            flash('success', 'Updated Successfully.');
            header('Location: index.php' . (isset($search) && $search != '' ? '?search=' . $search : ''));
            exit();
        } else {
            flash('error', 'email or username already exists');
            header("Location: " . $_SERVER['HTTP_REFERER']);
            exit();
        }
    } catch (Exception $e) {
        return $e->getMessage();
    }
} else {
    header('Location: index.php');
    exit();
}
