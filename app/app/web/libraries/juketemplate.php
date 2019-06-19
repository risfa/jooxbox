<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Juketemplate{
	protected $CI;
	public $title;
	public $meta;
    public function __construct()
    {
    	 $this->CI =& get_instance();
    }
    public function set_title($string){
		 $this->title=$string;
	}
}