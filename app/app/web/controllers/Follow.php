<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Follow extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("FollowModel");
	}
	public function index() {
		$userIdFollow = $_POST["userIdFollow"];
		$userId = $_POST["userId"];
		$now = date("Y-m-d H:i:s");
		$type = $_POST["type"];
		$data["user_id"] = $userIdFollow;
		$data["follower_id"] = $userId;
		if($type == "follow") {
			$data["created_date"] = $now;
			$result = $this->FollowModel->follow($data);
		} else {
			$result = $this->FollowModel->unfollow($data);
		}
		if($result) {
			echo true;
		} else {
			echo false;
		}
	}
}
