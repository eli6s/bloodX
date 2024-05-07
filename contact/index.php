<?php
include '../config.php';
include '../helpers/helpers.php';

$pageTitle = "Contact Page";
ob_start();

// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>

<!-- contact -->
<section id="wsus__contact">
    <div class="container">
        <div class="wsus__contact_area">
            <div class="row">
                <div class="col-xl-4">
                    <div class="row">
                        <div class="col-xl-12">
                            <div class="wsus__contact_single">
                                <i class="fal fa-envelope"></i>
                                <h5></h5>
                                <a href="mailto:mohammadrajha2@gmail.com">mohammadrajha2@gmail.com</a>
                                <a href="mailto:eliasbalkis@gmail.com">eliasbalkis@gmail.com</a>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="wsus__contact_single">
                                <i class="fa fa-whatsapp"></i>
                                <h5></h5>
                                <a href="https://wa.me/+96176058737" target="_blank">+961 76 058 737</a>
                                <a href="https://wa.me/+96171883106" target="_blank">+961 71 883 106</a>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <div class="wsus__contact_single">
                                <i class="fal fa-map-marker-alt"></i>
                                <h5></h5>
                                <a href="">Beirut, Bir Hassan, Lebanon</a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8">
                    <div class="wsus__contact_question">
                        <h5>Send Us a Message</h5>
                        <form method="POST" class="contact-form">
                            <div class="row">
                                <div class="col-xl-12">
                                    <div class="wsus__con_form_single">
                                        <input type="text" placeholder="Your Name" name="name" id="name" required>
                                    </div>
                                </div>
                                <div class="col-xl-12">
                                    <div class="wsus__con_form_single">
                                        <input type="email" placeholder="Your Email" id="email" required>
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="wsus__con_form_single">
                                        <input type="text" placeholder="Subject" id="subject" name="subject" required>
                                    </div>
                                </div>

                                <div class="col-xl-12">
                                    <div class="wsus__con_form_single">
                                        <textarea cols="3" rows="5" placeholder="Message" id="message" name="message"></textarea>
                                    </div>
                                    <button type="submit" class="common_btn">send now</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-xl-12">
                    <div class="wsus__con_map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m26!1m12!1m3!1d3312.83275186172!2d35.49134921506175!3d33.868200884853934!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!4m11!3e2!4m3!3m2!1d33.867260699999996!2d35.494605299999996!4m5!1s0x151f1744e461a561%3A0xf7522f4e02be1e34!2sBir+Hassan+Technical+College+-+Universit!3m2!1d33.866945199999996!2d35.4922998!5e0!3m2!1sen!2slb!4v1555484095566!5m2!1sen!2slb" width="1600" height="450" style="border:0;" allowfullscreen="100" loading="lazy"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php
$content = ob_get_clean();
include('../layout.php');
