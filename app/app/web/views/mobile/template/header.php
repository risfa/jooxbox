<html>
	<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">    
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
	<meta name="theme-color" content="#00aeff" />
    <link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">

    <title><?php echo $this->config->item("title") ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="<?php echo base_url(); ?>assets/css/bootstrap/docs/examples/navbar-fixed-top/navbar-fixed-top.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/css/bootstrap/docs/examples/sticky-footer/sticky-footer.css" rel="stylesheet">
	
	<?php if(isset($flag) && ($flag == "login" || $flag == "place")) { // ini buat template yg lama ?>
		<link href="<?php echo base_url(); ?>assets/css/bootstrap/bgstyle.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assets/css/bootstrap/docs/examples/signin/signin.css" rel="stylesheet">
		
	<?php } else if(isset($flag) && $flag == "register" || isset($flag) && $flag == "forgot" || isset($flag) && $flag == "newPass" || isset($flag) && $flag == "confirm" ) { ?>
		<link href="<?php echo base_url(); ?>assets/css/bootstrap/docs/examples/jumbotron-narrow/jumbotron-narrow.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assets/css/bootstrap/bgstyle.css" rel="stylesheet">
		
	
	<?php } else { ?>
		<link href="<?php echo base_url(); ?>assets/css/bootstrap/style-mobile.css" rel="stylesheet">
		<link href="<?php echo base_url(); ?>assets/css/hideshare.css" rel="stylesheet">
	<?php } ?>
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-awesome/css/font-awesome.min.css">
	<link href='<?php echo base_url() ?>assets/font/Source_Sans_Pro_700.css' rel='stylesheet' type='text/css'>
	<link href='<?php echo base_url() ?>assets/font/Gloria_Hallelujah.css' rel='stylesheet' type='text/css'>
	<link href='<?php echo base_url() ?>assets/font/Open_Sans_Condensed_300.css' rel='stylesheet' type='text/css'>
	<link href="<?php echo base_url(); ?>assets/css/bootstrap/sweetalert2.css" rel="stylesheet">
	<link href="<?php echo base_url(); ?>assets/css/bootstrap/bootstrap-social.css" rel="stylesheet">
	
	<script src="<?php echo base_url(); ?>assets/js/jquery.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/hideshare-mobile.js"></script>
	<script src="<?php echo base_url(); ?>assets/css/bootstrap/sweetalert2.min.js"></script>
	
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
	
	<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/base64.min.js"></script>