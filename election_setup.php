<?php
include ('header.php');
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseUser;

$querylog = new ParseQuery ( "pollVenues" );
$results = $querylog->find();
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
						<table class="table table-striped table-bordered bootstrap-datatable datatable">
						  <thead>
							  <tr>
								  <th>Object Id</th>
								  <th>ADA Accessible</th>
								  <th>Municipality</th>
								  <th>Ward</th>
								  <th>Precinct</th>
								  <th>Name of Location</th>
								  <th>Directions</th>
								  <th>Address Line 1</th>
								  <th>Address Line 2</th>
								  <th>Post Office</th>
								  <th>ST</th>
								  <th>ZIP</th>
								  <th>Latitude</th>
								  <th>Longitude</th>
<!--								  <th>Actions</th>-->
							  </tr>
						  </thead>   
						  <tbody>
						  <?php
						  for ($i = 0; $i < count($results); $i++) {
						  $object = $results[$i];
						 
						  ?>
							<tr>
								<td><?php echo $object->getObjectId();?></td>
								 <td><?php echo $object->get('ADA_Accessible'); ?></td>
								<td><?php echo $object->get('Municipality'); ?></td>
								<td>
									<?php echo $object->get('ward'); ?>
								</td>
								<td>
									<?php echo $object->get('Precinct'); ?>
								</td>
								<td>
									<?php echo $object->get('Name_of_Location'); ?>
								</td>
								<td>
									<?php echo $object->get('Directions'); ?>
								</td>
								<td>
									<?php echo $object->get('Address_Line_1'); ?>
								</td>
								<td>
									<?php echo $object->get('Address_Line_2'); ?>
								</td>
								<td>
									<?php echo $object->get('Post Office'); ?>
								</td>
								<td>
									<?php echo $object->get('ST'); ?>
								</td>
								<td>
									<?php echo $object->get('ZIP'); ?>
								</td>
								<td>
									<?php echo $object->get('latitude'); ?>
								</td>
								<td>
									<?php echo $object->get('longitude'); ?>
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
	
<?php
include('footer.php');
?>