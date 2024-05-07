<?php
include '../config.php';
include '../helpers/helpers.php';

$pageTitle = "Home";
ob_start();

// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$posts = [];
if (isAuthorized()) {
    $user_id = $_SESSION['USER']['user_id'];
    $appointments = fetchUserAppointments(['pending', 'canceled', 'approved', 'rejected', 'completed']);
}
?>

<section id="wsus__cart_view">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class=" wishlist table-responsive">
                    <table class="table table-striped table-sm border-none rounded table-hover">
                        <thead class="bg-danger text-white ">
                            <tr class=" ">
                                <th class="text-center py-2 " style="font-size:14px">Blood Group</th>
                                <th class="text-center py-2 " style="font-size:14px">Blood Process</th>
                                <th class="text-center py-2 " style="font-size:14px">Type</th>
                                <th class="text-center py-2 " style="font-size:14px">Case Details</th>
                                <th class="text-center py-2 " style="font-size:14px">Done/Appointment</th>
                                <th class="text-center py-2 " style="font-size:14px">Status</th>
                                <th class="text-center py-2 " style="font-size:14px">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (count($appointments) > 0) : ?>
                                <?php foreach ($appointments as $appointment) : ?>
                                    <?php
                                    $diseases = fetchUserDiseases($appointment['user_id']);
                                    ?>
                                    <tr>
                                        <td class="text-center  py-3">
                                            <p style="font-size:12px"><?= ucwords($appointment['group_name']) ?></p>
                                        </td>

                                        <td class="text-center  py-3">
                                            <p style="font-size:12px"><?= ucwords($appointment['process_name']) ?></p>
                                        </td>
                                        <td class="text-center  py-3">
                                            <p style="font-size:12px"><?= ucwords($appointment['type']) ?></p>
                                        </td>
                                        <td class="text-center  py-3">
                                            <p style="font-size:12px"><?= ucwords($appointment['case_details']) != '' ? ucwords($appointment['case_details']) : 'N/A' ?></p>
                                        </td>
                                        <td class="text-center  py-3">
                                            <?php if ($appointment['status_type'] == 'approved') : ?>
                                                <p style="font-size:12px"> <?= $appointment['appointment_at'] ?  date("M d, Y - H:i A ", strtotime($appointment['appointment_at'])) : ''; ?></p>
                                            <?php elseif ($appointment['status_type'] == 'pending') : ?>
                                                <p style="font-size:12px"><?= diffHumans($appointment['created_at'])  ?></p>
                                            <?php else : ?>
                                                <p style="font-size:12px"><?= diffHumans($appointment['updated_at'])  ?></p>
                                            <?php endif; ?>
                                        </td>
                                        <td class="text-center py-3">
                                            <p style="font-size:12px">
                                                <?= setStatusAppointment($appointment['status_type']); ?>
                                                <span class="text-sm ">
                                                    <?= ucwords($appointment['status_type']) ?>
                                                </span>
                                            </p>
                                        </td>
                                        <td class="text-center py-3">
                                            <?php if ($appointment['status_type'] == 'pending' || $appointment['status_type'] == 'approved') : ?>
                                                <a class="cancel-appointment" title="Cancel Appointment" href="cancel_appointment.php" data-id="<?= $appointment['appointment_id']; ?>">
                                                    <span class='btn btn-warning text-white btn-sm text-sm'><i class='fas fa-times'></i></span>
                                                </a>
                                            <?php else : ?>
                                                <span>N/A</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else : ?>
                                <td class="text-center fw-bold py-5" colspan="10">No records found </td>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Modal Cancel appointment -->
<div class="modal fade" id="cancelModal" tabindex="-1" aria-labelledby="cancelModalLabel" aria-hidden="false">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="cancelModalLabel">Cancel Appointment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-0">
                <div class="wsus__check_form ">
                    <form class="row w-100" action="cancel_appointment.php" method="POST">
                        <h3>
                            Are you sure ?
                        </h3>
                        <h5 class="my-3">
                            You want to cancel your appointment?
                        </h5>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary  rounded-pill" data-bs-dismiss="modal" aria-label="Close">
                                Close
                            </button>
                            <button type="submit" class="btn btn-danger rounded-pill">Cancel</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
include('../layout.php');
