<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ManagePlaylist extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("UserModel");
		$this->load->model("PlaylistModel");
	}
	public function index()
	{
		$login=$this->UserModel->islogin();
		if($login){
			$admin=$this->getData('admin');
			if($admin){
				$data['user_logout']=site_url()."/login/logout";
				$data['username']=$this->getData('username');
				$data['status']="admin";
				$data['id']=$this->getData('id');
				$data['loc_id']=$this->getData('id');
				$data['image']=$this->getData('image');
				
				if($data['id']=="367"){
					$this->load->template('playlistAdmin2',$data);
				}else{
					$this->load->template('playlistAdmin',$data);
				}
			}else{
				// if($this->session->userdata('user_id')=="367"){
					// $data['user_logout']=site_url()."/login/logout";
					// $data['username']=$this->getData('username');
					// $data['status']="admin";
					// $data['id']=$this->getData('id');
					// $data['loc_id']=$this->getData('id');
					// $data['image']=$this->getData('image');
					// $this->load->template('playlistAdmin2',$data);
				// }else{
					// redirect(site_url().'/home');
				// }
				redirect(site_url().'/home');
			}
		}else{
			redirect(site_url().'/login');
		}
	}
	public function getData($key){
		return $this->session->userdata('user_'.$key);
	}
	public function insertSong(){
		
		$track_id = $_GET['id'];
		$from = $_GET['from'];
		$title = $_GET['title'];
		$genre = $_GET['genre'];
		$location = $this->session->userdata('user_id');
		$playlist_name = $_GET['playlist_name'];
		$playlist_daily_id = $_GET['playlist_daily_id'];
		// $date = date("Y-m-d",strtotime(urldecode($_GET['date'])));
		$clientId= $this->config->item("soundcloud_id");
		$clientSecret= $this->config->item("soundcloud_key");		
		$callback=base_url();
		$soundcloud = new Services_Soundcloud($clientId, $clientSecret, $callback);
		if(strtolower($from) == "soundcloud"){
			$track = json_decode($soundcloud->get('tracks/' . $track_id . '.json'),true);
			$link = $track['permalink_url'];
		} else {
			$link = "https://www.youtube.com/watch?v=".$track_id;
		}
		$createby =$this->session->userdata('user_username');
		$data=array(
			'link'=>$link,
			'track_id'=>$track_id,
			'title'=>$title,
			'genre'=>$genre,
			'location'=>$location,
			'source'=>$from,
			'playlist_name'=>$playlist_name,
			'playlist_daily_id'=>$playlist_daily_id,
			'created'=>date("Y-m-d H:i:s"),
			'createby'=>$createby
		);
		$con=$this->PlaylistModel->insertSong($data);
		if($con) {
			echo 1; // sukses insert
		} else {
			echo 2; // gagal insert
		}
	}
	public function insert(){
		$playlist_name = isset($_GET["playlist_name"]) ? urldecode($_GET["playlist_name"]) : FALSE;
		$from = isset($_GET["from"]) ? urldecode($_GET["from"]) : FALSE;
		$to = isset($_GET["to"]) ? urldecode($_GET["to"]) : FALSE;
		$location = $this->session->userdata('user_id');
		$created = date("Y-m-d H:i:s");
		$createby = $this->session->userdata('user_username');
		if($playlist_name !== FALSE && $from !== FALSE && $to !== FALSE) {
			$from = date("Y-m-d",strtotime($from));
			$to = date("Y-m-d",strtotime($to));	
			$data=array(
				'playlist_name'=>$playlist_name,
				'from_date'=>$from,
				'to_date'=>$to,
				'location'=>$location,
				'created'=>$created,
				'createby'=>$createby
			);
			$result=$this->PlaylistModel->insert($data);
			if($result){
				echo 1; //sukses
			} else {
				echo 2; //gagal insert
			}
		} else {
			echo 0; //param tidak lengkap
		}
	}
	public function delete(){
		$id = isset($_GET["id"]) ? urldecode($_GET["id"]) : FALSE;
		if($id !== FALSE) {
			$result =$this->PlaylistModel->delete($id);
			if($result) {
				echo 1; //sukses
			} else {
				echo 2; //gagal delete
			}
		} else {
			echo 0; //param tidak lengkap
		}
	}
	public function deleteSongPlaylist(){
		$id = isset($_GET["id"]) ? urldecode($_GET["id"]) : FALSE;
		if($id !== FALSE) {
			$result =$this->PlaylistModel->deleteSongPlaylist($id);
			if($result) {
				echo 1; //sukses
			} else {
				echo 2; //gagal delete
			}
		} else {
			echo 0; //param tidak lengkap
		}
	}
	public function changeDate(){
		$id = isset($_GET["id"]) ? $_GET["id"] : FALSE;
		$from = isset($_GET["from"]) ? $_GET["from"] : FALSE;
		$to = isset($_GET["to"]) ? $_GET["to"] : FALSE;
		if($id != false && $from !== false && $to !== false) {
			$updateChangeDate = $this->PlaylistModel->changeDate($id,$from,$to);
			if($updateChangeDate) {
				echo 1;
			} else {
				echo 2;
			}
		} else {
			echo 0;
		}
	}
}
