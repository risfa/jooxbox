<!DOCTYPE html>

<html>

	<head>

		<meta charset="utf-8">

		<meta http-equiv="X-UA-Compatible" content="IE=edge">

		<meta name="description" content="">

		<meta name="author" content="">

		

		<title><?php echo $this->config->item("title") ?></title>

		<link rel="icon" href="<?php echo $this->config->item("faveicon"); ?>" type="image/x-icon">



		<!-- Bootstrap core CSS -->

		<link href="<?php echo base_url(); ?>assets/css/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">



		<!-- Custom styles for this template -->

		

		<link href="<?php echo base_url(); ?>assets/css/bootstrap/docs/examples/sticky-footer-navbar/sticky-footer-navbar.css" rel="stylesheet">

		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome/css/font-awesome.min.css">

		<link href='<?php echo base_url() ?>assets/font/Source_Sans_Pro_700.css' rel='stylesheet' type='text/css'>		

		<link href='<?php echo base_url() ?>assets/font/Gloria_Hallelujah.css' rel='stylesheet' type='text/css'>

		<link href='<?php echo base_url() ?>assets/font/Open_Sans_Condensed_300.css' rel='stylesheet' type='text/css'>

		<link href='<?php echo base_url() ?>assets/font/Oswald.css' rel='stylesheet' type='text/css'>

		<link href="<?php echo base_url(); ?>assets/css/bootstrap/style.css" rel="stylesheet">

		

		<?php if(isset($flag) && ($flag == "login" || $flag == "place")) { // ini buat template yg lama ?>

			<link href="<?php echo base_url(); ?>assets/css/bootstrap/bgstyle.css" rel="stylesheet">

			<link href="<?php echo base_url(); ?>assets/css/bootstrap/docs/examples/signin/signin.css" rel="stylesheet">

			

		<?php } else if(isset($flag) && $flag == "register" || isset($flag) && $flag == "forgot" || isset($flag) && $flag == "newPass" || isset($flag) && $flag == "confirm" ) { ?>

			<link href="<?php echo base_url(); ?>assets/css/bootstrap/bgstyle.css" rel="stylesheet">

			<link href="<?php echo base_url(); ?>assets/css/bootstrap/docs/examples/jumbotron-narrow/jumbotron-narrow.css" rel="stylesheet">


		<?php } else { ?>

			
			<link href="<?php echo base_url(); ?>assets/css/hideshare.css" rel="stylesheet">
						
			<link href="<?php echo base_url(); ?>assets/css/bootstrap/docs/examples/non-responsive/non-responsive.css" rel="stylesheet">
			
		<?php } ?>

		

		<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery-ui.css">

		<link href="<?php echo base_url(); ?>assets/css/bootstrap/sweetalert2.css" rel="stylesheet">

		<link href='<?php echo base_url(); ?>assets/font/lato.css' rel='stylesheet' type='text/css'>

		<link href="<?php echo base_url(); ?>assets/css/bootstrap/bootstrap-social.css" rel="stylesheet">

		<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>

		<script src="<?php echo base_url(); ?>assets/js/jquery-ui.js"></script>		

		

		<script src="<?php echo base_url(); ?>assets/css/bootstrap/js/tooltip.js"></script>

		<script src="<?php echo base_url(); ?>assets/css/bootstrap/js/popover.js"></script>

		<script src="<?php echo base_url(); ?>assets/css/bootstrap/sweetalert2.min.js"></script>

		<script src="<?php echo base_url(); ?>assets/css/bootstrap/dist/js/bootstrap.min.js"></script>

		

		<!-- emoji -->

		<link href="<?php echo base_url(); ?>assets/emoji/lib/css/nanoscroller.css" rel="stylesheet">

	 	<link href="<?php echo base_url(); ?>assets/emoji/lib/css/emoji.css" rel="stylesheet">

		

		<script src="<?php echo base_url(); ?>assets/emoji/lib/js/nanoscroller.min.js"></script>

		<script src="<?php echo base_url(); ?>assets/emoji/lib/js/tether.min.js"></script>

		<script src="<?php echo base_url(); ?>assets/emoji/lib/js/config.js"></script>

		<script src="<?php echo base_url(); ?>assets/emoji/lib/js/util.js"></script>

		<script src="<?php echo base_url(); ?>assets/emoji/lib/js/jquery.emojiarea.js"></script>

		<script src="<?php echo base_url(); ?>assets/emoji/lib/js/emoji-picker.js"></script>

		<!-- emoji -->

		

		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/hideshare.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/base64.min.js"></script>
		
		<script>
		  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
		  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
		  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
		  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

		  ga('create', 'UA-81890140-2', 'auto');
		  ga('send', 'pageview');

		</script>