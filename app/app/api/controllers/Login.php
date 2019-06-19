<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {
	public function __construct(){
		parent::__construct();	
		$this->load->model("Users");
		$this->load->library('form_validation');
	}
	public function index()
	{
        header('Access-Control-Allow-Origin: *');

        $this->form_validation->set_rules("email","Email","required");
		$this->form_validation->set_rules("password","Password","required");
		$this->form_validation->set_error_delimiters('','. ');
		if($this->form_validation->run()==TRUE){
			$username=$this->input->post("email");
			$password=$this->input->post("password");
			$status=$this->Users->login($username,$password);
			if($status){
				$status=$status;
			}else{
				$status['status']=false;
				$status['message']="Invalid Email and Password";
			}
		}else{
			$status['status']=false;
			$status['message']=validation_errors();
		}
		echo json_encode($status);
	}
	public function sosmedLogin(){
		
	}
}
