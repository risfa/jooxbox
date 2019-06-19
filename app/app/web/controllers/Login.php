<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Login extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->library('Mobile_Detect');
		$this->load->model("UserModel");
	}
	public function index()
	{
		$login=$this->UserModel->islogin();
		if($login) {
			redirect(site_url().'/home');
		} else {
			$detect = new Mobile_Detect();
 			$data['user_home']=site_url();
			$data['flag'] = "login";
			if ( $detect->isMobile() ) {
 				$this->load->template_mobile('login',$data);
			} else {
				$this->load->template('login',$data);
			}
		}
	}
	
	public function process(){
		$status=array();
		$this->form_validation->set_rules("username","Email","required");
		$this->form_validation->set_rules("password","Password","required");
		$this->form_validation->set_error_delimiters('','<br/>');
		if($this->form_validation->run()==TRUE){
			$username=$this->input->post("username");
			$password=md5($this->input->post("password"));
			$login=$this->UserModel->login($username,$password);
			if($login["status"]){
				$status['status']=true;
				$status['isAdmin']= $login["isAdmin"];
			}else{
				$status['status']=false;
				$status['message']=$login["status_string"];
			}
		}else{
			$status['status']=false;
			$status['message']=validation_errors();
		}
		echo json_encode($status);
	}
	
	public function pathLogin() {
		$code = $_GET["code"];
		$url = $this->config->item("path_oauth");
		$postData = array(
							"grant_type" => "authorization_code",
							"client_id" => $this->config->item('path_client_id'),
							"client_secret" => $this->config->item('path_client_secret'),
							"code" => $code
						);
		$curl = new Curl\Curl();
		$curl->setOpt(CURLOPT_POST, true);
		$curl->setOpt(CURLOPT_RETURNTRANSFER, TRUE);
		$curl->setOpt(CURLOPT_SSL_VERIFYPEER, false);
		$output = $curl->post($url,$postData);
		if($curl->error) {
			echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage;
		} else {
			$url = $this->config->item("path_url_get_me");
			$curl->setOpt(CURLOPT_HTTPHEADER, array(
							'Authorization: Bearer '.$output->access_token,
							'Content-Type: application/json',
						));
			$return = $curl->get($url);
			if($curl->error) {
				echo 'Error: ' . $curl->errorCode . ': ' . $curl->errorMessage;
			} else {
				$this->session->set_userdata("path_name",$return->user->name);
				$this->session->set_userdata("path_image",$return->user->photo->medium->url);
				$this->session->set_userdata("path_email",$return->user->email);
				$this->close_method();
			}
		}
	}
	
	public function close_method(){
		$return = site_url()."/login";
	    echo "<script type='text/javascript'>";
	    echo "window.opener.location.href='$return';";
	    echo "window.close();";
	    echo "</script>";
	}
	
	public function SosmedLogin(){
		$email = $_POST['email'];
		$username = $_POST['name'];
		$image = $_POST['image'];
		// $lat = $_POST["lat"];
		// $long = $_POST["long"];
		// $latlong = $lat."#".$long;
		$from = $_POST["from"];
		if($from == "path") {
			$this->session->unset_userdata("path_name");
			$this->session->unset_userdata("path_image");
			$this->session->unset_userdata("path_email");
		}
		if($email==""){
			$status['message'] = $this->config->item("no_email");
			$status['status'] = false;
		}else {
			$status=$this->UserModel->SosmedLogin($username,$email,$image);
		}
		echo json_encode($status);
	}
	
	public function logout(){
		$this->UserModel->logout();
		redirect(site_url().'/login');
	}
}
