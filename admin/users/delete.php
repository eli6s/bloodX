<?php
include '../../config.php';
include '../../helpers/helpers.php';

// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user_id parameter is set in the POST request
    if (isset($_POST['id'])) {
        $dir = '../assets/uploads/';
        $user_id = $_POST['id'];
        $imagePath = $_POST['img'];

        if ($imagePath != $_SESSION['DEFAULT_IMAGE_PATH']) {
            deleteImage($dir, $imagePath);
        }

        deleteUser($user_id);

        // Check if the deletion was successful
        $response = [
            'status' => 'success',
            'message' => 'The user along with their appointments were successfully deleted.'
        ];
    } else {
        $response = [
            'status' => 'error',
        ];
    }

    // Send the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
