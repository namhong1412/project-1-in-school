<?php
	session_start();
	header("Access-Control-Allow-Origin: *");
	header("Content-Type: application/json; charset=UTF-8");

	// include object database and login
	include_once '../config/database.php';
	include_once '../objects/login-admin.php';

	// instantiate login object
	$login = new Login();

	// value email and password user wrote
	$json = file_get_contents('php://input');
	$data_json = json_decode($json, true);
	
	$email = $data_json['email'];
	$password = $data_json['password'];

	// check user input data
	if ($password == "" || $email == "" || @$_SESSION['id']) {
		// set response code - 404 Not found
	    http_response_code(404);
	
	    // tell the user email or password wrong
	    echo json_encode(array("code" => 404,"message" => "Đăng nhập thất bại."));
	    die();
	}
	// mysqli_real_escape_string value input
	$password = mysqli_escape_string($login->get_connection(), $password);
	$email = mysqli_escape_string($login->get_connection(), $email);

	// assign user input to varialbe login object
	$login->email = $email;
	$login->password = $password;

	// query check email and password
	$check_login = $login->read();
	$data = mysqli_fetch_array($check_login);
	$password_db = $data['password'];

	if ($data['kinds'] == 2) {
		// set response code - 404 Not found
	    http_response_code(404);
	 
	    // tell the user email or password wrong found
	    echo json_encode(array("code" => 400,"message" => "Tài khoản của bạn đã bị khoá."));
	    die();
	}

	if (password_verify($login->password, $password_db)) {
		// get profile user
		$_SESSION['admin_id'] = $data['admin_id'];
		$_SESSION['name'] = $data['name'];
		$_SESSION['avatar'] = $data['avatar'];

		// set response code - 200 OK
	    http_response_code(200);
	 
	    // show products data in json format
	    echo json_encode(array("code" => 200,"message" => "Đăng nhập thành công."));
	    die();
	} else {
		// set response code - 404 Not found
	    http_response_code(404);
	 
	    // tell the user email or password wrong found
	    echo json_encode(array("code" => 404,"message" => "Đăng nhập thất bại."));
	    die();
	}
?>