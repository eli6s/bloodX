<?php
include '../../config.php';
include '../../helpers/helpers.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user_id parameter is set in the POST request
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $appointment_at = $_POST['appointment_at'];
        $s_id = 7;

        foreach (fetchStatuses() as $rd) {
            if (strtolower($rd['status_type']) == 'approved') {
                $s_id = $rd['status_id'];
            }
        }

        $query = 'UPDATE appointments SET status_id = ?, approved_at=CURRENT_TIMESTAMP, appointment_at = ? WHERE appointment_id = ?';
        $stmt = $conn->prepare($query);
        $stmt->execute([$s_id, $appointment_at, $id]);

        // Check if the approving was successful
        $response = [
            'status' => 'success',
            'message' => 'The appointment has been approved.'
        ];
    } else {
        $response = ['status' => 'error'];
    }

    // Send the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
