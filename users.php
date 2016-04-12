<?php
include('header.php');
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseUser;

$query = ParseUser::query();
$results_users = $query->find();
?>
			<!-- start: Content -->
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="users.php">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="#">Users</a></li>
			</ul>

			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>Users</h2>
						<div class="box-icon">
							
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>Object Id</th>
								  <th>Username</th>
								  <th>Email</th>
								  <th>User Type</th>
<!--								  <th>Actions</th>-->
							  </tr>
						  </thead>   
						  <tbody>
						  <?php
  for ($i = 0; $i < count($results_users); $i++) {
  $object = $results_users[$i];
 
  ?>
							<tr>
								<td><?php echo $object->getObjectId();?></td>
								 <td><?php echo $object->get('username'); ?></td>
								<td><?php echo $object->get('email'); ?></td>
								<td class="center">
									<?php echo $object->get('typeofuser'); ?>
								</td>
<!--								<td class="center">-->
<!--									-->
<!--									-->
<!--									<a class="btn btn-danger" href="#">-->
<!--										<i class="halflings-icon white trash"></i> -->
<!--									</a>-->
<!--								</td>-->
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
	
<?php
include('footer.php');
?>