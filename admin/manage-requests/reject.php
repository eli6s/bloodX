<?php
include '../../config.php';
include '../../helpers/helpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $s_id = 6;

        foreach (fetchStatuses() as $rd) {
            if (strtolower($rd['status_type']) == 'rejected') {
                $s_id = $rd['status_id'];
            }
        }

        $query = 'UPDATE appointments SET status_id = ? WHERE appointment_id = ?';
        $stmt = $conn->prepare($query);
        $stmt->execute([$s_id, $id]);

        // Check if the approving was successful
        $response = [
            'status' => 'success',
            'message' => 'Appointment Rejected successfully'
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
