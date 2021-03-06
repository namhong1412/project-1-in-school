<?php
	session_start();
	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json; chartset="UTF-8"');
	date_default_timezone_set('Asia/Ho_Chi_Minh');

	// include object database and login
	include_once '../config/database.php';
	include_once '../objects/editor.php';

	// Product object
	$editor = new Editor();

	// check access admin
	$admin_id = $_SESSION['admin_id'];
	$editor->admin_id($admin_id);
	$check = $editor->check_access();
	if ($check != 0) {
		header('location: /index.php');
		die();
	}
	// value input user
	if (!@file_get_contents('php://input')) {
		// set reponse code
		http_response_code(400);

		// send data json 
		echo json_encode(array('code' => 400, 'message' => 'Lỗi (･´з`･)'));
		die();
	}

	$json = file_get_contents('php://input');
	$data_json = json_decode($json, true);
	$admin_id = $data_json['id'];
	

	if ($admin_id == '') {
		// set reponse code
		http_response_code(400);

		// send data json 
		echo json_encode(array('code' => 400, 'message' => 'Lỗi (･´з`･)'));
		die();
	}

	// send value input to object
	$editor->admin_id($admin_id);


	try {
		$check = $editor->check_exist();
		if ($check != 0) {
			$editor->kinds(1);
			// lock editor
			$editor->delete();
			// set reponse code - 400
			http_response_code(200);

			// send data json
			echo json_encode(array('code' => 200, 'message' => 'Unlock'));
			die();
		}
		$editor->kinds(2);
		// lock editor
		$editor->delete();
		// set reponse code - 400
		http_response_code(200);

		// send data json 
		echo json_encode(array('code' => 200, 'message' => 'Locked'));


	} catch (Exception $e) {
		// set reponse code - 400
		http_response_code(400);

		// send data json 
		echo json_encode(array('code' => 400, 'message' => 'Lỗi (･´з`･)'));
		die();
	}
?>