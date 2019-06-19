<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class SongModel extends CI_Model {
	public function __construct(){
		parent::__construct();
	}
	public function insert_song($data){
		$query=$this->db->insert('tbl_playlist',$data);
		if($query){
			return true;
		}else{
			return false;
		}
	}
	public function checkTopSong($loc,$track_id){
		$this->db->where('location',$loc);
		$this->db->where('track_id',$track_id);
		$query=$this->db->get('tbl_top10mostplayed');
		if($query->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}
	public function checkTopPlayer($loc,$player,$id){
		$this->db->where('location',$loc);
		// $this->db->where('name',$player);
		$this->db->where('user_id',$id);
		$query=$this->db->get('tbl_top10player','top10player_id');
		if($query->num_rows()>0){
			return $query;
		}else{
			return false;
		}
	}
	public function checkTopSource($loc,$source){
		$this->db->where('location',$loc);
		$this->db->where('source',$source);
		$query=$this->db->get('tbl_topsource');
		if($query->num_rows()>0){
			return true;
		}else{
			return false;
		}
	}
	public function insertTopSong($data){
		$check=$this->checkTopSong($data['location'],$data['track_id']);
		if($check){
			$this->db->set('counter', 'counter+1', FALSE);
			$this->db->where('location',$data['location']);
			$this->db->where('track_id',$data['track_id']);
			$query=$this->db->update('tbl_top10mostplayed',$data);
		}else{	
			$data['counter']=1; 
			$query=$this->db->insert('tbl_top10mostplayed',$data);
		}
	}
	public function insertTopPlayer($data){
		$check=$this->checkTopPlayer($data['location'],$data['name'],$data["user_id"]);
		if($check){
			$this->db->set('counter', 'counter+1', FALSE);
			$this->db->where('location',$data['location']);
			// $this->db->where('name',$data['name']);
			$this->db->where('user_id',$data['user_id']);
			$query=$this->db->update('tbl_top10player');
			// $query=$this->db->update('tbl_top10player',$data);
		}else{
			$data['counter']=1;
			$query=$this->db->insert('tbl_top10player',$data);
		}
	}
	public function insertTopSource($data){
		$check=$this->checkTopSource($data['location'],$data['source']);
		if($check){
			$this->db->set('counter', 'counter+1', FALSE);
			$this->db->where('location',$data["location"]);
			$this->db->where('source',$data["source"]);
			$query=$this->db->update('tbl_topsource',$data);
		}else{
			$data['counter']=1;
			$query=$this->db->insert('tbl_topsource',$data);
		}
	}
	public function insertTop($datasong,$dataplayer,$datasource){
		$this->db->trans_begin();
		$this->insertTopSong($datasong);
		$this->insertTopPlayer($dataplayer);
		$this->insertTopSource($datasource);
		if ($this->db->trans_status() === FALSE)
		{
			$this->db->trans_rollback();
			return false;
		}else{
			 $this->db->trans_commit();
			return true;
		}
	}
}
