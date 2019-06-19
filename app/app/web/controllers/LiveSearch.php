<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class LiveSearch extends CI_Controller {
	public function __construct(){
		parent::__construct();
		$this->load->model("PlaylistModel");
		$this->load->model("UserModel");
	}
	//search for user
	public function index()
	{
		$q=$_GET['q'];
		$admin=$this->session->userdata('user_admin');
		if($admin) {
			$loc=$this->session->userdata('user_id');
		} else {
			$loc=$this->session->userdata('user_id_admin');
		}
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
		echo json_encode($this->AddfromAPI());
	}
	// add song from api
	public function AddfromAPI(){
		$q=$_GET['q'];
		$htmlBody="";
		$i = 0;
		$status['status']=true;
		
		// Youtube API
		$DEVELOPER_KEY = $this->config->item("google_developer_key");
		$maxResults = 5;
		$client = new Google_Client();
		$client->setDeveloperKey($DEVELOPER_KEY);
		$youtube = new Google_Service_YouTube($client);			
		try {
			$searchResponse = $youtube->search->listSearch('snippet', array(
				'q' => $_GET['q'],
				'maxResults' => $maxResults,
				'type' => 'video',
				'videoDuration' => 'any',
				'videoSyndicated' => 'true'
			));
			foreach ($searchResponse['items'] as $searchResult) {
				$videoSearch = $youtube->videos->listVideos('snippet,contentDetails,statistics', array(
					'id' => $searchResult['id']['videoId']
				));
				//echo "<pre>";print_r($videoSearch["items"]);die;
				$status['data'][$i]['title'] = preg_replace("/('|\")/","",$searchResult['snippet']['title']);
				// $status['data'][$i]['title'] = $this->duapuluhchar(preg_replace("/('|\")/","",$searchResult['snippet']['title']));
				$status['data'][$i]['track_id'] = $searchResult['id']['videoId'];
				$status['data'][$i]['genre'] = "";
				$status['data'][$i]['from'] = 'youtube';
				$status['data'][$i]['duration_youtube'] = $this->covtime($videoSearch["items"][0]["contentDetails"]["duration"]);
				// $status['data'][$i]['thumbnails'] = $videoSearch["items"][0]["snippet"]["thumbnails"]["maxres"]["url"];
				// $status['data'][$i]['thumbnails_standard'] = $videoSearch["items"][0]["snippet"]["thumbnails"]["standard"]["url"];
				
				// $status['data'][$i]['statistics_viewcount'] = $videoSearch["items"][0]["statistics"]["viewCount"];
				// $status['data'][$i]['chanel_titlte'] = $videoSearch["items"][0]["snippet"]["channelTitle"];

				//$interval = new DateInterval($videoSearch["items"][0]["contentDetails"]["duration"]);
        			//$videoSearch["items"][0]["contentDetails"]["duration"]= $interval->h * 3600 + $interval->i * 60 + $interval->s;


								

				$status['data'][$i]['link'] = "https://www.youtube.com/watch?v=".$searchResult['id']['videoId'];
				$i++;
			}
		} catch (Google_Service_Exception $e) {
			$htmlBody .= sprintf('<p>A service error occurred: <code>%s</code></p>',
				htmlspecialchars($e->getMessage()));
		} catch (Google_Exception $e) {
			$htmlBody .= sprintf('<p>An client error occurred: <code>%s</code></p>',
				htmlspecialchars($e->getMessage()));
		}

		//$dur = $videoSearch["items"][0]["contentDetails"]["duration"];
						//$start = new DateTime('@0'); // Unix epoch
						//$start->add(new DateInterval($dur));
						//$start->format('H:i:s');
		
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
			$status['data'][$i]['title'] = preg_replace("/('|\")/","",$value['title']);
			// $status['data'][$i]['title'] = $this->duapuluhchar(preg_replace("/('|\")/","",$value['title']));
			$status['data'][$i]['track_id'] = $value['id'];
			$status['data'][$i]['genre'] = $value['genre'];
			$status['data'][$i]['from'] = 'soundcloud';
			$status['data'][$i]['link'] = $value['permalink_url'];
			$status['data'][$i]['duration_soundcloud'] = $value['duration'];
			// echo "<pre>";print_r($status['data'][$i]['duration']);die;
			$i++;
		}
		
		$status['length'] = count($status)-1;
		$status['err'] = "";
		$status['log'] = $htmlBody;
		return ($status);
	}




	// function converter time youtube
	public function covtime($youtube_time) {
	    preg_match_all('/(\d+)/',$youtube_time,$parts);

	    // Put in zeros if we have less than 3 numbers.
	    if (count($parts[0]) == 1) {
	        array_unshift($parts[0], "0", "0");
	    } elseif (count($parts[0]) == 2) {
	        array_unshift($parts[0], "0");
	    }

	    $sec_init = $parts[0][2];
	    if(strlen($sec_init) == 2) {
	    	$seconds = $sec_init%60;
	    } else {
	    	$seconds = '0'.$sec_init%60;
	    }

	    $seconds_overflow = floor($sec_init/60);

	    $min_init = $parts[0][1] + $seconds_overflow;
	    if(strlen(($min_init)%60) == 2) {
	    	$minutes = ($min_init)%60;
	    } else {
	    	$minutes = '0'.($min_init)%60;
	    }
	    $minutes_overflow = floor(($min_init)/60);

	    $hours = $parts[0][0] + $minutes_overflow;

	    if($hours != 0)
	        return $hours.':'.$minutes.':'.$seconds;
	    else
	        return $minutes.':'.$seconds;
	}	

	//end

	public function duapuluhchar($char){

		if(mb_detect_encoding($char) == 'UTF-8') {
      		$str = mb_substr($char,0,50,"utf-8"); 
      		//print_r($str);
      		return $char = substr($str,0,50).' ...';
  			}else{

			if(strlen($char) >= 50 ){
				
				return $char = substr($char,0,50). " " .'...';	

			}else{

				return $char;

			}

				}
  				
  	}


}
?>