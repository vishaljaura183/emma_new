<?php
include ('header.php');


//$querylog = new ParseQuery ( "pollVenues" );
//$results = $querylog->find();

//Select all records from poll venues.
$admin_id = $_SESSION['userid'];
$sql = "SELECT * FROM call_reasons";
$results = $db->query($sql);


$results_arr = array();
if ($results->num_rows > 0) {
    // output data of each row
    $i = 0;
    while($row = $results->fetch_assoc()) {
		$results_arr[$i]['id'] = $row["id"];        
		$results_arr[$i]['call_reason'] = $row["call_reason"];        
		$results_arr[$i]['created_at'] = $row["created_at"];        
		
		
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
				<li><a href="#">Call Reasons Listing</a></li>
			</ul>
			<a title = "Add poll sites manually" href = "call_reason_edit.php" class = "add_poll_sites actions"><span class = "actions add"></span> Add New Call Reason</a>
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>Call Reasons Listing</h2>
						<div class="box-icon">
							
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						
						<table class="table table-striped table-bordered bootstrap-datatable">
						  <thead>
							  <tr>
								  <th>#</th>
								  
								  <th>Call Reason</th> <!-- Voting District -->
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						  <?php
						  foreach ($results_arr as $key=>$value) {
						 
						  ?>
							<tr>
								<td><?php echo $key+1;?></td>
								
								
								<td><?php echo $value['call_reason']; ?></td>
								
								<td>
									<div style = "width: 80px;">
										<span id = "<?php echo $value['id']; ?>" class = "actions delete"></span>
										<a href = "call_reason_edit.php?id=<?php echo $value['id']; ?>"><span id = "<?php echo $value['id']; ?>" class = "actions edit"></span></a>
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
			data : {'action': 'delete_call_reason', 'id': $(this).attr('id')},
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