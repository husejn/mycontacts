<?php
	session_start();
	header('Content-type: application/json');
	$user_id = $_SESSION['user_id'];
	if(empty($user_id) || $user_id == null || $user_id == 0 ) {
		//header ("Location: account.php");	
		die();
	}
	
	function removeContact($contact_id){
		global $user_id;
		global $mysqli;
		trim($contact_id);
		$contact_id = $mysqli->real_escape_string($contact_id);
		$contact_id = (int) $contact_id;
		$query = $mysqli->query("DELETE FROM `contacts` where `contact_id` = $contact_id AND `user_id` = $user_id");
		print_r (json_encode(true, JSON_PRETTY_PRINT));
	}
	function readContact($contact_id){
		global $user_id;
		global $mysqli;
		$arr = array();

			$query = $mysqli->query("SELECT `contact_id`, `name`, `phone_number`, `email`, `time_added`, `contact_public` FROM `contacts` where `contact_id` = $contact_id AND `user_id` = $user_id") or die();
			while ($r = $query->fetch_assoc()) {
				
				$arr['contact_id'] = htmlspecialchars($r['contact_id']);
				$arr['name'] = htmlspecialchars($r['name']);
				$arr['phone_number'] = htmlspecialchars($r['phone_number']);
				$arr['email'] = htmlspecialchars($r['email']);
				
				$phpdate = strtotime( $r['time_added'] );
				$mysqldate = date( 'd M Y H:i:s', $phpdate );
				
				$arr['time_added'] = htmlspecialchars($mysqldate);
				$arr['contact_public'] = ( $r['contact_public'] ?'true' : 'false');

			}
			return $arr;
		
	}
	function addContact($name="", $phone_number="", $email="", $public = 0){
		global $user_id;
		global $mysqli;
		trim($name);
		$name = $mysqli->real_escape_string($name);
		trim($phone_number);
		$phone_number = $mysqli->real_escape_string($phone_number);
		trim($email);
		$email = $mysqli->real_escape_string($email);
		trim($public);
		$public = $mysqli->real_escape_string($public);

		$query = $mysqli->query("INSERT INTO `contacts` (`user_id`, `name`, `phone_number`, `email`, `contact_public`) VALUES ($user_id, '$name', '$phone_number', '$email', $public)");
		
		
		$retArr = readContact($mysqli->insert_id);
		print_r (json_encode($retArr, JSON_PRETTY_PRINT));
	}	
	function updateContact($contact_id="", $name="", $phone_number="", $email="", $public = 0){
		global $user_id;
		global $mysqli;
		trim($contact_id);
		$contact_id = $mysqli->real_escape_string($contact_id);
		trim($name);
		$name = $mysqli->real_escape_string($name);
		trim($phone_number);
		$phone_number = $mysqli->real_escape_string($phone_number);
		trim($email);
		$email = $mysqli->real_escape_string($email);
		trim($public);
		$public = $mysqli->real_escape_string($public);
		$query = $mysqli->query("UPDATE `contacts` SET `name`='$name', `phone_number`='$phone_number', `email`='$email', `contact_public`=$public where `user_id` = $user_id AND `contact_id` = $contact_id");
		print_r (json_encode('updated', JSON_PRETTY_PRINT));
	}	
	function searchContactByName($q){
		global $user_id;
		$query = "SELECT `contact_id`, `time_added`, `name`, `phone_number`, `email` FROM `contacts` where `name` LIKE '%$q%' AND `user_id` = '$user_id'";
		
	}
	function searchContactByPhone($q){
		global $user_id;
		$query = "SELECT `contact_id`, `time_added`, `name`, `phone_number`, `email` FROM `contacts` where `phone_number` LIKE '%$q%' AND `user_id` = '$user_id'";
	}
	function printContacts($conArr){
		//print r json

	}

	function printResponse($response){
		//success = true || false;
	}
	
	if(!isset($_GET['action']) || !isset($_GET['data']) || empty($_GET['action']) || empty($_GET['data'])) {
		die("Bad Request");	
	}
	$action = $_GET['action'];

	$data = $_GET['data'];
	
	include_once("includes/db_connect.php");
	if($action == "delete"){
		removeContact($data);
	} 
	else if($action == "add"){
		
		$name = $_POST['name'];
		$phone = $_POST['phonenumber'];
		$email = $_POST['inputemail'];
		$contact_public = $_POST['inputpublic'];
		
		addContact($name, $phone, $email, $contact_public);	
	} else if($action == 'update'){
		$contact_id = $_GET['data'];
		$name = $_POST['name'];
		$phone = $_POST['phonenumber'];
		$email = $_POST['inputemail'];
		$contact_public = $_POST['inputpublic'];
		updateContact($contact_id, $name, $phone, $email, $contact_public);
		
		
	}
	die();
	
	
	

	
	
?>