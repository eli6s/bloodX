<?php
include_once 'helpers/helpers.php';
?>
<nav class="wsus__main_menu d-none d-lg-block">
  <div class="container">
    <div class="row">
      <div class="col-xl-12">
        <div class="relative_contect d-flex">
          <div class="wsus_menu_category_bar d-lg-none">
            <i class="far fa-bars"></i>
          </div>
          <ul class="wsus__menu_item">
            <li><a class="<?= setActive(['index.php', '/']) ?>" href="<?= asset('index.php'); ?>">home</a></li>
            <li>
              <a class="<?= setActive(['compatibility/index.php', 'compatibility']) ?>" href="<?= asset('compatibility/index.php'); ?>">
                Compatibility
              </a>
            </li>

            <li>
              <a class="<?= setActive(['contact/index.php', 'contact']) ?>" href="<?= asset('contact/index.php'); ?>">
                Contact Us
              </a>
            </li>
            <?php if (!isAuthorized()) : ?>
              <li><a class="<?= setActive(['auth/login.php']) ?>" href="<?= asset('auth/login.php'); ?>">Login</a></li>
            <?php endif; ?>
          </ul>

          <ul class="wsus__menu_item wsus__menu_item_right">
            <?php if (isset($_SESSION['USER']['username'])) : ?>
              <ul class="wsus__icon_area ">
                <li>
                  <!-- <button data-bs-toggle="modal" data-bs-target="#DonateModal" class="btn btn-sm text-white bg-danger">
                    Request to donate
                  </button> -->
                  <a href="<?= asset('actions/index.php') ?>" class="w-100">
                    <button class="btn btn-sm text-white bg-danger">
                      Request an Appointment
                    </button>
                  </a>
                </li>
              </ul>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</nav>

<!--============================
        MOBILE MENU START
    ==============================-->
<section id="wsus__mobile_menu">
  <span class="wsus__mobile_menu_close" id="trigger-btn-close"><i class="fal fa-times"></i></span>
  <ul class="wsus__mobile_menu_header_icon ">
    <li> <a href="#" class="wsus__cart_icon  " id="btn-appointments"><i class="fas fa-calendar-alt"></i><span><?= count($appointments); ?></span></a></li>
  </ul>
  <form>
    <input type="text" placeholder="Search">
    <button type="submit"><i class="far fa-search"></i></button>
  </form>

  <div class="tab-content" id="pills-tabContent">
    <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
      <div class="wsus__mobile_menu_main_menu">
        <div class="accordion accordion-flush" id="accordionFlushExample">
          <ul class="wsus_mobile_menu_category">
            <?php if (isset($_SESSION['USER']['user_id']) && isAdmin($_SESSION['USER']['user_id'])) : ?>
              <li><a href="#" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#flush-collapseThreew" aria-expanded="false" aria-controls="flush-collapseThreew"><i class="fas fa-user-shield"></i>
                  <?= $_SESSION['USER']['username']; ?>
                </a>
                <div id="flush-collapseThreew" class="accordion-collapse collapse" data-bs-parent="#accordionFlushExample">
                  <div class="accordion-body">
                    <ul>
                      <li><a href="<?= asset('admin') ?>"> Dashboard</a></li>
                      <li><a href="<?= asset('profile/index.php') ?>"> Profile</a></li>
                    </ul>
                  </div>
                </div>
              </li>
            <?php endif; ?>

            <li><a href="<?= asset('index.php') ?>"><i class="fas fa-home"></i> Home </a></li>

            <?php if (isset($_SESSION['USER']['is_admin']) && $_SESSION['USER']['is_admin'] == 0) : ?>
              <li><a href="<?= asset('profile/index.php') ?>"><i class="fas fa-user"></i> Profile</a></li>
            <?php endif; ?>
            <!-- <li><a href="<?= asset('index.php#wsus__team') ?>"><i class="fas fa-users"></i> Team </a></li> -->
            <li><a href="<?= asset('compatibility/index.php') ?>"><i class="fas fa-check-circle"></i> Compatibility </a></li>
            <?php if (isAuthorized()) : ?>
              <li><a href="<?= asset('auth/logout.php') ?>" class="logoutBtn text-danger"> <i class="fas fa-sign-out-alt mx-2"></i>Logout</a></li>
            <?php else : ?>
              <li><a href="<?= asset('auth/login.php') ?>"><i class="fas fa-user"></i> Login </a></li>
              <li><a href="<?= asset('auth/login.php') ?>"><i class="fas fa-user-plus"></i> Register </a></li>
            <?php endif; ?>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>
<!--============================
        MOBILE MENU END
    ==============================-->

<!-- Close sidebar when display rightbar   -->
<script>
  document.getElementById('btn-appointments').addEventListener('click', function() {
    document.getElementById('trigger-btn-close').click();
  });
</script>