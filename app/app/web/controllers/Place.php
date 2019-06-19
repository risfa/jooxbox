<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Place extends CI_Controller {
	public function __construct() {
		parent::__construct();
		$this->load->model("UserModel");
		$this->load->library('Mobile_Detect');
	}
	
	public function index() {
		$login=$this->UserModel->islogin();
		if($login){
			$detect = new Mobile_Detect();
			// $data["allLocation"] = $this->UserModel->getData("all_location");
			$data['flag'] = 'place';
			if ( $detect->isMobile() ) {
				$this->load->template_mobile("place",$data);
			}else{
				$this->load->template("place",$data);	
			}
		}else{
			redirect(site_url().'/home');
		}
	}
	
	public function updatelocation() {
		$status = array();
		$location = $_POST["location"];
		$user_id = $this->session->userdata("user_id");
		$result = $this->UserModel->updateLocation($location,$user_id);
		$status["status"] = $result;
		if($result) {
			$status["message"] = $this->config->item("success_update_loc");
			$this->session->set_userdata("user_location",$location);
			$this->session->set_userdata("user_id_admin",$_POST["ida"]);
			$this->session->set_userdata("username_admin",$_POST["usernameAdmin"]);
			$this->session->set_userdata("latlong",$_POST["latlong"]);
			// $this->session->unset_userdata("user_all_location");
		} else {
			$status["message"] = $this->config->item("error_update_loc");
		}
		echo json_encode($status);
	}
	
	public function getAllAdmin() {
		$lat = $_POST["lat"];
		$long = $_POST["long"];
		if($lat !== "" && $long !== "") {
			$data = $this->UserModel->getAllAdmin($lat,$long);
		} else {
			$data["status"] = false;
			$data["status_string"] = "empty latlong";
		}
		echo json_encode($data);
	}
	public function changeLocation(){
        $this->load->template("change_place",array());
    }
}
