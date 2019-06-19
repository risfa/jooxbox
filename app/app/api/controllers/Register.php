<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Register extends CI_Controller {
	public function __construct(){
		parent::__construct();	
		$this->load->library('form_validation');
		$this->load->model("Users");
	}
	public function index()
	{
        header('Access-Control-Allow-Origin: *');

        $this->form_validation->set_rules("username","Username","required");
		$this->form_validation->set_rules("password","Password","required");
		$this->form_validation->set_rules("email","Email","required");
		$this->form_validation->set_rules("cpassword","Password Confirmation","required");
		$this->form_validation->set_error_delimiters('','\n');
		if($this->form_validation->run()==TRUE){
			$username=$this->input->post("username");
			$password=$this->input->post("password");
			$cpassword=$this->input->post("cpassword");
			$email=$this->input->post("email");
			$image = "images/user.jpg";
			if($password==$cpassword){
				$data=array(
					"email"=>$email,
					"username"=>$username,
					"password"=>md5($password),
                    "food"=>"[]",
                    "drink"=>"[]",
                    "hangout_place"=>"[]",
                    "music_genre"=>"[]",
					"twitter_image"=>$image
				);
				$status=$this->Users->register($data);
			}else{
				$status['status']=false;
				$status['message']="Password does not match";
			}
		}else{
			$status['status']=false;
			$status['message']=validation_errors();
		}
		echo json_encode($status);
	}
}
