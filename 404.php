<?php
$pageTitle = "4O4";
ob_start();
?>
<!--============================
        404 PAGE START
    ==============================-->
<section id="wsus__404">
    <div class="container">
        <div class="row">
            <div class="col-xl-6 col-md-10 col-lg-8 col-xxl-5 m-auto">
                <div class="wsus__404_text">
                    <h2>4O4</h2>
                    <h4><span>Oops!</span> Something went wrong.</h4>
                    <p>There might be a misspelling in the URL entered, or the page you are looking for no longer
                        exists.</p>
                    <a href="index.php" class="common_btn">Go Back Home</a>
                </div>
            </div>
        </div>
    </div>
</section>
<!--============================
        404 PAGE END
    ==============================-->
<?php
$content = ob_get_clean();
include('layout.php');
?>