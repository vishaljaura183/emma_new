<?php
include ('header.php');

//	echo "<style> #sidebar-left {display: none;} </style>";
//	echo $sql;
//	die;

//Updating
if( isset( $_POST['update_call_reason'] ) && isset( $_GET['id'] ) )
{
	
	
	$sql = "UPDATE call_reasons 
			SET
			`call_reason`='".$_POST['call_reason']."'
			 where `id` = ".$_GET['id'];

	if ($db->query($sql) === TRUE) {
		$_SESSION['success_msg'] = "Data updated.";
	} else {
	   	$_SESSION['error_msg'] = "Error: " . $sql . "<br>" . $db->error;
	}
}
else if( isset( $_POST['update_call_reason'] ) ) //Adding NEW reond in database
{
	
	$datetime = new DateTime();
	$sql = "INSERT INTO `call_reasons`
	(
	`call_reason`
	)
	VALUES
	(
	'".$_POST['call_reason']."'
	)";
	
	if ($db->query($sql) === TRUE) {
		$_SESSION['success_msg'] = "Data added.";
	} else {
	   	$_SESSION['error_msg'] = "Error: " . $sql . "<br>" . $db->error;
	}
} 

//Select the records from poll venues.
if( isset( $_GET['id'] ) )
{
	$sql = "SELECT * FROM call_reasons where id = ".$_GET['id'];
	$results = $db->query($sql);

	$results_arr = array();
	if ($results->num_rows > 0) {
    // output data of each row
	    $i = 0;
	    while($row = $results->fetch_assoc()) {
			$results_arr[$i]['id'] = $row["id"];        
			$results_arr[$i]['call_reason'] = $row["call_reason"];        
			
			$i++;
	    }
	}
}
?>

	<div class = "fixedSuccessMessage" title = 'discard' >
	<?php
		if( @$_SESSION['success_msg'] )
		{
			echo '<style>div.fixedSuccessMessage{display:block;}</style>';
			echo $_SESSION['success_msg'];
			unset($_SESSION['success_msg']);
		}
	?>
	</div>
	<div class = "fixedErrorMessage" title = 'discard' >
	<?php 
		if( @$_SESSION['error_msg'] )
		{
			echo '<style>div.fixedErrorMessage{display:block;}</style>';
			echo $_SESSION['error_msg'];
			unset($_SESSION['error_msg']);
		}
	?>
	</div>



<div id="content" class="span10">
	<ul class="breadcrumb">
		<li><i class="icon-home"></i> <a href="poll_venues.php">Home</a> <i
			class="icon-angle-right"></i></li>
		<li>
			<a href="#">
<?php			
				if( isset( $_GET['id'] ) ){				
					echo 'Edit Call Reason';
				}else{
					echo 'Add Call Reason';
				}
?>				
			</a>
		</li>
	</ul>
	<a href="<?php echo LIVE_SITE; ?>/reason_listing.php">View All Call Resons</a>
	<div class="row-fluid sortable">
		<div class="box span12">
			<div class="box-header" data-original-title>
				<h2>
					<i class="halflings-icon edit"></i>
						<span class="break"></span>
<?php			
					if( isset( $_GET['id'] ) ){				
						echo 'Edit';
					}else{
						echo 'Add';
					}
?>
						 
						&nbsp;&nbsp;<span style = 'color: green'><?php echo @$success_message ?></span>
				</h2>
				
				<div class="box-icon">
					<a href="#" class="btn-minimize">
						<i class="halflings-icon chevron-up"></i>
					</a> 
					<a href="#" class="btn-close">
						<i class="halflings-icon remove"></i>
					</a>
				</div>
			</div>
			
		<div class="box-content">
			<form class="form-horizontal" method="post" enctype="multipart/form-data" id="manage_poll_venue_form">
				<fieldset>
					<div class="control-group">
						<label style="color:red"><?php echo @$error; ?></label>
					</div>
					<div class="control-group" >
						<label class="control-label" for="focusedInput">Call Reason</label>
						<div class="controls">
						  <input class="input-xlarge" id="call_reason" type="text" value="<?php echo @$results_arr[0]['call_reason']?>" name = 'call_reason'>
						</div>
					 </div>
					
					
				
					
					<div class="form-actions">
						<button type="submit" name='update_call_reason' value = 'Save' class="btn btn-primary">Submit</button>
						<button type="reset" class="btn">Cancel</button>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>

</div>
<div class="modal hide fade" id="myModal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h3>Settings</h3>
	</div>
	<div class="modal-body">
		<p>Here settings can be configured...</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Close</a>
		<a href="#" class="btn btn-primary">Save changes</a>
	</div>
</div>
<?php
include('footer.php');
?>
<style>
label.error { 
margin-right: 200px;
color: red;
}
input.error {
border: 1px solid red !important; 
}
</style>
<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script>

$( "#manage_poll_venue_form" ).validate({
  rules: {
    'call_reason': {
      required: true
    }
	
  }
});
</script>
