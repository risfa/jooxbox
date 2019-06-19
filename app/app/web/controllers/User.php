<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("UserModel");
	}
	public function index()
	{
	
	}
	public function Profile(){
		$id=$_GET['id'];
		$loc=$_GET['loc'];
		$detail=$this->UserModel->detail($id);
		$recent=$this->UserModel->recentSong($id,$loc);
		$followData=$this->UserModel->follow($id);
		if($detail){
			$status['status']=true;
			$status['data']=$detail;
		}else{
			$status['status']=false;
			$status['message']=$this->config->item("no_user_found");
		}
		$status['recent']=$recent;
		$status["follow"]=$followData;
		echo json_encode($status);
	}
	public function getAdmins(){
		$servers=$this->UserModel->getAllAdminHome();
		echo json_encode($servers);
	}
}
