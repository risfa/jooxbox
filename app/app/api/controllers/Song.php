<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Song extends CI_Controller {
	public function __construct(){
		parent::__construct();
		//tbl_prev_week_chart	
		$this->load->model('PlaylistModel');
	}
	public function index()
	{
		
	}
	public function prevWeekly(){
        header('Access-Control-Allow-Origin: *');

        $loc = $_POST["loc"];
		$token = $_POST["token"];
		$status=$this->PlaylistModel->prevWeeklyChart($loc,$token);
		echo json_encode($status);
	}
}
