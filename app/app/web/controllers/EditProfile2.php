<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class EditProfile2 extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->library('form_validation');
		$this->load->model("UserModel");
		$this->load->helper('file');
	}
	public function index()
	{
		$login=$this->UserModel->islogin();
		if($login){
			$data['isAdmin']=$this->getData('admin');
			if($data['isAdmin']){
                $data['lat']=$this->getData('lat');
                $data['long']=$this->getData('long');
            }
			$data['username']=$this->getData('username');
			$data['email']=$this->getData('email');
			$data['id']=$this->getData('id');
			$data['image']=$this->getData('image');
			$data['address']=$this->getData('address');
			$data['music_genre']= (null !== $this->getData('music_genre') && is_array(json_decode($this->getData('music_genre')))) ? json_decode($this->getData('music_genre')) : array();
			$data['bio']= (null !== $this->getData('bio')) ? $this->getData('bio') : "";
			$data['hangout_place']= (null !== $this->getData('hangout_place') && is_array(json_decode($this->getData('hangout_place')))) ? implode(',',json_decode($this->getData('hangout_place'))) : "";
			$data['food']= (null !== $this->getData('food') && is_array(json_decode($this->getData('food')))) ? implode(',',json_decode($this->getData('food'))) : "";
			$data['drink']= (null !== $this->getData('drink') && is_array(json_decode($this->getData('drink')))) ? implode(',',json_decode($this->getData('drink'))) : "";
			$this->load->template('edit_profile2',$data);
		}else{
			redirect(site_url().'/login');
		}
	}
	public function getData($key){
		return $this->session->userdata('user_'.$key);
	}
    public function setData($key,$val){
        $this->session->set_userdata('user_'.$key,$val);
    }
	public function changePassword(){
		$old = $_POST['oldpass'];
		$new = $_POST['newpass'];
		$retype = $_POST['retype'];
		$flag = isset($_POST["m"]) ? $_POST["m"] : "";
		$redirect = "";
		if($flag != "") {
			$redirect = "home/";
		}
		$status=$this->UserModel->changePassword($old,$new,$retype,$this->session->userdata('user_id'));
		if($status['status']){
			redirect($redirect.'EditProfile?err='.$status['message']);
		}else{
			redirect($redirect.'EditProfile?err='.$status['message']);
		}
	}
	public function process(){
		$isAdmin = $this->getData('admin');
		if($isAdmin) {
			$address = $_POST["address"];
            $latlong=$_POST['lat'].'#'.$_POST['long'];
            $this->setData('lat',$_POST['lat']);
            $this->setData('long',$_POST['long']);
		}
		$email = $_POST['email'];
		$id = $_POST['userID'];
		$newUsername = $_POST["newUsername"];
		$about = $_POST["about"];
		$genre = isset($_POST["genre"]) ? $_POST["genre"] : array();
		$food = $_POST["food"];
		$drink = $_POST["drink"];
		$hangout_place = $_POST["hangout_place"];
		$flag = isset($_POST["m"]) ? $_POST["m"] : "";
		$this->form_validation->set_rules("email","Email","required");
		$this->form_validation->set_rules("about","About","required|min_length[5]|max_length[200]");
		$this->form_validation->set_rules("newUsername","Username","required");
		$this->form_validation->set_error_delimiters('','<br/>');
		$redirect = "";
		if($flag != "") {
			$redirect = "home/";
		}
		if($this->form_validation->run()==TRUE){
			$data=array(
				'email'=>$email,
				'username'=>$newUsername,
				'bio'=>$about,
				'music_genre'=>json_encode($genre),
				'food'=>json_encode(explode(",",$food)),
				'drink'=>json_encode(explode(",",$drink)),
				'hangout_place'=>json_encode(explode(",",$hangout_place)),
			);
			if($isAdmin) $data["address"] = $address;
			if($isAdmin) $data["latlong"] = $latlong;
			// print_r($data);die;
			$status=$this->UserModel->updateData($data,$id);
			if($status){
				$message="Edit Profile Success";
				redirect($redirect.'EditProfile?err='.$message);
			}else{
				$message="Edit Profile Failed";
				redirect($redirect.'EditProfile?err='.$message);
			}
		}else{
			$message=validation_errors();
			redirect($redirect.'EditProfile?err='.$message);
		}
	}
	public function upload(){
		$thumb_square_size 		= 200;
		$max_image_size 		= 500; 
		$thumb_prefix			= "thumb_"; 
		$destination_folder		= './assets/';
		$jpeg_quality 			= 90; 
		if(isset($_POST) && isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
			if(!isset($_FILES['image_file']) || !is_uploaded_file($_FILES['image_file']['tmp_name'])){
					die('Image file is Missing!');
			}
			$image_name = $_FILES['image_file']['name']; 
			$image_size = $_FILES['image_file']['size']; 
			$image_temp = $_FILES['image_file']['tmp_name'];
			$image_size_info 	= getimagesize($image_temp); 
			if($image_size_info){
				$image_width 		= $image_size_info[0]; 
				$image_height 	= $image_size_info[1]; 
				$image_type 		= $image_size_info['mime']; 
			}else{
				die("Make sure image file is valid!");
			}

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

				$image_info = pathinfo($image_name);
				$image_extension = strtolower($image_info["extension"]); //image extension
				$image_name_only = strtolower($image_info["filename"]);//file name only, no extension
				
				//create a random name for new image (Eg: fileName_293749.jpg) ;
				$new_file_name = $this->session->userdata("user_id"). '_' .  rand(0, 9999999999) . '.' . $image_extension;
				
				//folder path to save resized images and thumbnails
				$thumb_save_folder 	= $destination_folder .'images/people/'. $thumb_prefix . $new_file_name; 
				$image_save_folder 	= $destination_folder.'images/people/'. $new_file_name;
					if(!$this->crop_image_square($image_res, $thumb_save_folder, $image_type, $thumb_square_size, $image_width, $image_height, $jpeg_quality))
					{
						die('Error Creating thumbnail');
					}
					$data=array(
						"twitter_image"=>'images/people/'.$thumb_prefix . $new_file_name
					);
					$row=$this->UserModel->updatePhoto($data);
					if($row) {
						if(!preg_match("(user\.jpg|jukebox\-admin\.png)",$this->session->userdata("user_image"))){
							unlink($destination_folder.$this->session->userdata('user_image'));
						}
						$this->session->set_userdata('user_image', 'images/people/'.$thumb_prefix . $new_file_name);
						echo "images/people/".$thumb_prefix . $new_file_name;
					} else {
						echo 2; // gagal insert
					}	
				imagedestroy($image_res); //freeup memory
			}
		}
	}
	#####  This function will proportionally resize image ##### 
	function normal_resize_image($source, $destination, $image_type, $max_size, $image_width, $image_height, $quality){
		
		if($image_width <= 0 || $image_height <= 0){return false;} //return false if nothing to resize
		
		//do not resize if image is smaller than max size
		if($image_width <= $max_size && $image_height <= $max_size){
			if(save_image($source, $destination, $image_type, $quality)){
				return true;
			}
		}
		
		//Construct a proportional size of new image
		$image_scale	= min($max_size/$image_width, $max_size/$image_height);
		$new_width		= ceil($image_scale * $image_width);
		$new_height		= ceil($image_scale * $image_height);
		
		$new_canvas		= imagecreatetruecolor( $new_width, $new_height ); //Create a new true color image
		
		//Copy and resize part of an image with resampling
		if(imagecopyresampled($new_canvas, $source, 0, 0, 0, 0, $new_width, $new_height, $image_width, $image_height)){
			save_image($new_canvas, $destination, $image_type, $quality); //save resized image
		}

		return true;
	}

	##### This function corps image to create exact square, no matter what its original size! ######
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
		$new_canvas	= imagecreatetruecolor( $square_size, $square_size); //Create a new true color image
		
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
}
