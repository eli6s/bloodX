<?php
include '../../config.php';
include '../../helpers/helpers.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Check if the user_id parameter is set in the POST request
    if (isset($_POST['id'])) {
        $id = $_POST['id'];
        $s_id = 1;

        foreach (fetchStatuses() as $status) {
            if (strtolower($status['status_type']) == 'completed') {
                $s_id = $status['status_id'];
            }
        }

        $query = 'SELECT user_id, type FROM appointments WHERE appointment_id = ?';
        $stmt = $conn->prepare($query);
        $stmt->execute([$id]);
        $data = $stmt->fetch();
        $user_id = $data['user_id'];
        $type = $data['type'];

        $query = 'UPDATE appointments SET status_id = ? WHERE appointment_id = ?';
        $stmt = $conn->prepare($query);
        $stmt->execute([$s_id, $id]);
        if ($type == 'donation') {
            $query = 'UPDATE users SET donated_at=CURRENT_TIMESTAMP WHERE user_id = ?';
            $stmt = $conn->prepare($query);
            $stmt->execute([$user_id]);
        }

        // Check if the approving was successful
        $response = [
            'status' => 'success',
            'message' => 'Appointment Completed successfully'
        ];
    } else {
        $response = ['status' => 'error'];
    }

    // Send the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
