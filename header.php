<?php
$appointments = fetchUserAppointments();

?>
<header id="dark-mode-header2 ">
  <div class="container ">
    <div class="row">
      <!-- logo -->
      <div class="         col-2 col-md-2 d-lg-none">
        <div class="wsus__mobile_menu_area">
          <span class="wsus__mobile_menu_icon"><i class="fal fa-bars"></i></span>
        </div>

      </div>
      <!-- blood X -->
      <div class="col-xl-4 col-5 col-md-6  col-lg-2">
        <div class="wsus_logo_area">
          <a class="wsus__header_logo" href="<?= asset('index.php') ?>">
            <h6 class="text-white fw-bold  pt-3 d-none d-lg-block"> B L O O D X </h6>
          </a>
        </div>
      </div>
      <!-- search -->
      <div class="col-xl-4 d-none col-md-4 col-lg-6 d-lg-block">
        <div class="wsus__search">
          <form method="GET">
            <input type="text" placeholder="Search..." name="search" value="<?= isset($_GET['search']) ? $_GET['search'] : '' ?>" />
            <button type="submit"><i class="far fa-search"></i></button>
          </form>
        </div>
      </div>
      <!-- user -->
      <div class="col-xl-4 col-5 col-md-4 col-lg-4">
        <ul style="float:right;" class="d-flex align-items-center flex-end">
          <?php if (isAuthorized()) : ?>
            <ul class="wsus__icon_area d-none d-lg-block">
              <li><a class="wsus__cart_icon fs-6  " href="#"><i class="fas fa-calendar-alt"></i><span><?= count($appointments); ?></span></a></li>
            </ul>
            <li class="dropdown " style="min-width: 100%;">
              <a class="btn dropdown-toggle fw-bold text-white fs-6" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                <img class="rounded-circle mx-1 bg-white" style="object-fit: contain;" src="<?= asset('assets/uploads/' . $_SESSION['USER']['profile_pic']); ?>" alt="" width="40" height="40">
                <?= ucwords($_SESSION['USER']['username']) ?>
              </a>

              <ul class="dropdown-menu m-0 " style="min-width: 200px;" aria-labelledby="dropdownMenuLink">
                <?php if (isset($_SESSION['USER']['user_id']) && isAdmin($_SESSION['USER']['user_id'])) : ?>
                  <li>
                    <a class="dropdown-item p-2" style="border:none !important" href="<?= asset('admin') ?>" target="_blank">
                      <i class="fas fa-tachometer mx-2"></i>
                      Dashboard
                    </a>
                  </li>
                <?php endif; ?>

                <li>
                  <a class="dropdown-item p-2" style="border:none !important" href="<?= asset('profile/index.php?id=' . $_SESSION['USER']['user_id']) ?>">
                    <i class=" fas fa-user mx-2"></i>
                    Profile
                  </a>
                </li>

                <li>
                  <hr class="dropdown-divider">
                </li>
                <li>
                  <a class="dropdown-item p-2 logoutBtn" style="border:none !important;color:red !important;" href="<?= asset('auth/logout.php') ?>">
                    <i class="fas fa-sign-out-alt mx-2"></i>
                    Logout
                  </a>
                </li>
            </li>
        </ul>
        </li>
      <?php endif; ?>
      </ul>
      </div>
    </div>
  </div>

  <div class="wsus__mini_cart">
    <h4>Recent appointments <span class="wsus_close_mini_cart"><i class="far fa-times"></i></span></h4>
    <ul>
      <?php if (count($appointments) > 0) : ?>
        <?php foreach ($appointments as $appointment) : ?>
          <li>
            <div class="wsus__cart_img d-flex justify-content-center align-items-center">
              <?= setStatusAppointment($appointment['status_type']); ?>
            </div>
            <div class="wsus__cart_text">
              <a class="wsus__cart_title text-danger" href="#">your appointment was <?= $appointment['status_type']; ?> </a>
              <p style="font-size: .7rem;"> <?= $appointment['appointment_at'] ?  date("M d, Y - H:i A ", strtotime($appointment['appointment_at'])) : ''; ?></p>
              <p style="font-size: .7rem;"> <?= $appointment['approved_at'] ?  diffHumans($appointment['approved_at']) : diffHumans($appointment['updated_at']); ?></p>
            </div>
          </li>
        <?php endforeach; ?>
      <?php else : ?>
        <li>
          <p class="text-center">
            No Recent Appointments
          </p>
        </li>
      <?php endif; ?>
    </ul>
    <h5> </h5>
    <div class="wsus__minicart_btn_area">
      <a class="common_btn" href="<?= asset('appointments/details.php') ?>">view details</a>
    </div>
  </div>
</header>