<?php 
session_start();
date_default_timezone_set("Asia/Bangkok");

#google config
require_once 'Google/autoload.php';
$DEVELOPER_KEY = 'AIzaSyDSq6Io3vNJLHXbL9BPJ4b2qfrKIIkcrco';

#soundcloud config
require_once 'lib/Soundcloud.php';
$clientId="484e4f6b160e6f2cc9f68167656afc2c";
$clientSecret="5019216ddfb09d516d371464f8ccf3b8";
$callback="https://5dapps.com/music/callback.php";
$soundcloud = new Services_Soundcloud($clientId, $clientSecret, $callback);

# config auto post twitter
$config = array();
$config['autopost'][0] = "Play [lagu] at #JUKEBOX5D,follow @Jukebox5D [tag]";
$config['autopost'][1] = "Listening [lagu] at #JUKEBOX5D,follow @Jukebox5D [tag]";
$config['autopost'][2] = "Requested [lagu] at #JUKEBOX5D,follow @Jukebox5D [tag]";
$config['autopost'][3] = "Listened [lagu] at #JUKEBOX5D,follow @Jukebox5D [tag]";
$config['autopost'][4] = "Request [lagu] at #JUKEBOX5D,follow @Jukebox5D [tag]";

$config['subjectForgotPass'] = "JUKEBOX5D Forgot Password";
$config['contentForgotPass'] = "5dapps.com/music/new-password.php?code=[code]";

# config database
$data = array();
$data['host'] = "localhost";
$data['username'] = "dapps";
$data['password'] = "admin5D";
$data['database'] = "dapps_music";
mysql_connect($data['host'],$data['username'],$data['password']);
mysql_select_db($data['database']);
?>