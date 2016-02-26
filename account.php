<?php
	
	//login request
	//sign up request
	//view login/signup page
	//logged in redirect home -
	
	if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != "") { // logged in
		header("Location: index.php");
		die();
	}
	function login($user, $pass){
		global $mysqli;
		$password_hash = md5($pass);
		$query = $mysqli->query("SELECT * FROM `users` where `username` = '$user' and `password` = '$password_hash'") or die();
		if($query->num_rows == 0){
			addError("Username or password is incorrect");
			return 0;
		} 
		while ($r = $query->fetch_assoc()) {
			$_SESSION['user_id'] = $r['user_id'];
		}
	}
	function signup($user, $pass, $name, $email){
		global $mysqli;
		$password_hash = md5($pass);
		$query = "INSERT INTO `users` (`username`, `password`, `name`, `email`) VALUES('$user', '$password_hash', '$name', '$email'";
		$mysqli->query($sql) or die();
		return login($user, $pass);
	}
	function checkUsernameAvailable($username){
		$query = "SELECT * FROM `users` where `username` = '$username'";
		if(num_rows() == 1){
			return false;
		}
		return true;
	}
	function checkEmailAvailable($email){
		$query = "SELECT * FROM `users` where `email` = '$email'";
		if(num_rows() == 1){
			return false;
		}
		return true;
	}
	
	
	if($_REQUEST["POST"]){ //log in or signup request
		
		
		if($requestlogin){
			$required = array('username' => 'User Name', 'password' => "Password");
			$error = array();
			foreach($required as $field => $print) {
			  if (!isset($_POST[$field]) || empty($_POST[$field])) {
				$error[] = "$print is required.";
			  }
			}
			if(count($error) == 0) { //good to go
				login($_POST['username'], $_POST['password']);
			} 
			else { //print errors
				
			}
		}
		else if($requestSignUp){
			$required = array('username' => 'User Name', 'password' => 'Password', 'name' => 'Full Name', 'email' => 'Email' );
			foreach($required as $field => $print) {
			  if (!isset($_POST[$field]) || empty($_POST[$field])) {
				$error[] = "$print is required.";
			  }
			}
			if(!filter_var("Email", $_POST['email']))
				$error[] = "Please enter a valid email address";
			if(!checkUsernameAvailable($_POST['username']))
				$error[] = "Username is already used.";
			if(!checkEmailAvailable($_POST['email']))
				$error[] = "Email is already used.";
			
			if(count($error) == 0) { //good to go
				signup($_POST['username'], $_POST['password'], $_POST['name'], $_POST['email']);
			} 
			else { //print errors
				
			}	
		}
			
	}

	


?>