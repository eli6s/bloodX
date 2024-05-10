<?php
include '../helpers/helpers.php';
include '../config.php';

$pageTitle = "Login";
ob_start();
// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (isset($_SESSION['USER']['username']) && $_SESSION['USER']['username'] != '') {
    header('Location: ../index.php');
    exit();
}


$blood_groups = fetchBloodGroups();
$statuses = fetchStatuses();
$diseases = fetchDiseases();
?>

<style>
    /* Custom CSS for password field */
    .password-toggle {
        position: relative;
    }

    .password-toggle .toggle-password {
        position: absolute;
        top: 0;
        right: 0;
        cursor: pointer;
        padding: 20px 10px;
        border-left: 1px solid;
    }
</style>

<section id="wsus__login_register">
    <div class="container">
        <div class="row">
            <div class="col-lg-10 col-sm-12 col-md-12 m-auto">
                <div class="wsus__login_reg_area">
                    <ul class="nav nav-pills mb-3" id="pills-tab2" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab2" data-bs-toggle="pill" data-bs-target="#pills-homes" type="button" role="tab" aria-controls="pills-homes" aria-selected="true">login</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab2" data-bs-toggle="pill" data-bs-target="#pills-profiles" type="button" role="tab" aria-controls="pills-profiles" aria-selected="true">signup</button>
                        </li>
                    </ul>

                    <div class="tab-content" id="pills-tabContent2">
                        <?php if (isset($_GET['forget_password']) && $_GET['forget_password']) : ?>
                            <div class="tab-pane fade  show active" id="pills-homes" role="tabpanel" aria-labelledby="pills-home-tab2">
                                <div class="wsus__login">
                                    <form method="POST" class="email-form">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-floating my-3">
                                                    <input type="text" class="form-control" id="email" name="email" placeholder="Email" required>
                                                    <label for="email">Email</label>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="wsus__login_save">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                                <label class="form-check-label" for="flexSwitchCheckDefault">Remember me</label>
                                            </div>
                                            <a class="" href="<?= asset('auth/login.php') ?>">Login here!</a>
                                        </div>
                                        <div class="col-12">
                                            <br>
                                            <button class="common_btn" type="submit">Send Link</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        <?php else : ?>
                            <!-- Login START -->
                            <div class="tab-pane fade  show active" id="pills-homes" role="tabpanel" aria-labelledby="pills-home-tab2">
                                <div class="wsus__login">
                                    <form method="POST" action="signin.php">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" name="usernameOrEmail" placeholder="Username or Email" required>
                                                    <label for="usernameOrEmail">Username or Email</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="password" class="form-control" name="password" placeholder="Password" required>
                                                    <label for="password">Password</label>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="wsus__login_save">
                                            <div class="form-check form-switch">
                                                <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault">
                                                <label class="form-check-label" for="flexSwitchCheckDefault">Remember me</label>
                                            </div>
                                            <a class="forget_p" href="<?= asset('auth/login.php?forget_password=true') ?>">forgot password?</a>
                                        </div>

                                        <div class="col-12">
                                            <br>
                                            <button class="common_btn" type="submit">login</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- Login END -->

                            <!-- Register START -->
                            <div class="tab-pane fade " id="pills-profiles" role="tabpanel" aria-labelledby="pills-profile-tab2">
                                <div class="wsus__login">
                                    <form method="POST" action="signup.php">
                                        <div class="row">
                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="name" name="name" placeholder="Name..." value="<?= old('name') ?>" required>
                                                    <label for="name">Name</label>
                                                </div>
                                                <div class="form-floating mb-3">
                                                    <input type="email" class="form-control" id="email" name="email" placeholder="name@example.com" value="<?= old('email') ?>" required>
                                                    <label for="email">Email address</label>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-floating mb-3">
                                                    <input type="text" class="form-control" id="username" name="username" placeholder="Username..." value="<?= old('username') ?>" required>
                                                    <label for="username">Username</label>
                                                </div>
                                                <div class="form-floating mb-3 password-toggle">
                                                    <input type="password" class="form-control" id="password" name="passwrd" placeholder="Password" required>
                                                    <label for="password">Password</label>
                                                    <span><i class="fas fa-eye toggle-password" id="toggle-password"></i></span>
                                                </div>
                                            </div>

                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-floating mb-3">
                                                    <input type="tel" class="form-control" id="phone" name="phone" placeholder="Phone Number..." value="<?= old('phone') ?>" required>
                                                    <label for="phone">Phone</label>
                                                </div>
                                                <select class="mw-100 " name="blood_group_id" id="Select2" placeholder="Blood Group" data-search="true" data-silent-initial-value-set="true" required>
                                                    <option value="" disabled selected>Blood Group</option>
                                                    <?php foreach ($blood_groups as $group) : ?>
                                                        <option value="<?= $group['group_id'] ?>" <?= $group['group_id'] == old('blood_group_id') ? 'selected' : '' ?>><?= $group['group_name'] ?></option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="col-lg-6 col-sm-12">
                                                <div class="form-floating my-3">
                                                    <input type="date" class="form-control" name="birthday" id="birthday" placeholder="Date Of Birth" required />
                                                    <label for="birthday">Birthday</label>
                                                </div>
                                                <select class="mw-100 mb-3" id="Select" placeholder="Gender" data-search="true" data-silent-initial-value-set="true" name="gender" required>
                                                    <option value="" disabled selected>Gender</option>
                                                    <option value="male" <?= old('gender') == "male" ? 'selected' : ''; ?>>Male</option>
                                                    <option value="female" <?= old('gender') == "female" ? 'selected' : ''; ?>>Female</option>
                                                </select>
                                            </div>

                                            <div class="col-lg-6 col-sm-12">
                                                <select class="mw-100 mb-3" id="Select" placeholder="City" data-search="true" data-silent-initial-value-set="false" name="city" required>
                                                    <option value="" disabled selected>City</option>
                                                    <?= getCities(old('city')); ?>
                                                </select>
                                            </div>

                                            <div class="col-lg-6 col-sm-12">
                                                <select class="mw-100 mb-3" id="Select2" class="Select2" placeholder="No Diseases" data-search="true" data-silent-initial-value-set="true" name="diseases[]" multiple>
                                                    <option value="" disabled selected>No Diseases</option>
                                                    <?php foreach ($diseases as $d) : ?>
                                                        <option value="<?= $d['disease_id'] ?>" <?= (old('diseases') ? in_array($d['disease_id'], old('diseases')) : false) ? 'selected' : '' ?>> <?= $d['disease_name'] ?> </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>

                                            <div class="col-12 ">
                                                <br>
                                                <button name="createBtn" class="common_btn" type="submit">Sign Up</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script>
    // Show/hide password functionality
    const togglePassword = document.getElementById('toggle-password');
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