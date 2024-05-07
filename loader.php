<style>
  .loader_bg {
    position: fixed;
    z-index: 9999999;
    background: #fff;
    width: 100%;
    height: 100%;
  }

  .loader {
    height: 100%;
    width: 100%;
    position: absolute;
    left: 0;
    top: 0;
    display: flex;
    justify-content: center;
    align-items: center;
  }

  .loader img {
    width: 280px;
  }
</style>

<!-- loader  -->
<div class="loader_bg">
  <div class="loader"><img src="<?= asset('assets/images/loading.gif') ?>" alt="#" /></div>
</div>
<!-- end loader -->

<script>
  setTimeout(function() {
    $('.loader_bg').fadeToggle(function() {
      new WOW({
        duration: 5000, // 1 second

        delay: 1000, // 0.3 seconds

        offset: 100 // Viewport offset in pixels
      }).init();
    });
  }, 1500);
</script>