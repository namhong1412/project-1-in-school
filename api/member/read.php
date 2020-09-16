<?php
	session_start();
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json; chartset="UTF-8"');
	date_default_timezone_set('Asia/Ho_Chi_Minh');

	// include object database and login
	include_once '../config/database.php';
	include_once '../objects/member.php';

	// Product object
	$member = new Member();
	$data = [];
	
	// check access admin
	$admin_id = $_SESSION['admin_id'];
	$member->admin_id($admin_id);
	$check = $member->check_access();
	if ($check != 0) {
		header('location: /index.php');
		die();
	}

	try {
		$query = $member->read();
		$i = 0;
		while ($row = mysqli_fetch_array($query)) {
			$data['result'][$i]['id'] = $row['user_id'];
			$data['result'][$i]['name'] = $row['name'];
			$data['result'][$i]['email'] = $row['email'];
			if ($row['created'] == 0) {
				$data['result'][$i]['status'] = 'Mở khoá';
			} else {
				$data['result'][$i]['status'] = 'Khoá';
			}
			$i++;
		}
		// set reponse code - 200 OK
		http_response_code(200);
		// send data json 
		echo json_encode($data);

	} catch (Exception $e) {
		// set reponse code - 400
		http_response_code(400);

		// send data json 
		echo json_encode(array('code' => 400, 'message' => 'Lỗi (･´з`･)'));
		die();
	}
?>