<?php
	require_once("../config.php");
	if(isset($_GET['username']) && strlen(trim($_GET['username'])) > 0 && isset($_GET['password']) && strlen(trim($_GET['password'])) > 0 ){
		if(isset($config['user'][$_GET['username']][$_GET['password']])){
			$access = $config['user'][$_GET['username']][$_GET['password']];
			setcookie("cmsadmin_jukebox_username",$_GET['username'],time()+60*60*24*30,"/");
			setcookie("cmsadmin_jukebox_access",$access,time()+60*60*24*30,"/");
			echo "OK";
		}else{
			echo "Access Denied";
		}
	}else{
		echo "Please enter your username and password";
	}
?>