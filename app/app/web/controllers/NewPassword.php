<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class NewPassword extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("UserModel");
		$this->load->library('Mobile_Detect');
	}
	public function index()
	{
		$code = (isset($_GET["code"])) ? $_GET["code"] : "";
		if($code != "") {
			$data = array();
			$user = json_decode($this->UserModel->getUserDataFromCode($code),true);
			if($user["status"]) {
				$data["user_id"] = $user["user"]["user_id"];
				$data['flag'] = "newPass";
				$this->load->template('newpassword',$data);				
			} else {
				redirect(site_url().'/login');
			}
		} else {
			redirect(site_url().'/login');
		}
	}
}