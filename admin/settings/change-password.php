<?php
include '../../config.php';
include '../../helpers/helpers.php';
$pageTitle = "Settings";
ob_start();

?>
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="<?= asset('admin'); ?>" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
        </div>
        <h1>General Settings</h1>
        <div class="section-header-breadcrumb">
            <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
            <div class="breadcrumb-item active"><a href="#">Settings</a></div>
            <div class="breadcrumb-item">General Settings</div>
        </div>
    </div>

    <div class="section-body">
        <div id="output-status"></div>
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h4>Settings</h4>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-pills flex-column">
                            <li class="nav-item"><a href="<?= asset('admin/settings/change-password.php'); ?>" class="nav-link <?= setActive(['admin/settings/change-password.php']) ?>">Change Password</a></li>
                            <li class="nav-item"><a href="<?= asset('admin/settings/forget-password.php'); ?>" class="nav-link <?= setActive(['admin/settings/forget-password.php']) ?>">Forget Password</a></li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class=" col-md-8">
                <form id="setting-form" method="POST" action="<?= asset('auth/change-password.php'); ?>">
                    <div class="card" id="settings-card">
                        <div class="card-header">
                            <h4>Change Password</h4>
                        </div>
                        <input type="hidden" name="user_id" value="<?= $_SESSION['USER']['user_id']; ?>" />
                        <div class="card-body">
                            <div class="form-floating mb-3">
                                <label for="passwrd">Current Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control " id="current_password" name="current_password" placeholder="Current Password" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-eye" style="user-select:none" id="toggle_current_password" onclick="togglePassword('current_password')"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating mb-3">
                                <label for="passwrd">New Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="new_password" name="new_password" placeholder="New Password" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-eye" style="user-select:none" id="toggle_new_password" onclick="togglePassword('new_password')"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="form-floating mb-3">
                                <label for="passwrd">Confirm Password</label>
                                <div class="input-group">
                                    <input type="password" class="form-control password" id="confirm_password" name="confirm_password" placeholder="Confirm Password" required>
                                    <div class="input-group-append">
                                        <span class="input-group-text">
                                            <i class="fas fa-eye" style="user-select:none" id="toggle_confirm_password" onclick="togglePassword('confirm_password')"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-whitesmoke text-md-right">
                            <button class="btn btn-primary" id="save-btn"> Change Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
<script>
    // Show/hide password functionality
    function togglePassword(e) {
        const password = document.querySelector('#' + e);
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);

        const icon = document.querySelector('#toggle_' + e);
        icon.classList.toggle('fa-eye-slash');
    }
</script>
<?php
$content = ob_get_clean();
include('../layout.php');
?>