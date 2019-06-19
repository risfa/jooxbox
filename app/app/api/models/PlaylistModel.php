<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PlaylistModel extends CI_Model {
	public function __construct(){
		parent::__construct();
		$this->load->model('Token');
	}
	public function getPlaylistDaily($loc,$from,$to){
		$this->db->where('from_date<=',$from);
		$this->db->where('to_date>=',$to);
		$this->db->where('location',$loc);
		$query=$this->db->get('tbl_playlist_daily');
		if($query->num_rows()>0){
			return $query->result();
		}else{
			return false;
		}
	}
	public function getPlaylistItems($playlist,$loc,$q){
		if(strtolower($q) != "all") {
			$this->db->like('title',$q);
		}
		$this->db->order_by('title','asc');
		$this->db->where('location',$loc);
		$this->db->where('playlist_name',$playlist);
		$this->db->select('title,track_id,genre,source as from,link , link as permalink_url');
		$query=$this->db->get('tbl_list_playlist_daily');
		if($query->num_rows()>0){
			return $query->result();
//            echo json_encode($query->result());die;
		}else{
			return array();
		}
	}
	public function SearchPlaylist($q,$loc){
		$query=$this->getPlaylistDaily($loc,date('Y-m-d'),date('Y-m-d'));
		if($query){
			$i=0;
			$data=array();
			foreach($query as $q2){
				foreach($this->getPlaylistItems($q2->playlist_name,$loc,$q) as $d){
					$data[$i]=$d;
                    $i++;
				}
			}
			if(!empty($data[0])){
				$data['length'] =$i;
				$data['status']=true;
				return $data;
			}else{
				$data['status']=false;
				$data['err'] = "Please type \"all\" to see Admin's playlist";
				$data['errMobile'] = "Please type \"all\" to see Admin's playlist";
				return $data;
			}
		}else{
			return false;
		}
	}
	public function getDislike($id){
		$this->db->where('playlist_id',$id);
		$query=$this->db->get('tbl_playlist');
		if($query->num_rows()>0){
			return $query->row()->playlist_id;
		}else{
			return array();
		}
	}
	public function insert($data){
		$query=$this->db->insert('tbl_playlist_daily',$data);
		if($query){
			return true;
		}else{
			return false;
		}
	}
	public function prevWeeklyChart($loc,$tokens){
		$status=$this->Token->check_tokens($tokens);
		if($status['status']){
			$this->db->where('location',$loc);
			$query=$this->db->get('tbl_prev_week_chart');
			$status['status']=true;
			$status['data']=$query->result();
			return $status;
		}else{
			return $status;
		}
	}
}
