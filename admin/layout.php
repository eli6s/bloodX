<?php
date_default_timezone_set('Etc/GMT-3');
// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
  session_start();
}
$_SESSION['LAYOUT_PATH_FRONTEND'] = '/bloodX/';
$_SESSION['LAYOUT_PATH'] = '/admin/';
$_SESSION['DEFAULT_IMAGE_PATH'] = 'default.png';
$_SESSION['BANNER_SLIDER_IMAGES'] = ['banner1.gif', 'banner2.png', 'banner3.png'];
$_SESSION['PER_PAGE'] = 5;

if (!isset($_SESSION['USER']['username']) || !isAdmin($_SESSION['USER']['user_id'])) {
  flash('error', 'Unable to access that page..');
  header('Location: ' . asset('auth/login.php'));
  exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, shrink-to-fit=no" name="viewport">
  <title><?= $pageTitle ?></title>

  <!-- General CSS Files -->
  <link rel="stylesheet" href="<?= asset('admin/assets/modules/bootstrap/css/bootstrap.css'); ?>">
  <link rel="stylesheet" href="<?= asset('admin/assets/modules/fontawesome/css/all.min.css'); ?>">

  <!-- CSS Libraries -->
  <link rel="stylesheet" href="<?= asset('admin/assets/css/toastr.min.css'); ?>">

  <link rel="stylesheet" href="<?= asset('admin/assets/modules/jqvmap/dist/jqvmap.min.css'); ?>">
  <link rel="stylesheet" href="<?= asset('admin/assets/modules/summernote/summernote-bs4.css'); ?>">
  <link rel="stylesheet" href="<?= asset('admin/assets/modules/owlcarousel2/dist/assets/owl.carousel.min.css'); ?>">
  <link rel="stylesheet" href="<?= asset('admin/assets/modules/owlcarousel2/dist/assets/owl.theme.default.min.css'); ?>">
  <link rel="stylesheet" href="<?= asset('admin/assets/modules/bootstrap-daterangepicker/daterangepicker.css'); ?>">
  <link rel="stylesheet" href="<?= asset('admin/assets/modules/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css'); ?>">
  <link rel="stylesheet" href="<?= asset('admin/assets/modules/select2/dist/css/select2.min.css'); ?>">
  <link rel="stylesheet" href="<?= asset('admin/assets/modules/jquery-selectric/selectric.css'); ?>">
  <link rel="stylesheet" href="<?= asset('admin/assets/modules/bootstrap-timepicker/css/bootstrap-timepicker.min.css'); ?>">
  <link rel="stylesheet" href="<?= asset('admin/assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.css'); ?>">
  <link rel="stylesheet" href="<?= asset('admin/assets/modules/ionicons/css/ionicons.min.css'); ?>">

  <link rel="stylesheet" href="<?= asset('admin/assets/modules/izitoast/css/iziToast.min.css'); ?>" />

  <link rel="stylesheet" href="<?= asset('admin/assets/css/style.css'); ?>">
  <link rel="stylesheet" href="<?= asset('admin/assets/css/components.css'); ?>">
</head>

<body>
  <div id="app">
    <div class="main-wrapper main-wrapper-1">

      <!-- NAVBAR -->
      <?php include_once('navbar.php'); ?>
      <!-- // NAVBAR // -->

      <!-- SIDEBAR -->
      <?php include_once('sidebar.php'); ?>
      <!-- // SIDEBAR // -->

      <!-- Main Content -->
      <main class="my-3 main-content">
        <?= $content; ?>
      </main>
      <!-- // Main Content // -->

      <footer class="main-footer">
        <?php include_once('footer.php'); ?>
      </footer>
    </div>

    <script src="<?= asset('admin/assets/modules/jquery.min.js'); ?>"></script>
    <script src="<?= asset('admin/assets/modules/popper.js'); ?>"></script>
    <script src="<?= asset('admin/assets/modules/tooltip.js'); ?>"></script>
    <script src="<?= asset('admin/assets/modules/bootstrap/js/bootstrap.min.js'); ?>"></script>
    <script src="<?= asset('admin/assets/modules/nicescroll/jquery.nicescroll.min.js'); ?>"></script>
    <script src="<?= asset('admin/assets/modules/moment.min.js'); ?>"></script>
    <script src="<?= asset('admin/assets/js/stisla.js'); ?>"></script>
    <script src="<?= asset('admin/assets/modules/jquery.sparkline.min.js'); ?>"></script>
    <script src="<?= asset('admin/assets/modules/chart.min.js'); ?>"></script>
    <script src="<?= asset('admin/assets/modules/owlcarousel2/dist/owl.carousel.min.js'); ?>"></script>
    <script src="<?= asset('admin/assets/modules/summernote/summernote-bs4.js'); ?>"></script>
    <script src="<?= asset('admin/assets/modules/chocolat/dist/js/jquery.chocolat.min.js'); ?>"></script>
    <script src="<?= asset('admin/assets/modules/cleave-js/dist/cleave.min.js'); ?>"></script>
    <script src="<?= asset('admin/assets/modules/cleave-js/dist/addons/cleave-phone.us.js'); ?>"></script>
    <script src="<?= asset('admin/assets/modules/jquery-pwstrength/jquery.pwstrength.min.js'); ?>"></script>
    <script src="<?= asset('admin/assets/modules/bootstrap-daterangepicker/daterangepicker.js'); ?>"></script>
    <script src="<?= asset('admin/assets/modules/bootstrap-colorpicker/dist/js/bootstrap-colorpicker.min.js'); ?>"></script>
    <script src="<?= asset('admin/assets/modules/bootstrap-timepicker/js/bootstrap-timepicker.min.js'); ?>"></script>
    <script src="<?= asset('admin/assets/modules/bootstrap-tagsinput/dist/bootstrap-tagsinput.min.js'); ?>"></script>
    <script src="<?= asset('admin/assets/modules/select2/dist/js/select2.full.min.js'); ?>"></script>
    <script src="<?= asset('admin/assets/modules/jquery-selectric/jquery.selectric.min.js'); ?>"></script>
    <script src="<?= asset('admin/assets/js/page/modules-toastr.js'); ?>"></script>
    <script src="<?= asset('admin/assets/modules/izitoast/js/iziToast.min.js'); ?>"></script>
    <script src="<?= asset('admin/assets/js/page/modules-ion-icons.js'); ?>"></script>
    <script src="<?= asset('admin/assets/js/page/index.js'); ?>"></script>
    <script src="<?= asset('admin/assets/js/scripts.js'); ?>"></script>
    <script src="<?= asset('admin/assets/js/toastr.min.js'); ?>"></script>
    <script src="<?= asset('admin/assets/js/custom.js'); ?>"></script>
    <script src="<?= asset('admin/assets/js/email-js.js') ?>"></script>
    <script src="<?= asset('admin/assets/js/sweet-alert.js') ?>"></script>

    <script>
      // Get the current URL && Remove empty query parameters
      var url = window.location.href;
      var cleanUrl = url.replace(/&?\w+=(&|$)/g, '');
      window.history.replaceState({}, document.title, cleanUrl);
    </script>
    <script>
      $(document).ready(function() {
        (function() {
          emailjs.init("GtxWI4jW4smvXWodf");
        })();

        $('body').on('click', '.delete-item', function(event) {
          event.preventDefault();

          let URL = $(this).attr('href');
          let id = $(this).data('id');
          let title = $(this).data('title') ?? 'Deleted';
          let img = $(this).attr('data-image');

          // let title = URL.startsWith('delete') ? 'Deleted' : 'Updated';

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
                  img: img
                },
                success: function(data) {
                  if (data.status === 'success') {
                    swal(data.message, {
                      title: title,
                      icon: "success",
                    }).then(() => {
                      window.location.reload();
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
        $('body').on('submit', '.email-form', function(event) {
          event.preventDefault();
          let URL = '../../auth/generate-token.php';
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
                      title: 'Failed to send email. Please try again later.',
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
            error: function(xhr, status, error) {}
          });
        });

        $('body').on('submit', '.send-mail', function(event) {
          event.preventDefault();

          function formatAppointmentDate(d) {
            const options = {
              weekday: 'long',
              month: 'long',
              day: 'numeric',
              hour: 'numeric',
              minute: 'numeric',
              hour12: true // 
            };
            return d.toLocaleDateString(undefined, options);
          }

          function validateAppointment(appointment) {
            let date1 = new Date();
            let date2 = new Date(appointment);
            if (date2 > date1) {
              return true;
            } else {
              return false;
            }
          }

          let appointment_id = document.getElementById('appointment_id').value;
          let appointment = document.getElementById('appointment').value;
          let app = new Date(appointment);
          let formated_appointment = formatAppointmentDate(app);

          if (validateAppointment(appointment) != true) {
            swal('The appointment date must be in the future.', {
              title: 'Invalid Date',
              icon: "error",
            });
          } else {
            $.ajax({
              type: 'POST',
              url: 'approve.php',
              data: {
                id: appointment_id,
                appointment_at: appointment
              },
              success: function(data) {
                if (data.status === 'success') {
                  swal('The user has been notified regarding their appointment.', {
                    title: 'Successfully sent',
                    icon: "success",
                  }).then(() => {
                    window.history.back();
                  });
                } else {
                  swal('Something went wrong!', {
                    title: "Error",
                    icon: "error",
                  }).then(() => {
                    window.history.back();
                  });
                }
              },
              error: function(xhr, status, error) {}
            });
          }
        });
      });
    </script>
    <?php include 'flash.php'; ?>
</body>

</html>