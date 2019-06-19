<?php
	require_once('config.php');
	setcookie("cmsadmin_jukebox_username",false,time()*-90*90,"/");
	setcookie("cmsadmin_jukebox_access",false,time()*-90*90,"/");
	
	header("location:index.php");
?>