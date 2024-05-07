<?php
include '../../config.php';
include '../../helpers/helpers.php';
$pageTitle = "Settings";
ob_start();

?>
<section class="section">
    <div class="section-header">
        <div class="section-header-back">
            <a href="<?= asset('admin/settings/change-password.php'); ?>" class=" btn btn-icon"><i class="fas fa-arrow-left"></i></a>
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
                <form method="POST" class="email-form">
                    <div class="card" id="settings-card">
                        <div class="card-header">
                            <h4>Forget Password</h4>
                        </div>
                        <div class="card-body">
                            <div class="form-floating mb-3">
                                <label for="email">Email</label>
                                <input type="email" class="form-control " id="email" name="email" placeholder="Enter your E-mail" required>
                            </div>
                        </div>
                        <div class="card-footer bg-whitesmoke text-md-right">
                            <button class="btn btn-primary" id="save-btn"> Send Link</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include('../layout.php');
?>