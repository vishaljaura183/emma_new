<?php
include('header.php');
 $sql = "SELECT TD.*, ST.id as st_id, TH.first_name, TH.last_name, TH.email
FROM ticket_data  TD

LEFT JOIN service_tickets ST
ON TD.service_ticket_id=ST.id

LEFT JOIN technician TH
ON ST.technician_id=TH.id

ORDER BY TD.created_at"; //die;

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
				<li><a href="#">Ticket Data Collected</a></li>
			</ul>
			<a class="download_btn" href="<?php echo LIVE_SITE;?>/export_ticket_data.php">Export Data to CSV</a>
			<div class="row-fluid sortable">		
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>Ticket Data Collected</h2>
						<div class="box-icon">
							
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable">
						  <thead>
							  <tr>
								  <th>Service Ticket</th>
								  
								  <th>Technician</th>
								  <th>Notes</th>
								  <th>Image</th>
								  <th>Signature Img</th>
								  <th>Submitted On</th>
								  
							  </tr>
						  </thead>   
						  <tbody>
						  <?php
  while($results_users=mysqli_fetch_array($result,MYSQLI_ASSOC)){ 
  // print_r($results_users);
   $object = $results_users;
	$id = $object['id'];
	$tech_username = $object['tech_username'];
	$service_ticket_id = $object['service_ticket_id'];
	$service_ticket_id_num =  sprintf('%06d', $service_ticket_id);
	$inspector_dropoff_loc = $object['inspector_dropoff_loc'];
	$num_votes_cast = $object['num_votes_cast'];
	$image_name = $object['image_name'];
	$signature_image = $object['signature_image'];
	$comments = $object['comments'];
	$cellphone = $object['cellphone'];
	$submitted_on = $object['created_at'];
	$first_name = $object['first_name'];
	$last_name = $object['last_name'];
	$email = $object['email'];
	
	if($image_name != ''){
	$image_path_src = LIVE_SITE.TICKET_PHOTO_PATH.$image_name;
	$image_name_thumb = "<img src='".$image_path_src."' width='120' height='120' onclick=show_photo('$image_path_src'); style='cursor:pointer;' title='View Image' />";
	}
	else{
	
	$image_name_thumb = "No Image";
	}
	if($signature_image != ''){
	$image_sign_src = LIVE_SITE.TICKET_PHOTO_SIGN_PATH.$signature_image;
	$signature_image_thumb = "<img src='".$image_sign_src."' width='120' height='120' onclick=show_photo('$image_sign_src'); style='cursor:pointer;' title='View Image' />";
	}
	else{
	$signature_image_thumb = "No Signature Image";
	}
	
	
	
  ?>
							<tr id="tr_<?php echo $id; ?>">
								<td><a href="javascript:void(0);" onclick="view_detail_ticket('<?php echo $service_ticket_id; ?>');"><?php echo $service_ticket_id_num; ?></a></td>
								 
								
								<td><?php echo $first_name.' '.$last_name; ?></td>
								<td><?php echo $comments; ?></td>
								<td><?php echo $image_name_thumb; ?></td>
								<td><?php echo $signature_image_thumb; ?></td>
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
	<!-- ============== PHOTO DETAIL BOX ========================= -->
	<div class="modal hide fade" id="photoModal">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3 id="h3_photo_title">Photo Detail</h3>
		</div>
		<div class="modal-body" id="modal_body_photo">
			<p>Loading data...</p>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
			<a href="javascript:void(0)" id="image_link_download" onclick="image_download_func();" class="btn btn-primary">Download Photo</a> 
		</div>
	</div>
	<!-- =================================================================== -->
	<!-- ============== TICKET DETAIL MODAL BOX ========================= -->
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
			
});

function show_photo(image_src){
var image_html = '<img src="'+image_src+'" /><input type="hidden" value="'+image_src+'" id="image_download_name"/>';
		
		$("#modal_body_photo").html(image_html);
		$("#image_link_download").attr("href","download.php?file="+image_src);
		$('#photoModal').modal('show');

}

function image_download_func(){
	//$("#image_download_name");
}
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