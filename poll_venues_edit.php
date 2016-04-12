<?php
include ('header.php');

//	echo "<style> #sidebar-left {display: none;} </style>";
//	echo $sql;
//	die;

//Updating
if( isset( $_POST['update_poll_venue'] ) && isset( $_GET['id'] ) )
{
	$address = $_POST['address_line_1'].', '.$_POST['ST'].' '.$_POST['ZIP'];
	$prepAddr = str_replace(' ','+',$address);
	$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
					
	$output= json_decode($geocode);
	
	if( @$output->results[0] )
	{
		$lat = $output->results[0]->geometry->location->lat;
		$long = $output->results[0]->geometry->location->lng;
	}
	else
	{
		$lat = '';
		$long = '';
	}
	
	$sql = "UPDATE poll_venues 
			SET
			`ADA_accessible`='".$_POST['ADA_accessible']."',
			`voting_district`='".$_POST['voting_district']."',
			`name_of_location`='".$_POST['name_of_location']."',
			`directions`='".$_POST['Directions']."',
			`address_line_1`='".$_POST['address_line_1']."',
			`post_office`='".$_POST['post_office']."',
			`ST`='".$_POST['ST']."',
			`ZIP`='".$_POST['ZIP']."',
			`latitude`='".$lat."',
			`longitude`='".$long."'
			 where `id` = ".$_GET['id'];

	if ($db->query($sql) === TRUE) {
		$_SESSION['success_msg'] = "Data updated.";
	} else {
	   	$_SESSION['error_msg'] = "Error: " . $sql . "<br>" . $db->error;
	}
}
else if( isset( $_POST['update_poll_venue'] ) ) //Adding
{
	$address = $_POST['address_line_1'].', '.$_POST['ST'].' '.$_POST['ZIP'];
	$prepAddr = str_replace(' ','+',$address);
	$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
					
	$output= json_decode($geocode);
	if( @$output->results[0] )
	{
		$lat = $output->results[0]->geometry->location->lat;
		$long = $output->results[0]->geometry->location->lng;
	}
	else
	{
		$lat = '';
		$long = '';
	} 
	
	$datetime = new DateTime();
	$sql = "INSERT INTO `poll_venues`
	(
	`ADA_accessible`,
	`created_at`,
	`updated_at`,
	`voting_district`,
	`name_of_location`,
	`directions`,
	`address_line_1`,
	`post_office`,
	`ST`,
	`ZIP`,
	`latitude`,
	`longitude`)
	VALUES
	(
	'".$_POST['ADA_accessible']."',
	'".$datetime->format('Y-m-d H:i:s')."',
	'".$datetime->format('Y-m-d H:i:s')."',
	'".$_POST['voting_district']."',
	'".$_POST['name_of_location']."',
	'".$_POST['Directions']."',
	'".$_POST['address_line_1']."',
	'".$_POST['post_office']."',
	'".$_POST['ST']."',
	'".$_POST['ZIP']."',
	'".$lat."',
	'".$long."'
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
	$sql = "SELECT * FROM poll_venues where id = ".$_GET['id'];
	$results = $db->query($sql);

	$results_arr = array();
	if ($results->num_rows > 0) {
    // output data of each row
	    $i = 0;
	    while($row = $results->fetch_assoc()) {
			$results_arr[$i]['id'] = $row["id"];        
			$results_arr[$i]['ADA_accessible'] = $row["ADA_accessible"];        
			$results_arr[$i]['created_at'] = $row["created_at"];        
			$results_arr[$i]['updated_at'] = $row["updated_at"];        
			$results_arr[$i]['ACL'] = $row["ACL"];        
			$results_arr[$i]['voting_district'] = $row["voting_district"];                
			$results_arr[$i]['name_of_location'] = $row["name_of_location"];        
			$results_arr[$i]['directions'] = $row["directions"];        
			$results_arr[$i]['address_line_1'] = $row["address_line_1"];          
			$results_arr[$i]['post_office'] = $row["post_office"];        
			$results_arr[$i]['ST'] = $row["ST"];        
			$results_arr[$i]['ZIP'] = $row["ZIP"];
			
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
					echo 'Edit Poll Venue';
				}else{
					echo 'Add Poll Venue';
				}
?>				
			</a>
		</li>
	</ul>
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
					<div class="control-group" style="display:none;">
						<label class="control-label" for="focusedInput">ADA Accessible</label>
						<div class="controls">
						  <input class="input-xlarge" id="" type="text" value="<?php echo @$results_arr[0]['ADA_accessible']?>" name = 'ADA_accessible'>
						</div>
					 </div>
					<div class="control-group">
						<label class="control-label" for="focusedInput">Voting District</label>
						<div class="controls">
						  <input class="input-xlarge" id="voting_district" required type="text" value="<?php echo @$results_arr[0]['voting_district']?>" name = 'voting_district'>
						</div>
					 </div>
					
					<div class="control-group">
						<label class="control-label" for="focusedInput">Name Of Location</label>
						<div class="controls">
						  <input class="input-xlarge" id="name_of_location" required type="text" value="<?php echo @$results_arr[0]['name_of_location']?>" name = 'name_of_location'>
						</div>
					 </div>
					<div class="control-group">
						<label class="control-label" for="focusedInput">Directions</label>
						<div class="controls">
						  <input class="input-xlarge" id="" type="text" value="<?php echo @$results_arr[0]['directions']?>" name = 'Directions'>
						</div>
					 </div>
					<div class="control-group">
						<label class="control-label" for="focusedInput">Address Line 1</label>
						<div class="controls">
						  <input class="input-xlarge" id="address_line_1" required type="text" value="<?php echo @$results_arr[0]['address_line_1']?>" name = 'address_line_1'>
						</div>
					 </div>
				
					<div class="control-group">
						<label class="control-label" for="focusedInput">Post Office</label>
						<div class="controls">
						  <input class="input-xlarge" id="" type="text" value="<?php echo @$results_arr[0]['post_office']?>" name = 'post_office'>
						</div>
					 </div>
					<div class="control-group">
						<label class="control-label" for="focusedInput">ST</label>
						<div class="controls">
						  <input class="input-xlarge" id="ST" required type="text" value="<?php echo @$results_arr[0]['ST']?>" name = 'ST' maxlength="2">
						</div>
					 </div>
					<div class="control-group">
						<label class="control-label" for="focusedInput">ZIP</label>
						<div class="controls">
						  <input class="input-xlarge" id="ZIP" required type="text" value="<?php echo @$results_arr[0]['ZIP']?>" name = 'ZIP' maxlength="9">
						</div>
					 </div>
					<div class="form-actions">
						<button type="submit" name='update_poll_venue' value = 'Save' class="btn btn-primary">Submit</button>
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
    'voting_district': {
      required: true
    },
	'address_line_1': {
      required: true
    },
	'ST': {
      required: true
    },
	'ZIP': {
      required: true
    }
	
  }
});
</script>
