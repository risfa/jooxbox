<?php
	require_once 'MobileDetect/Mobile_Detect.php';
	$detect = new Mobile_Detect;
?>

<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Limadigit" />
	<meta name="keywords" content="jukebox, aplikasi musik, dengerin musik lewat internet, online jukebox, music jukebox, cafe jakarta, pemutar musik online">
	<meta name="description" content="Ingat Jukebox masa lalu? Kini hadir versi Digital Jukebox. Jukebox App adalah aplikasi musik gratis kekinian untuk denger lagu bareng komunitas. Download di Play Store.">
	
    <!-- Stylesheets
    ============================================= -->
	<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="style.css" type="text/css" />
    <link rel="stylesheet" href="css/dark.css" type="text/css" />
    <link rel="stylesheet" href="css/font-icons.css" type="text/css" />
    <link rel="stylesheet" href="css/animate.css" type="text/css" />
    <link rel="stylesheet" href="css/magnific-popup.css" type="text/css" />
	<link rel="stylesheet" href="css/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="css/vmap.css" type="text/css" />

    <link rel="stylesheet" href="css/responsive.css" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <!--[if lt IE 9]>
    	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->

    <!-- External JavaScripts
    ============================================= -->
	<script data-pagespeed-no-defer type="text/javascript" src="js/jquery.js"></script>
	
	
	<!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
    <script data-pagespeed-no-defer type="text/javascript" src="include/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
    <script data-pagespeed-no-defer type="text/javascript" src="include/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>
	
	<!--Google Analytics-->
	<script>
	  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
	  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
	  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
	  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

	  ga('create', 'UA-81890140-2', 'auto');
	  ga('send', 'pageview');

	</script>

    <!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
    <link rel="stylesheet" type="text/css" href="include/rs-plugin/css/settings.css" media="screen" />
	
	
	
    <!-- Document Title
    ============================================= -->
	<title>Jukebox 5D | Limadigits</title>
	<link rel="icon" href="https://jukebox5d.com/app/assets/images/favicon.ico" type="image/x-icon">
	
	<style>

        .revo-slider-emphasis-text {
            font-size: 64px;
            font-weight: 700;
            letter-spacing: -1px;
            font-family: 'Raleway', sans-serif;
            padding: 15px 20px;
            border-top: 2px solid #FFF;
            border-bottom: 2px solid #FFF;
        }

        .revo-slider-desc-text {
            font-size: 20px;
            font-family: 'Lato', sans-serif;
            width: 650px;
            text-align: center;
            line-height: 1.5;
        }

        .revo-slider-caps-text {
            font-size: 16px;
            font-weight: 400;
            letter-spacing: 3px;
            font-family: 'Raleway', sans-serif;
        }
		
		#map_wrapper {
			height: 600px;
		}

		#map_canvas {
			width: 100%;
			height: 100%;
		}
		
		@media(min-width:768px){
			
			
		}
		
    </style>

</head>

<body class="stretched">

    <!-- Document Wrapper
    ============================================= -->
    <div id="wrapper" class="clearfix">

        <!-- Header
		============================================= -->
		<header id="header" style="background-color:#282828;border-color:#282828;box-shadow:0px 0px 5px #888">

			<div id="header-wrap" style="background-color:#282828;border-color:#282828;box-shadow:0px 0px 8px #888">

				<div class="container clearfix">

					<div id="primary-menu-trigger"><i class="icon-reorder"></i></div>

					<!-- Logo
					============================================= -->
					<div id="logo">
						<a href="#" class="standard-logo" data-dark-logo="images/logo-blue.png"><img src="images/logo-blue.png" alt="Jukebox 5D Logo"></a>	
						<a href="#" class="retina-logo" data-dark-logo="images/logo-blue.png"><img src="images/logo-blue.png" alt="Canvas Logo"></a>
					</div><!-- #logo end -->
					
					

					<!-- Primary Navigation
					============================================= -->
					<nav id="primary-menu" class="style-3">

                        <ul>
                            
                            <li class="current" style="margin-right:20px" ><a href="https://jukebox5d.com/app/index.php/login" style="background-color: orange;"><div><i class="fa fa-music"></i> Mainkan Sekarang</div></a></li>							
                        </ul>
						
						<div id="top-cart">
							<a href="https://jukebox5d.com/"><img src="../images/idn-flag.png" width="40px"/></a>							
						</div>

						
						<div id="top-search">
							<a href="https://jukebox5d.com/en/"><img src="../images/en-flag.png" width="40px"/></a>
						</div>
						

                    </nav><!-- #primary-menu end -->

				</div>

			</div>

		</header><!-- #header end -->

       
		
		<section id="slider" class="slider-parallax revslider-wrap clearfix">

            <!--
            #################################
                - THEMEPUNCH BANNER -
            #################################
            -->
            <div class="tp-banner-container">
                <div class="tp-banner" >
                    <ul>    <!-- SLIDE  -->

                <!-- SLIDE  -->
                

                <li class="dark" style="padding:50px" data-transition="zoomout" data-slotamount="1" data-masterspeed="1500" data-thumb="images/slider/pramborsbanner.png"  data-saveperformance="off"  data-title="Fixed-Size Video">
                   <!-- MAIN IMAGE -->
                    <img src="images/slider/pramborsbanner.png"  alt="jukebox 5d"  data-bgposition="right bottom" data-kenburns="on" data-duration="20000" data-ease="Linear.easeNone" data-bgfit="100" data-bgfitend="120" data-bgpositionend="right top">
                    <!-- LAYERS -->

                    <!-- LAYER NR. 1 -->
					
					<?php
						if($detect->isMobile() || $detect->isTablet()){
					?>
						<div class="tp-caption customin"
						data-x="560"
						data-y="160"
						data-customin="x:0;y:0;z:0;rotationZ:0;scaleX:0.6;scaleY:0.6;skewX:0;skewY:0;opacity:0;transformPerspective:0;transformOrigin:50% 50%;"
						data-speed="400"
						data-start="1000"
						data-easing="easeOutQuad"
						data-splitin="none"
						data-splitout="none"
						data-elementdelay="0.01"
						data-endelementdelay="0.1"
						data-endspeed="1000"
						data-endeasing="Power4.easeIn"><div class="col-md-12"><img src="images/slider/dekstop.png" alt="jukebox 5D"></div></div>                    

						<div class="tp-caption customin ltl tp-resizeme revo-slider-caps-text uppercase"
						data-x="20"
						data-y="165"
						data-customin="x:0;y:150;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
						data-speed="800"
						data-start="1000"
						data-easing="easeOutQuad"
						data-splitin="none"
						data-splitout="none"
						data-elementdelay="0.01"
						data-endelementdelay="0.1"
						data-endspeed="1000"
						data-endeasing="Power4.easeIn" style=""><div class="col-md-12">#DENGERBARENG</div></div>

						<div class="tp-caption customin ltl tp-resizeme revo-slider-emphasis-text nopadding noborder"
						data-x="20"
						data-y="180"
						data-customin="x:150;y:150;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
						data-speed="800"
						data-start="1200"
						data-easing="easeOutQuad"
						data-splitin="none"
						data-splitout="none"
						data-elementdelay="0.01"
						data-endelementdelay="0.1"
						data-endspeed="1000"
						data-endeasing="Power4.easeIn" style="font-size: 53px;"><div class="col-md-12">Aplikasi Musik Anak Bangsa</div></div>

						<div class="tp-caption customin ltl tp-resizeme revo-slider-desc-text tleft"
						data-x="20"
						data-y="280"
						data-customin="x:0;y:150;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
						data-speed="800"
						data-start="1400"
						data-easing="easeOutQuad"
						data-splitin="none"
						data-splitout="none"
						data-elementdelay="0.01"
						data-endelementdelay="0.1"
						data-endspeed="1000"
						data-endeasing="Power4.easeIn" style="max-width: 550px; white-space: normal;"><div class="col-md-12">Putar musik andalan bareng komunitasmu dengan Jukebox App!</div></div>

						<div class="tp-caption customin ltl tp-resizeme"
						data-x="20"
						data-y="385"
						data-customin="x:0;y:150;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
						data-speed="800"
						data-start="1550"
						data-easing="easeOutQuad"
						data-splitin="none"
						data-splitout="none"
						data-elementdelay="0.01"
						data-endelementdelay="0.1"
						data-endspeed="1000"
						data-endeasing="Power4.easeIn">
							<div class="col-md-12">
								<div class="btn-group">
									<a href="https://jukebox5d.com/app/index.php/register" target="_blank" class="button button-border button-white button-light button-large button-rounded tright nomargin"><span>Daftar sebagai Admin</span> <i class="icon-music"></i></a> &nbsp;&nbsp;
									<?php
										if($detect->isAndroidOS()){
									?>
									<a href="https://play.google.com/store/apps/details?id=com.limadigit.jukebox5dmusic&hl=in" class="button button-border button-white button-light button-large button-rounded tright nomargin"><span>Daftar sebagai User</span> <i class="icon-user"></i></a>
									<?php
										}else{
									?>
									<a href="https://jukebox5d.com/app/index.php/register" target="_blank" class="button button-border button-white button-light button-large button-rounded tright nomargin"><span>Daftar sebagai User</span> <i class="icon-user"></i></a>
									<?php 
										}
									?>
								</div>
							</div>
						</div>
					<?php 
						}else{						
					?>
						<div class="tp-caption customin"
						data-x="660"
						data-y="160"
						data-customin="x:0;y:0;z:0;rotationZ:0;scaleX:0.6;scaleY:0.6;skewX:0;skewY:0;opacity:0;transformPerspective:0;transformOrigin:50% 50%;"
						data-speed="400"
						data-start="1000"
						data-easing="easeOutQuad"
						data-splitin="none"
						data-splitout="none"
						data-elementdelay="0.01"
						data-endelementdelay="0.1"
						data-endspeed="1000"
						data-endeasing="Power4.easeIn"><div class="col-md-12"><img src="images/slider/dekstop.png" alt="jukebox 5D"></div></div>                    

						<div class="tp-caption customin ltl tp-resizeme revo-slider-caps-text uppercase"
						data-x="0"
						data-y="165"
						data-customin="x:0;y:150;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
						data-speed="800"
						data-start="1000"
						data-easing="easeOutQuad"
						data-splitin="none"
						data-splitout="none"
						data-elementdelay="0.01"
						data-endelementdelay="0.1"
						data-endspeed="1000"
						data-endeasing="Power4.easeIn" style=""><div class="col-md-12">#DENGERBARENG</div></div>

						<div class="tp-caption customin ltl tp-resizeme revo-slider-emphasis-text nopadding noborder"
						data-x="-3"
						data-y="180"
						data-customin="x:150;y:150;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
						data-speed="800"
						data-start="1200"
						data-easing="easeOutQuad"
						data-splitin="none"
						data-splitout="none"
						data-elementdelay="0.01"
						data-endelementdelay="0.1"
						data-endspeed="1000"
						data-endeasing="Power4.easeIn" style="font-size: 53px;"><div class="col-md-12">Aplikasi Musik Anak Bangsa</div></div>

						<div class="tp-caption customin ltl tp-resizeme revo-slider-desc-text tleft"
						data-x="0"
						data-y="280"
						data-customin="x:0;y:150;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
						data-speed="800"
						data-start="1400"
						data-easing="easeOutQuad"
						data-splitin="none"
						data-splitout="none"
						data-elementdelay="0.01"
						data-endelementdelay="0.1"
						data-endspeed="1000"
						data-endeasing="Power4.easeIn" style="max-width: 550px; white-space: normal;"><div class="col-md-12">Putar musik andalan bareng komunitasmu dengan Jukebox App!</div></div>

						<div class="tp-caption customin ltl tp-resizeme"
						data-x="0"
						data-y="385"
						data-customin="x:0;y:150;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
						data-speed="800"
						data-start="1550"
						data-easing="easeOutQuad"
						data-splitin="none"
						data-splitout="none"
						data-elementdelay="0.01"
						data-endelementdelay="0.1"
						data-endspeed="1000"
						data-endeasing="Power4.easeIn">
							<div class="col-md-12">
								<div class="btn-group">
									<a href="https://jukebox5d.com/app/index.php/register" target="_blank" class="button button-border button-white button-light button-large button-rounded tright nomargin"><span>Daftar sebagai Admin</span> <i class="icon-music"></i></a> &nbsp;&nbsp;
									<?php
										if($detect->isAndroidOS()){
									?>
									<a href="https://play.google.com/store/apps/details?id=com.limadigit.jukebox5dmusic&hl=in" class="button button-border button-white button-light button-large button-rounded tright nomargin"><span>Daftar sebagai User</span> <i class="icon-user"></i></a>
									<?php
										}else{
									?>
									<a href="https://jukebox5d.com/app/index.php/register" target="_blank" class="button button-border button-white button-light button-large button-rounded tright nomargin"><span>Daftar sebagai User</span> <i class="icon-user"></i></a>
									<?php 
										}
									?>
								</div>
							</div>
						</div>
					<?php 
						}
					?>
					
                </li>
                <li class="dark" data-transition="zoomout" data-slotamount="1" data-masterspeed="1500"data-thumb="images/slider/pramborsbanner.png"  data-saveperformance="off"  data-title="Fixed-Size Video">
                    <!-- MAIN IMAGE -->
                    <img src="images/slider/pramborsbanner.png"  alt="jukebox 5d"  data-bgposition="left bottom" data-kenburns="on" data-duration="20000" data-ease="Linear.easeNone" data-bgfit="100" data-bgfitend="120" data-bgpositionend="right top">
                    <!-- LAYERS -->

                    <div class="tp-caption customin"
                    data-x="0"
                    data-y="130"
                    data-customin="x:0;y:0;z:0;rotationZ:0;scaleX:0.6;scaleY:0.6;skewX:0;skewY:0;opacity:0;transformPerspective:0;transformOrigin:50% 50%;"
                    data-speed="850"
                    data-start="1200"
                    data-easing="easeOutQuad"
                    data-splitin="none"
                    data-splitout="none"
                    data-elementdelay="0.01"
                    data-endelementdelay="0.1"
                    data-endspeed="1000"
                    data-endeasing="Power4.easeIn"><div class="col-md-12"><iframe src='https://www.youtube.com/embed/HChYLmWaVMY' width='600' height='340' style='width:600px;height:340px;border: none !important;'></iframe></div></div>

                    <div class="tp-caption customin ltl tp-resizeme revo-slider-caps-text uppercase"
                    data-x="675"
                    data-y="165"
                    data-customin="x:140;y:0;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
                    data-speed="800"
                    data-start="1000"
                    data-easing="easeOutQuad"
                    data-splitin="none"
                    data-splitout="none"
                    data-elementdelay="0.01"
                    data-endelementdelay="0.1"
                    data-endspeed="1000"
                    data-endeasing="Power4.easeIn" style="">#DENGERBARENG</div>

                    <div class="tp-caption customin ltl tp-resizeme revo-slider-emphasis-text nopadding noborder"
                    data-x="672"
                    data-y="180"
                    data-customin="x:140;y:0;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
                    data-speed="800"
                    data-start="1200"
                    data-easing="easeOutQuad"
                    data-splitin="none"
                    data-splitout="none"
                    data-elementdelay="0.01"
                    data-endelementdelay="0.1"
                    data-endspeed="1000"
                    data-endeasing="Power4.easeIn" style="font-size: 56px;">Jukebox 5D</div>

                    <div class="tp-caption customin ltl tp-resizeme revo-slider-desc-text tleft"
                    data-x="675"
                    data-y="280"
                    data-customin="x:140;y:0;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
                    data-speed="800"
                    data-start="1400"
                    data-easing="easeOutQuad"
                    data-splitin="none"
                    data-splitout="none"
                    data-elementdelay="0.01"
                    data-endelementdelay="0.1"
                    data-endspeed="1000"
                    data-endeasing="Power4.easeIn" style="max-width: 450px; white-space: normal;">Yuk, kenal Jukebox App lebih dekat. Bukan Aplikasi Musik Biasa!</div>

                    <div class="tp-caption customin ltl tp-resizeme"
                    data-x="675"
                    data-y="385"
                    data-customin="x:140;y:0;z:0;rotationZ:0;scaleX:1;scaleY:1;skewX:0;skewY:0;opacity:0;transformPerspective:200;transformOrigin:50% 0%;"
                    data-speed="800"
                    data-start="1550"
                    data-easing="easeOutQuad"
                    data-splitin="none"
                    data-splitout="none"
                    data-elementdelay="0.01"
                    data-endelementdelay="0.1"
                    data-endspeed="1000"
                    data-endeasing="Power4.easeIn"><a href="https://www.youtube.com/watch?v=HChYLmWaVMY" class="button button-border button-white button-light button-large button-rounded tright nomargin" target="_blank"><span>Lihat di Youtube</span> <i class="icon-angle-right"></i></a></div>

                </li>
				
				
            </ul>
            </div>
            </div>

            <script type="text/javascript">

                jQuery(document).ready(function() {

                    jQuery('.tp-banner').show().revolution(
                    {
                        dottedOverlay:"none",
                        delay:16000,
                        startwidth:1140,
                        startheight:600,
                        hideThumbs:200,

                        thumbWidth:100,
                        thumbHeight:50,
                        thumbAmount:5,

                        navigationType:"bullet",
                        navigationArrows:"solo",
                        navigationStyle:"preview4",

                        touchenabled:"on",
                        onHoverStop:"on",

                        swipe_velocity: 0.7,
                        swipe_min_touches: 1,
                        swipe_max_touches: 1,
                        drag_block_vertical: false,

                        parallax:"mouse",
                        parallaxBgFreeze:"on",
                        parallaxLevels:[7,4,3,2,5,4,3,2,1,0],

                        keyboardNavigation:"off",

                        navigationHAlign:"center",
                        navigationVAlign:"bottom",
                        navigationHOffset:0,
                        navigationVOffset:20,

                        soloArrowLeftHalign:"left",
                        soloArrowLeftValign:"center",
                        soloArrowLeftHOffset:20,
                        soloArrowLeftVOffset:0,

                        soloArrowRightHalign:"right",
                        soloArrowRightValign:"center",
                        soloArrowRightHOffset:20,
                        soloArrowRightVOffset:0,

                        shadow:0,
                        fullWidth:"on",
                        fullScreen:"off",

                        spinner:"spinner4",

                        stopLoop:"off",
                        stopAfterLoops:-1,
                        stopAtSlide:-1,

                        shuffle:"off",

                        autoHeight:"off",
                        forceFullWidth:"off",
                        hideTimerBar:"on",


                        hideThumbsOnMobile:"off",
                        hideNavDelayOnMobile:1500,
                        hideBulletsOnMobile:"off",
                        hideArrowsOnMobile:"off",
                        hideThumbsUnderResolution:0,

                        hideSliderAtLimit:0,
                        hideCaptionAtLimit:0,
                        hideAllCaptionAtLilmit:0,
                        startWithSlide:0,
                        fullScreenOffsetContainer: ".header"
                    });

                }); //ready

            </script>

            <!-- END REVOLUTION SLIDER -->

        </section>

        <!-- Content
        ============================================= -->
        <section id="content">

            <div id="caraBermain" class="content-wrap" style="padding-bottom:0px">
											
				
				<div class="container clearfix" style="margin-bottom:60px">
					
					<div class="heading-block center">
                        <h3>Cara Bermain</h3>
                        <span>Masih ingat Jukebox masa lalu? Kini hadir dengan versi Digital Jukebox.<br/>Ajak Komunitasmu bergabung menjadi Admin dan daftarkan dirimu sebagai User!</span>
                    </div>
					
                    <div class="col-md-3 nobottommargin" data-animate="fadeInLeft" data-delay="500">
                        
						<h4>Apa itu Admin?</h4>
                        <p align="justify">Admin berfungsi sebagai pemutar musik online yang direquest para User. Tanpa adanya Admin di jangkauan lokasimu, kamu (User) tidak dapat masuk (sign-in) ke dalam Jukebox App. Admin juga dapat mengelola playlist sesuai keinginan komunitasmu. *gratis</p>
						
						<h4>Apa yang dibutuhkan Admin?</h4>
                        <p align="justify">Komputer/laptop dan koneksi internet adalah pasangan sempurna untuk mengakses Aplikasi Musik Digital Jukebox ini. Pastikan PC tersambung dengan speaker agar playlist lagu yang dimainkan terdengar dengan baik.</p>
                        
                    </div>

                    <div class="col-md-6 nobottommargin center">
                        <img src="images/appshowcase/radiolistener.png" alt="Image" class="bottommargin-sm">
                        
                    </div>

                    <div class="col-md-3 nobottommargin" data-animate="fadeInRight">
                        
						<h4>Apa itu User?</h4>
                        <p align="justify">Sebagai User, kamu bisa bebas pilih dan request lagu apapun sesuka kamu di Jukebox App. Mainkan lagu secara berganti-gantian dengan teman-temanmu. Banyak fitur lain yang bisa bikin kamu semakin dekat dengan pengguna lainnya di Aplikasi Musik ini. *gratis</p>
						
						<h4>Apa yang dibutuhkan User?</h4>
                        <p align="justify">Kamu hanya perlu Smartphone dan koneksi internet. Kemudian, buka Aplikasi Musik Jukebox 5D dan daftaran diri kamu sebagai User. Tenang, hemat kuota kok!</p>
                        
                    </div>
					
					<div class="clear"></div>

                </div>
				
				<div id="fiturJukebox" class="section dark notopmargin" style="padding-top: 60px;margin-bottom:0px">
					<div class="heading-block center">
                            <h2>Fitur Jukebox 5D</h2>
							<span>Selamat Datang di Era Digital Jukebox.<br/>Bayangkan fitur yang mampu mengekspresikan diri kamu melalui musik</span>
                        </div>
                    <div class="container clearfix">
				
                        <div class="col_one_third">
                            <div class="feature-box fbox-plain">
                                <div class="fbox-icon">
                                    <a href="#"><i class="fa fa-line-chart"></i></a>
                                </div>
                                <h3>Weekly Trends</h3>
                                <p>Temukan 10 daftar lagu terbaik yang paling sering diputar User lainnya.</p>
                            </div>
                        </div>

                        <div class="col_one_third">
                            <div class="feature-box fbox-plain">
                                <div class="fbox-icon">
                                    <a href="#"><i class="fa fa-comments-o"></i></a>
                                </div>
                                <h3>Chat Lounge</h3>
                                <p>Yuk, ngobrol bareng Admin dan User lainnya via online. Ekspresikan tulisanmu dengan emoticon yang seru dan lucu.</p>
                            </div>
                        </div>

                        <div class="col_one_third col_last">
                            <div class="feature-box fbox-plain">
                                <div class="fbox-icon">
                                    <a href="#"><i class="fa fa-trophy" aria-hidden="true"></i></a>
                                </div>
                                <h3>Top User</h3>
                                <p>Jadilah satu dari lima orang terbaik yang paling sering merequest lagu di komunitasmu. Unjuk kebolehanmu sekarang juga!</p>
                            </div>
                        </div>

                        <div class="clear"></div>

                        <div class="col_one_third">
                            <div class="feature-box fbox-plain">
                                <div class="fbox-icon">
                                    <a href="#"><i class="fa fa-share-alt" aria-hidden="true"></i></a>
                                </div>
                                <h3>Share</h3>
                                <p>Tunjukan selera musikmu! Bagikan momen saat lagu yang kamu suka diputar melalui Media Sosial kamu dengan mengeklik fitur 'share'.</p>
                            </div>
                        </div>

                        <div class="col_one_third">
                            <div class="feature-box fbox-plain">
                                <div class="fbox-icon">
                                    <a href="#"><i class="fa fa-fast-forward" aria-hidden="true"></i></a>
                                </div>
                                <h3>Skip</h3>
                                <p>Kamu gak suka dengan lagu yang sedang diputar? Mainkan lagu selanjutnya dengan mengajak user lain mengeklik fitur 'skip'. Lagu akan secara otomatis berhenti diputar setelah jumlah skip terpenuhi (3 atau lebih).</p>
                            </div>
                        </div>

                        <div class="col_one_third col_last">
                            <div class="feature-box fbox-plain">
                                <div class="fbox-icon">
                                    <a href="#"><i class="fa fa-heart" aria-hidden="true"></i></a>
                                </div>
                                <h3>Love </h3>
                                <p>Suka dengan lagu yang sedang diputar? Mainkan kembali lagu tersebut dengan mengajak 4 User atau lebih mengeklik fitur 'love'. Lagu akan kembali dimainkan/masuk dalam playlist setelah jumlah minimum love terpenuhi.</p>
                            </div>
                        </div>
						
						<div class="clear"></div>

                        <div class="col_one_third nobottommargin">
                            <div class="feature-box fbox-plain">
                                <div class="fbox-icon">
                                    <a href="#"><i class="fa fa-users" aria-hidden="true"></i></a>
                                </div>
                                <h3>Online Users</h3>
                                <p>Mau tau siapa saja User yang sedang online? Kamu bisa cari tau di bilik ini.</p>
                            </div>
                        </div>

                        <div class="col_one_third nobottommargin">
                            <div class="feature-box fbox-plain">
                                <div class="fbox-icon">
                                    <a href="#"><i class="fa fa-commenting" aria-hidden="true"></i></a>
                                </div>
                                <h3>Caption</h3>
                                <p>Tunjukan perasaanmu pada lagu yang kamu pilih, dan biarkan si dia tau apa yang ada di hati.</p>
                            </div>
                        </div>

                        <div class="col_one_third nobottommargin col_last">
                            <div class="feature-box fbox-plain">
                                <div class="fbox-icon">
                                    <a href="#"><i class="fa fa-user" aria-hidden="true"></i></a>
                                </div>
                                <h3>Edit Profile </h3>
                                <p>Pasang foto andalan dan edit biodata kamu semenarik mungkin!</p>
                            </div>
                        </div>

                        <div class="clear"></div><div class="line"></div>

                        <!--<div class="heading-block center">
                            <h2>Easy to use for all device.</h2>
                        </div>

                        <div style="position: relative; margin-bottom: -60px;" data-height-lg="415" data-height-md="342" data-height-sm="262" data-height-xs="160" data-height-xxs="102">
                            <img src="images/services/chrome.png" style="position: absolute; top: 0; left: 0;" data-animate="fadeInUp" alt="Chrome">
                            <img src="images/services/ipad3.png" style="position: absolute; top: 0; left: 0;" data-animate="fadeInUp" data-delay="300" alt="iPad">
                        </div>-->

                    </div>
                </div>
				
				<div id="playstore" class="section notopmargin" style="margin-bottom:0px">
                    <div class="container clearfix">

                        <div class="col_half nobottommargin topmargin-lg">

                            <img src="images/appshowcase/iphone-solid.png" alt="Image" class="center-block">

                        </div>

                        <div class="col_half nobottommargin topmargin-lg col_last">

                            <div class="heading-block topmargin-lg">
                                <h2>Tersedia di Smartphone-mu</h2>
                                <span>Temukan cara termudah menggunakan Aplikasi Musik Jukebox 5D</span>
                            </div>

                            <p>
								Download Aplikasi Musik Jukebox 5D secara gratis di Smartphone kamu. <br/>Tidak mempunyai Smartphone?
								Kamu juga bisa mengakses Jukebox App ini melalui <a href="https://jukebox5d.com/app/index.php/login">www.jukebox5d.com</a>
							</p>

                            <a href="https://play.google.com/store/apps/details?id=com.limadigit.jukebox5dmusic&hl=in" class="button button-border button-rounded button-large button-dark noleftmargin"><i class="icon-android"></i> Download Sekarang</a>
							<a href="https://bit.ly/Jukebox5DonIOS" class="button button-border button-rounded button-large button-dark noleftmargin"><i class="icon-apple"></i> Download Sekarang</a>

                        </div>

                    </div>
                </div>
				
				
				
				
				
				<div id="adminJukebox" class="section notopmargin nobottommargin clearfix" style="background-color:#fff;padding-bottom:0px">                                   

                    <div class="heading-block center">
                        <h3>Admin <span>Jukebox 5D</span></h3>
						<span>Mau coba mainkan Digital Jukebox ini sebagai User? <br/>Kunjungi beberapa Cafe Jakarta dan tempat hangout di wilayah kamu!</span>
                    </div>                    
					
					<div id="map_wrapper">
						<div id="map_canvas" class="mapping"></div>
					</div>
					
					<script>
						jQuery(function($) {
							// Asynchronously Load the map API 
							var script = document.createElement('script');
							script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyAgWju3voDNAXSTGjbzRaPB3TMLB_fk7PI&callback=initialize&libraries=places";
							document.body.appendChild(script);
						});

						function initialize() {
							var map;
							var bounds = new google.maps.LatLngBounds();
							var mapOptions = {
								mapTypeId: 'roadmap',
							};
											
							// Display a map on the page
							map = new google.maps.Map(document.getElementById("map_canvas"), mapOptions);
							map.setTilt(45);
							$.ajax({
								url : "https://jukebox5d.com/app/index.php/User/getAdmins",
								type : 'GET',
								success : function(resp){
									var json=JSON.parse(resp);
									var markers = [];
									var infoWindowContent =[];
									var typeMarkers = [];
									$.each(json,function(x,y){
										markers.push(y.location_data);
										if(y.type_admin == 1) {
											typeMarkers.push("https://jukebox5d.com/app/assets/images/markers/Testing.png");
										} else if(y.type_admin == 2) {
											typeMarkers.push("https://jukebox5d.com/app/assets/images/markers/Community.png");
										} else if(y.type_admin == 3) {
											typeMarkers.push("https://jukebox5d.com/app/assets/images/markers/Personal.png");
										} else if(y.type_admin == 9) {
											typeMarkers.push("https://jukebox5d.com/app/assets/images/markers/Official.png");
										} else {
											typeMarkers.push("https://jukebox5d.com/app/assets/images/markers/Official.png");
										}
							
										infoWindowContent.push('<div class="info_content">' +
										'<h4>'+y.location_data[0]+'</h4>' +
										'<p>'+y.desc+'</p>' +
										'</div>');
									});
									// Multiple Markers
									
										
									// Display multiple markers on a map
									var infoWindow = new google.maps.InfoWindow(), marker, i;
									
									// Loop through our array of markers & place each one on the map  
									for( i = 0; i < markers.length; i++ ) {
										if(typeMarkers[i] != "") {
											var icon = {
												url: typeMarkers[i]
											}
										} else {
											var icon = {};
										}
										var position = new google.maps.LatLng(markers[i][1], markers[i][2]);
										bounds.extend(position);
										marker = new google.maps.Marker({
											position: position,
											map: map,
											title: markers[i][0],
											icon: icon
										});
										// Allow each marker to have an info window    
										google.maps.event.addListener(marker, 'click', (function(marker, i) {
											return function() {
												infoWindow.setContent(infoWindowContent[i]);
												infoWindow.open(map, marker);
											}
										})(marker, i));

										// Automatically center the map fitting all markers on the screen
										map.fitBounds(bounds);
									}

									// Override our map zoom level once our fitBounds function runs (Make sure it only runs once)
									var boundsListener = google.maps.event.addListener((map), 'bounds_changed', function(event) {
										this.setZoom(10);
										google.maps.event.removeListener(boundsListener);
									});
									map.setCenter({ lat : -6.3711936, lng : 106.7917005});
								}	
							});				
						}
					</script>
                </div>
				
				
				
				
				
				
                

                

                

               

                

            </div>

        </section><!-- #content end -->

        <!-- Footer
        ============================================= -->
        <footer id="footer" class="dark">

            <div class="container">

                <!-- Footer Widgets
                ============================================= -->
                <div class="footer-widgets-wrap clearfix">

                    <div class="col_two_third">

                        <div class="col_one_third">

                            <div class="widget clearfix">

                                <img src="images/logo-white.png" alt="" class="footer-logo">                                

                                <div style="background: url('images/world-map.png') no-repeat center center; background-size: 100%;">
                                    <address>
                                        <strong>Headquarters:</strong><br>
                                        Komplek Kebayoran Center,<br>
										Blok A-17, Jalan Raya Kebayoran Baru<br>
                                        Jakarta Selatan, DKI Jakarta 12240<br>
										Indonesia
                                    </address>
                                    <abbr title="Phone Number"><strong>Phone:</strong></abbr> +21-4010-1801<br>                                    
                                    <abbr title="Email Address"><strong>Email:</strong></abbr> explore@limadigit.com
                                </div>

                            </div>

                        </div>

                        <div class="col_one_third">

                            <div class="widget widget_links clearfix" style="padding-top:20px;">

                                <h4>Site Map</h4>

                                <ul>
                                    <li><a href="#header">Beranda</a></li>
                                    <li><a href="#caraBermain">Cara Bermain Jukebox 5D</a></li>
                                    <li><a href="#fiturJukebox">Fitur Jukebox 5D</a></li>
                                    <li><a href="#playstore">Playstore</a></li>
                                    <li><a href="#adminJukebox">Admin Jukebox 5D</a></li>                                   
                                </ul>

                            </div>

                        </div>

                        <div class="col_one_third col_last">

                            <div class="widget widget_links clearfix" style="padding-top:20px;">

                                <h4>Source</h4>

                                 <ul>
                                    <li><a href="https://www.youtube.com/" target="_blank">Youtube</a></li>
                                    <li><a href="https://soundcloud.com/" target="_blank">Soundcloud</a></li>                                    
                                </ul>

                            </div>

                        </div>

                    </div>

                    <div class="col_one_third col_last">
                                              

                        <div class="widget clearfix" style="margin-bottom: -20px;padding-top:20px">

                            <div class="row">

                                <div class="col-md-6 clearfix bottommargin-sm">
                                    <a href="https://www.facebook.com/Jukebox5D/" target="_blank" class="social-icon si-dark si-colored si-facebook nobottommargin" style="margin-right: 10px;">
                                        <i class="icon-facebook"></i>
                                        <i class="icon-facebook"></i>
                                    </a>
                                    <a href="https://www.facebook.com/Jukebox5D/" target="_blank"><small style="display: block; margin-top: 3px;"><strong>Like us</strong><br>on Facebook</small></a>
                                </div>
                                <div class="col-md-6 clearfix">
                                    <a href="https://www.instagram.com/jukebox5d/" target="_blank" class="social-icon si-dark si-colored si-instagram nobottommargin" style="margin-right: 10px;">
                                        <i class="icon-instagram"></i>
                                        <i class="icon-instagram"></i>
                                    </a>
                                    <a href="https://www.instagram.com/jukebox5d/" target="_blank"><small style="display: block; margin-top: 3px;"><strong>Follow us</strong><br>on Instagram</small></a>
                                </div>

                            </div>

                        </div>

                    </div>

                </div><!-- .footer-widgets-wrap end -->

            </div>

            <!-- Copyrights
            ============================================= -->
            <div id="copyrights">

                <div class="container clearfix">

                    <div class="col_half">
                        Copyrights &copy; <?php echo date('Y'); ?> Limadigit. Jukebox 5D.<br>
                        <div class="copyright-links"><a href="#">Terms of Use</a> / <a href="#">Privacy Policy</a></div>
                    </div>

                    <div class="col_half col_last tright">
                        <div class="fright clearfix">
                            <a href="https://www.facebook.com/Jukebox5D/" target="_blank" class="social-icon si-small si-borderless si-facebook">
                                <i class="icon-facebook"></i>
                                <i class="icon-facebook"></i>
                            </a>

                            <a href="https://twitter.com/Jukebox5D" target="_blank" class="social-icon si-small si-borderless si-twitter">
                                <i class="icon-twitter"></i>
                                <i class="icon-twitter"></i>
                            </a>

                            <a href="https://www.instagram.com/jukebox5d/" target="_blank" class="social-icon si-small si-borderless si-instagram">
                                <i class="icon-instagram"></i>
                                <i class="icon-instagram"></i>
                            </a>                            
                        </div>

                        <div class="clear"></div>

                        <i class="icon-envelope2"></i> explore@limadigit.com <span class="middot">&middot;</span> <i class="icon-headphones"></i> 021-4010-1801 / +21-4010-1812 
                    </div>

                </div>

            </div><!-- #copyrights end -->

        </footer><!-- #footer end -->

    </div><!-- #wrapper end -->

    <!-- Go To Top
    ============================================= -->
    <div id="gotoTop" class="icon-angle-up"></div>

    <!-- Footer Scripts
    ============================================= -->
	<script data-pagespeed-no-defer type="text/javascript" src="js/plugins.js"></script>
	<script>
		$(function() {
		  $('a[href*="#"]:not([href="#"])').click(function() {
			if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {
			  var target = $(this.hash);
			  target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			  if (target.length) {
				$('html, body').animate({
				  scrollTop: target.offset().top
				}, 1000);
				return false;
			  }
			}
		  });
		});
				
	</script>
    <script data-pagespeed-no-defer type="text/javascript" src="js/functions.js"></script>
</body>
</html>