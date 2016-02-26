<?php
	session_start();
	$thispage = "login";
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
			return 0;
		} 
		while ($r = $query->fetch_assoc()) {
			$_SESSION['user_id'] = $r['user_id'];
			$_SESSION['username'] = $r['username'];
			$_SESSION['name'] = $r['name'];
			$_SESSION['email'] = $r['email'];
		}
		header("Location: dashboard.php");
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
	
		
		$user = basicChecker('username', 'User Name');
		$pass = basicChecker('inputpassword', 'Password');
		
		if(count($errors) == 0){
			session_unset();
			require_once("includes/db_connect.php");
			login($user, $pass);
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
    <title>Login</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body>
	<?php
		include_once("includes/header.php");
	?>
    
    <div class="container">

		<form method="post" action="" class="form-signin">
			<h2 class="form-signin-heading">Please sign in</h2>
			<label for="username" class="sr-only">User Name</label>
			<input type="text" id="username" name="username" class="form-control" placeholder="User Name" required="" autofocus="">
			<label for="inputpassword" class="sr-only">Password</label>
			<input type="password" id="inputpassword" name="inputpassword" class="form-control" placeholder="Password" required="" autocomplete="off" style="padding-right: 25px;">
			<?php
				if(count($errors) > 0){
					printErrors();
				}
			?>
			
			
			<button class="btn btn-lg btn-primary btn-block" style="margin-top: 16px" type="submit">Sign in</button>
		</form>
		<div>
			<p style="text-align: center;margin: 24px;">Dont have an account? <a href="signup.php">Sign Up</a>.</p>
		</div>
    </div>
	
	<?php
		include_once("includes/footer.php");
	?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>




