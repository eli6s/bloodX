<?php
include_once '../config.php';
include_once '../helpers/helpers.php';

$pageTitle = "Profile";
ob_start();

// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_SESSION['USER']['user_id']) && !empty($_SESSION['USER'])) {
    try {
        $user_id = $_GET['id'];
        $user = fetchUser($user_id);
        $bgroups = fetchBloodGroups();
        $diseases = fetchDiseases();
        $user_diseases = fetchUserDiseases($user_id);
        $selectedDiseases =  count($user_diseases) > 0 ? $user_diseases : [];

        if (!$user) {
            header('Location: ../index.php');
        }
    } catch (Exception $e) {
        header('Location: ../index.php');
    }
} else {
    header('Location: ../index.php');
}
?>
<section id="wsus__dashboard" class="mt-5 mt-lg-1">
    <div class="container">
        <div class="dashboard_content pt-3 mt-md-0">
            <div class="wsus__dashboard_profile">
                <div class="wsus__dash_pro_area">
                    <div class="d-flex justify-content-between">
                        <h4 class="mx-2 mb-3">
                            <?= $user['username'] ?>'s Profile
                        </h4>
                    </div>
                    <?php if (isAuthorized($_GET['id']) && isset($_GET['edit']) && $_GET['edit']) : ?>
                        <div class="wsus__team_details_top">
                            <form method="POST" action="update.php" enctype="multipart/form-data">
                                <div class="row">
                                    <input type="hidden" name="user_id" value="<?= $user['user_id'] ?>">
                                    <input type="hidden" name="status_id" value="<?= $user['status_id'] ?>">
                                    <input type="hidden" name="is_admin" value="<?= $user['is_admin'] ?>">
                                    <div class="col-xl-4 col-md-5 mb-3">
                                        <div class="wsus__team_details_img wsus__dash_pro_img">
                                            <img src="<?= asset('assets/uploads/' . $user['profile_pic']); ?>" alt="" class="img-fluid w-100">
                                            <input type="file" name="image" />
                                        </div>
                                    </div>
                                    <div class="col-xl-8 col-md-7">
                                        <div class="row">
                                            <input type="hidden" value="<?= $user['profile_pic']; ?>" name="old_path_image">
                                            <div class="col-xl-6 col-md-6">
                                                <div class="wsus__dash_pro_single">
                                                    <i class="fas fa-user-tie"></i>
                                                    <input type="text" placeholder="Name" name="name" value="<?= $user['name'] ?>" required>
                                                </div>
                                            </div>
                                            <div class="col-xl-6 col-md-6">
                                                <div class="wsus__dash_pro_single">
                                                    <i class="fas fa-user-tie"></i>
                                                    <input type="text" placeholder="Username" name="username" value="<?= $user['username'] ?>" required>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-md-6">
                                                <div class="wsus__dash_pro_single">
                                                    <i class="far fa-phone-alt"></i>
                                                    <input type="email" placeholder="Email" name="email" value="<?= $user['email'] ?>" required>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-md-6">
                                                <div class="wsus__dash_pro_single">
                                                    <i class="fal fa-envelope-open"></i>
                                                    <input type="text" placeholder="Phone" name="phone_number" value="<?= $user['phone_number'] ?>" required>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-md-6">
                                                <div class="wsus__dash_pro_single">
                                                    <i class="fal fa-clock"></i>
                                                    <input type="text" class="datepicker" placeholder="Birthday" name="birthday" value="<?= date('Y-m-d', strtotime($user['birthday'])) ?>" required>
                                                </div>
                                            </div>

                                            <div class="col-xl-6 col-md-6">
                                                <select class=" mw-100 " name="bgroup" id="Select" placeholder="Blood Group" data-search="true" data-silent-initial-value-set="true">
                                                    <option value="" disabled selected>Blood Group</option>
                                                    <?php foreach ($bgroups as $bgroup) : ?>
                                                        <option value="<?= $bgroup['group_id'] ?>" <?= $bgroup['group_id'] == $user['blood_group_id'] ? 'selected' : '' ?>><?= ucwords($bgroup['group_name']) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="col-xl-6 col-md-6">
                                                <select class=" mw-100 " name="city" id="Select" placeholder="City" data-search="true" data-silent-initial-value-set="true">
                                                    <option value="" disabled selected>City</option>
                                                    <?= $cities = getCities($user['city']); ?>
                                                </select>
                                            </div>

                                            <div class="col-xl-6 col-md-6">
                                                <select class=" mw-100 " name="gender" id="Select2" placeholder="Blood Group" data-search="true" data-silent-initial-value-set="true">
                                                    <option value="" disabled selected>Gender</option>
                                                    <option value="male" <?= $user['gender'] == 'male' ? 'selected' : '' ?>>Male</option>
                                                    <option value="female" <?= $user['gender'] == 'female' ? 'selected' : '' ?>>Female</option>
                                                </select>
                                            </div>
                                            <div class="col-xl-12 col-md-12 my-4">
                                                <select class=" mw-100  " id="Select2" class="DiseasesSelect" placeholder="No Diseases" data-search="true" data-silent-initial-value-set="true" name="diseases[]" multiple>
                                                    <option value="" disabled selected>No Diseases</option>
                                                    <?php foreach ($diseases as $disease) : ?>
                                                        <option value="<?= $disease['disease_id'] ?>" <?= in_array($disease['disease_id'], array_column($selectedDiseases, 'disease_id')) ? 'selected' : '' ?>> <?= ucwords($disease['disease_name']) ?> </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-xl-12">
                                        <a class="common_btn mb-4 mt-2 bg-warning mr-2" href="<?= asset('profile/index.php?id=' . $user['user_id']) ?>">Back</a>
                                        <button class="common_btn mb-4 mt-2" type="submit">Update Profile</button>
                                    </div>
                            </form>
                        </div>
                    <?php elseif (isset($_GET['id'])) : ?>
                        <div class="wsus__team_details_top">
                            <div class="row">
                                <div class="col-xl-4 col-md-5">
                                    <div class="wsus__team_details_img">
                                        <img src="<?= asset('assets/uploads/' . $user['profile_pic']); ?>" alt="team" class="img-fluid w-100">
                                    </div>
                                </div>
                                <div class="col-xl-8 col-md-7 mt-5">
                                    <div class="wsus__team_details_text">
                                        <div class="wsus__team_det_text_center">
                                            <h3><?= $user['username'] ?></h3>
                                            <h6><?= $user['name'] ?></h6>
                                            <div class="wsus__team_address">
                                                <a href="https://wa.me/<?= $user['phone_number'] ?>" target="_blank">
                                                    <i class="fa fa-whatsapp"></i>
                                                    <?= $user['phone_number']  ?>
                                                </a>
                                                <a href="mailto:<?= $user['email'] ?>">
                                                    <i class="fal fa-envelope"></i>
                                                    <?= $user['email'] ?>
                                                </a>

                                                <p><i class="far fa-tint"></i>
                                                    <?= $user['group_name'] ?>
                                                </p>
                                                <p><i class="far fa-city"></i>
                                                    <?= $user['city'] ?>
                                                </p>
                                                <p>
                                                    <i class="far  fa-birthday-cake"></i>
                                                    <?= date('F j, Y', strtotime($user['birthday'])); ?>
                                                </p>

                                                <p>
                                                    <?= $user['gender'] == 'male' ?
                                                        '<i class="fas fa-venus"></i>' . ucwords($user['gender'])  :
                                                        '<i class="fas fa-mars"></i>' . ucwords($user['gender']); ?>
                                                </p>

                                                <p>
                                                    <i class="far fa-ambulance"></i>
                                                    <?php if (count($selectedDiseases) > 0) : ?>
                                                        <?php foreach ($diseases as $disease) : ?>
                                                            <?php if (in_array($disease['disease_id'], array_column($selectedDiseases, 'disease_id'))) : ?>
                                                                <span class="badge bg-danger p-2 px-3 "><?= ucwords($disease['disease_name']) ?></span>
                                                            <?php endif; ?>
                                                        <?php endforeach; ?>
                                                    <?php else : ?>
                                                        <span class="badge bg-success p-2 px-3 ">
                                                            No Diseases
                                                        </span>
                                                    <?php endif; ?>
                                                </p>
                                                <?php if (isAuthorized($_GET['id'])) : ?>
                                                    <div class="d-flex justify-content-end">
                                                        <a href="?id=<?= $_GET['id']; ?>&edit=true" class="btn btn-success w-5 text-white text-center mx-2 btn-sm fw-400">
                                                            Edit
                                                        </a>
                                                    </div>
                                                <?php endif;  ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php if (isAuthorized($_GET['id']) && isset($_GET['edit']) && $_GET['edit']) : ?>
    <section id="wsus__dashboard" class="py-0">
        <div class="container">
            <div class="dashboard_content  pt-3 mt-md-0 ">
                <div class="wsus__dashboard_profile">
                    <div class="wsus__dash_pro_area">
                        <h4 class="mb-4">Change Password</h4>
                        <form action="<?= asset('auth/change-password.php') ?>" method="POST">
                            <input type="hidden" name="user_id" value="<?= $_SESSION['USER']['user_id']; ?>" />

                            <div class="wsus__dash_pass_change mt-2">
                                <div class="row">
                                    <div class="col-xl-4 col-md-6">
                                        <div class="wsus__dash_pro_single">
                                            <i class="fas fa-unlock-alt"></i>
                                            <input type="password" placeholder="Current Password" name="current_password">
                                        </div>
                                    </div>
                                    <div class="col-xl-4 col-md-6">
                                        <div class="wsus__dash_pro_single">
                                            <i class="fas fa-lock-alt"></i>
                                            <input type="password" placeholder="New Password" name="new_password">
                                        </div>
                                    </div>
                                    <div class="col-xl-4">
                                        <div class="wsus__dash_pro_single">
                                            <i class="fas fa-lock-alt"></i>
                                            <input type="password" placeholder="Confirm Password" name="confirm_password">
                                        </div>
                                    </div>
                                    <div class="col-xl-12">
                                        <button class="common_btn" type="submit">Change Password</button>
                                    </div>
                                </div>
                            </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        </div>
    </section>

<?php endif; ?>
<?php
$content = ob_get_clean();
include('../layout.php');
?>