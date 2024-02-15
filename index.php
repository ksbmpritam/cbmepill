<!DOCTYPE html>
<html lang="en-US">

<?php

require ("admin/includes/function.php");
require ("admin/language/language.php");
require_once ("admin/thumbnail_images.class.php");

    $qry = "SELECT * FROM index_data where id='1'";
    $result = mysqli_query($mysqli, $qry);
    $row = mysqli_fetch_assoc($result);
  
?>


<head>
    <!-- required meta -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- title for this document -->
    <title>Cbme Pill</title>
    <!-- favicon for this document -->
    <link rel="shortcut icon" href="assets1/images/logo.png" type="image/x-icon">
    <!-- keywords for this document -->
    <meta name="keywords" content="game">
    <!-- description for this document -->
    <meta name="description" content="game">
    <!-- author of this document -->
    <meta name="auhtor" content="PixelAxis">

    <!-- bootstrap 5 minified css source -->
    <link rel="stylesheet" href="assets1/css/vendor/bootstrap.min.css">
    <!-- font awesome 5 icons minified css source -->
    <link rel="stylesheet" href="assets1/icons/css/all.min.css">
    <!-- jquery nice select css source -->
    <link rel="stylesheet" href="assets1/css/vendor/nice-select.css">
    <!-- magnific popup-1.1.0 css source -->
    <link rel="stylesheet" href="assets1/css/vendor/magnific-popup.css">
    <!-- owl carousel-2.3.4 minified css source -->
    <link rel="stylesheet" href="assets1/css/vendor/owl.carousel.min.css">
    <!-- owl carousel-2.3.4 theme default minified css source -->
    <link rel="stylesheet" href="assets1/css/vendor/owl.theme.default.min.css">
    <!-- animate-4.1.1 minified css source -->
    <link rel="stylesheet" href="assets1/css/vendor/animate.min.css">
    <!-- custom css source -->
    <link rel="stylesheet" href="assets1/css/main.css">
</head>

<body>
    <!-- header section start -->
    <header>
        <nav class="navbar navbar-expand-lg" id="mainNav">
            <div class="container">
                <a class="navbar-brand" href="index.html">
                    <img src="assets1/images/logo.png" style="width:80px !important;height:80px !important" alt="Logo" class="logo">
                </a>
                
                <div class="collapse navbar-collapse align-items-center justify-content-end order-3 order-lg-2"
                    id="primaryNav">
                    <ul class="navbar-nav">
                        <li class="nav-item">
                            <a class="nav-link" href="#">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">About</a>
                        </li>
                       
                        <li class="nav-item">
                            <a class="nav-link" href="#screenshot">Screenshot</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#appStore">Download</a>
                        </li>
						
						<li class="nav-item">
                            <a class="nav-link" href="contact-us.html">Contact Us</a>
                        </li>
                         <li class="nav-item">
                            <a class="btn btn-primary" href="http://cbmepill.com/admin/index_teacher.php" style="margin-left:5px">Teacher Login</a>
                        </li>
						
						<li class="nav-item">
                            <a class="btn btn-primary" href="http://cbmepill.com/admin/" style="margin-left:5px">Admin Login</a>
                        </li>
                       
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <!-- header section end -->

    <!-- hero section start -->
    <section class="hero bg-img" data-background="assets1/images/hero/hero-bg.png">
        <div class="container">
            <div class="hero__area">
                <div class="row d-flex align-items-center">
                    <div class="col-lg-7">
                        <div class="hero__content">
                            <h1 class="wow animate__animated animate__fadeInUp">Cbmepill</h1>
                            <h6 class="wow animate__animated animate__fadeInUp">Security - Privacy - User friendly</h6>
                            <h1 class="wow animate__animated animate__fadeInUp" style="font-size: 39px; line-height: 1.2;"><?=$row['first_h']?></h1>
                            <p class="large wow animate__animated animate__fadeInUp">
                               <?=$row['first_p']?>
                            </p>
                         
                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="hero__img wow animate__animated animate__fadeInTopRight">
            <img src="assets1/images/hero/circle.png" alt="circle" class="hero__circle">
            <img src="assets1/images/hero/wallet.png" alt="Wallet" class="hero__wallet">
            <img src="assets1/images/mockup.png" alt="mockup" class="hero__mock">
        </div>
    </section>
    <!-- hero section end -->

  

    <!-- invest section start -->
    <section class="invest" id="about">
        <div class="container">
            <div class="invest__area">
                <div class="row d-flex align-items-center">
                    <div class="col-lg-5 d-none d-lg-block">
                        <div class="invest__thumb wow animate__animated animate__fadeInLeft">
                            <img src="assets1/images/about.png" alt="Invest">
                        </div>
                    </div>
                    <div class="col-lg-6 offset-lg-1">
                        <div class="invest__content">
                            <h6 class="wow animate__animated animate__fadeInUp">About Us
                            </h6>
                            <h2 class="wow animate__animated animate__fadeInUp">About Cbme Pill</h2>
                            <p class="wow animate__animated animate__fadeInUp"><?=$row['about_first_p']?></p>
                            <br>
						<?=$row['about_second_p']?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- invest section end -->
    
    
    <div class="Pharmacology_area">
        <div class="container">
            <div class="row">
                <div class="row">
                    <div class="col-md-12">
                        <h2 class="wow animate__ animate__fadeInUp animated" style="visibility: visible; animation-name: fadeInUp;">Pharmacology</h2>
                        <div class="line" style="width:100px; height:3px; background:#27346d;margin-bottom: 20px;"></div>
                        <p><?=$row['phar_p']?></p>
                        
                        <ul>
                            <ol><b>1.</b> <?=$row['phar_line_first']?></ol>

                            <ol><b>2.</b><?=$row['phar_line_second']?></ol>

                            <ol><b>3.</b><?=$row['phar_line_third']?></ol>
                             
                            <ol><b>4.</b><?=$row['phar_line_four']?></ol>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

 

    <!-- design section start -->
    <section class="design">
        <div class="container">
            <div class="design__area">
                <div class="row d-flex align-items-center">
                    <div class="col-lg-5 d-none d-lg-block">
                        <div class="design__thumb wow animate__animated animate__fadeInLeft">
                            <img src="assets1/images/feature.png" alt="Design">
                        </div>
                    </div>
                    <div class="col-lg-6 offset-lg-1">
                        <div class="design__content">
                            
                            <h2 class="wow animate__animated animate__fadeInUp">Cbme & Pill Feature</h2>
                            <p class="wow animate__animated animate__fadeInUp"><?=$row['feature_p']?></p>
                            <div class="design__content__security">
                              
                                
                                <div class="design__content__cards">
                                    
                                    
                                    <div
                                        class="design__content__cards__item third--item wow animate__animated animate__fadeInUp" style="width: 490px;">
                                       
                                        <p>FLASH CARDS</p>
                                    </div>
                                    
                                    
                                    <div
                                        class="design__content__cards__item third--item wow animate__animated animate__fadeInUp" style="width: 490px;">
                                       
                                        <p>MATCHING GAME</p>
                                    </div>
                                 
                                 
                                </div>
                                <div class="design__content__cards">
                                    
                                    
                                    <div
                                        class="design__content__cards__item third--item wow animate__animated animate__fadeInUp" style="width: 490px;">
                                       
                                        <p>PRESCPTION  GAME</p>
                                    </div>
                                    
                                    
                                    <div
                                        class="design__content__cards__item third--item wow animate__animated animate__fadeInUp" style="width: 490px;">
                                       
                                        <p>THINK HIGH</p>
                                    </div>
                                 
                                 
                                </div>
                                
                                <div class="design__content__cards">
                                    
                                    
                                  
                                    
                                    <div
                                        class="design__content__cards__item third--item wow animate__animated animate__fadeInUp" style="width:634px;">
                                       
                                        <p>LIVE MCQ WITH RANKING</p>
                                    </div>
                                 
                                 
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- design section end -->




    <!-- work section start -->
    <section class="work bg-img" data-background="assets1/images/choice/choice-bg.png">
        <div class="container">
            <div class="work__area">
                <div class="choice__title">
                    <h6 class="text-center wow animate__animated animate__fadeInUp">How Does It Works</h6>
                    <h2 class="text-center wow animate__animated animate__fadeInUp">Follow Some Simple Steps For Using
                        Cbme Pill</h2>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-4">
                        <div class="work__item text-center work__item--primary wow animate__animated animate__fadeInUp">
                            <img src="assets1/images/choice/withdrawal.png" alt="Install">
                            <h6 class="text-center">Install Our App</h6>
                            <p class="text-center"><?=$row['install_p']?></p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="work__item text-center work__item--secondary wow animate__animated animate__fadeInUp"
                            data-wow-delay="0.2s">
                            <img src="assets1/images/choice/account.png" alt="Account">
                            <h6 class="text-center">Set Up Your Account</h6>
                            <p class="text-center"><?=$row['account_p']?></p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="work__item text-center wow animate__animated animate__fadeInUp"
                            data-wow-delay="0.4s">
                            <img src="assets1/images/choice/secure.png" alt="Secure">
                            <h6 class="text-center">Easy Play</h6>
                            <p class="text-center"><?=$row['easy_play_p']?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- work section end -->

    <!-- screenshot slider start -->
    <section class="shot" id="screenshot">
        <div class="container">
            <div class="shot__area">
                <div class="choice__title">
                    <h6 class="text-center wow animate__animated animate__fadeInUp">Our Work</h6>
                    <h2 class="text-center wow animate__animated animate__fadeInUp">App screenshots</h2>
                    
                </div>
            </div>
        </div>
        <div class="shot__slider__wrapper wow animate__animated animate__fadeInUp">
            <div class="shot__slider owl-carousel owl-theme">
                <div class="shot__item">
                    <img src="assets1/images/login.png" alt="Screenshot">
                </div>
                <div class="shot__item">
                    <img src="assets1/images/otp.png" alt="Screenshot">
                </div>
               
                <div class="shot__item">
                    <img src="assets1/images/chill-pill.png" alt="Screenshot">
                </div>
               
                <div class="shot__item">
                    <img src="assets1/images/menu.png" alt="Screenshot">
                </div>
             
            
                
                <div class="shot__item">
                    <img src="assets1/images/splash.png" alt="Screenshot">
                </div>
            </div>
            <div class="slide__button">
                <a href="javascript:void(0)" class="prev">
                    <img src="assets1/images/screenshot/arrow.png" alt="Previous">
                </a>
                <a href="javascript:void(0)" class="next">
                    <img src="assets1/images/screenshot/arrow.png" alt="Next">
                </a>
            </div>
            <img src="assets1/images/screenshot/dev.png" alt="Device" class="device">
        </div>
    </section>
    <!-- screenshot slider end -->

  

  

    <!-- app section start -->
    <section class="app" id="appStore">
        <div class="container">
            <div class="app__area">
                <div class="app__area__content">
                    <h2 class="wow animate__animated animate__fadeInUp">Download app for Andraoid today — it's free.
                    </h2>
                    <div class="hero__content__link wow animate__animated animate__fadeInUp">
                        
                        <a href="<?=$row['play_store_url']?>">
                            <img src="assets1/images/play-store.png" alt="Google Play Store">
                        </a>
                    </div>
                </div>
                <img src="assets1/images/android.png"
                    class="android d-none d-xl-block wow animate__animated animate__fadeInUp" alt="Download App">
            </div>
        </div>
    </section>
    <!-- app section end -->

    <!-- footer start -->
    <footer class="bg-img" data-background="assets1/images/footer-bg.png">
        <div class="container">
            <div class="footer__area">
                
                <div class="footer__links wow animate__animated animate__fadeInUp">
                    <a href="#">About</a>
                    <a href="#">Contact</a>
                    <a href="term-and-condition.html">Terms of Service</a>
                    <a href="privacy-policy.html">Privacy Policy</a>
                </div>
                <div class="footer__credit wow animate__animated animate__fadeInUp">
                    <p class="text-center">Copyright © 2022.All Rights Reserved By <a
                            href="#">Cbme Pill</a></p>
                </div>
            </div>
        </div>
    </footer>
    <!-- footer end -->

    <!-- Scroll To Top -->
    <a href="javascript:void(0)" class="scrollToTop">
        <i class="fas fa-angle-double-up"></i>
    </a>

    <!-- jquery-3.6.0 minified source -->
    <script src="assets1/js/vendor/jquery-3.6.0.min.js"></script>
    <!-- bootstrap 5 minified bundle js source -->
    <script src="assets1/js/vendor/bootstrap.bundle.min.js"></script>
    <!-- nice select minified js source -->
    <script src="assets1/js/vendor/jquery.nice-select.min.js"></script>
    <!-- owl carousel-2.3.4 minified js source -->
    <script src="assets1/js/vendor/owl.carousel.min.js"></script>
    <!-- magnific popup-1.1.0 js source -->
    <script src="assets1/js/vendor/jquery.magnific-popup.min.js"></script>
    <!-- wow-1.1.3 minified js source -->
    <script src="assets1/js/vendor/wow.min.js"></script>
    <!-- custom js source -->
    <script src="assets1/js/main.js"></script>
</body>

</html>