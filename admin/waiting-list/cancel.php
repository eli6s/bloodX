<?php

include '../../config.php';
include '../../helpers/helpers.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user_id parameter is set in the POST request
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $s_id = 2;

        foreach (fetchStatuses() as $status) {
            if (strtolower($status['status_type']) == 'canceled') {
                $s_id = $status['status_id'];
            }
        }

        $query = 'UPDATE appointments SET status_id = ? WHERE appointment_id = ?';
        $stmt = $conn->prepare($query);
        $stmt->execute([$s_id, $id]);


        // Check if the approving was successful
        $response = [
            'status' => 'success',
            'message' => 'Appointment cancelled successfully.'
        ];
    } else {
        $response = ['status' => 'error'];
    }

    // Send the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
