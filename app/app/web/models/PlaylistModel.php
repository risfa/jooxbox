<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class PlaylistModel extends CI_Model {
	public function __construct(){
		parent::__construct();
	}
	public function getPlaylistDaily($loc,$from,$to){
		// $this->db->select("playlist_name");
		$this->db->where('from_date<=',$from);
		$this->db->where('to_date>=',$to);
		$this->db->where('location',$loc);
		$query=$this->db->get('tbl_playlist_daily');
		// print_r($this->db->last_query());die;
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
		}else{
			return array();
		}
	}
	public function SearchPlaylist($q,$loc){
		// $loc = 247;
		$status=array();
		$query=$this->getPlaylistDaily($loc,date('Y-m-d'),date('Y-m-d'));
		if($query){
			$data=array();
			// print_r($query);die;
			foreach($query as $val){
				foreach($this->getPlaylistItems($val->playlist_name,$loc,$q) as $r){
					array_push($data,$r);	
				}
			}
			if(count($data)>0){
			//if(!empty($data)){
				$status['data']=$data;
				$status['length'] = count($data);
				$status['status'] = true;
				$status['err'] = "";
				return $status;
			}else{
				$status['status'] = false;
				$status['err'] = $this->config->item("special_day_ajax");
				return $status;
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
	public function insertSong($data){
		$query=$this->db->insert('tbl_list_playlist_daily',$data);
		if($query){
			return true;
		}else{
			return false;
		}
	}
	public function delete($id){
		$this->db->where('playlist_daily_id',$id);
		$query=$this->db->delete('tbl_playlist_daily');
		if($query){
			return true;
		}else{
			return false;
		}
	}
	public function deleteSongPlaylist($id){
		$this->db->where('id_list_playlist_daily',$id);
		$query=$this->db->delete('tbl_list_playlist_daily');
		if($query){
			return true;
		}else{
			return false;
		}
	}
	public function changeDate($id,$from,$to) {
		$this->db->where("playlist_daily_id",$id);
		$query = $this->db->update("tbl_playlist_daily",["from_date" => date("Y-m-d",strtotime($from)), "to_date" => date("Y-m-d", strtotime($to))]);
		if($query) {
			return true;
		} else {
			return false;
		}
	}
}
