<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("UserModel");
		$this->load->library('Mobile_Detect');
	}
	public function index()
	{
		$login=$this->UserModel->islogin();
		if($login){
			redirect(site_url().'/home');
		}else{
			$detect = new Mobile_Detect();
			$data['user_home']=site_url();
			if ( $detect->isMobile() ) {
				$data['flag'] = "register";
				$this->load->template_mobile('register',$data);
			} else {
				$data['flag'] = "register";
				$this->load->template('register',$data);
			}
		}
	}
	public function process(){
		$cap=$this->input->post('g-recaptcha-response');
		$capResponse=$this->checkCap($cap);
		$statusUser=$this->input->post("status");
		if($capResponse['success']){
			$this->form_validation->set_rules("username","Username","required");
			$this->form_validation->set_rules("password","Password","required");
			$this->form_validation->set_rules("email","Email","required");
			
			$this->form_validation->set_rules("status","status","required");
			if($statusUser == "admin") {
				$this->form_validation->set_rules("address","address","required");
				$this->form_validation->set_rules("lat","Latitude","required");
				$this->form_validation->set_rules("long","Longitude","required");
			}
			$this->form_validation->set_rules("cpassword","Password Confirmation","required");
			$this->form_validation->set_error_delimiters('','<br/>');
			if($this->form_validation->run()==TRUE){
				$username=$this->input->post("username");
				$password=$this->input->post("password");
				$cpassword=$this->input->post("cpassword");
				$email=$this->input->post("email");
				$latlong=$this->input->post("lat").'#'.$this->input->post("long");
				if($statusUser == "admin") {
					$address=$this->input->post("address");
					$image = "images/jukebox-admin.png";
				} else{
					$image = "images/user.jpg";
				}
				if($password==$cpassword){
					$data=array(
						"email"=>$email,
						"username"=>$username,
						"password"=>md5($password),
						"twitter_image"=>$image,
						"latlong"=>$latlong,
						"register_as"=>$statusUser,
						"food"=>"[]",
						"drink"=>"[]",
						"hangout_place"=>"[]",
						"music_genre"=>"[]",
						"created_date"=>date("Y-m-d H:i:s")
					);
					if($statusUser == "admin"){
						$data["location_name"] = $username;
						$data["address"] = $address;
					}
					$status=$this->UserModel->register($data);
				}else{
					$status['status']=false;
					$status['message']= $this->config->item("password_regis_not_match");
				}
			}else{
				$status['status']=false;
				$status['message']=validation_errors();
			}
		}else{
			$status['status']=false;
			$status['message']=$this->config->item("invalid_captcha");
		}
		echo json_encode($status);
	}
	private function checkCap($response){
		$curl = new Curl\Curl();
		$recaptchaResponse = trim($response);
		$userIp=$this->input->ip_address();
		$secret=$this->config->item("recaptcha_secret");
		$url="https://www.google.com/recaptcha/api/siteverify?secret=".$secret."&response=".$recaptchaResponse."&remoteip=".$userIp;
		$cpa = $curl->get($url);
		if ($curl->error) {
			$status['success']=true;
			$status['message']=$curl->errorMessage;
			return $status;
		} else {
			return (array) $cpa;
		}
	}
	
	public function confirmation() {
		$u = (isset($_GET["u"])) ? $_GET["u"] : "";
		if($u != "") {
			$check = $this->UserModel->checkValidationCode($u);
			if($check) {
				$data['flag'] = "confirm";
				$this->load->template("confirmation", $data);
			} else {
				redirect(site_url().'/login');
			}
		} else {
			redirect(site_url().'/login');
		}
	}
}
