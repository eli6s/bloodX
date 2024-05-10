<?php
date_default_timezone_set('Etc/GMT-3');
include '../config.php';
include '../helpers/helpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['email'])) {
        try {
            $token = bin2hex(random_bytes(32));

            $query = "SELECT name FROM users WHERE email = ?";
            $stmt = $conn->prepare($query);
            $stmt->execute([$_POST['email']]);
            $userData = $stmt->fetch();

            if (count($userData) > 0) {
                // Store token and expiry in the database using PDO prepared statement
                $query = "UPDATE users SET reset_token=?, expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE email=?";
                $stmt = $conn->prepare($query);
                $stmt->execute([$token,  $_POST['email']]);

                $reset_link = 'http://localhost/' . asset("auth/reset-password-form.php?token=$token");
                $response = [
                    'status' => 'success',
                    'name' => $userData['name'],
                    'email' => $_POST['email'],
                    'subject' => 'Reset Password',
                    'message' => "Click the following link to reset your password: $reset_link . This link will expire in one hour."
                ];
            } else {
                $response = ['status' => 'error', 'msg' => 'Invalid E-mail.'];
            }
        } catch (PDOException $e) {
            $response = ['status' => 'error', 'msg' => $e->getMessage()];
        }
    } else {
        $response = ['status' => 'error'];
    }

    // Send the JSON response
    header('Content-Type: application/json');
    echo json_encode($response);
    exit;
}
