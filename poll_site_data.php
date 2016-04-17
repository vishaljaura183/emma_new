<?php
include('header.php');
	$sql = "SELECT PD.*, PV.id as poll_venue_id, PV.voting_district, TH.first_name, TH.last_name, TH.email
	FROM poll_site_data  PD

	LEFT JOIN poll_venues PV
	ON PD.poll_venues_id=PV.id

	LEFT JOIN technician TH
	ON PD.technician_id=TH.id

	ORDER BY PD.created_at"; //die;

	$result=mysqli_query($db,$sql);

?>
			<!-- start: Content -->
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="index.php">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="#">Poll Data Collected</a></li>
			</ul>
			<a class="download_btn" href="<?php echo LIVE_SITE;?>/exp_poll_data.php">Export Data to CSV</a>
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>Poll Data Collected</h2>
						<div class="box-icon">
							
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable">
						  <thead>
							  <tr>
								  <th>Voting District</th>
								  <th>Technician</th>
								 
								  <th>Clerk Name</th>
								  <th>Insp. drop-off Loc</th>
								  <th>Cellphone</th>
								  <th>Homephone</th>
								  <th>Notes</th>
								  
								  
								  <th>Submitted On</th>
								  
							  </tr>
						  </thead>   
						  <tbody>
						  <?php
	while($results_users=mysqli_fetch_array($result,MYSQLI_ASSOC)){ 
//	print_r($results_users); die;
	$object = $results_users;
	$id = $object['id'];
	$voting_district = $object['voting_district'];
	$first_name = $object['first_name'];
	$last_name = $object['last_name'];
	$tech_name =  $first_name.' '.$last_name;
	$clerk_name = $object['clerk_name'];
	
	$inspector_dropoff_loc = $object['drop_off_location'];
	
	$cellphone = $object['cellphone'];
	$homephone = $object['homephone'];
	
	$submitted_on = $object['created_at'];
	$notes = $object['notes'];
	
  ?>
							<tr id="tr_<?php echo $id; ?>">
								<td><?=$voting_district;?></td>
								 
								<td><?php echo $tech_name; ?></td>
								<td class="center">
									<?php echo $clerk_name; ?>
								</td>
								<td><?php echo $inspector_dropoff_loc; ?></td>
								<td><?php echo $cellphone; ?></td>
								<td><?php echo $homephone; ?></td>
								<td><?php echo $notes; ?></td>
						
								<td><?php echo $submitted_on; ?></td>
								
							</tr>
							     <?php
}?>                                
							  </tbody>
						 </table>  
						  
					</div>
				</div><!--/span-->
			</div><!--/row-->
    

	</div><!--/.fluid-container-->
	
			<!-- end: Content -->
		</div><!--/#content.span10-->
		</div><!--/fluid-row-->
		
	<div class="modal hide fade" id="myModal" style="width:680px;">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3>Service Ticket Detail</h3>
		</div>
		<div class="modal-body" id="modal_body">
			<p>Loading Data...</p>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Close</a>
			
		</div>
	</div>
<script type="text/javascript">
$(document).ready(function(){


	$('.bootstrap-datatable').dataTable({
        "aLengthMenu": [[20, 50, 100, -1], [20, 50, 100, "All"]],
        "iDisplayLength": 20,
		"aaSorting": [[ 0, "desc" ]]
    });
			
})
// ----------- View Detail of Ticket -----------------
	function view_detail_ticket(id){
	
		$('#myModal').modal('show');
		ser_ticket_num = pad(id,6);
		$('#h3_sr_title').html('Service Ticket : '+ser_ticket_num);
		
		var url  = "<?php echo LIVE_SITE; ?>/process/get_ticket_detail.php";
		$.ajax({
		url: url,
		method: "POST",
		data: { id : id },
		dataType: "html",
		success: function(data){
			$("#modal_body").html(data);
		
		}
		});
	}
	function pad (str, max) {
	  str = str.toString();
	  return str.length < max ? pad("0" + str, max) : str;
	}
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
	
<?php
include('footer.php');
?>