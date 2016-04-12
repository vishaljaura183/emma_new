<?php
include ('header.php');


//$querylog = new ParseQuery ( "pollVenues" );
//$results = $querylog->find();

if( @$_POST['update_poll_venue'] )
{
	$sql = "UPDATE poll_venues 
			SET
			ADA_accessible = '".$_POST['ADA_accessible']."'
			created_at = '".$_POST['created_at']."'
			updated_at = '".$_POST['updated_at']."'
			ACL = '".$_POST['ACL']."'
			municipality = '".$_POST['municipality']."'
			ward = '".$_POST['ward']."'
			precinct = '".$_POST['precinct']."'
			name_of_location = '".$_POST['name_of_location']."'
			directions = '".$_POST['directions']."'
			address_line_1 = '".$_POST['address_line_1']."'
			address_line_2 = '".$_POST['address_line_2']."'
			post_office = '".$_POST['post_office']."'
			WHERE id=1";
				
	if ($db->query($sql) === TRUE) {
	} else {
	    echo "Error: " . $sql . "<br>" . $db->error;
	}
}

//Select all records from poll venues.
$admin_id = $_SESSION['userid'];
$sql = "SELECT * FROM poll_venues";
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
		$results_arr[$i]['municipality'] = $row["municipality"];        
		$results_arr[$i]['ward'] = $row["ward"];        
		$results_arr[$i]['ward'] = $row["ward"];        
		$results_arr[$i]['precinct'] = $row["precinct"];        
		$results_arr[$i]['name_of_location'] = $row["name_of_location"];        
		$results_arr[$i]['directions'] = $row["directions"];        
		$results_arr[$i]['address_line_1'] = $row["address_line_1"];        
		$results_arr[$i]['address_line_2'] = $row["address_line_2"];        
		$results_arr[$i]['post_office'] = $row["post_office"];        
		$results_arr[$i]['ST'] = $row["ST"];        
		$results_arr[$i]['ZIP'] = $row["ZIP"];        
		$results_arr[$i]['latitude'] = $row["latitude"];        
		$results_arr[$i]['longitude'] = $row["longitude"];
		
		$i++;
    }
}

//echo "<pre>";
//print_r($results_arr);
//die;
?>

			<!-- start: Content -->
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="poll_venues.php">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="#">Poll Venue Listing</a></li>
			</ul>

			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>Poll Venues Listing</h2>
						<div class="box-icon">
							
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<a title = "Add poll sites manually" href = "poll_venues_edit.php" class = "add_poll_sites actions"><span class = "actions add"></span> Add poll sites manually</a>
						<table class="table table-striped table-bordered bootstrap-datatable">
						  <thead>
							  <tr>
								  <th>#</th>
								  
								  <th>Voting District</th> <!-- Voting District -->
								  <th>Name of Location</th>
								  <th>Directions</th>
								  <th>Address Line 1</th>
								  
								  <th>Post Office</th>
								  <th>ST</th>
								  <th>ZIP</th>
								  <th>Latitude</th>
								  <th>Longitude</th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						  <?php
						  foreach ($results_arr as $key=>$value) {
						 
						  ?>
							<tr>
								<td><?php echo $key+1;?></td>
								
								
								<td><?php echo $value['voting_district']; ?></td>
								<td>
									<?php echo $value['name_of_location']; ?>
								</td>
								<td>
									<?php echo $value['directions']; ?>
								</td>
								<td>
									<?php echo $value['address_line_1']; ?>
								</td>
								
								<td>
									<?php echo $value['post_office']; ?>
								</td>
								<td>
									<?php echo $value['ST']; ?>
								</td>
								<td>
									<?php echo $value['ZIP']; ?>
								</td>
								<td>
									<?php echo $value['latitude']; ?>
								</td>
								<td>
									<?php echo $value['longitude']; ?>
								</td>
								<td>
									<div style = "width: 80px;">
										<span id = "<?php echo $value['id']; ?>" class = "actions delete"></span>
										<a href = "poll_venues_edit.php?id=<?php echo $value['id']; ?>"><span id = "<?php echo $value['id']; ?>" class = "actions edit"></span></a>
									</div>	
								</td>
							</tr>
<?php
							}
?>
							  </tbody>
						 </table>  
						  
					</div>
				</div><!--/span-->
			</div><!--/row-->
    

	</div><!--/.fluid-container-->
	
			<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
		
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
<script type = "text/javascript">
$(document).ready(function(){
	$('span.actions.delete').click(function(){
		$('div.fixedLoader').show();
		thiss = this;
		$.ajax({
			url : "ajax_call_functions.php",
			method : "POST",
			data : {'action': 'delete_poll_venues', 'id': $(this).attr('id')},
			dataType : "json",
			success : function(jsonData) {
				$(thiss).parents('tr').slideUp();
				$('div.fixedLoader').fadeOut();		
			}
		});
	});


	$('.bootstrap-datatable').dataTable({
        "aLengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
        "iDisplayLength": 20
    });
			
})
</script>
<style>
div.dataTables_filter {
    float: right;
    width: 275px;
}
div.dataTables_length {
    display: inline-block;
    width: 310px;
}
div.dataTables_info {
    display: inline-block;
    float: left;
    width: 450px;
}
div.dataTables_paginate {
    display: inline-block;
    float: right;
}
.dataTables_paginate a {
    background: #f0f0f0 none repeat scroll 0 0;
    border: 1px solid grey;
    cursor: pointer;
    display: inline-block;
    margin-left: 3px;
    padding: 5px;
    text-decoration: none;
}
</style>