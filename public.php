<?php
	session_start();
	$thispage = "public_contacts";
	
	$logged_in = isset($_SESSION['user_id']) && $_SESSION['user_id'] != "";
	
	/*if(!$logged_in) {
		header("Location: login.php");
		die();
	}*/
	require_once('includes/db_connect.php');

?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <title><?php echo htmlspecialchars(ucfirst($_SESSION['name'])); ?>'s Contacts</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
	
	<script src="js/jquery-1.11.3.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	
  </head>

  <body>
	<?php
		include_once("includes/header.php");
		
		
		function getPublicData(){
			global $mysqli;
			$html = "";
			
			$query = $mysqli->query("SELECT `contacts`.`contact_id`, `users`.`name` as `users_name` , `contacts`.`name` as `contacts_name`, `contacts`.`phone_number`, `contacts`.`email`, `contacts`.`time_added` FROM `contacts` INNER JOIN `users` ON `contacts`.`user_id` = `users`.`user_id` where `contact_public` = 1") or die();
			while ($r = $query->fetch_assoc()) {
				
				$html .= "<tr>";
					$html .= "<td>" . htmlspecialchars($r['contact_id']) . "</td>";
					$html .= "<td>" . htmlspecialchars($r['users_name']) . "</td>";
					$html .= "<td>" . htmlspecialchars($r['contacts_name']) . "</td>";
					$html .= "<td>" . htmlspecialchars($r['phone_number']) . "</td>";
					$html .= "<td>" . htmlspecialchars($r['email']) . "</td>";
					
					$phpdate = strtotime( $r['time_added'] );
					$mysqldate = date( 'd M Y H:i:s', $phpdate );
					
					$html .= "<td>" . htmlspecialchars($mysqldate) . "</td>";
				$html .= "</tr>";

			}
			return $html;
		}
		
	?>
    
    <div class="container">
	<h2>Public Contacts</h2>

	
	
	<table id="datatable" class="stripe" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Contact ID</th>
                <th>Created By</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Added On</th>
            </tr>
        </thead>
        
		<tbody>
		
<?php
				echo getPublicData();
			?>
		</tbody>

		<tfoot>
            <tr>
                <th>Contact ID</th>
                <th>Created By</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Added On</th>
            </tr>
        </tfoot>
	</table>
			
			
    </div>

	<?php
		include_once("includes/footer.php");
	?>
	<script src="js/jquery.dataTables.min.js"></script>
	<script>
		$(document).ready(function() {
		    var table = $('#datatable').DataTable();
			table.order( [ 5, 'desc' ] ).draw();
		} );
	</script>
  </body>
</html>




