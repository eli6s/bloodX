<?php
date_default_timezone_set('Etc/GMT-3');
include_once 'helpers/helpers.php';
$_SESSION['LAYOUT_PATH_FRONTEND'] = '/bloodX/';
$_SESSION['LAYOUT_PATH'] = '/admin/';
$_SESSION['DEFAULT_IMAGE_PATH'] = 'default.png';
$_SESSION['BANNER_SLIDER_IMAGES'] = ['banner1.gif', 'banner2.png', 'banner3.png'];
$_SESSION['PER_PAGE'] = 5;
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no, target-densityDpi=device-dpi" />
  <title><?= $pageTitle; ?></title>
  <link rel="icon" type="image/png" href="<?= asset('assets/images/logo.png'); ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/all.min.css'); ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/bootstrap.min.css'); ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/select2.min.css'); ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/slick.css'); ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/jquery.nice-number.min.css'); ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/jquery.calendar.css'); ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/add_row_custon.css'); ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/mobile_menu.css'); ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/jquery.exzoom.css'); ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/multiple-image-video.css'); ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/ranger_style.css'); ?>">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <link rel="stylesheet" href="<?= asset('assets/css/jquery.classycountdown.css'); ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/venobox.min.css'); ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/virtual-select.min.css'); ?>" />
  <link rel="stylesheet" href="<?= asset('assets/css/style.css'); ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/responsive.css'); ?>">
  <link rel="stylesheet" href="<?= asset('assets/modules/jquery-selectric/selectric.css'); ?>">
  <link rel="stylesheet" href="<?= asset('assets/css/toastr.min.css'); ?>">
</head>

<body>
  <!-- loader -->
  <?php include_once('loader.php'); ?>

  <!-- header -->
  <?php include_once('header.php'); ?>

  <!-- menu -->
  <?php include_once('navbar.php'); ?>

  <!-- content -->
  <?= $content; ?>

  <?php include_once('footer.php'); ?>

  <!-- scroll top -->
  <div class="wsus__scroll_btn">
    <i class="fas fa-chevron-up"></i>
  </div>

  <!--jquery library js-->
  <script src="<?= asset('assets/js/jquery-3.6.0.min.js'); ?>"></script>
  <!--bootstrap js-->
  <script src="<?= asset('assets/js/bootstrap.bundle.min.js'); ?>"></script>
  <!--font-awesome js-->
  <script src="<?= asset('assets/js/Font-Awesome.js'); ?>"></script>
  <!--select2 js-->
  <script src="<?= asset('assets/js/select2.min.js'); ?>"></script>
  <!--slick slider js-->
  <script src="<?= asset('assets/js/slick.min.js'); ?>"></script>
  <!--simplyCountdown js-->
  <script src="<?= asset('assets/js/simplyCountdown.js'); ?>"></script>
  <!--product zoomer js-->
  <script src="<?= asset('assets/js/jquery.exzoom.js'); ?>"></script>
  <!--nice-number js-->
  <script src="<?= asset('assets/js/jquery.nice-number.min.js'); ?>"></script>
  <!--counter js-->
  <script src="<?= asset('assets/js/jquery.waypoints.min.js'); ?>"></script>
  <script src="<?= asset('assets/js/jquery.countup.min.js'); ?>"></script>
  <!--add row js-->
  <script src="<?= asset('assets/js/add_row_custon.js'); ?>"></script>
  <!--multiple-image-video js-->
  <script src="<?= asset('assets/js/multiple-image-video.js'); ?>"></script>
  <!--sticky sidebar js-->
  <script src="<?= asset('assets/js/sticky_sidebar.js'); ?>"></script>
  <!--price ranger js-->
  <script src="<?= asset('assets/js/ranger_jquery-ui.min.js'); ?>"></script>
  <script src="<?= asset('assets/js/ranger_slider.js'); ?>"></script>
  <!--isotope js-->
  <script src="<?= asset('assets/js/isotope.pkgd.min.js'); ?>"></script>
  <!--venobox js-->
  <script src="<?= asset('assets/js/venobox.min.js'); ?>"></script>
  <!--classycountdown js-->
  <script src="<?= asset('assets/js/jquery.classycountdown.js'); ?>"></script>
  <script src="<?= asset('assets/js/wow.js'); ?>"></script>
  <!--main/custom js-->
  <script src="<?= asset('assets/js/main.js'); ?>"></script>
  <script src="<?= asset('assets/js/virtual-select.min.js'); ?>"></script>
  <script src="<?= asset('assets/js/toastr.min.js'); ?>"></script>
  <script src="<?= asset('assets/js/init-virtual-select.js') ?>"></script>

  <script src="<?= asset('admin/assets/js/email-js.js') ?>"></script>
  <script src="<?= asset('admin/assets/js/sweet-alert.js') ?>"></script>

  <script>
    // Get the current URL &&  Remove empty query parameters
    var url = window.location.href;
    var cleanUrl = url.replace(/&?\w+=(&|$)/g, '');
    window.history.replaceState({}, document.title, cleanUrl);

    $(document).ready(function() {
      (function() {
        emailjs.init("GtxWI4jW4smvXWodf");
      })();

      $('body').on('click', '.delete-item', function(event) {
        event.preventDefault();

        let URL = $(this).attr('href');
        let id = $(this).data('id');

        let title = 'Deleted';

        swal({
          title: "Are you sure?",
          text: "This action cannot be undone. Do you want to continue?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#d33',
          confirmButtonText: 'Delete',
          buttons: true,
          dangerMode: true
        }).then((will) => {
          if (will) {
            $.ajax({
              type: 'POST',
              url: URL,
              data: {
                id: id,
              },
              success: function(data) {
                if (data.status === 'success') {
                  swal(data.message, {
                    title: title,
                    icon: "success",
                  }).then(() => {
                    location.href = "../index.php";
                    // window.location.reload();
                  });
                } else if (data.status === 'error') {
                  swal(data.message, {
                    title: "Can't delete it!",
                    icon: "error",
                  });
                }
              },
              error: function(xhr, status, error) {
                console.log(error);
              }
            });
          }
        });

      });

      $('body').on('click', '.logoutBtn', function(e) {
        e.preventDefault();
        let url = $(this).attr('href');

        swal({
            title: "Logout",
            text: "Are you sure you want to logout?",
            icon: "warning",
            buttons: true,
            dangerMode: true,
          })
          .then((willDelete) => {
            if (willDelete) {
              window.location.href = url;
            }
          });
      });

      $('body').on('click', '.cancel-appointment', function(event) {
        event.preventDefault();

        let URL = $(this).attr('href');
        let id = $(this).data('id');
        swal({
          title: "Cancel appointment",
          text: "Are you sure you want to cancel your appointment?",
          icon: "warning",
          showCancelButton: true,
          confirmButtonColor: '#3085d6',
          cancelButtonColor: '#fff',
          confirmButtonText: 'Cancel',
          buttons: true,
          dangerMode: true
        }).then((will) => {
          if (will) {
            $.ajax({
              type: 'POST',
              url: URL,
              data: {
                id: id
              },
              success: function(data) {
                if (data.status === 'success') {
                  swal(data.message, {
                    title: 'Cancelled.',
                    icon: "success",
                  }).then(() => {
                    window.location.reload();
                  });
                } else if (data.status === 'error') {
                  swal(data.message, {
                    title: "Can't cancel it!",
                    icon: "error",
                  });
                }
              },
              error: function(xhr, status, error) {
                console.log(error);
              }
            });
          }
        });

      });

      $('body').on('submit', '.email-form', function(event) {
        event.preventDefault();
        let URL = 'generate-token.php';
        let email = document.getElementById('email').value;

        $.ajax({
          type: 'POST',
          url: URL,
          data: {
            email: email
          },
          success: function(data) {
            if (data.status === 'success') {
              emailjs.send("service_cnznjsg", "template_ozs9ii5", {
                  name: data.name,
                  email: data.email,
                  subject: data.subject,
                  message: data.message
                })
                .then(function(response) {
                  swal('Please check your inbox.', {
                    title: 'Successfully sent',
                    icon: "success",
                  }).then(() => {
                    window.location.reload();
                  });
                }, function(error) {
                  swal(data.message, {
                    title: 'Failed',
                    icon: "warning",
                  }).then(() => {
                    window.location.reload();
                  });
                });

            } else if (data.status === 'error') {
              swal('This email is not registered.', {
                title: "Invalid email",
                icon: "error",
              }).then(() => {
                window.location.reload();
              });
            } else {
              swal('This email is not registered.', {
                title: "Invalid email",
                icon: "error",
              }).then(() => {
                window.location.reload();
              });
            }
          },
          error: function(xhr, status, error) {
            console.log(error)
          }
        });
      });

      $('body').on('submit', '.contact-form', function(event) {
        event.preventDefault();
        let email = document.getElementById('email').value;
        let name = document.getElementById('name').value;
        let subject = document.getElementById('subject').value;
        let message = document.getElementById('message').value;

        emailjs.send("service_cnznjsg", "template_5gso563", {
          name: name,
          email: email,
          subject: subject,
          message: message
        }).then(function(response) {
          swal('Please check your inbox.', {
            title: 'Successfully sent',
            icon: "success",
          }).then(() => {
            window.location.reload();
          });
        }, function(error) {
          swal(data.message, {
            title: 'Failed to send email. Please try again later.',
            icon: "warning",
          }).then(() => {
            window.location.reload();
          });
        });
      });
    });
  </script>
  <?php include 'flash.php'; ?>
</body>

</html>