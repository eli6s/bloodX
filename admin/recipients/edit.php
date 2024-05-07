<?php
include '../../config.php';
include '../../helpers/helpers.php';

$pageTitle = "Supplicants";
ob_start();
// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_GET['id']) && $_GET['id'] != '') {
    try {
        $statusTypes = ['active', 'suspended'];
        $user_id = $_GET['id'];

        $recipient = fetchUser($user_id);
        $blood_groups =  fetchBloodGroups();
        $statuses = fetchStatuses($statusTypes);
        $diseases = fetchDiseases();
        $user_diseases = fetchUserDiseases($user_id);
        $selectedDiseases =  count($user_diseases) > 0 ? $user_diseases : [];
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
} else {
    header('Location: index.php');
}
?>
<!-- Recipients -->
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="<?= '../supplicants'; ?><?= isset($_GET['search']) && $_GET['search'] != '' ? '?search=' . $_GET['search'] : ''; ?>" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Recipients</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="../">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="../recipients">Recipients</a></div>
            <div class="breadcrumb-item">Edit Recipient</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Edit Recipient : <?= ucwords($recipient['username']) ?> </h4>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="update.php" enctype="multipart/form-data">
                            <div class="row ">
                                <div class="col-md-3">
                                    <div class="form-floating mb-3">
                                        <label for="preview">Preview</label><br>
                                        <img src="<?= asset('assets/uploads/' . $recipient['profile_pic']); ?>" alt="image" style="max-height: 200px; max-width:200px" id="preview" width="100%" height="100%" class="rounded border  shadow-sm" style="object-fit: contain;   pointer-events: none;">
                                        <input type="hidden" name="user_id" value="<?= $recipient['user_id'] ?>">
                                        <input type="hidden" name="old_path_image" value="<?= $recipient['profile_pic'] ?>">
                                    </div>
                                </div>
                                <div class="col-md-9">
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-floating mb-3">
                                                <label for="image">Image</label>
                                                <input type="file" class="form-control" id="image" name="image" />
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-floating mb-3">
                                                <label for="name">Name</label>
                                                <input type="text" class="form-control" id="name" name="name" placeholder="Name..." value="<?= $recipient['name'] ?>">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-floating mb-3">
                                                <label for="email">Email address</label>
                                                <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="<?= $recipient['email'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-floating mb-3">
                                                <label for="username">Username</label>
                                                <input type="text" class="form-control" id="username" name="username" placeholder="Username..." value="<?= strtolower($recipient['username']) ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-floating mb-3">
                                                <label for="phone">Phone</label>
                                                <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone Number..." value="<?= $recipient['phone_number'] ?>">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-floating mb-3">
                                                <label for="blood_group">Blood Group</label>
                                                <select class="form-control selectric" name="blood_group" id="blood_group">
                                                    <option value="" disabled>Select</option>
                                                    <?php foreach ($blood_groups as $groups_rd) : ?>
                                                        <option value="<?= $groups_rd['group_id'] ?>" <?= $groups_rd['group_id'] ==  $recipient['blood_group_id'] ? 'selected' : '' ?>><?= $groups_rd['group_name'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-floating mb-3">
                                                <label for="gender">Gender</label>
                                                <select class="form-control selectric" name="gender" id="gender">
                                                    <option value="" disabled>Select</option>
                                                    <option value="male" <?= $recipient['gender'] ==  'male'   ? 'selected' : '' ?>>Male</option>
                                                    <option value="female" <?= $recipient['gender'] ==  'female' ? 'selected' : '' ?>>Female</option>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-floating mb-3">
                                                <label for="birthday">Birthday</label>
                                                <input type="text" class="form-control datepicker" id="birthday" name="birthday" placeholder="Birthday..." value="<?= $recipient['birthday']; ?>">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-floating mb-3">
                                                <label for="city">City</label>
                                                <select class="form-control selectric" name="city" id="city">
                                                    <option value="" disabled>Select</option>
                                                    <?= getCities($user['city']); ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-floating mb-3">
                                                <label for="is_admin">Role</label>
                                                <select class="form-control selectric" name="is_admin" id="is_admin">
                                                    <option value="" disabled>Select</option>
                                                    <option value="1" <?= $recipient['is_admin'] == 1 ? 'selected' : '' ?>>Admin</option>
                                                    <option value="0" <?= $recipient['is_admin'] == 0 ? 'selected' : '' ?>>User</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">

                                        <div class="col-6">
                                            <div class="form-floating mb-3">
                                                <label for="status">Status</label>
                                                <select class="form-control selectric" name="status_id" id="status_id">
                                                    <option value="" disabled>Select</option>
                                                    <?php foreach ($statuses as $status) : ?>
                                                        <option value="<?= $status['status_id'] ?>" <?= $status['status_id'] ==  $recipient['status_id'] ? 'selected' : '' ?>><?= ucwords($status['status_type']) ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                        <div class="col-6">
                                            <div class="form-floating mb-3">
                                                <label for="diseases">Diseases <code> (If No diseases unselect all )</code></label>
                                                <select class="form-control selectric" name="diseases[]" id="Select2" multiple>
                                                    <option value="" disabled>No Diseases</option>
                                                    <?php foreach ($diseases as $d) : ?>
                                                        <option value="<?= $d['disease_id'] ?>" <?= in_array($d['disease_id'], array_column($selectedDiseases, 'disease_id')) ? 'selected' : '' ?>> <?= ucwords($d['disease_name']); ?> </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <button type="submit" class="btn btn-warning" name="editBtn">Update</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
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