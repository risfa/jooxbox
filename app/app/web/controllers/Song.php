<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Song extends CI_Controller {
	public function __construct(){
		parent::__construct();
		header('Access-Control-Allow-Origin: *');
		$this->load->model("UserModel");
		$this->load->model("SongModel");
	}
	public function index()
	{

	}
	public function insert(){
		$login=$this->UserModel->islogin();
		if($login) {
			date_default_timezone_set("Asia/Bangkok");
			$username = (isset($_GET["username"])) ? $_GET["username"] : FALSE;
			$track_id = $_GET['id'];
			$from = $_GET['from'];
			$title = $_GET['title'];
			$genre = $_GET['genre'];
			$tags = urldecode($_GET['tag']);
			$img = (isset($_GET["img"])) ? urldecode($_GET['img']) : "";
			$caption = (isset($_GET["cap"]) && $_GET["cap"] != null) ? urldecode($_GET['cap']) : "";
			
			$location = $_COOKIE['jukebox_location'];
			if(strtolower($from) == "soundcloud"){
				$track = json_decode($soundcloud->get('tracks/' . $track_id . '.json'),true);
				$link = $track['permalink_url'];
			} else {
				$link = "https://www.youtube.com/watch?v=".$track_id;
			}
		}else{
			echo "please login first";
		}
	}
	public function updateCounter(){
		header('Access-Control-Allow-Origin: *');
		$track_id = isset($_GET["track_id"]) ? $_GET["track_id"] : FALSE;
		$link = isset($_GET["link"]) ? $_GET["link"] : FALSE;
		$genre = isset($_GET["genre"]) ? $_GET["genre"] : FALSE;
		$title = isset($_GET["title"]) ? urldecode($_GET["title"]) : FALSE;
		$location = isset($_GET["location"]) ? $_GET["location"] : FALSE;
		$created = isset($_GET["created"]) ? $_GET["created"] : FALSE;
		$user_id = isset($_GET["user_id"]) ? $_GET["user_id"] : FALSE;
		if(preg_match("/youtube/",$link)) {
			$source="youtube";
		}else if(preg_match("/soundcloud/",$link)) {
			$source="soundcloud";
		}else{
			$source="other";
		}
		$datasong=array(
			'track_id'=>$track_id,
			'link'=>$link,
			'title'=>$title,
			'location'=>$location,
			'genre'=>$genre,
		);
		$dataplayer=array(
			'location'=>$location,
			'name'=>$created,
			'user_id'=>$user_id
		);
		$datasource=array(
			'location'=>$location,
			'source'=>$created,
		);
		if($user_id != 0) {
			$status=$this->SongModel->insertTop($datasong,$dataplayer,$datasource);
			if($status){
				echo 1;
			}else{
				echo 0;
			}
		} else {
			echo 1;
		}
	}
	public function get_dislike(){
		
	}
}
