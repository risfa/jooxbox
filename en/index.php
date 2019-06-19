<?php
	require_once '../MobileDetect/Mobile_Detect.php';
	$detect = new Mobile_Detect;
?>

<!DOCTYPE html>
<html dir="ltr" lang="en-US">
<head>

    <meta http-equiv="content-type" content="text/html; charset=utf-8" />
	<meta name="author" content="Limadigit" />
	<meta name="keywords" content="jukebox, jukebox music player, digital jukebox, jukebox app, free jukebox music, online jukebox, music jukebox, listen to free music, free music apps, music app">
	<meta name="description" content="Remember Jukebox? It is now available with Digital Jukebox. Jukebox App is a free music app to listen to any songs with your community. Get it on Google Play Store.">

    <!-- Stylesheets
    ============================================= -->
	<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="../css/bootstrap.css" type="text/css" />
    <link rel="stylesheet" href="../style.css" type="text/css" />
    <link rel="stylesheet" href="../css/dark.css" type="text/css" />
    <link rel="stylesheet" href="../css/font-icons.css" type="text/css" />
    <link rel="stylesheet" href="../css/animate.css" type="text/css" />
    <link rel="stylesheet" href="../css/magnific-popup.css" type="text/css" />
	<link rel="stylesheet" href="../css/font-awesome/css/font-awesome.min.css">
	<link rel="stylesheet" href="../css/vmap.css" type="text/css" />

    <link rel="stylesheet" href="css/responsive.css" type="text/css" />
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
    <!--[if lt IE 9]>
    	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->

    <!-- External JavaScripts
    ============================================= -->
	<script data-pagespeed-no-defer type="text/javascript" src="../js/jquery.js"></script>
	
	
	<!-- SLIDER REVOLUTION 4.x SCRIPTS  -->
    <script data-pagespeed-no-defer type="text/javascript" src="../include/rs-plugin/js/jquery.themepunch.tools.min.js"></script>
    <script data-pagespeed-no-defer type="text/javascript" src="../include/rs-plugin/js/jquery.themepunch.revolution.min.js"></script>

    <!-- SLIDER REVOLUTION 4.x CSS SETTINGS -->
    <link rel="stylesheet" type="text/css" href="../include/rs-plugin/css/settings.css" media="screen" />
	
	
	
    <!-- Document Title
    ============================================= -->
	<title>Jukebox 5D | Limadigit</title>
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
						<a href="#" class="standard-logo" data-dark-logo="../images/logo-blue.png"><img src="../images/logo-blue.png" alt="Jukebox 5D Logo"></a>	
						<a href="#" class="retina-logo" data-dark-logo="../images/logo-blue.png"><img src="../images/logo-blue.png" alt="Canvas Logo"></a>
					</div><!-- #logo end -->
					
					

					<!-- Primary Navigation
					============================================= -->
					<nav id="primary-menu" class="style-3">

                        <ul>
                            
                            <li class="current" style="margin-right:20px" ><a href="https://jukebox5d.com/app/index.php/login"><div><i class="fa fa-music"></i> Play Now</div></a></li>							
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
                

                <li class="dark" style="padding:50px" data-transition="zoomout" data-slotamount="1" data-masterspeed="1500" data-thumb="../images/slider/1.jpg"  data-saveperformance="off"  data-title="Fixed-Size Video">
                   <!-- MAIN IMAGE -->
                    <img src="../images/slider/1.jpg"  alt="jukebox 5d"  data-bgposition="right bottom" data-kenburns="on" data-duration="20000" data-ease="Linear.easeNone" data-bgfit="100" data-bgfitend="120" data-bgpositionend="right top">
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
						data-endeasing="Power4.easeIn"><div class="col-md-12"><img src="../images/slider/dekstop.png" alt="jukebox 5D"></div></div>                    

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
						data-endeasing="Power4.easeIn" style="font-size: 53px;"><div class="col-md-12">Indonesia's Music App</div></div>

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
						data-endeasing="Power4.easeIn" style="max-width: 550px; white-space: normal;"><div class="col-md-12">Enjoy playing your fav songs with your fellas by using Jukebox App!</div></div>

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
									<a href="https://jukebox5d.com/app/index.php/register" target="_blank" class="button button-border button-white button-light button-large button-rounded tright nomargin"><span>Register as Admin</span> <i class="icon-music"></i></a> &nbsp;&nbsp;
									<?php
										if($detect->isAndroidOS()){
									?>
									<a href="https://play.google.com/store/apps/details?id=com.limadigit.jukebox5dmusic&hl=in" class="button button-border button-white button-light button-large button-rounded tright nomargin"><span>Daftar sebagai User</span> <i class="icon-user"></i></a>
									<?php
										}else{
									?>
									<a href="https://jukebox5d.com/app/index.php/register" target="_blank" class="button button-border button-white button-light button-large button-rounded tright nomargin"><span>Register as User</span> <i class="icon-user"></i></a>
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
						data-endeasing="Power4.easeIn"><div class="col-md-12"><img src="../images/slider/dekstop.png" alt="jukebox 5D"></div></div>                    

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
						data-endeasing="Power4.easeIn" style="font-size: 53px;"><div class="col-md-12">Indonesia's Music App</div></div>

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
						data-endeasing="Power4.easeIn" style="max-width: 550px; white-space: normal;"><div class="col-md-12">Enjoy playing your fav songs with your fellas by using Jukebox App!</div></div>

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
									<a href="https://jukebox5d.com/app/index.php/register" target="_blank" class="button button-border button-white button-light button-large button-rounded tright nomargin"><span>Register as Admin</span> <i class="icon-music"></i></a> &nbsp;&nbsp;
									<?php
										if($detect->isAndroidOS()){
									?>
									<a href="https://play.google.com/store/apps/details?id=com.limadigit.jukebox5dmusic&hl=in" class="button button-border button-white button-light button-large button-rounded tright nomargin"><span>Daftar sebagai User</span> <i class="icon-user"></i></a>
									<?php
										}else{
									?>
									<a href="https://jukebox5d.com/app/index.php/register" target="_blank" class="button button-border button-white button-light button-large button-rounded tright nomargin"><span>Register as User</span> <i class="icon-user"></i></a>
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
                <li class="dark" data-transition="zoomout" data-slotamount="1" data-masterspeed="1500"data-thumb="../images/slider/2.png"  data-saveperformance="off"  data-title="Fixed-Size Video">
                    <!-- MAIN IMAGE -->
                    <img src="../images/slider/2.png"  alt="jukebox 5d"  data-bgposition="left bottom" data-kenburns="on" data-duration="20000" data-ease="Linear.easeNone" data-bgfit="100" data-bgfitend="120" data-bgpositionend="right top">
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
                    data-endeasing="Power4.easeIn" style="font-size: 56px;">More Than a Music App</div>

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
                    data-endeasing="Power4.easeIn" style="max-width: 450px; white-space: normal;">Get to know Jukebox App closer!</div>

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
                    data-endeasing="Power4.easeIn"><a href="https://www.youtube.com/watch?v=HChYLmWaVMY" class="button button-border button-white button-light button-large button-rounded tright nomargin" target="_blank"><span>See on Youtube</span> <i class="icon-angle-right"></i></a></div>

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
                        <h3>How To Play</h3>
                        <span>Have you ever used Jukebox?  It's now available with Digital Jukebox. <br/>Play this Jukebox App by joining as a User and your community as an Admin.</span>
                    </div>
					
                    <div class="col-md-3 nobottommargin" data-animate="fadeInLeft" data-delay="500">
                        
						<h4>What is Admin?</h4>
                        <p align="justify">Admin acts as an online music player, so that all Users can request any songs. As Admin, you can also create playlist tailored to your needs. Without the presence of Admin in your location range, User(s) can not sign in to this Jukebox App. *Free music app</p>
						
						<h4>What is Admin needs?</h4>
                        <p align="justify">PC + Internet Connection are the perfect combination to access this Digital Jukebox Music App. Make sure your PC is well connected with speaker(s) so that your playlist sounds great.</p>
                        
                    </div>

                    <div class="col-md-6 nobottommargin center">
                        <img src="../images/appshowcase/admin-user.svg" alt="Image" class="bottommargin-sm">
                        
                    </div>

                    <div class="col-md-3 nobottommargin" data-animate="fadeInRight">
                        
						<h4>What is User?</h4>
                        <p align="justify">User can request any songs they want in Jukebox App.  To request a song, you have to do it alternately with your friends. .You can also enjoy other features offered in this Music App that makes you get closer with others. *Free music app</p>
						
						<h4>What is User needs?</h4>
                        <p align="justify">You only need a Smartphone and internet connection. Access Jukebox Music App and registered yourself as a User. No need to worry of running out of internet quota.</p>
                        
                    </div>
					
					<div class="clear"></div>

                </div>
				
				<div id="fiturJukebox" class="section dark notopmargin" style="padding-top: 60px;margin-bottom:0px">
					<div class="heading-block center">
                            <h2>Jukebox 5D Feature</h2>
							<span>Welcome to the New Era of Digital Jukebox. <br/>Imagine features that can express yourself towards Music</span>
                        </div>
                    <div class="container clearfix">
				
                        <div class="col_one_third">
                            <div class="feature-box fbox-plain">
                                <div class="fbox-icon">
                                    <a href="#"><i class="fa fa-line-chart"></i></a>
                                </div>
                                <h3>Weekly Trends</h3>
                                <p>Get to know 10 best songs that are mostly requested by all Users in every week.</p>
                            </div>
                        </div>

                        <div class="col_one_third">
                            <div class="feature-box fbox-plain">
                                <div class="fbox-icon">
                                    <a href="#"><i class="fa fa-comments-o"></i></a>
                                </div>
                                <h3>Chat Lounge</h3>
                                <p>Let's have a great chit chat to Admin and other Users simply via online chat. Express your words with cute emoticon!</p>
                            </div>
                        </div>

                        <div class="col_one_third col_last">
                            <div class="feature-box fbox-plain">
                                <div class="fbox-icon">
                                    <a href="#"><i class="fa fa-trophy" aria-hidden="true"></i></a>
                                </div>
                                <h3>Top User</h3>
                                <p>Be one of the best 5 Persons who are mostly active and request many songs in your community! Show them who the boss is.</p>
                            </div>
                        </div>

                        <div class="clear"></div>

                        <div class="col_one_third">
                            <div class="feature-box fbox-plain">
                                <div class="fbox-icon">
                                    <a href="#"><i class="fa fa-share-alt" aria-hidden="true"></i></a>
                                </div>
                                <h3>Share</h3>
                                <p>Show your music taste to others! Share your �now playing song� to your friends in Social Media by clicking "share".</p>
                            </div>
                        </div>

                        <div class="col_one_third">
                            <div class="feature-box fbox-plain">
                                <div class="fbox-icon">
                                    <a href="#"><i class="fa fa-fast-forward" aria-hidden="true"></i></a>
                                </div>
                                <h3>Skip</h3>
                                <p>Guess you don't like the 'now playing song'? Play the next song by asking other Users to skip it. It will be automatically skipped after getting 3 skips or more.</p>
                            </div>
                        </div>

                        <div class="col_one_third col_last">
                            <div class="feature-box fbox-plain">
                                <div class="fbox-icon">
                                    <a href="#"><i class="fa fa-heart" aria-hidden="true"></i></a>
                                </div>
                                <h3>Love </h3>
                                <p>Love the song? Play it again by asking 4 Users or more to click 'love'. The song will be automatically played in the playlist.</p>
                            </div>
                        </div>
						
						<div class="clear"></div>

                        <div class="col_one_third nobottommargin">
                            <div class="feature-box fbox-plain">
                                <div class="fbox-icon">
                                    <a href="#"><i class="fa fa-users" aria-hidden="true"></i></a>
                                </div>
                                <h3>Online Users</h3>
                                <p>Do you want to know who are online? Let's simply find out here!</p>
                            </div>
                        </div>

                        <div class="col_one_third nobottommargin">
                            <div class="feature-box fbox-plain">
                                <div class="fbox-icon">
                                    <a href="#"><i class="fa fa-commenting" aria-hidden="true"></i></a>
                                </div>
                                <h3>Caption</h3>
                                <p>Show what you are feeling about your song thru Caption. Let others know your current mood and feeling.</p>
                            </div>
                        </div>

                        <div class="col_one_third nobottommargin col_last">
                            <div class="feature-box fbox-plain">
                                <div class="fbox-icon">
                                    <a href="#"><i class="fa fa-user" aria-hidden="true"></i></a>
                                </div>
                                <h3>Edit Profile </h3>
                                <p>Set your best Profile Picture and Edit Profile, so that others are more curious about you!</p>
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

                            <img src="../images/appshowcase/iphone-solid.png" alt="Image" class="center-block">

                        </div>

                        <div class="col_half nobottommargin topmargin-lg col_last">

                            <div class="heading-block topmargin-lg">
                                <h2>Get It On your Smartphone</h2>
                                <span>Enjoy the easiest way to play Jukebox 5D Music App</span>
                            </div>

                            <p>
								Download Jukebox 5D Free Music App on your mobile.<br/>Not using Smartphone? Simply access this Jukebox App on <a href="https://jukebox5d.com/app/index.php/login">www.jukebox5d.com</a>
							</p>

                            <a href="https://play.google.com/store/apps/details?id=com.limadigit.jukebox5dmusic&hl=in" class="button button-border button-rounded button-large button-dark noleftmargin"><i class="icon-android"></i> Download Now</a>
							<a href="https://bit.ly/Jukebox5DonIOS" class="button button-border button-rounded button-large button-dark noleftmargin"><i class="icon-apple"></i> Download Now</a>

                        </div>

                    </div>
                </div>
				
				
				
				
				
				<div id="adminJukebox" class="section notopmargin nobottommargin clearfix" style="background-color:#fff;padding-bottom:0px">                                   

                    <div class="heading-block center">
                        <h3>Admin <span>Jukebox 5D</span></h3>
						<span>Do you want to enjoy using the Digital Jukebox as a User?<br/>Visit several Cafes in Jakarta and other hangout cafe near you!</span>
                    </div>                    
					
					<div id="map_wrapper">
						<div id="map_canvas" class="mapping"></div>
					</div>
					
					<script>
						jQuery(function($) {
							// Asynchronously Load the map API 
							var script = document.createElement('script');
							script.src = "https://maps.googleapis.com/maps/api/js?key=AIzaSyDDCX4D7evDuctviwVdM-GA29f9e5Xml6g&callback=initialize&libraries=places";
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
											typeMarkers.push("");
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
                        Copyrights &copy; 2016 Limadigit. Jukebox 5D.<br>
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
	<script data-pagespeed-no-defer type="text/javascript" src="../js/plugins.js"></script>
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
    <script data-pagespeed-no-defer type="text/javascript" src="../js/functions.js"></script>
</body>
</html>