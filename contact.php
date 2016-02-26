<?php
	session_start();
	$thispage = "contact";
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
    <title>MyContacts - Contact</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
  </head>

  <body>
	<?php
		include_once("includes/header.php");
	?>
    
    <div class="container">

      <div class="starter-template">
		<h1>This page is not implemented yet.</h1>
		<div class="buttonholder">

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
