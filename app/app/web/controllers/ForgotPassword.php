<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ForgotPassword extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("UserModel");
		$this->load->library('Mobile_Detect');
	}
	public function index()
	{
		// $detect = new Mobile_Detect();
		$data['user_home']=site_url();
		// if ( $detect->isMobile() ) {
			// $data['flag'] = "register";
			// $this->load->template_mobile('register',$data);
		// } else {
			$data['flag'] = "forgot";
			$this->load->template('forgotpassword',$data);
		// }
	}
	public function changePassword() {
		$type = isset($_POST["type"]) ? $_POST["type"] : "";
		switch($type) {
			case "add":
					$mail = isset($_POST["mail"]) ? $_POST["mail"] : false;
					if($mail !== false) {
						$cekMail = json_decode($this->UserModel->getUserDataFromEmail($mail),true);
						if($cekMail["status"]) {
							$uniqueCode = md5($mail.date("Y-m-d H:i:s"));
							$update = $this->UserModel->updateUniqueCode($mail, $uniqueCode);
							if(!$update) {
								$result["error"] = true;
								$result["error_string"] = "update failed";
								$result["request_type"] = "add";
							} else {
								$contentResetPass = preg_replace("/\[code\]/",$uniqueCode,$this->config->item("contentResetPass"));
								$contentResetPass = preg_replace("/\[user\]/",$cekMail["user"]['username'],$contentResetPass);
								$mail = $this->UserModel->sendMail($mail,$this->config->item('subjectResetPass'),$contentResetPass);
								$result["error"] = false;
								$result["error_string"] = "update success";
								$result["request_type"] = "add";
							}
						} else {
							$result["error"] = true;
							$result["error_string"] = "mail not found";
							$result["request_type"] = "add";
						}
					} else {
						$result["error"] = true;
						$result["error_string"] = "empty email";
						$result["request_type"] = "add";
					}
				break;
			
			case "edit":
					$uid = isset($_POST["uid"]) ? $_POST["uid"] : false;
					$pass = isset($_POST["pass"]) ? $_POST["pass"] : false;
					if($uid !== false && $pass !== false) {
						$update = $this->UserModel->createNewPassword($pass,$uid);
						if($update) {
							$result["error"] = false;
							$result["error_string"] = "update success";
							$result["request_type"] = "edit";
						} else {
							$result["error"] = true;
							$result["error_string"] = "update failed";
							$result["request_type"] = "edit";
						}
					} else {
						$result["error"] = true;
						$result["error_string"] = "param not complete";
						$result["request_type"] = "edit";
					}
				break;
			
			default:
					$result["error"] = true;
					$result["error_string"] = "empty type";
				break;
		}
		
		echo json_encode($result);
	}
}
