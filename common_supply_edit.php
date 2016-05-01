<?php
include ('header.php');

//	echo "<style> #sidebar-left {display: none;} </style>";
//	echo $sql;
//	die;

//Updating
if( isset( $_POST['update_common_supply'] ) && isset( $_GET['id'] ) )
{
	
	
	$sql = "UPDATE common_election_supplies 
			SET
			`common_supply`='".$_POST['common_supply']."'
			 where `id` = ".$_GET['id'];

	if ($db->query($sql) === TRUE) {
		$_SESSION['success_msg'] = "Data updated.";
	} else {
	   	$_SESSION['error_msg'] = "Error: " . $sql . "<br>" . $db->error;
	}
}
else if( isset( $_POST['update_common_supply'] ) ) //Adding NEW reond in database
{
	
	$datetime = new DateTime();
	$sql = "INSERT INTO `common_election_supplies`
	(
	`common_supply`
	)
	VALUES
	(
	'".$_POST['common_supply']."'
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
	$sql = "SELECT * FROM common_election_supplies where id = ".$_GET['id'];
	$results = $db->query($sql);

	$results_arr = array();
	if ($results->num_rows > 0) {
    // output data of each row
	    $i = 0;
	    while($row = $results->fetch_assoc()) {
			$results_arr[$i]['id'] = $row["id"];        
			$results_arr[$i]['common_supply'] = $row["common_supply"];        
			
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
					echo 'Edit Common Supply';
				}else{
					echo 'Add Common Supply';
				}
?>				
			</a>
		</li>
	</ul>
	<a href="<?php echo LIVE_SITE; ?>/supplies_listing.php">View All Common Supplies</a>
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
						<label class="control-label" for="focusedInput">Common Supplies</label>
						<div class="controls">
						  <input class="input-xlarge" id="common_supply" type="text" value="<?php echo @$results_arr[0]['common_supply']?>" name = 'common_supply'>
						</div>
					 </div>
					
					
				
					
					<div class="form-actions">
						<button type="submit" name='update_common_supply' value = 'Save' class="btn btn-primary">Submit</button>
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
    'common_supply': {
      required: true
    }
	
  }
});
</script>
