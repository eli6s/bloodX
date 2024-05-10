<?php
include '../../config.php';
include '../../helpers/helpers.php';

$pageTitle = "Users";
ob_start();

// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$statusTypes = ['active', 'suspended'];
$blood_groups_rds = fetchBloodGroups();
$statuses = fetchStatuses($statusTypes);
$diseases = fetchDiseases();
?>
<!-- Create User -->
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="<?= '../users'; ?>" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>Users</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="../">Dashboard</a></div>
            <div class="breadcrumb-item"><a href="../users/">Users</a></div>
            <div class="breadcrumb-item">Create User</div>
        </div>
    </div>

    <div class="section-body">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h4>Create User</h4>
                    </div>

                    <div class="card-body">
                        <form method="POST" action="store.php" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-floating mb-3">
                                        <label for="image">Image</label>
                                        <input type="file" class="form-control" id="image" name="image" />
                                    </div>
                                </div>
                            </div>

                            <div class="row ">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <label for="name">Name</label>
                                        <input type="text" class="form-control" id="name" name="name" placeholder="Name..." value="<?= old('name') ?>" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <label for="username">Username</label>
                                        <input type="text" class="form-control" id="username" name="username" placeholder="Username..." value="<?= old('username') ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <label for="email">Email address</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="<?= old('email') ?>" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <label for="passwrd">Password</label>
                                        <div class="input-group">
                                            <input type="password" class="form-control" id="password" name="passwrd" placeholder="Password..." value="<?= old('passwrd') ?>" required>
                                            <div class="input-group-append">
                                                <span class="input-group-text">
                                                    <i class="fas fa-eye" id="togglePassword"></i>
                                                </span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <label for="phone">Phone</label>
                                        <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone Number..." value="<?= old('phone') ?>" required>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <label for="blood_group">Blood Group</label>
                                        <select class="form-control selectric" name="blood_group" id="blood_group" required>
                                            <option value="">Select</option>
                                            <?php foreach ($blood_groups_rds as $groups_rd) : ?>
                                                <option value="<?= $groups_rd['group_id'] ?>" <?= $groups_rd['group_id'] == old('blood_group') ? 'selected' : '' ?>><?= $groups_rd['group_name'] ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <label for="gender">Gender</label>
                                        <select class="form-control selectric" name="gender" id="gender" required>
                                            <option value="">Select</option>
                                            <option value="male" <?= old('gender') == "male" ? 'selected' : ''; ?>>Male</option>
                                            <option value="female" <?= old('gender') == "female" ? 'selected' : ''; ?>>Female</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <label for="birthday">Birthday</label>
                                        <input type="text" class="form-control datepicker" id="birthday" name="birthday" placeholder="Birthday..." value="<?= old('birthday') ?>" required>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <label for="is_admin">Role</label>
                                        <select class="form-control selectric" name="is_admin" id="is_admin" required>
                                            <option value="0" <?= old('is_admin') == 0 ? 'selected' : ''; ?>>User</option>
                                            <option value="1" <?= old('is_admin') == 1 ? 'selected' : ''; ?>>Admin</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <label for="status_id"> Status</label>
                                        <select class="form-control selectric" name="status_id" id="status_id" value="<?= old('status_id') ?>" required>
                                            <?php foreach ($statuses as $status) : ?>
                                                <option value="<?= $status['status_id'] ?>" <?= $status['status_id'] == old('status_id') ? 'selected' : '' ?>><?= ucwords($status['status_type']) ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <label for="diseases">Diseases <code> (If no diseases, unselect all)</code></label>
                                        <select class="form-control selectric" name="diseases[]" id="Select2" multiple>
                                            <option value="" disabled>No Diseases</option>
                                            <?php foreach ($diseases as $d) : ?>
                                                <option value="<?= $d['disease_id'] ?>" <?= (old('diseases') ? in_array($d['disease_id'], old('diseases')) : false) ? 'selected' : '' ?>> <?= ucwords($d['disease_name']) ?> </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating mb-3">
                                        <label for="city">City</label>
                                        <select class="form-control selectric" name="city" id="city">
                                            <option value="" disabled>Select</option>
                                            <?= getCities(old('city')); ?>
                                        </select>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <button type="submit" class="btn btn-warning" name="createBtn">Create</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Create User END -->
<script>
    // Show/hide password functionality
    const togglePassword = document.getElementById('togglePassword');
    const password = document.getElementById('password');

    togglePassword.addEventListener('click', function() {
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        this.classList.toggle('fa-eye-slash');
    });
</script>

<?php
$content = ob_get_clean();
include('../layout.php');
?>