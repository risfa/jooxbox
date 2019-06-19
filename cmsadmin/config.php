<?php
	require_once("medoo.php");
	$config = array();
	$config['user']['admin']['jukeboxADMIN123'] = "all";
	
	$config["db"]['database_type'] = "mysql";
	$config["db"]['server'] = "5dapps.com";
	$config["db"]['username'] = "dapps";
	$config["db"]['password'] = "admin5D";
	$config["db"]['database_name'] = "dapps_music";
	$config["db"]['charset'] = "utf8";
	
	$db = new medoo($config["db"]);
?>
