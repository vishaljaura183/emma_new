<?php
include('header.php');
$extra_conditions='';
if(isset($_GET['role'])){
$role_title = $_GET['role']=='rover'?" - Rover":"- Technician";
$role= $_GET['role'];
$extra_conditions = " AND role='$role'";
}
$sql="SELECT * FROM technician WHERE is_deleted!=1".$extra_conditions;
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
				<li><a href="#">Personnels <?php echo $role_title; ?> </a></li>
			</ul>
			<a href="add_technician.php">Add Personnels</a>
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>Personnels <?php echo $role_title; ?></h2>
						<div class="box-icon">
							
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable">
						  <thead>
							  <tr>
								  <th>Name</th>
								  <th>Email</th>
								  <th>Role</th>
								  <th>Phone</th>
								  <th>Created At</th>
								  <th>Actions</th>
							  </tr>
						  </thead>   
						  <tbody>
						  <?php
  while($results_users=mysqli_fetch_array($result,MYSQLI_ASSOC)){ 
   $object = $results_users;
	$id = $object['id'];
	$role = $object['role']=='rover'?"Rover":"Technician";
  ?>
							<tr id="tr_<?php echo $id; ?>">
								<td><?php echo $object['first_name'].' '.$object['last_name'];?></td>
								 <td><?php echo $object['email']; ?></td>
								 <td><?php echo $role; ?></td>
								<td><?php echo $object['phone']; ?></td>
								<td class="center">
									<?php echo $object['created_at']; ?>
								</td>
								<td class="center">
									<a class="btn btn-success" title="Edit Profile" href="profile_technician.php?id=<?php echo $id;?>">
										<i class="halflings-icon white zoom-in"></i>  
									</a>
									
									<a class="btn btn-danger" title="Delete" href="javascript:void(0);" onclick="del_officer('<?php echo $id; ?>')">
										<i class="halflings-icon white trash"></i> 
									</a>
								</td>
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
	<script>
	function del_officer(id){
	var url  = "<?php echo LIVE_SITE; ?>/process/delete_technician.php";
	var confirmm = confirm("Are you sure to delete?");
	//var r = confirm("Press a button!");
	if(confirmm == true){
	
	$.ajax({
	url: url,
	method: "POST",
	data: { del_id : id },
	dataType: "html",
	success: function(data){
	if(data =='success'){
		$("tr#tr_"+id).remove();
	}
	}
	});
	}
}



	$(document).ready(function(){


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
<?php
include('footer.php');
?>