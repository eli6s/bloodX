<?php

include '../../config.php';
include '../../helpers/helpers.php';

$pageTitle = "Send Mail";
ob_start();

// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_GET['user_id']) &&  $_GET['user_id'] == '' && !isset($_GET['id']) &&  $_GET['id'] == '') {
    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}

$id = $_GET['id'];
// $user_id = $_GET['user_id'];
// $user = fetchUser($user_id);

?>
<div class="card">
    <div class="card-header">
        <h4>Appointment</h4>
    </div>
    <div class="card-body">
        <form class="send-mail" method="POST">
            <input type="hidden" name="appointment_id" id="appointment_id" value="<?= $id; ?>">

            <div class="form-group">
                <label>Appointment</label>
                <input type="text" class="form-control datetimepicker" name="appointment" id="appointment" required>
            </div>

            <button type="submit" class="btn btn-success text-white ">Send</button>
        </form>
    </div>
</div>
<?php
$content = ob_get_clean();
include('../layout.php');
