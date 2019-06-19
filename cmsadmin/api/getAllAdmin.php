<?php
	require_once "../config.php";
	$where["AND"] = ["register_as" => 'admin'];
	// $where["ORDER"] = ["last_login" => "DESC"];
	$allAdmin = $db->select("tbl_user","*",$where);
	$data = array();
	$i = 0;
	foreach($allAdmin as $val) {
		$data['data'][$i]['user_id'] = $val['user_id'];
		$data['data'][$i]['username'] = $val['username'];
		$data['data'][$i]['email'] = $val['email'];
		$data['data'][$i]['last_login'] = date("d M y H:i:s",strtotime($val['last_login']));
		$data['data'][$i]['address'] = $val['address'];
		if($val["type_admin"] == 1) {
			$data['data'][$i]['type'] = "Testing";
		} else if($val["type_admin"] == 2) {
			$data['data'][$i]['type'] = "Comunity";
		} else if($val["type_admin"] == 3) {
			$data['data'][$i]['type'] = "Personal";
		} else if($val["type_admin"] == 9) {
			$data['data'][$i]['type'] = "Official Partner";
		} else {
			$data['data'][$i]['type'] = "Unknown";
		}
		$data['data'][$i]['location'] = $val['location_name'];
		$i++;
	}
	echo json_encode($data);
?>