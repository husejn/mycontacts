<?php
	session_start();
	$thispage = "home";
	$logged_in = isset($_SESSION['user_id']) && $_SESSION['user_id'] != "";

	
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title>MyContacts Homepage</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body>
	<?php
		include_once("includes/header.php");
	?>
    
    <div class="container">

      <div class="starter-template">
		<?php 
		if($logged_in){
			echo "<h1>Welcome " . htmlspecialchars($_SESSION['name']) . "</h1>";
			
		} else {
			echo "<h1>MyContacts Web Interface</h1>";
			echo "<p class=\"lead\">Please login or sign up to use this web application.</p>";
		}
		?>
		<div class="buttonholder">
			<?php
			if($logged_in){
				echo '<a href="dashboard.php"><button type="button" class="btn btn-primary btn-block">Go to Dashboard</button></a>';
				echo '<a href="logout.php"><button style="margin-top: 6px;" type="button" class="btn btn-link btn-block">Log Out</button></a>';
			}
			else {
				echo '<a href="login.php"><button type="button" class="btn btn-primary btn-block">Login</button></a>';
				echo '<a href="signup.php"><button style="margin-top: 6px;" type="button" class="btn btn-success btn-block">Sign Up</button></a>';
			}
			?>
		</div>
		</div>
      </div>

    </div>
	<?php
		include_once("includes/footer.php");
	?>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
  </body>
</html>
