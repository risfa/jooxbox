<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("UserModel");
		$this->load->model("UserPlaylist");
		$this->load->library('Mobile_Detect');
		header('Access-Control-Allow-Origin: *');

	}
	public function index()
	{
		$login=$this->UserModel->islogin();
		$loc=$this->session->userdata('user_id_admin');
		if($login){
			$data['user_logout']=site_url()."/login/logout";
			$data['username']=$this->getData('username');
			$admin=$this->getData('admin');
			$data['image']=$this->getData('image');
				if($admin) {
					$data['status']="admin";
					$data['id']=$this->getData('id');
					$data['loc_id']=$this->getData('id');
					$data['flag'] = "homeAdminResp";
					$this->load->template('playlistAdmin',$data);
				} else {
					$data['status']="user";
					$data['id']=$this->getData('id');
					$data['loc_id']=$this->getData('id_admin');
					$detect = new Mobile_Detect();
					if($loc!=""){
						if ( $detect->isMobile() ) {
			 				$data['user_home']=site_url();
							$data["isAndroid"] = $detect->isAndroidOS();
			 				$this->load->template_mobile_with_menu('mobile/homeUser',$data);
						} else {
							$data['prev_week_chart'] = $this->UserModel->prevWeekChart($data["loc_id"]);
							// if($this->input->ip_address() == "202.158.42.163") {
								// if($this->session->userdata('user_id')=="4"){
									// $data['user_home']=site_url();
									// $data["isAndroid"] = $detect->isAndroidOS();
					 				// $this->load->template_mobile_with_menu('mobile/homeUser',$data);
								// }else{
									// $data['user_home']=site_url();
									// $data["isAndroid"] = true;
									// $this->load->template('homeUser2',$data);	
								// }
								$data['user_home']=site_url();
								$data["isAndroid"] = $detect->isAndroidOS();
								// $this->load->template('homeUser2',$data);
							// } else {
								$this->load->template('homeUser',$data);				
							// }
						}
					}else{
						redirect(site_url().'/place');
					}
				}
		}else{
			redirect(site_url().'/login');
		}
	}
	
	public function getData($key){
		return $this->session->userdata('user_'.$key);
	}
	public function ManagePlaylist(){
		
	}
	
	public function WeeklyTrends() {
		$login=$this->UserModel->islogin();
		$loc=$this->session->userdata('user_id_admin');
		if($login){
			$data['user_logout']=site_url()."/login/logout";
			$data['username']=$this->getData('username');
			$admin=$this->getData('admin');
			if($loc!=""){
				if($admin){
					$data['status']="admin";
					$data['id']=$this->getData('id');
					$data['loc_id']=$this->getData('id');
				}else{
					$data['status']="user";
					$data['id']=$this->getData('id');
					$data['loc_id']=$this->getData('id_admin');
				}
				$data['image']=$this->getData('image');
				if($this->session->userdata("user_admin")) {
					$this->load->template('homeAdmin',$data);
				} else {
					$detect = new Mobile_Detect();
					if ( $detect->isMobile() ) {
		 				$data['user_home']=site_url();
						$data["isAndroid"] = $detect->isAndroidOS();
		 				$this->load->template_mobile_with_menu('mobile/weeklyTrends',$data);
					} else {
						$this->load->template('homeUser',$data);				
					}
				}
			}else{
				redirect(site_url().'/place');
			}
		}else{
			redirect(site_url().'/login');
		}
		
	}
	
	public function RecentSong(){
		
		$login=$this->UserModel->islogin();
		$loc=$this->session->userdata('user_id_admin');
		if($login){
			$data['user_logout']=site_url()."/login/logout";
			$data['username']=$this->getData('username');
			$admin=$this->getData('admin');
			if($loc!=""){
					
				if($admin){
					$data['status']="admin";
					$data['id']=$this->getData('id');
					$data['loc_id']=$this->getData('id');
				}else{
					$data['status']="user";
					$data['id']=$this->getData('id');
					$data['loc_id']=$this->getData('id_admin');
				}
				$data['image']=$this->getData('image');
				if($this->session->userdata("user_admin")) {
					$this->load->template('playlistAdmin',$data);
				} else {
					$detect = new Mobile_Detect();
					if ( $detect->isMobile() ) {
		 				$data['user_home']=site_url();
						$data["isAndroid"] = $detect->isAndroidOS();
		 				$this->load->template_mobile_with_menu('mobile/recentSong',$data);
					} else {
						// if($this->session->userdata("user_username") == "arwinapel") {
							// $data['user_home']=site_url();
							// $data["isAndroid"] = true;
							// $this->load->template_mobile_with_menu('mobile/recentSong',$data);
						// } else {								
							// $this->load->template('recentSong',$data);				
						// }
						$this->load->template('homeUser',$data);				
					}
				}
			}else{
				redirect(site_url().'/place');
			}
		}else{
			redirect(site_url().'/login');
		}
		
	}
	
	public function MostRequest(){
		
		$login=$this->UserModel->islogin();
		$loc=$this->session->userdata('user_id_admin');
		if($login){
			$data['user_logout']=site_url()."/login/logout";
			$data['username']=$this->getData('username');
			$admin=$this->getData('admin');
			if($loc!=""){
					
				if($admin){
					$data['status']="admin";
					$data['id']=$this->getData('id');
					$data['loc_id']=$this->getData('id');
				}else{
					$data['status']="user";
					$data['id']=$this->getData('id');
					$data['loc_id']=$this->getData('id_admin');
				}
				$data['image']=$this->getData('image');
				if($this->session->userdata("user_admin")) {
					$this->load->template('playlistAdmin',$data);
				} else {
					$detect = new Mobile_Detect();
					if ( $detect->isMobile() ) {
		 				$data['user_home']=site_url();
						$data["isAndroid"] = $detect->isAndroidOS();
		 				$this->load->template_mobile_with_menu('mobile/mostRequest',$data);
					} else {
						if($this->session->userdata("user_username") == "herospalada") {
							$data['user_home']=site_url();
							$data["isAndroid"] = true;
							$this->load->template_mobile_with_menu('mobile/mostRequest',$data);
						} else {								
							$this->load->template('homeUser',$data);				
						}
						// $this->load->template('homeUser',$data);				
					}
				}
			}else{
				redirect(site_url().'/place');
			}
		}else{
			redirect(site_url().'/login');
		}
		
	}
	
	public function ChatLounge(){
		
		$login=$this->UserModel->islogin();
		$loc=$this->session->userdata('user_id_admin');
		if($login){
			$data['user_logout']=site_url()."/login/logout";
			$data['username']=$this->getData('username');
			$admin=$this->getData('admin');
			if($loc!=""){
					
				if($admin){
					$data['status']="admin";
					$data['id']=$this->getData('id');
					$data['loc_id']=$this->getData('id');
				}else{
					$data['status']="user";
					$data['id']=$this->getData('id');
					$data['loc_id']=$this->getData('id_admin');
				}
				$data['image']=$this->getData('image');
				if($this->session->userdata("user_admin")) {
					$this->load->template('playlistAdmin',$data);
				} else {
					$detect = new Mobile_Detect();
					if ( $detect->isMobile() ) {
		 				$data['user_home']=site_url();
						$data["isAndroid"] = $detect->isAndroidOS();
		 				$this->load->template_mobile_with_menu('mobile/chatLounge',$data);
					} else {
						// if($this->session->userdata("user_username") == "herospalada") {
							// $data['user_home']=site_url();
							// $data["isAndroid"] = true;
							// $this->load->template_mobile_with_menu('mobile/chatLounge',$data);
						// } else {								
							// $this->load->template('homeUser',$data);				
						// }
						$this->load->template('homeUser',$data);				
					}
				}
			}else{
				redirect(site_url().'/place');
			}
		}else{
			redirect(site_url().'/login');
		}
		
	}
	
	public function EditProfile(){
		
		$login=$this->UserModel->islogin();
		$loc=$this->session->userdata('user_id_admin');
		if($login){
			$data['user_logout']=site_url()."/login/logout";
			$data['username']=$this->getData('username');
			$data['email']=$this->getData('email');
			$data['music_genre']= (null !== $this->getData('music_genre')) ? json_decode($this->getData('music_genre')) : array();
			$data['bio']= (null !== $this->getData('bio')) ? $this->getData('bio') : "";
			$data['hangout_place']= (null !== $this->getData('hangout_place')) ? implode(',',json_decode($this->getData('hangout_place'))) : "";
			$data['food']= (null !== $this->getData('food')) ? implode(',',json_decode($this->getData('food'))) : "";
			$data['drink']= (null !== $this->getData('drink')) ? implode(',',json_decode($this->getData('drink'))) : "";
			$admin=$this->getData('admin');
			if($loc!=""){
				if($admin){
					$data['status']="admin";
					$data['id']=$this->getData('id');
					$data['loc_id']=$this->getData('id');
				}else{
					$data['status']="user";
					$data['id']=$this->getData('id');
					$data['loc_id']=$this->getData('id_admin');
				}
				$data['image']=$this->getData('image');
				if($this->session->userdata("user_admin")) {
					$this->load->template('playlistAdmin',$data);
				} else {
					$detect = new Mobile_Detect();
					if ( $detect->isMobile() ) {
		 				$data['user_home']=site_url();
						$data["isAndroid"] = $detect->isAndroidOS();
		 				$this->load->template_mobile_with_menu('mobile/editProfile',$data);
					} else {
						$this->load->template('homeUser',$data);				
					}
				}
			}else{
				redirect(site_url().'/place');
			}
		}else{
			redirect(site_url().'/login');
		}
		
	}
	
	function checkAdminIsLogin() {
		$idAdmin = $_GET["id"];
		$data = $this->UserModel->isLoginAdmin($idAdmin);
		echo json_encode($data);
	}

	public function getPlaylistUser(){
        $id=$this->session->userdata('user_id');
        $getPlaylist=$this->UserPlaylist->getPlaylist($id);
        if(sizeof($getPlaylist)>0)
	        if($getPlaylist){
	            $status['status']=true;
	            $status['data']=$getPlaylist;
	        }else{
	            $status['status']=false;
	            $status['message']="no playlist found";
	        }
        echo json_encode($status);
    }

   public function addItem(){
        $status=array();
        $data=array(
          'track_id'=>$this->input->post('track_id'),
          'link'=>$this->input->post('link'),
          'title'=>$this->input->post('title'),
          'playlist_id'=>$this->input->post('playlist_id')
        );
        $addPlaylistItem=$this->UserPlaylist->addPlaylistItem($data);
        if($addPlaylistItem){
            $status['status']=true;
            $status['message']="playlist item added";
        }else{
            $status['status']=false;
            $status['message']="playlist item not added";
        }
        echo json_encode($status);
    }
}
