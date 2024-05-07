<?php
include '../helpers/helpers.php';
include '../config.php';

$pageTitle = "Compatibility";
ob_start();

$blood_types = ['A+', 'O+', 'B+', 'AB+', 'A-', 'O-', 'B-', 'AB-',];

function donateBlood($donor, $recipient)
{
    global $blood_types;
    $give_arr  = [
        [1, 0, 0, 1, 0, 0, 0, 0],
        [1, 1, 1, 1, 0, 0, 0, 0],
        [0, 0, 1, 1, 0, 0, 0, 0],
        [0, 0, 0, 1, 0, 0, 0, 0],

        [1, 0, 0, 1, 1, 0, 0, 1],
        [1, 1, 1, 1, 1, 1, 1, 1],
        [0, 0, 1, 1, 0, 0, 1, 1],
        [0, 0, 0, 1, 0, 0, 0, 1]
    ];

    $donorIndex  = array_search($donor, $blood_types);
    $recipientIndex = array_search($recipient, $blood_types);
    return $give_arr[$donorIndex][$recipientIndex] == 1;
}

function receiveBlood($donor, $recipient)
{
    global $blood_types;

    $reveive_arr  = [
        [1, 1, 0, 0, 1, 1, 0, 0],
        [0, 1, 0, 0, 0, 1, 0, 0],
        [0, 1, 1, 0, 0, 1, 1, 0],
        [1, 1, 1, 1, 1, 1, 1, 1],

        [0, 0, 0, 0, 1, 1, 0, 0],
        [0, 0, 0, 0, 0, 1, 0, 0],
        [0, 0, 0, 0, 0, 1, 1, 0],
        [0, 0, 0, 0, 1, 1, 1, 1]
    ];

    $donorIndex  = array_search($donor, $blood_types);
    $recipientIndex = array_search($recipient, $blood_types);
    return $reveive_arr[$donorIndex][$recipientIndex] == 1;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $type = $_POST['type'] ?? 0;
    $owner = $_POST['owner_bgroup'] ?? '';
    $give = $_POST['give_bgroup'] ?? '';
    $receive = $_POST['receive_bgroup'] ?? '';

    if ($type == 1) {
        if (empty($owner) || empty($give)) {
            flash('error', 'All fields are required');
        } else {
            if (donateBlood($owner, $give)) {
                flash('success', "<b>$owner</b> can give blood to <b>$give</b>");
            } else {
                flash('error', "<b>$owner</b> can not give blood to <b>$give</b>");
            }
        }
    } elseif ($type == 0) {
        if (empty($owner) || empty($receive)) {
            flash('error', 'All fields are required');
        } else {
            if (receiveBlood($owner, $receive)) {
                flash('success', "<b>$owner</b> can receive blood to <b>$receive</b>");
            } else {
                flash('error', "<b>$owner</b> can not receive blood to <b>$receive</b>");
            }
        }
    } else {
        flash('error', 'All fields are required');
    }
}

$bgroups = fetchBloodGroups();
?>

<section id="wsus__login_register">
    <div class="row">
        <div class="col-lg-10 col-sm-12 col-md-12 m-auto">
            <div class="wsus__login_reg_area">
                <h4 class="text-center mb-2">Blood Compatibility</h4>

                <ul class="nav nav-pills my-3 " id="pills-tab2" role="tablist">
                    <li class="nav-item p-0" role="presentation">
                        <button class="nav-link active p-0 py-1" id="pills-home-tab2" data-bs-toggle="pill" data-bs-target="#pills-homes" type="button" role="tab" aria-controls="pills-homes" aria-selected="true">Donate</button>
                    </li>
                    <li class="nav-item " role="presentation">
                        <button class="nav-link p-0 py-1" id="pills-profile-tab2" data-bs-toggle="pill" data-bs-target="#pills-profiles" type="button" role="tab" aria-controls="pills-profiles" aria-selected="true">Receive</button>
                    </li>
                </ul>

                <div class="tab-content" id="pills-tabContent2">
                    <div class="tab-pane fade  show active" id="pills-homes" role="tabpanel" aria-labelledby="pills-home-tab2">
                        <div class="wsus__login">
                            <form method="POST">
                                <input type="hidden" name="type" value="1">

                                <div class="wsus__track_input">
                                    <select class="mw-100 my-2 " id="Select" placeholder="Your Blood Group " data-search="false" data-silent-initial-value-set="true" name="owner_bgroup">
                                        <option value="" disabled selected class="p-2">Your Blood Group </option>
                                        <?php foreach ($bgroups as $bgroup) : ?>
                                            <option value="<?= $bgroup['group_name']; ?>">
                                                <?= ucwords($bgroup['group_name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="wsus__track_input">
                                    <select class="mw-100 my-2 mb-4" id="Select" placeholder="Receiver Blood Group" data-search="false" data-silent-initial-value-set="true" name="give_bgroup">
                                        <option value="" disabled selected class="p-2"> Receiver Blood Group</option>
                                        <?php foreach ($bgroups as $bgroup) : ?>
                                            <option value="<?= $bgroup['group_name']; ?>">
                                                <?= ucwords($bgroup['group_name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <button type="submit" class="common_btn">Check</button>
                            </form>
                        </div>
                    </div>

                    <div class="tab-pane fade " id="pills-profiles" role="tabpanel" aria-labelledby="pills-profile-tab2">
                        <div class="wsus__login">
                            <form method="POST">
                                <input type="hidden" name="type" value="0">

                                <div class="wsus__track_input">
                                    <select class="mw-100 my-2 " id="Select" placeholder="Your Blood Group " data-search="false" data-silent-initial-value-set="true" name="owner_bgroup">
                                        <option value="" disabled selected class="p-2">Your Blood Group </option>
                                        <?php foreach ($bgroups as $bgroup) : ?>
                                            <option value="<?= $bgroup['group_name']; ?>">
                                                <?= ucwords($bgroup['group_name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <div class="wsus__track_input">
                                    <select class="mw-100 my-2 mb-4" id="Select" placeholder=" Donor Blood Group" data-search="false" data-silent-initial-value-set="true" name="receive_bgroup">
                                        <option value="" disabled selected class="p-2"> Donor Blood Group </option>
                                        <?php foreach ($bgroups as $bgroup) : ?>
                                            <option value="<?= $bgroup['group_name']; ?>">
                                                <?= ucwords($bgroup['group_name']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>

                                <button type="submit" class="common_btn">Check</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include('../layout.php');
?>