<?php
	session_start();
	$thispage = "dashboard";
	
	$logged_in = isset($_SESSION['user_id']) && $_SESSION['user_id'] != "";
	
	if(!$logged_in) {
		header("Location: login.php");
		die();
	}
	require_once('includes/db_connect.php');
	$user_id = $_SESSION['user_id'];

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
		
		
		function getData($user_id_l){
			global $mysqli;
			$html = "";
			
			$query = $mysqli->query("SELECT `contact_id`, `name`, `phone_number`, `email`, `time_added`, `contact_public` FROM `contacts` where `user_id` = $user_id_l") or die();
			while ($r = $query->fetch_assoc()) {
				
				$html .= "<tr>";
					$html .= "<td>" . htmlspecialchars($r['contact_id']) . "</td>";
					$html .= "<td>" . htmlspecialchars($r['name']) . "</td>";
					$html .= "<td>" . htmlspecialchars($r['phone_number']) . "</td>";
					$html .= "<td>" . htmlspecialchars($r['email']) . "</td>";
					
					$phpdate = strtotime( $r['time_added'] );
					$mysqldate = date( 'd M Y H:i:s', $phpdate );
					
					$html .= "<td>" . htmlspecialchars($mysqldate) . "</td>";
					$html .= "<td>" . ( $r['contact_public'] ?'true' : 'false') . "</td>";
				$html .= "</tr>";

			}
			return $html;
		}
		
	?>
    
    <div class="container">
	<h2><?php echo htmlspecialchars(ucfirst($_SESSION['name'])); ?>'s Contacts
	
	<button id="delete" type="button" class="btn btn-sm btn-danger">
		<span class="glyphicon glyphicon-remove"></span>&nbsp;Delete
	</button>

	<button id="edit" type="button" class="btn btn-sm btn-primary">
		<span class="glyphicon glyphicon-edit"></span>&nbsp;Edit
	</button>
	
	<button id="add" type="button" class="btn btn-sm btn-default" data-toggle="modal" data-target="#addModal">
		<span class="glyphicon glyphicon-plus"></span>&nbsp;Add
	</button>
	</h2>

	
	
	<table id="datatable" class="stripe" cellspacing="0" width="100%">
        <thead>
            <tr>
                <th>Contact ID</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Added On</th>
                <th>Public</th>
            </tr>
        </thead>
        
		<tbody>
		
			<?php
				echo getData($user_id);
			?>
		</tbody>
		<tfoot>
            <tr>
                <th>Contact ID</th>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Added On</th>
                <th>Public</th>
            </tr>
        </tfoot>
	</table>
			
 
			
			
			
			
			
    </div>
	
	
	
	
	<!-- Modal -->
<div id="addModal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Contact</h4>
            </div>
            <form class="form-horizontal" onsubmit="" id="add-form-horizontal" role="form">
                <div class="modal-body">
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="inputname">Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputname" placeholder="Name" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="inputphonenumber">Phone Number</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="inputphonenumber" placeholder="Phone Number" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="inputemail">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="inputemail" placeholder="Email" />
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <div class="checkbox">
                                <label>
                            <input id="inputpublic" type="checkbox"/> Make contact publicly available
                        </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <img style="display:none" id="addloading" src="images/loading.gif" alt="loading" />
                    <button type="submit" id="addButtonModal" class="btn btn-primary">Save</button>
                    <button type="button" id="cancelButtonModal" class="btn btn-default">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>


<!-- Modal -->
<div id="editModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Edit Contact</h4>
            </div>
            <form class="form-horizontal" onsubmit="" id="edit-form-horizontal" role="form">
                <div class="modal-body">

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Contact ID</label>
                        <div class="col-sm-9">
                            <label id="updatecontactid" style="padding-top: 7px; font-weight: normal"></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="updateinputname">Name</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="updateinputname" placeholder="Name" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="updateinputphonenumber">Phone Number</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="updateinputphonenumber" placeholder="Phone Number" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-sm-3 control-label" for="updateinputemail">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" id="updateinputemail" placeholder="Email" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="col-sm-3 control-label">Added On</label>
                        <div class="col-sm-9">
                            <label id="updatedate" style="padding-top: 7px; font-weight: normal"></label>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-sm-offset-3 col-sm-9">
                            <div class="checkbox">
                                <label>
                            <input id="updateinputpublic" type="checkbox"/> Make contact publicly available
                        </label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <img style="display:none" id="uloading" src="images/loading.gif" alt="loading" />
                    <button type="submit" id="updateButtonModal" class="btn btn-primary">Update</button>
                    <button type="button" id="updatecancelButtonModal" class="btn btn-default">Cancel</button>
                </div>
            </form>
        </div>

    </div>
</div>
	
	
	<?php
		include_once("includes/footer.php");
	?>
	<script src="js/jquery.dataTables.min.js"></script>
	<script>
$(document).ready(function() {
    var table = $('#datatable').DataTable();
    table
        .order([4, 'desc'])
        .draw();

    $('#datatable tbody').on('click', 'tr', function() {
        if ($(this).hasClass('selected')) {
            $(this).removeClass('selected');
        } else {
            table.$('tr.selected').removeClass('selected');
            $(this).addClass('selected');
        }
    });


    function getIdFromNode(node) {
        return node.querySelector('tr td:first-child').innerText;
    }

    function getContactFromNode(node) {
        var contact = [];
        contact['contact_id'] = node.querySelector('td:nth-child(1)').innerText;
        contact['name'] = node.querySelector('td:nth-child(2)').innerText;
        contact['phone_number'] = node.querySelector('td:nth-child(3)').innerText;
        contact['email'] = node.querySelector('td:nth-child(4)').innerText;
        contact['time_added'] = node.querySelector('td:nth-child(5)').innerText;
        contact['contact_public'] = node.querySelector('td:nth-child(6)').innerText;
        return contact;
    }

    function updateArow(node, contact) {
        console.log(contact);
        node.querySelector('td:nth-child(2)').innerText = contact['name'];
        node.querySelector('td:nth-child(3)').innerText = contact['phone_number'];
        node.querySelector('td:nth-child(4)').innerText = contact['email'];

        node.querySelector('td:nth-child(6)').innerText = contact['contact_public'];
    }

    var node;
    $('#delete').click(function() {
        if (!table.row('.selected').node()) {
            alert("Click to the row you want to delete before clicking this button.");
            return;
        }

        var id = getIdFromNode(table.row('.selected').node());

        if (confirm("You are about to delete contact id: " + id + ".\nThis step is irreversible.")) {
            $.ajax({
                type: "GET",
                url: "contacts_manager.php?action=delete&data=" + id,
                data: "",
                success: function(msg) {
                    table.row('.selected').remove().draw(false);
                }
            });
        }
    });

    $('#edit').click(function() {
        if (!table.row('.selected').node()) {
            alert("Click to the row you want to edit before clicking this button.");
            return;
        }
		
        $('#editModal').modal('show');
        var contact = getContactFromNode(table.row('.selected').node());
		
        $('#updatecontactid').text(contact['contact_id']);
        $('#updateinputname').val(contact['name']);
        $('#updateinputphonenumber').val(contact['phone_number']);
        $('#updateinputemail').val(contact['email']);
        $('#updatedate').text(contact['time_added']);;
        if (contact['contact_public'] == 'true') $("#updateinputpublic").attr('checked', true)
        else $("#updateinputpublic").attr('checked', false);
    })

    function emptyModal() {
        $('#addModal input').val('');
        $('#addModal input[type=checkbox]').attr('checked', false);
        $('#updateButtonModal').removeAttr('disabled');
        $('#addloading').hide();
    }

    function emptyEditModal() {
        $('#updatecontactid').text('');
        $('#updateinputname').val('');
        $('#updateinputphonenumber').val('');
        $('#updateinputemail').val('');
        $('#updatedate').text('');;
        $("#updateinputpublic").attr('checked', false)
        $('#updateloading').hide();
    }

    $("#edit-form-horizontal").submit(function(event) {
        event.preventDefault();
        $('#addButtonModal').attr('disabled', 'disabled');
        $('#updateloading').show();
        var contact = [];

        contact['name'] = $('#updateinputname').val();
        contact['phone_number'] = $("#updateinputphonenumber").val();
        contact['email'] = $("#updateinputemail").val();
        contact['contact_public'] = $('#updateinputpublic')[0].checked ? "true" : "false";

        $.ajax({
            type: "POST",
            url: "contacts_manager.php?action=update&data=" + $("#updatecontactid").text(),
            data: "name=" + contact['name'] + "&phonenumber=" + contact['phone_number'] + "&inputemail=" + contact['email'] + "&inputpublic=" + ($('#updateinputpublic')[0].checked ? "1" : "0"),
            success: function(msg) {
                $('#editModal').modal('hide');
                emptyEditModal();

                var node = table.row('.selected').node()

                updateArow(node, contact);

            }
        });
    });

    $("#add-form-horizontal").submit(function(event) {
        event.preventDefault();
        $('#addButtonModal').attr('disabled', 'disabled');
        $('#addloading').show();

        $.ajax({
            type: "POST",
            url: "contacts_manager.php?action=add&data=_",
            data: "name=" + $('#inputname').val() + "&phonenumber=" + $("#inputphonenumber").val() + "&inputemail=" + $("#inputemail").val() + "&inputpublic=" + ($('#inputpublic')[0].checked ? "1" : "0"),
            success: function(msg) {
                $('#addModal').modal('hide');
                emptyModal();
                table.row.add([
                    msg['contact_id'],
                    msg['name'],
                    msg['phone_number'],
                    msg['email'],
                    msg['time_added'],
                    msg['contact_public']
                ]).draw(false);
            }
        });
    });
    $('#updatecancelButtonModal').on('click', function() {
        $('#editModal').modal('hide');
        emptyEditModal();
    });
    $('#cancelButtonModal').on('click', function() {
        $('#addModal').modal('hide');
        emptyModal();
    });
});

	
	
	</script>
  </body>
</html>




