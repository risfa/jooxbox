<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cron extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("CronModel");
	}
	
	public function index() {
		$this->CronModel->clearChatAndPlaylistWeekly();
	}
	
	public function daily() {
		$this->CronModel->clearPlaylistDaily();
	}
	
	public function logout() {
		$this->CronModel->logout();
	}
}