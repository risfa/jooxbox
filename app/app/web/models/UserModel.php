<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {
	public function __construct(){
		parent::__construct();
		$config = Array(
				'protocol' => 'smtp',
				'smtp_crypto' => "tls",
				'smtp_host' => "smtp.gmail.com",
				'smtp_port' => 587,
				'smtp_user' => "explore@limadigit.com",
				'smtp_pass' => "5d3xpl0r3",
				'mailtype' => 'html',
				'charset' => 'iso-8859-1',
				'wordwrap' => TRUE,
				'newline' => "\r\n"
			);
		$this->load->library("calculate");
		$this->load->library("email",$config);
		$this->load->helper('file');
	}
	public function login($username,$password){
		$this->db->where('email',$username);
		$this->db->where('password',$password);
		$query=$this->db->get('tbl_user');
		$this->data = array();
		if($query->num_rows()>0){
			$this->setlogin(true);
			$user=$query->row();
			$this->setData('id',$user->user_id);
			$this->setData('username',$user->username);
			$this->setData('email',$user->email);
			$this->setData('image',$user->twitter_image);
			$this->setData('flag_email',$user->flag_email);
			$this->setData('bio',$user->bio);
			$this->setData('hangout_place',$user->hangout_place);
			$this->setData('address',$user->address);
			// $this->setData('gender',$user->gender);
			$this->setData('food',$user->food);
			$this->setData('music_genre',$user->music_genre);
			$this->setData('drink',$user->drink);
			$this->setData('admin',false);
			$this->db->where("user_id",$user->user_id);
			$this->db->update('tbl_user',["last_login" => date("Y-m-d H:i:s"), "flag_login" => 1]);
			if($user->register_as == "admin") {
				$this->setData('admin',true);
				$latlong=explode('#',$user->latlong);
                $this->setData('lat',$latlong[0]);
                $this->setData('long',$latlong[1]);
				$this->data["status"] = true;
				$this->data["isAdmin"] = $this->getData('admin');
			} else {
				$this->data["status"] = true;
				$this->data["status_string"] = $this->config->item("success");
				$this->data["isAdmin"] = $this->getData('admin');
			}
		}else{
			$this->setlogin(false);
			$this->data["status"] = false;
			$this->data["status_string"] = $this->config->item("wrong_username_or_password");
		}
		// print_r($this->data);die;
		return $this->data;
	}

	public function getAllAdmin($latitude,$longitude) {
		$this->db->where("flag_login",1);
		$this->db->where("register_as","admin");
		$query=$this->db->get('tbl_user');
		$data_distance = array();
		$data = array();
		if($query->num_rows() > 0) {
			foreach($query->result_array() as $val) {
				$expVal = explode("#",$val["latlong"]);
				$latAdmin = $expVal[0];
				$longAdmin = $expVal[1];
				if($latitude !== "" && $longitude !== "") {
					$distance = round($this->calculate->distance($latAdmin,$longAdmin,$latitude,$longitude),2);
					if($distance <= 1000) { //1000 in meters
						$data_distance[$val["location_name"]] = $distance . "#" . $val["user_id"] . "#" . $val["username"] . "#" . $val["latlong"];
					}
				}
			}
			if(empty($data_distance)) {
				$data['all_location'] = array();
				$data["status"] = false;
				$data["status_string"] = $this->config->item("no_server");
			} else {
				$data['all_location'] = $data_distance;
				$data["status"] = true;
				$data["status_string"] = $this->config->item("success");
			}
		} else {
			$data["status"] = false;
			$data["status_string"] = $this->config->item("no_server");
		}
		return $data;
	}

	public function updateLocation($location, $user_id) {
		$this->db->where("user_id",$user_id);
		$resultUpdate = $this->db->update("tbl_user",["location_name"=>$location]);
		return $resultUpdate;
	}

	public function islogin(){
		$data=$this->session->get_userdata();
		if(isset($data['is_login'])){
			return $data['is_login'];
		}else{
			return false;
		}
	}
	public function logout(){
		$this->db->where("user_id",$this->session->userdata("user_id"));
		$this->db->update('tbl_user',["flag_login" => 0]);
		$this->session->sess_destroy();
	}
	public function setlogin($val){
		$this->session->set_userdata('is_login',$val);
	}
	public function setData($key,$val){
		$this->session->set_userdata('user_'.$key,$val);
	}
	public function getData($key){
		$data=$this->session->get_userdata();
		return $data['user_'.$key];
	}
	public function register($data){
		$data['verification_code']=md5(uniqid());
		$check=$this->checkEmail($data['email']);
		if($check){
			$status['status']=true;
			$this->db->insert('tbl_user',$data);
			// if($data['register_as']=="admin"){
				// write_file('./assets/chat/'.$this->db->insert_id().".txt", "");
			// }
			$this->registerMail($data['email'],$data['register_as'],$data['verification_code']);

		}else{
			$status['status']=false;
			$status['message']= $this->config->item("email_already_exist");
		}
		return $status;
	}
	public function checkEmail($email){
		$this->db->where('email',$email);
		$query=$this->db->get('tbl_user');
		if($query->num_rows()>0){
			return false;
		}else{
			return true;
		}
	}

	// buat forgot password
	public function updateUniqueCode($email, $uniqueCode) {
		$this->db->where("email",$email);
		$update = $this->db->update("tbl_user",array("unique_code" => $uniqueCode));
		if($update) {
			return true;
		} else {
			return false;
		}
	}

	public function getUserDataFromEmail($email) {
		$this->db->where('email',$email);
		$query=$this->db->get('tbl_user');
		$data = array();
		if($query->num_rows()>0){
			$data["user"] = (array) $query->row();
			$data["status"] = true;
		}else{
			$data["user"] = array();
			$data["status"] = false;
		}
		return json_encode($data);
	}

	public function getUserDataFromCode($code) {
		$this->db->where('unique_code',$code);
		$query=$this->db->get('tbl_user');
		$data = array();
		if($query->num_rows()>0){
			$data["user"] = (array) $query->row();
			$data["status"] = true;
		}else{
			$data["user"] = array();
			$data["status"] = false;
		}
		return json_encode($data);
	}

	public function createNewPassword($pass,$userId) {
		$this->db->where("user_id",$userId);
		$update = $this->db->update("tbl_user",array("password" => md5($pass)));
		if($update) {
			return true;
		} else {
			return false;
		}
	}
	// end forgot password

	public function checkValidationCode($verification_code) {
		$this->db->where("verification_code",$verification_code);
		$query = $this->db->get("tbl_user");
		if($query->num_rows() > 0) {
			$user = $query->row();
			$this->db->where("user_id",$user->user_id);
			$update = $this->db->update("tbl_user",array("flag_email" => 1));
			if($update) {
				return true;
			} else {
				return false;
			}
		} else {
			return false;
		}
	}
	public function registerMail($email,$statusUser,$code){
		$emailsubject = $this->config->item('subjectEmailConfirmation');
		$content =  $this->config->item('contentEmailConfirmation');
		$search=array(
			'[user]','[uniqueid]'
		);
		$replace=array(
			$statusUser,$code
		);
		$content =str_replace($search,$replace,$content);
		$this->sendMail($email,$emailsubject,$content);
	}
	public function sendMail($to,$subject,$message){
		$this->email->from($this->config->item('from_email'), $this->config->item('from_email_name'));
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->send();
		// echo $this->email->print_debugger();
	}
	public function updateData($data,$id){
		$username=$this->getData('username');
		$this->db->where('user_id',$id);
		$query=$this->db->update('tbl_user',$data);
		if($query){
			$this->db->query("UPDATE tbl_playlist set createby = '".$data['username']."' where user_id = '".$id."'");
			$this->db->query("UPDATE tbl_top10player set name = '".$data['username']."' where user_id = '".$id."'");
			$this->setData('username',$data['username']);
			$this->setData('bio',$data['bio']);
			$this->setData('hangout_place',$data['hangout_place']);
			$this->setData('food',$data['food']);
			$this->setData('music_genre',$data['music_genre']);
			$this->setData('drink',$data['drink']);
			if(isset($data["address"])) $this->setData('address',$data['address']);
			return true;
		}else{
			return false;
		}
	}
	public function SosmedLogin($username,$email,$image){
		$this->db->where('email',$email);
		$query=$this->db->get('tbl_user');
		// user register
		if($query->num_rows()>0){
			//login
			return $this->login($email,$query->row()->password);
		}else{
			if($image == "undefined") $image = "images/user.jpg";
			$data=array(
				'username'=>$username,
				'email'=>$email,
				'twitter_image'=>$image,
				'flag_email'=>'1'
			);
			//register & login
			$this->db->insert('tbl_user',$data);
			return $this->login($email,'');
		}
	}
	public function updatePhoto($data){
		$this->db->trans_begin();
		$this->db->where('user_id',$this->session->userdata('user_id'));
		$this->db->update('tbl_user',$data);
		$this->db->where('createby',$this->session->userdata('user_username'));
		$this->db->update('tbl_playlist',$data);
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}else{
			$this->db->trans_commit();
			return true;
		}
	}
	public function changePassword($oldpass,$newpassword,$retype,$id){
			$this->db->where('user_id',$id);
			$this->db->where('password',md5($oldpass));
			$query=$this->db->get('tbl_user');
			if($query->num_rows()>0){
				if($newpassword==$retype){
					$data=array(
						'password'=>md5($newpassword)
					);
					$this->db->where('user_id',$id);
					$this->db->update('tbl_user',$data);
					$status['status']=true;
					$status['message']= $this->config->item("success_change_pass");
				}else{
					$status['status']=false;
					$status['message']= $this->config->item("password_not_match");
				}
			}else{
				$status['status']=false;
				$status['message']=$this->config->item("wrong_old_pass");
			}
			return $status;
	}
	public function detail($id){
		$this->db->where('user_id',$id);
		$this->db->select('user_id,username,music_genre,drink,twitter_image,bio,food,hangout_place');
		$get=$this->db->get('tbl_user');
		if($get->num_rows()>0){
			return $get->row();
		}else{
			return false;
		}
	}
	public function recentSong($id,$loc){
		$get=$this->db->query("SELECT * FROM (SELECT * FROM `tbl_playlist` WHERE play = 1 and user_id = '".$id."' and location = '".$loc."' ORDER BY playlist_id DESC) AS t GROUP BY title ORDER BY playlist_id DESC LIMIT 10");
		if($get->num_rows()>0){
			return $get->result_array();
		}else{
			return false;
		}
	}
	public function follow($id) {
		$this->db->where("user_id",$id);
		$this->db->select("follower_id");
		$follower = $this->db->get("tbl_relationship");
		if($follower->num_rows() > 0) {
			$data["follower_count"] = $follower->num_rows();
			foreach($follower->result_array() as $val) {
				$data["follower_data"][] = $val["follower_id"];
			}
		} else {
			$data["follower_count"] = 0;
			$data["follower_data"] = array();
		}
		$this->db->where("follower_id",$id);
		$this->db->select("user_id");
		$following = $this->db->get("tbl_relationship");
		if($following->num_rows() > 0) {
			$data["following_count"] = $following->num_rows();
			foreach($following->result_array() as $val) {
				$data["following_data"][] = $val["user_id"];
			}
		} else {
			$data["following_count"] = 0;
			$data["following_data"] = array();
		}
		return $data;
	}
	public function isLoginAdmin($id) {
		$this->db->where('user_id',$id);
		$this->db->select('flag_login');
		$get=$this->db->get('tbl_user');
		if($get->num_rows()>0){
			return $get->row();
		}else{
			return false;
		}
	}
	public function getAllAdminHome() {
		//$this->db->where("flag_login",1);
		$this->db->where("register_as","admin");
		$query=$this->db->get('tbl_user');
		$data_distance = array();
		$data = array();
		if($query->num_rows() > 0) {
			foreach($query->result_array() as $val) {
				$status=array();
				$new_data=array();
				$expVal = explode("#",$val["latlong"]);
				$latAdmin = $expVal[0];
				$longAdmin = $expVal[1];//tanda
				$new_data[]=$val["location_name"];
				$new_data[]=(double)$latAdmin;
				$new_data[]=(double)$longAdmin;
				$status['location_data']=$new_data;
				if(is_null($val["address"])){
					$status['desc']="-";
				}else{
					$status['desc']=$val["address"];
				}
				$status['type_admin']=$val["type_admin"];
				$data[]=$status;
			}
		}
		return $data;
	}
	public function prevWeekChart($loc) {
		$this->db->where("location",$loc);
		$query=$this->db->get('tbl_prev_week_chart');
		if($query->num_rows() > 0) {
			return $query->result_array();
		} else {
			return array();
		}
	}
}
