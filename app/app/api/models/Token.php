<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Token extends CI_Model {
	public function __construct(){
		parent::__construct();	
	}
	public function getToken($username,$password,$md5=true){
		if($md5){
			$password=md5($password);
		}else{
			$password=$password;
		}
		$this->db->where('email',$username);
		$this->db->where('password',$password);
		$this->db->select('user_id,username,email,twitter_image,register_as,food,drink,hangout_place,music_genre,bio');
		$query=$this->db->get('tbl_user');
		if($query->num_rows()>0){
			$this->db->where('token',md5($query->row()->user_id).md5(date('Y-m-d')));
			$check=$this->db->get('tbl_tokens');
			if(!$check->num_rows()>0){
				$data=array(
					'user_id'=>$query->row()->user_id,
					'date'=>date('Y-m-d H:i:s'),
					'token'=>md5($query->row()->user_id).md5(date('Y-m-d')),
					'expire'=>date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s')." +30 days"))
				);
				$this->db->insert('tbl_tokens',$data);	
			}
			$status['status']=true;
			$status['data']=$query->row();
			$status['token']=md5($query->row()->user_id).md5(date('Y-m-d'));
			return $status;
		}else{
			return false;
		}
	}
	public function check_tokens($token){
		$this->db->where('token',$token);
		$query=$this->db->get('tbl_tokens');
		if($query->num_rows()>0){
			$expire=$query->row()->expire;
			$date1=new DateTime($expire);
			$date2=new DateTime(date('Y-m-d H:i:s'));
			$this->db->where('user_id',$query->row()->user_id);
			$this->db->select('user_id,username,email,twitter_image,register_as');
			$query2=$this->db->get('tbl_user');
			if(date_diff($date1,$date2)->days>0){
				$status['status']=true;
				$status['user_id']=$query->row()->user_id;
				$status['date_generated']=$query->row()->date;
				$status['username']=$query2->row()->username;
				$status['email']=$query2->row()->email;
				$status['twitter_image']=$query2->row()->twitter_image;
				$status['expire_in']=date_diff($date1,$date2)->days." days";
			}else{
				$this->db->where('token',$token);
				$data=array(
					'date'=>date('Y-m-d H:i:s'),
					'expire'=>date('Y-m-d H:i:s',strtotime(date('Y-m-d H:i:s')." +30 days"))
				);
				$this->db->update('tbl_tokens',$data);
				$status['status']=true;
                $status['user_id']=$query->row()->user_id;
                $status['date_generated']=$query->row()->date;
                $status['username']=$query2->row()->username;
                $status['email']=$query2->row()->email;
                $status['twitter_image']=$query2->row()->twitter_image;
                $status['expire_in']=date_diff($date1,$date2)->days." days";
				$status['message']="Token Refreshed";
			}
		}else{
			$status['status']=false;
			$status['message']="Invalid Token";
		}
		return $status;
	}
}
