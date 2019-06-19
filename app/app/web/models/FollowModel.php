<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class FollowModel extends CI_Model {
	public function __construct(){
		parent::__construct();
	}
	public function follow($data) {
		$this->db->insert("tbl_relationship",$data);
		if($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
	public function unfollow($data) {
		$this->db->delete("tbl_relationship",$data);
		if($this->db->affected_rows() > 0) {
			return true;
		} else {
			return false;
		}
	}
}