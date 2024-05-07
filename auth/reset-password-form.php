<?php
date_default_timezone_set('Etc/GMT-3');
include '../config.php';
include '../helpers/helpers.php';

// Check if the post_id parameter is set in the POST request
if (isset($_GET['token'])) {
    try {
        $query = "SELECT * FROM users WHERE reset_token = ?";
        $stmt = $conn->prepare($query);
        $stmt->execute([$_GET['token']]);
        $userData = $stmt->fetch();


        if ($userData) {
            // Get the current timestamp
            $currentTimestamp = time();

            // Get the expiry timestamp from the database
            $expiryTimestamp = strtotime($userData['expiry']);

            // Check if the currentTimestamp is greater than expiryTimestamp
            if ($currentTimestamp > $expiryTimestamp) {
                // Token expired, handle accordingly
                flash('error', 'Token has expired');
                header('Location: ' . asset('index.php'));
                exit();
            }
        } else {
            flash('error', 'Token has expired');
            header('Location: ' . asset('index.php'));
            exit();
        }
    } catch (PDOException $e) {
        flash('error', 'something went wrong try again.');
        header('Location: ' . asset('index.php'));
        exit();
    }
}

$pageTitle = "Reset Password";
ob_start();

// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<section id="wsus__dashboard " class="py-0">
    <div class="container mt-5">
        <div class="dashboard_content  pt-3 mt-md-0">
            <div class="wsus__dashboard_profile">
                <div class="wsus__dash_pro_area">
                    <h4 class="mb-4">Reset Password</h4>
                    <form action="<?= asset('auth/reset-password.php') ?>" method="POST">
                        <input type="hidden" name="email" value="<?= $userData['email'] ?>" />

                        <div class="wsus__dash_pass_change mt-2">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="wsus__dash_pro_single">
                                        <i class="fas fa-lock-alt"></i>
                                        <input type="password" placeholder="New Password" name="new_password">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="wsus__dash_pro_single">
                                        <i class="fas fa-lock-alt"></i>
                                        <input type="password" placeholder="Confirm Password" name="confirm_password">
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <button class="common_btn" type="submit">Reset Password</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include('../layout.php');
?>