<?php

class Testsearch extends CI_Controller {

	public function __construct(){
		parent::__construct();
	}
	public function index()
	{
		$this->load->template('testsearch');
	}

}


?>