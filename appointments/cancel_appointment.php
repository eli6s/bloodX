<?php
include '../config.php';
include '../helpers/helpers.php';

// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user_id parameter is set in the POST request
    if (isset($_POST['id'])) {
        $id = $_POST['id'];

        deleteAppointment($id);

        // Check if the cancelation was successful
        $response = [
            'status' => 'success',
            'message' => 'your appointment canceled successfully'
        ];
    } else {
        $response = [
            'status' => 'error',
        ];
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
