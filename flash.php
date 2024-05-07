<?php
// Dynamic validation
if (isset($_SESSION['toastr']) && is_array($_SESSION['toastr'])) {
    foreach ($_SESSION['toastr'] as $message) {
        $status = $message['status'];
        $msg = $message['message'];

        if ($status === 'success') {
            echo "<script>toastr.success('$msg');</script>";
        } elseif ($status === 'error') {
            echo "<script>toastr.error('$msg');</script>";
        } elseif ($status === 'warning') {
            echo "<script>toastr.warning('$msg');</script>";
        }
    }

    // Clear the session variable to avoid displaying the message again
    unset($_SESSION['toastr']);
}
