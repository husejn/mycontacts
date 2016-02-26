<?php
	session_start();
	header('Content-Type: application/json');
	//login request
	//sign up request
	//view login/signup page
	//logged in redirect home -
	
	if(!isset($_SESSION['user_id']) && $_SESSION['user_id'] != "") { // logged in
		die("");
	}
	
	
	
	function getData($user_id_l){
		global $mysqli;
		$data = array();
		
		$query = $mysqli->query("SELECT `contact_id`, `name`, `phone_number`, `email`, `time_added`, `contact_public` FROM `contacts` where `user_id` = $user_id_l") or die();
		while ($r = $query->fetch_assoc()) {
			$data[] = array(
				'contact_id' => $r['contact_id'],
				'name' => $r['name'],
				'phone_number' => $r['phone_number'],
				'email' => $r['email'],
				'added_on' => $r['time_added'],
				'public' => $r['contact_public'],
			
			);

		}
		return $data;
	}
	
	$user_id = $_SESSION['user_id'];
	
	require_once('includes/db_connect.php');

	$print_data = array("data"=>getData($user_id));

	$json_string = json_encode($print_data, JSON_PRETTY_PRINT);
	
	print_r($json_string)

?>