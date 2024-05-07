<?php
include '../config.php';
include '../helpers/helpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    global $conn;
    try {
        $id = $_POST['user_id'];
        $birth = $_POST['birthday'];
        $bunit = $_POST['bunit'];
        $bprocess = $_POST['bprocess'];
        $type = $_POST['type'];
        $case_details = $_POST['case_details'] ?? NULL;

        $user = fetchUser($id);
        $process_name = fetchBloodProcess($bprocess);
        $bprocesses = fetchBloodProcesses();

        // Check if female and trying to donate platelets
        if (strtolower($user['gender']) == 'female' && $type == 'donation' && strtolower($process_name) == 'platelet') {
            flash('error', 'Females cannot donate platelets.');
            redirectBack();
        }

        if ($type == 'donation') {
            $bprocesses_ = array_filter($bprocesses, function ($bprocess) {
                global $user;
                if (strtolower($bprocess['process_name']) == 'whole blood') {
                    return true;
                } elseif (strtolower($bprocess['process_name']) == 'power red') {
                    if (in_array($user['group_name'], ['A-', 'B-', 'O+', 'O-'])) {
                        return true;
                    }
                } elseif (strtolower($bprocess['process_name']) == 'platelet') {
                    if (in_array($user['group_name'], ['A-', 'AB-', 'A+'])) {
                        return true;
                    }
                }
            });

            if (!in_array($bprocess, array_column($bprocesses_, 'process_id'))) {
                flash('error', 'You cannot donate ' . $process_name . ' with your blood group (' . $user['group_name'] . ')');
                redirectBack();
            }
        }



        if ($type == 'donation') {
            // validate brith day.
            $isValidBirth = ceil(checkDate2($birth) / 365);
            if ($isValidBirth < 18) {
                flash('error', 'You must be at least 18 years old to donate.');
                redirectBack();
            }
            
            // donation
            $checked = checkIfLimited($bprocess, $bunit);
            if ($checked[0]) {
                $query = "SELECT donated_at FROM users WHERE donated_at IS NOT NULL AND user_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->execute([$id]);
                $donated_at =  $stmt->fetchColumn();

                $date_checked_donate = checkDate2($donated_at);
                $query = "SELECT interval_days FROM blood_processes WHERE process_id = ?";
                $stmt = $conn->prepare($query);
                $stmt->execute([$bprocess]);
                $interval_days = $stmt->fetchColumn();

                if ($date_checked_donate > $interval_days || $donated_at == null) {
                    // can donate
                    $query = "SELECT COUNT(*) FROM appointments
                        INNER JOIN statuses ON appointments.status_id = statuses.status_id
                        WHERE appointments.type = 'donation'
                        AND appointments.user_id = ? 
                        AND appointments.approved_at IS NOT NULL 
                        AND statuses.status_type = 'approved'
                        ORDER BY appointments.approved_at ASC LIMIT 1";
                    $stmt = $conn->prepare($query);
                    $stmt->execute([$id]);
                    $data = $stmt->fetchColumn();

                    if (isset($data) && $data > 0) {
                        flash('error', 'Unable to donate, you already have an appointment in progress.');
                        header("Location: " . $_SERVER['HTTP_REFERER']);
                        exit();
                    } else {
                        $query = "SELECT COUNT(*) FROM appointments
                    INNER JOIN statuses ON appointments.status_id = statuses.status_id
                    WHERE appointments.type = 'donation'
                    AND statuses.status_type = 'pending'
                    AND appointments.user_id = ? 
                    ORDER BY appointments.created_at ASC LIMIT 1";
                        $stmt = $conn->prepare($query);
                        $stmt->execute([$id]);
                        $data2 = $stmt->fetchColumn();
                        if (isset($data2) && $data2 > 0) {
                            flash('error', 'Unable to donate, you already have an appointment in progress.');
                            header("Location: " . $_SERVER['HTTP_REFERER']);
                            exit();
                        } else {
                            createNewAppointment($id, $bprocess, $type, $bunit, $case_details);
                            flash('success', ' You have requested an appointment! We will email you with details about your appointment when it gets approved.');
                            header("Location: " . $_SERVER['HTTP_REFERER']);
                            exit();
                        }
                    }
                } else {
                    flash('error', 'You must wait ' . $interval_days -  $date_checked_donate . ' more days until you can donate again.');
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit();
                }
            } else {
                if ($checked[1] == $checked[2]) {
                    flash('error', "Invalid unit!The required one is $checked[1]ML");
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit();
                } else {
                    flash('error', "Invalid unit! The range is between $checked[1]-$checked[2] ML");
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit();
                }
            }
        } else {
            // request
            $query = "SELECT COUNT(*) FROM appointments
                    INNER JOIN statuses ON appointments.status_id = statuses.status_id
                    WHERE appointments.type = 'request'
                    AND appointments.user_id = ? 
                    AND appointments.approved_at IS NOT NULL 
                    AND statuses.status_type = 'approved'
                    ORDER BY appointments.approved_at ASC LIMIT 1";
            $stmt = $conn->prepare($query);
            $stmt->execute([$id]);
            $data = $stmt->fetchColumn();

            if (isset($data) && $data > 0) {
                flash('error', 'Unable to receive, you already have an appointment in progress.');
                header("Location: " . $_SERVER['HTTP_REFERER']);
                exit();
            } else {
                $query = "SELECT COUNT(*) FROM appointments
                        INNER JOIN statuses ON appointments.status_id = statuses.status_id
                        WHERE appointments.type = 'request'
                        AND statuses.status_type = 'pending'
                        AND appointments.user_id = ? 
                        ORDER BY appointments.created_at ASC LIMIT 1";
                $stmt = $conn->prepare($query);
                $stmt->execute([$id]);
                $data2 = $stmt->fetchColumn();
                if (isset($data2) && $data2 > 0) {
                    flash('error', 'Unable to receive, you already have an appointment in progress.');
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit();
                } else {
                    createNewAppointment($id, $bprocess, $type, $bunit, $case_details);
                    flash('success', ' You have requested an appointment! We will email you with details about your appointment when it gets approved.');
                    header("Location: " . $_SERVER['HTTP_REFERER']);
                    exit();
                }
            }
        }
    } catch (Exception $e) {
        flash('error', 'you are not provided to access that page');
        header("Location: " . $_SERVER['HTTP_REFERER']);
        exit();
    }
}
