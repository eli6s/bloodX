<?php

include 'config.php';
include 'helpers/helpers.php';
ob_start();
$pageTitle = "Home";
$_SESSION['LAYOUT_PATH_FRONTEND'] = '/bloodX/';
$_SESSION['LAYOUT_PATH'] = '/admin/';
$_SESSION['DEFAULT_IMAGE_PATH'] = 'default.png';
$_SESSION['BANNER_SLIDER_IMAGES'] = ['banner1.gif', 'banner2.png', 'banner3.png'];
$_SESSION['PER_PAGE'] = 5;

if (isset($_SESSION['USER']['username']) && $_SESSION['USER']['username'] != '') {
    $username = $_SESSION['USER']['username'];
}
$images = isset($_SESSION['BANNER_SLIDER_IMAGES']) ? $_SESSION['BANNER_SLIDER_IMAGES'] : [];
?>
<style>
    .text-shadow {
        text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5);
    }

    .shadow-blood {
        text-shadow: 2px 2px 4px rgba(250, 31, 15, .5);
    }
</style>
<!-- banner -->
<section id="wsus__banner">
    <div class="container">
        <div class="row">
            <div class="col-xl-12">
                <div class="wsus__banner_content">
                    <div class="row banner_slider">
                        <?php foreach ($images as $image) : ?>
                            <div class="col-xl-12">
                                <div class="wsus__single_slider" style="background: url(<?= asset('assets/images/' . $image); ?>); ">
                                    <div class="wsus__single_slider_text">
                                        <h1 class="text-dark text-shadow">EVERY SECOND</h1>
                                        <h1 class="text-dark text-shadow" style="font-size: 28px;">SOMEONE NEEDS
                                            BLOOD...
                                        </h1>
                                        <h6 class="shadow-blood">
                                            Give the gift of blood and help save a life.
                                        </h6>
                                        <?php if (isAuthorized()) : ?>

                                            <a href="<?= asset('actions/index.php') ?>">
                                                <button class="btn btn-sm text-white bg-danger d-lg-none d-block">
                                                    Request an appointment
                                                </button>
                                            </a>
                                        <?php else : ?>
                                            <a href="<?= asset('auth/login.php') ?>">

                                                <button class="btn btn-sm text-white bg-danger d-lg-none d-block">
                                                    Request an appointment
                                                </button>
                                            </a>
                                        <?php endif;    ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<!-- our team -->
<?php include_once('team/index.php'); ?>
<!-- end our team -->

<?php
$content = ob_get_clean();
include('layout.php');
?>