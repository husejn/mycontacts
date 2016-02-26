<?php
	session_start();
	$thispage = "sign_up";
	$errors = [];
	
	if(isset($_SESSION['user_id']) && $_SESSION['user_id'] != "") { // logged in
		header("Location: dashboard.php");
		die();
	}
	
	function login($user, $pass){
		global $mysqli;
		trim($user);
		trim($pass);
		$user = $mysqli->real_escape_string($user);
		$pass = $mysqli->real_escape_string($pass);
		$password_hash = md5($pass);
		$query = $mysqli->query("SELECT * FROM `users` where `username` = '$user' and `password` = '$password_hash'") or addError("Unknown Error");
		if($query->num_rows == 0){
			addError("Username or password is incorrect");
			return;
		} 
		while ($r = $query->fetch_assoc()) {
			$_SESSION['user_id'] = $r['user_id'];
			$_SESSION['username'] = $r['username'];
			$_SESSION['name'] = $r['name'];
			$_SESSION['email'] = $r['email'];
		}
		header("Location: dashboard.php");
	}
	
	
	function signup($user, $pass, $name, $email){
		global $mysqli;
		trim($user);
		trim($pass);
		trim($name);
		trim($email);
		
		$user = $mysqli->real_escape_string($user);
		$pass = $mysqli->real_escape_string($pass);
		$name = $mysqli->real_escape_string($name);
		$email = $mysqli->real_escape_string($email);
		
		$password_hash = md5($pass);
		$query = "INSERT INTO `users` (`username`, `password`, `name`, `email`) VALUES('$user', '$password_hash', '$name', '$email')";
		print_r($query);
		$mysqli->query($query) or die();
		
		return login($user, $pass);
	}
	function checkUsernameAvailable($user){
		global $mysqli;
		$user = $_POST[$user];
		trim($user);
		$user = $mysqli->real_escape_string($user);
		$query = $mysqli->query("SELECT * FROM `users` where `username` = '$user'") or addError("Unknown Error");
		if($query->num_rows > 0){
			addError("User Name is already in use");
			return;
		}
	}
	function checkEmailAvailable($email){
		global $mysqli;
		$email = $_POST[$email];
		trim($email);
		$user = $mysqli->real_escape_string($email);
		$query = $mysqli->query("SELECT * FROM `users` where `email` = '$email'") or addError("Unknown Error");
		if($query->num_rows > 0){
			addError("Email is already in use");
			return;
		}
	}
	
	function addError($e){
		global $errors;
		$errors[] = $e;
	}
	function printErrors(){
		global $errors;
		echo '<ul style="list-style: none;color: red;font-weight: bold;font-size: 13px;margin: 0;padding: 0;">';
		foreach($errors as $error){
			echo "<li>$error</li>";
		}
		echo "</ul>";
	}
	//returns the value
	function basicChecker($postItemId, $desc = "", $isEmail = false){
		if(!isset($_POST[$postItemId]) || empty($_POST[$postItemId])){
			addError("Please enter $desc");
			return;
		}
		if($isEmail && !filter_var($_POST[$postItemId], FILTER_VALIDATE_EMAIL)){
			addError("Please enter a valid email address.");
			return;
		}
		return $_POST[$postItemId];
	}
	if ( $_SERVER['REQUEST_METHOD'] == "POST") {
		require_once("includes/db_connect.php");
		
		$user = basicChecker('username', 'User Name');
		$name = basicChecker('name', 'Name');
		$email = basicChecker('inputemail', 'Email', true);
		$pass = basicChecker('inputpassword', 'Password');
		checkEmailAvailable('inputemail');
		checkUsernameAvailable('username');
		
		if(count($errors) == 0){
			session_unset();
			signup($user, $pass, $name, $email);
		}
	}
		
	

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>Sign Up</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body>
	<?php
		include_once("includes/header.php");
	?>
    
    <div class="container">

		<form method="post" action="" class="form-signin">
			<h2 class="form-signin-heading">Fill the form to sign up</h2>
			<label for="username" class="sr-only">User name</label>
			<input type="text" id="username" name="username" class="form-control" placeholder="User Name" required="" autofocus="">
			<label for="name" class="sr-only">Name</label>
			<input type="text" id="name" name="name" class="form-control" placeholder="Name" required="" autofocus="">
			<label for="inputemail" class="sr-only">Email address</label>
			<input type="email" id="inputemail" name="inputemail" class="form-control" placeholder="Email address" required="">
			<label for="inputpassword" class="sr-only">Password</label>
			<input type="password" id="inputpassword" name="inputpassword" class="form-control" placeholder="Password" required="" autocomplete="off" style="padding-right: 25px;">

			<?php
				if(count($errors) > 0){
					printErrors();
				}
			?>
			
			<button class="btn btn-lg btn-primary btn-block" style="margin-top: 16px" type="submit">Sign Up</button>
		</form>
		<div>
			<p style="text-align: center;margin: 24px;">Already have an account? <a href="login.php">Login</a>.</p>
		</div>
    </div>
	
	<?php
		include_once("includes/footer.php");
	?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>




