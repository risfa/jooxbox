<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LiveSearch extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("PlaylistModel");
	}
	//search fro user
	public function index()
	{
        header('Access-Control-Allow-Origin: *');

        $q=$_GET['q'];
		$loc=$_GET['loc'];
		$playlist=$this->PlaylistModel->SearchPlaylist($q,$loc);
		//get playlist daily
		if($playlist){
			$status=$playlist;
			// return playlist
		}else{
			$status=$this->AddfromAPI();
			// return song from api
		}
		echo json_encode($status);
	}
	// search for admin
	public function SearchAll(){
        header('Access-Control-Allow-Origin: *');

        echo json_encode($this->AddfromAPI());
	}
	// add song from api
	public function AddfromAPI(){
        header('Access-Control-Allow-Origin: *');

        $q=$_GET['q'];
		$loc=$_GET['loc'];
		$i = 0;
		$status['status']=true;
		// Youtube API
		
		$DEVELOPER_KEY = $this->config->item("google_developer_key");
		
		$client = new Google_Client();
		$client->setDeveloperKey($DEVELOPER_KEY);
		$youtube = new Google_Service_YouTube($client);			
			try {
				$searchResponse = $youtube->search->listSearch('id,snippet', array(
					'q' => $_GET['q'],
					'maxResults' => 5,
					'type' => 'video',
					'videoDuration' => 'any',
					'videoSyndicated' => 'true'
				));
			} catch (Google_Service_Exception $e) {
				$htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
					htmlspecialchars($e->getMessage()));
			} catch (Google_Exception $e) {
				$htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
					htmlspecialchars($e->getMessage()));
			}
			foreach ($searchResponse['items'] as $searchResult) {
				$status[$i]['title'] = preg_replace("/('|\")/","",$searchResult['snippet']['title']);
				// $status[$i]['title'] = $this->duapuluhchar(preg_replace("/('|\")/","",$searchResult['snippet']['title']));
				$status[$i]['track_id'] = $searchResult['id']['videoId'];
				$status[$i]['genre'] = "";
				$status[$i]['from'] = 'youtube';
				$status[$i]['link'] = "https://www.youtube.com/watch?v=".$searchResult['id']['videoId'];
				$i++;
			}
			
		// SOUNCLOUD API
		
		$clientId= $this->config->item("soundcloud_id");
		$clientSecret= $this->config->item("soundcloud_key");
			
		$callback=base_url();
		$soundcloud = new Services_Soundcloud($clientId, $clientSecret, $callback);
		$wheredata = array(
							'q' => $q,
							'limit' => 5,
							'filter' => "public",
							'types' => 'original'
							);	
		$tracks = json_decode($soundcloud->get('tracks', $wheredata),true);
		foreach($tracks as $key => $value) {
			// $data[] = $value['title'];
			$status[$i]['title'] = preg_replace("/('|\")/","",$value['title']);
			$status[$i]['track_id'] = $value['id'];
			$status[$i]['genre'] = $value['genre'];
			$status[$i]['from'] = 'soundcloud';
			$status[$i]['link'] = $value['permalink_url'];
			$i++;
		}
		
		$status['length'] = count($status)-1;
		$status['err'] = "";
		return ($status);
	}
	public function Cari(){
        header('Access-Control-Allow-Origin: *');

        $q=$_GET['q'];
		$loc=$_GET['loc'];
		$i = 0;
		$status['status']=true;
		
		// Youtube API
		
		$DEVELOPER_KEY = $this->config->item("google_developer_key");
		
		$client = new Google_Client();
		$client->setDeveloperKey($DEVELOPER_KEY);
		$youtube = new Google_Service_YouTube($client);			
			try {
				$searchResponse = $youtube->search->listSearch('id,snippet', array(
					'q' => $_GET['q'],
					'maxResults' => 10,
					'type' => 'video',
					'videoDuration' => 'any',
					'videoSyndicated' => 'true'
				));
			} catch (Google_Service_Exception $e) {
				$htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
					htmlspecialchars($e->getMessage()));
			} catch (Google_Exception $e) {
				$htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
					htmlspecialchars($e->getMessage()));
			}
			foreach ($searchResponse['items'] as $searchResult) {
				$status[$i]['title'] = preg_replace("/('|\")/","",$searchResult['snippet']['title']);
				// $status[$i]['title'] = $this->duapuluhchar(preg_replace("/('|\")/","",$searchResult['snippet']['title']));
				$status[$i]['track_id'] = $searchResult['id']['videoId'];
				$status[$i]['genre'] = "";
				$status[$i]['from'] = 'youtube';
				$status[$i]['link'] = "https://www.youtube.com/watch?v=".$searchResult['id']['videoId'];
				$i++;
			}
			
		// SOUNCLOUD API
		
		$clientId= $this->config->item("soundcloud_id");
		$clientSecret= $this->config->item("soundcloud_key");
			
		$callback=base_url();
		$soundcloud = new Services_Soundcloud($clientId, $clientSecret, $callback);
		$wheredata = array(
							'q' => $q,
							'limit' => 5,
							'filter' => "public",
							'types' => 'original'
							);	
		$tracks = json_decode($soundcloud->get('tracks', $wheredata),true);
		foreach($tracks as $key => $value) {
			// $data[] = $value['title'];
			$status[$i]['title'] = preg_replace("/('|\")/","",$value['title']);
			$status[$i]['track_id'] = $value['id'];
			$status[$i]['genre'] = $value['genre'];
			$status[$i]['from'] = 'soundcloud';
			$i++;
		}
	
		$status['length'] = count($status)-1;
		$status['err'] = "";
		echo json_encode($status);
	}



	// public function duapuluhchar($char){

	// 	if(mb_detect_encoding($char) == 'UTF-8') {
 //      		$str = mb_substr($char,0,50,"utf-8"); 
 //      		//print_r($str);
 //      		return $char = substr($str,0,50).' ...';
 //  			}else{

	// 		if(strlen($char) >= 25 ){
				
	// 			return $char = substr($char,0,25). " " .'...';	

	// 		}else{

	// 			return $char;

	// 		}

	// 			}
  				
 //  	}


}
?>