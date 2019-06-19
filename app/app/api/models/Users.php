<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Model {
	public $from="explore@limadigit.com";
	public $fromName="Jukebox 5D";
	public function __construct(){
		parent::__construct();	
		$this->load->model('Token');
		$this->load->helper('file');
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
		$this->load->library('email',$config);
	}
	public function register($data){
		$check=$this->checkEmail($data['email']);
		if(!$check){
			$status['status']=true;
			$this->db->insert('tbl_user',$data);
            $code=md5("Y-m-d H:i:s");
			$this->registerMail($data['email'],'user',$code);
		}else{
			$status['status']=false;
			$status['message']="Email is already exist, use another.";
		}
		return $status;
	}
	public function login($email,$password,$md5=true){
		$login=$this->Token->getToken($email,$password,$md5);
		if($login!=false){
			return $login;
		}else{
			$status['status']=false;
			$status['message']="Invalid Email and Password";
			return $status;
		}
	}
	public function getLocations($lat,$long,$tokens){
		$status=$this->Token->check_tokens($tokens);
		if($status['status']){
			$latlong = $lat."#".$long;
			$data_admin = array();
			$data_distance = array();
			$this->db->where('flag_login',1);
			$this->db->where('register_as','admin');
			$this->db->where('latlong!=','');
			$query=$this->db->get('tbl_user');
			foreach($query->result() as $d) {	
			    $expVal = explode("#",$d->latlong);
			    $lat2 = $expVal[0];
			    $long2 = $expVal[1];
			    if($lat2 != "" && $long2 != "") {
			        $distance = round($this->distance($lat2,$long2,$lat,$long),2);
			        // echo $distance."====";
			        if($distance <= 2000) {
			            $data_distance[] = array(
			            	"location"=>$d->username,
			            	"distance"=>$distance,
			            	"latlong"=>$d->latlong,
			            	"user_id"=>$d->user_id
			            );
			        }
			    }
			}
			if(count($data_distance)>0){
				$status['status']=true;
				$status['data']=$data_distance;
			}else{
				$status['status']=false;
				$status['message']="No Admin Found";
			}
			return $status;
		}else{
			return $status;
		}
	}
	public function changePassword($tokens,$newpassword){
		$status=$this->Token->check_tokens($tokens);
		if($status['status']){
			$data=array(
			'password'=>md5($newpassword)
			);
			$this->db->where('user_id',$status['user_id']);
			$this->db->update('tbl_user',$data);
			$status['status']=true;
			$status['message']="password has changed";	
			return $status;
		}else{
			return $status;
		}
	}
	public function followUser($tokens,$user_id){
		$status=$this->Token->check_tokens($tokens);
		if($status['status']){
			$follow=$this->checkFollow($status['user_id'],$user_id);
			if($follow){
				$status['status']=false;
				$status['message']="failed to follow  this user";	
			}else{
				$data=array(
					'user_id'=>$user_id,
					'follower_id'=>$status['user_id'],
					'created_date'=>date('Y-m-d H:i:s')
				);
				$this->db->insert('tbl_relationship',$data);
				$status['status']=true;
				$status['message']="you have follow this user";	
			}
			return $status;
		}else{
			return $status;
		}
	}
	public function checkFollow($user_id,$follower_id){
		$this->db->where('user_id',$follower_id);
		$this->db->where('follower_id',$user_id);
		$follow=$this->db->get('tbl_relationship');
//        echo $follower_id."-".$user_id;echo json_encode($follow->row());die;
		if($follow->num_rows()>0){
			return true;
		}else{
			return false;	
		}
	}
	public function unfollowUser($tokens,$user_id){
		$status=$this->Token->check_tokens($tokens);
		if($status['status']){
			$follow=$this->checkFollow($status['user_id'],$user_id);
			if($follow){
				$this->db->where('user_id',$user_id);
				$this->db->where('follower_id',$status['user_id']);
				$this->db->delete('tbl_relationship');
				$status['status']=true;
				$status['message']="you have unfollow this user";	
			}else{
				$status['status']=false;
				$status['message']="failed to unfollow  this user";	
			}
			return $status;
		}else{
			return $status;
		}
	}
	/*
	public function followerList($tokens,$user_id){
		$status=$this->Token->check_tokens($tokens);
		if($status['status']){
			
			$status['status']=true;	
			return $status;
		}else{
			return $status;
		}
	}
	public function followingList($tokens,$user_id){
		$status=$this->Token->check_tokens($tokens);
		if($status['status']){
			
			$status['status']=true;	
			return $status;
		}else{
			return $status;
		}
	}
	*/
	public function getPlaylist($tokens){
        $status=$this->Token->check_tokens($tokens);
        if($status['status']){
            $this->db->where('user_id',$status['user_id']);
            $playlist=$this->db->get('tbl_user_playlist');
            if($playlist->num_rows()>0){
                $status['status']=true;
                $status['message']="success result found";
                $status['data']=$playlist->result();
            }else{
                $status['status']=false;
                $status['message']="you have not created playlist yet";
            }
            return $status;
        }else{
            return $status;
        }
    }
    public function savePlaylist($tokens,$data){
        $status=$this->Token->check_tokens($tokens);
        if($status['status']){
            $data['user_id']=$status['user_id'];
            $this->db->insert('tbl_user_playlist',$data);
            $status['status']=true;
            $status['message']="data saved";
            return $status;
        }else{
            return $status;
        }
    }
    public function deletePlaylist($tokens,$playlist_id){
        $status=$this->Token->check_tokens($tokens);
        if($status['status']) {
            $this->db->where('playlist_id', $playlist_id);
            $delete = $this->db->delete('tbl_user_playlist');
            if ($delete) {
                $status['status'] = true;
                $status['message'] = "playlist deleted";
            } else {
                $status['status'] = false;
                $status['message'] = "playlist not deleted";
            }
        }
        return $status;
    }
    public function updatePlaylist($tokens,$data,$playlist_id){
        $status=$this->Token->check_tokens($tokens);
        if($status['status']) {
            $this->db->where('playlist_id', $playlist_id);
            $update = $this->db->update('tbl_user_playlist', $data);
            if ($update) {
                $status['status'] = true;
                $status['message'] = "playlist updated";
            } else {
                $status['status'] = false;
                $status['message'] = "playlist not updated";
            }
        }
        return $status;
    }
    public function addPlaylistItem($tokens,$data){
        $status=$this->Token->check_tokens($tokens);
        if($status['status']) {
            $insert = $this->db->insert('tbl_user_playlist_item', $data);
            if ($insert) {
                $status['status'] = false;
                $status['message'] = "playlist item added";
            } else {
                $status['status'] = false;
                $status['message'] = "playlist item not added";
            }
        }
        return $status;
    }
    public function deletePlaylistItem($tokens,$link,$playlist_id){
        $status=$this->Token->check_tokens($tokens);
        if($status['status']) {
            $this->db->where('playlist_id', $playlist_id);
            $this->db->where('link', $link);
            $delete = $this->db->delete('tbl_user_playlist_item');
            if ($delete) {
                $status['status'] = true;
                $status['message'] = "playlist item deleted";
            } else {
                $status['status'] = false;
                $status['message'] = "playlist item not deleted";
            }
        }
        return $status;
    }
    public function getPlaylistItem($tokens,$playlist_id){
        $status=$this->Token->check_tokens($tokens);
        if($status['status']) {
            $this->db->where('playlist_id', $playlist_id);
            $userDataPlaylistItem = $this->db->get('tbl_user_playlist_item');
            if ($userDataPlaylistItem->num_rows() > 0) {
                $status['status']=true;
                $status['message']="success result found";
                $status['data']=$userDataPlaylistItem->result();
            } else {
                $status['status'] = false;
                $status['message'] = "No playlist data found";
            }
        }
        return $status;
    }
	public function uploadPhoto($id,$old_filename){
		//if($photo != "") {
		
			$destinationFolder='./assets/images/people/';
			$new_file_name = 'android_' . $id . '_' . date('dmYHis') . '.png';
			if(!isset($_FILES['photo']) || !is_uploaded_file($_FILES['photo']['tmp_name'])){
					$status['status']=false;
					$status['message']="No File";
					return $status;
			}
			$image_name = $_FILES['photo']['name']; 
			$image_size = $_FILES['photo']['size']; 
			$image_temp = $_FILES['photo']['tmp_name'];
			$image_size_info 	= getimagesize($image_temp); 
			if($image_size_info){
				$image_width 		= $image_size_info[0]; 
				$image_height 	= $image_size_info[1]; 
				$image_type 		= $image_size_info['mime']; 
			}else{
				$status['status']=false;
				$status['message']="Null Size";
				return $status;
			}
			$thumb_square_size 		= 200;
			$max_image_size 		= 500; 
			$thumb_prefix			= "thumb_"; 
			$jpeg_quality 			= 90; 
			
			switch($image_type){
				case 'image/png':
					$image_res =  imagecreatefrompng($image_temp); break;
				case 'image/gif':
					$image_res =  imagecreatefromgif($image_temp); break;			
				case 'image/jpeg': case 'image/pjpeg':
					$image_res = imagecreatefromjpeg($image_temp); break;
				default:
					$image_res = false;
			}

			if($image_res){
				//folder path to save resized images and thumbnails
				$thumb_save_folder 	= $destinationFolder . $new_file_name;

				if(!$this->crop_image_square($image_res, $thumb_save_folder, $image_type, $thumb_square_size, $image_width, $image_height, $jpeg_quality))
				{
					$status['status']=false;
					$status['message']="Fail Crop";
					return $status;
				}
				
				imagedestroy($image_res); //freeup memory
			}
			$this->db->where('user_id',$id);
			$this->db->update('tbl_user',array('twitter_image'=>'images/people/'.$new_file_name));
			if(!preg_match('/user\.jpg/',$old_filename)){
				if (file_exists('./assets/'.$old_filename)){
					unlink('./assets/'.$old_filename);
				}
			}
			$status['status']=true;
			$status['file']='images/people/'.$new_file_name;
			return $status;
		//}
	}
	public function checkEmail($email){
		$this->db->where('email',$email);
		$query=$this->db->get('tbl_user');
		if($query->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}
	public function checkUsername($username){
		$this->db->where('username',$username);
		$query=$this->db->get('tbl_user');
		if($query->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}
	public function detailOthers($user_id,$tokens,$loc=null){
		$status=$this->Token->check_tokens($tokens);
		if($status['status']){
			$this->db->where('user_id',$user_id);
			$this->db->select('user_id,username,email,register_as,twitter_image,food,drink,hangout_place,music_genre,bio');
			$query=$this->db->get('tbl_user');
			if($query->num_rows()>0){
				$status['status']=true;
				$data=$query->row();
				if($data->food!=""){
					$data->food=implode(', ',json_decode($data->food));
				}
				if($data->drink!=""){
					$data->drink=implode(', ',json_decode($data->drink));
				}
				if($data->hangout_place!=""){	
					$data->hangout_place=implode(',',json_decode($data->hangout_place));
				}
				if($data->music_genre!=""){
					$data->music_genre=implode(', ',json_decode($data->music_genre));
				}
 				$recents=$this->db->query("SELECT * FROM (SELECT * FROM `tbl_playlist` WHERE play = 1 and user_id = '".$user_id."' and location = '".$loc."' ORDER BY playlist_id DESC) AS t GROUP BY title ORDER BY playlist_id DESC LIMIT 10");
 				$followNumber=$this->db->query("select (select count(*) from  tbl_relationship where follower_id=".$user_id.") as following , (select count(*) from  tbl_relationship where user_id=".$user_id.") as followers ");
 				$data->following=$followNumber->row()->following;
 				$data->followers=$followNumber->row()->followers;
 				$data->recents=$recents->result();
 				$follow=$this->checkFollow($status['user_id'],$data->user_id);
 				if($status['user_id']==$data->user_id){
                    $data->self=true;
                    $data->is_follow=true;
                }else{
                    $data->self=false;
                    if($follow){
                        $data->is_follow=true;
                    }else{
                        $data->is_follow=false;
                    }
                }
				$status['data']=$data;	
			}else{
				$status['status']=true;
				$status['message']="No Userdata Found";	
			}
			return $status;
		}else{
			return $status;
		}
	}
	public function editProfile($data,$tokens){
		$status=$this->Token->check_tokens($tokens);
		if($status['status']){
			$this->db->where('user_id',$status['user_id']);
			$this->db->update('tbl_user',$data);
			if(isset($_FILES['photo'])){
				$gambar=$this->uploadPhoto($status['user_id'],$status['twitter_image']);
				if($gambar['status']){
					$status['twitter_image']=$gambar['file'];
				}else{
					$status['twitter_image']=$status['twitter_image'];
					$status['error_upload']=$gambar['message'];
				}
			}
			$status['status']=true;
			if(isset($data['username']) && isset($data['username'])){
				$status['username']=$data['username'];
				$status['email']=$data['email'];	
			}
			$status['message']="data has changed";	
			return $status;
		}else{
			return $status;
		}
	}
	public function registerMail($email,$statusUser,$code){
		$emailsubject = $this->config->item('subjectEmailConfirmation');		
		$content =  $this->config->item('contentEmailConfirmation');
		$search=array(
			'[user]','[uniqueid]'
		);
		$replace=array(
			"user",$code
		);
		$content =str_replace($search,$replace,$content);
		$this->db->where('email',$email);
		$this->db->update('tbl_user',array(
		    'unique_code'=>$code
        ));
		$this->sendMail($email,$emailsubject,$content);
	}
	public function forgotMail($user,$email,$code){
		$emailsubject = $this->config->item('subjectResetPass');		
		$content =  $this->config->item('contentResetPass');
		$search=array(
			'[user]','[code]'
		);
		$replace=array(
			$user,$code
		);
		$content =str_replace($search,$replace,$content);
		$this->db->where('email',$email);
		$this->db->update('tbl_user',array('verification_code'=>$code));
		$this->sendMail($email,$emailsubject,$content);
	}
	public function forgotPassword($email){
		$uniqueCode = md5($email.date("Y-m-d H:i:s"));
		$data=$this->getUserDataFromEmail($email);
		if($data['status']){
			$this->updateUniqueCode($email,$uniqueCode);
			$this->forgotMail($data['user']->username,$email,$uniqueCode);	
		}
		return $data;
	}
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
			$data["user"] = $query->row();
			$data["status"] = true;
		}else{
			$data["user"] = array();
			$data["status"] = false;
		}
		return $data;
	}
	public function sendMail($to,$subject,$message){
		$this->email->from("explore@limadigit.com", "jukebox");
		$this->email->to($to);
		$this->email->subject($subject);
		$this->email->message($message);
		$this->email->send();
	}
	
	public function music_genre($token) {
		$this->db->where("token",$token);
		$token = $this->db->get("tbl_tokens");
		if($token->num_rows()>0) {
			$status['status']=true;
			$status['data']=$this->config->item("music_genre");
		} else {
			$status['status']=false;
			$status['message']="Invalid Token";
		}
		return $status;
	}
	
	public function detail($token){
		$this->db->where('token',$token);
		$detail=$this->db->get('tbl_tokens');
		if($detail->num_rows()>0){
			$this->db->where('user_id',$detail->row()->user_id);
			$this->db->select('user_id,username,email,register_as,twitter_image,food,drink,hangout_place,music_genre,bio');
			$user=$this->db->get('tbl_user');
			if($user->num_rows()>0){
				$status['status']=true;
				$status['data']=$user->row();			
			}else{
				$status['status']=false;
				$status['message']="No User data";
			}
		}else{
			$status['status']=false;
			$status['message']="Invalid Token";
		}
		return $status;
	}
	function crop_image_square($source, $destination, $image_type, $square_size, $image_width, $image_height, $quality){
		if($image_width <= 0 || $image_height <= 0){return false;} //return false if nothing to resize
		
		if( $image_width > $image_height )
		{
			$y_offset = 0;
			$x_offset = ($image_width - $image_height) / 2;
			$s_size 	= $image_width - ($x_offset * 2);
		}else{
			$x_offset = 0;
			$y_offset = ($image_height - $image_width) / 2;
			$s_size = $image_height - ($y_offset * 2);
		}
		$new_canvas	= imagecreatetruecolor($square_size, $square_size); //Create a new true color image
		
		//Copy and resize part of an image with resampling
		if(imagecopyresampled($new_canvas, $source, 0, 0, $x_offset, $y_offset, $square_size, $square_size, $s_size, $s_size)){
			$this->save_image($new_canvas, $destination, $image_type, $quality);
		}

		return true;
	}

	##### Saves image resource to file ##### 
	function save_image($source, $destination, $image_type, $quality){
		switch(strtolower($image_type)){//determine mime type
			case 'image/png': 
				imagepng($source, $destination); return true; //save png file
				break;
			case 'image/gif': 
				imagegif($source, $destination); return true; //save gif file
				break;          
			case 'image/jpeg': case 'image/pjpeg': 
				imagejpeg($source, $destination, $quality); return true; //save jpeg file
				break;
			default: return false;
		}
	}
	function distance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000) {
	    // convert from degrees to radians
	    $latFrom = deg2rad($latitudeFrom);
	    $lonFrom = deg2rad($longitudeFrom);
	    $latTo = deg2rad($latitudeTo);
	    $lonTo = deg2rad($longitudeTo);

	    $lonDelta = $lonTo - $lonFrom;
	    $a = pow(cos($latTo) * sin($lonDelta), 2) + pow(cos($latFrom) * sin($latTo) - sin($latFrom) * cos($latTo) * cos($lonDelta), 2);
	    $b = sin($latFrom) * sin($latTo) + cos($latFrom) * cos($latTo) * cos($lonDelta);

	    $angle = atan2(sqrt($a), $b);
	    return $angle * $earthRadius;
	}
	public function SosmedLogin($username,$email,$image){
		$this->db->where('email',$email);
		$query=$this->db->get('tbl_user');
		// user register
		if($query->num_rows()>0){
			//login
			return $this->login($email,$query->row()->password,false);
		}else{
			$data=array(
				'username'=>$username,
				'email'=>$email,
				'password'=>md5(''),
				'twitter_image'=>$image,
				'flag_email'=>'1'
			);
			
			//register & login
			$this->db->insert('tbl_user',$data);
			return $this->login($email,'');
		}
	}
}
