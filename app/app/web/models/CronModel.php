<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class CronModel extends CI_Model {
	public function __construct(){
		parent::__construct();
	}
	
	public function clearPlaylistDaily() {
		$this->db->where("play",0);
		$this->db->update("tbl_playlist",["play" => 1]);
	}
	
	public function clearChatAndPlaylistWeekly() {
		
		$this->db->truncate("tbl_prev_week_chart");
		
		$this->db->select("user_id");
		$this->db->where("register_as","admin");
		$this->db->order_by("user_id asc");
		$allAdmin = $this->db->get("tbl_user");
		$i = 0;
		foreach($allAdmin->result_array() as $val) {
			$this->db->where("location", $val["user_id"]);
			$this->db->order_by("counter desc");
			$this->db->limit(10);
			$topTenSongFromLoc = $this->db->get("tbl_top10mostplayed");
			if($topTenSongFromLoc->num_rows() > 0) {
				foreach($topTenSongFromLoc->result_array() as $val) {
					$data[$i]["prev_week_chart_id"] = $val["top10mostplayed_id"];
					$data[$i]["track_id"] = $val["track_id"];
					$data[$i]["link"] = $val["link"];
					$data[$i]["genre"] = $val["genre"];
					$data[$i]["title"] = $val["title"];
					$data[$i]["location"] = $val["location"];
					$data[$i]["counter"] = $val["counter"];
					$i++;
				}
			}
		}
		
		$this->db->insert_batch('tbl_prev_week_chart', $data);
		
		$dateNow = date("Y-m-d");
		$twoWeeks = date("Y-m-d",strtotime("-1 month"));
		$this->db->where("created <=",$twoWeeks);
		$this->db->delete("tbl_playlist");
		
		$this->db->truncate("tbl_top10mostplayed");
		
		$this->db->truncate("tbl_chat");
	}
	
	public function logout() {
		$this->db->where("flag_login",1);
		// $this->db->where("register_as","admin");
		$this->db->update("tbl_user",["flag_login" => 0]);
	}
}