<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {
	public function __construct(){
		parent::__construct();	
		$this->load->model("Users");
		$this->load->library('form_validation');
	}
	public function index()
	{
		
	}
	public function forgot_password(){
        header('Access-Control-Allow-Origin: *');

        $email = $_POST["email"];
		$status=$this->Users->forgotPassword($email);
		echo json_encode($status);
	}
	public function change_password(){
        header('Access-Control-Allow-Origin: *');

        $this->form_validation->set_rules("token","Token","required");
		$this->form_validation->set_rules("password","Password","required");
		$this->form_validation->set_error_delimiters('','\n');
		if($this->form_validation->run()==TRUE){
			$password=$this->input->post("password");
			$token=$this->input->post("token");
			$status=$this->Users->changePassword($token,$password);
		}else{
			$status['status']=false;
			$status['message']=validation_errors();
		}
		echo json_encode($status);
	}
	public function updateLocation(){
        header('Access-Control-Allow-Origin: *');

        $token=$_POST['token'];
		$location_name=$_POST['location_name'];
		$data=array(
				'location_name'=>$location_name
			);
//			$photo=$this->input->post("photo");
		$status=$this->Users->editProfile($data,$token);
		echo json_encode($status);
	}
	public function get_genre() {
        header('Access-Control-Allow-Origin: *');

        $token=$_POST['token'];
		if(isset($token)){
			$status=$this->Users->music_genre($token);
		}else{
			$status['status']=false;
			$status['message']="Token is required";
		}
		echo json_encode($status);
	}
	
	public function edit_profile(){
        header('Access-Control-Allow-Origin: *');

        $this->form_validation->set_rules("token","Token","required");
		$this->form_validation->set_rules("email","Email","required");
		$this->form_validation->set_rules("username","Username","required");
		$this->form_validation->set_error_delimiters('','\n');
		if($this->form_validation->run()==TRUE){
			$email=$this->input->post("email");
			$token=$this->input->post("token");
			$food = $this->input->post("food");
			$drink = $this->input->post("drink");
			$hangout_place = $this->input->post("hangout_place");
			$music_genre = $this->input->post("music_genre");
			$bio = $this->input->post("bio");
			$username=$this->input->post("username");
			$data=array(
				'email'=>$email,
				'username'=>$username,
				'drink'=>$drink,
				'food'=>$food,
				'hangout_place'=>$hangout_place,
				'music_genre'=>$music_genre,
				'bio'=>$bio
			);
//			$photo=$this->input->post("photo");
			$status=$this->Users->editProfile($data,$token);
		}else{
			$status['status']=false;
			$status['message']=validation_errors();
		}
		echo json_encode($status);
	}
	public function profile(){
        header('Access-Control-Allow-Origin: *');

        $token=$_GET['token'];
		if(isset($token)){
			$status=$this->Users->detail($token);
		}else{
			$status['status']=false;
			$status['message']="Token is required";
		}
		echo json_encode($status);
	}
	public function detail(){
        header('Access-Control-Allow-Origin: *');

        $token=$_POST['token'];
		$user_id=$_POST['user_id'];
		if(isset($_POST['loc'])){
			$loc=$_POST['loc']; 
		}else{
			$loc=NULL;
		}
		if(isset($token)){
			$status=$this->Users->detailOthers($user_id,$token,$loc);
		}else{
			$status['status']=false;
			$status['message']="Token is required";
		}
		echo json_encode($status);
	}
	public function check_token(){
        header('Access-Control-Allow-Origin: *');

        $token=$_GET['token'];
		if(isset($token)){
			$status=$this->Token->check_tokens($token);
		}else{
			$status['status']=false;
			$status['message']="Token is required";
		}
		echo json_encode($status);
	}
	public function getsAdmin(){
        header('Access-Control-Allow-Origin: *');

        $lat = $_POST["lat"];
		$long = $_POST["long"];
		$token = $_POST["token"];
		$status=$this->Users->getLocations($lat,$long,$token);
		echo json_encode($status);
	}
	public function follow(){
        header('Access-Control-Allow-Origin: *');

        $user_id = $_POST["user_id"];
		$token = $_POST["token"]; 
		$status=$this->Users->followUser($token,$user_id);
		echo json_encode($status);
	}
	public function unfollow(){
        header('Access-Control-Allow-Origin: *');

        $user_id= $_POST["user_id"];
		$token = $_POST["token"];
		$status=$this->Users->unfollowUser($token,$user_id);
		echo json_encode($status);
	}
	public function SosmedLogin(){
        header('Access-Control-Allow-Origin: *');

        $email = $_POST['email'];
		$username = $_POST['name'];
		$image = $_POST['image'];
		if($email==""){
			$status['message'] ="No Email Provided. Update Your Social Network Data !";
			$status['status'] = false;
		}else {
			$status=$this->Users->SosmedLogin($username,$email,$image);
		}
		echo json_encode($status);
	}
	public function savePlaylist(){
        header('Access-Control-Allow-Origin: *');
        $data = array(
            'playlist_name'=>$_POST["playlist_name"]
        );
        $token = $_POST["token"];
        $status=$this->Users->savePlaylist($token,$data);
        echo json_encode($status);
    }
    public function getPlaylist(){
        header('Access-Control-Allow-Origin: *');
        $token = $_GET["token"];
        $status=$this->Users->getPlaylist($token);
        echo json_encode($status);
    }
    public function deletePlaylist(){
        header('Access-Control-Allow-Origin: *');
        $token=$this->input->post('token');
        $status=array();
        $id=$this->input->post('playlist_id');
        $del=$this->Users->deletePlaylist($token,$id);
        echo json_encode($del);
    }
    public function updatePlaylist(){
        header('Access-Control-Allow-Origin: *');
        $token=$this->input->post('token');
        $id=$this->input->post('playlist_id');
        $data=array(
            'playlist_name'=>$this->input->post('name')
        );
        $up=$this->Users->updatePlaylist($token,$data,$id);
        echo json_encode($up);
    }
    public function addItem(){
        header('Access-Control-Allow-Origin: *');
        $token=$this->input->post('token');
        $data=array(
            'track_id'=>$this->input->post('track_id'),
            'link'=>$this->input->post('link'),
            'title'=>$this->input->post('title'),
            'playlist_id'=>$this->input->post('playlist_id')
        );
        $addPlaylistItem=$this->Users->addPlaylistItem($token,$data);
        echo json_encode($addPlaylistItem);
        // unset($data['track_id']);
        // unset($data['link']);
        // unset($data['title']);
        // unset($data['playlist_id']);
        // unset($data);
        // $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate");

    }
    public function deleteItem(){
        header('Access-Control-Allow-Origin: *');
        $token=$this->input->post('token');
        $playlist_id=$this->input->post('playlist_id');
        $link=$this->input->post('link');
        $deletePlaylistItem=$this->Users->deletePlaylistItem($token,$link,$playlist_id);
        echo json_encode($deletePlaylistItem);
    }
    public function getPlaylistUserItem($id){
        header('Access-Control-Allow-Origin: *');
        $token=$this->input->post('token');
        $getPlaylistItem=$this->Users->getPlaylistItem($token,$id);
        echo json_encode($getPlaylistItem);
    }
}
