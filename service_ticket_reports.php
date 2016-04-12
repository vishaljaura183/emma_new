<?php
include('header.php');
?>
<style>
a#download_excel{
	display: inline-block;
    float: right;
   /* width: 40px;*/
}
</style>
<?php

if(isset($_GET['sr_type'])){
$st_type = $_GET['sr_type'];
$whr_condition = "WHERE ST.status=".$st_type;
}
else{
$whr_condition = "";
}
 $sql = "SELECT DISTINCT ST.id, ST.*, PV.ward, PV.address_line_1,PV.voting_district, PV.ST, PV.ZIP ,TH.first_name, TH.last_name, TH.email
FROM service_tickets  ST

LEFT JOIN poll_venues PV
ON ST.polling_site_id=PV.id

LEFT JOIN technician TH
ON ST.technician_id=TH.id

".$whr_condition."
ORDER BY ST.created_at DESC";

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
				<li><a href="#">Service Tickets Report</a></li>
			</ul>
			
			<a href="service-ticket-reports-download-xlsx.php" id = 'download_excel' title = 'download excel'>DOWNALOD ALL TICKETS TO EXCEL<img alt="Download Excel" src="img/excel-download-icon.gif"/></a>
			<div class="row-fluid sortable">
						
				<div class="box span12">
					<div class="box-header" data-original-title>
						<h2><i class="halflings-icon user"></i><span class="break"></span>Service Tickets</h2>
						<div class="box-icon">
							<a href="#" class="btn-minimize"><i class="halflings-icon chevron-up"></i></a>
							<a href="#" class="btn-close"><i class="halflings-icon remove"></i></a>
						</div>
					</div>
					<div class="box-content">
						<table class="table table-striped table-bordered bootstrap-datatable datatable_tickets">
						  <thead>
							  <tr>
								  <th width="8%">Ticket Number</th>
								  <th width="5%">Technician</th>
								  <th width="20%">Polling Site</th>
								  <th width="10%">Voting District</th>
								  <th width="5%">Priority [1-Lowest, 5-Highest]</th>
								  <th width="15%">Reason Of Call</th>
								  <th width="10%">Status</th>
								  <th width="6%">Accept/Reject</th>
								  <th width="10%">Date Created</th>
							  </tr>
						  </thead>   
						  <tbody>
						  <?php
  while($results_users=mysqli_fetch_array($result,MYSQLI_ASSOC)){ 
   $object = $results_users;
	$id = $object['id'];
	$sr_ticket_no = sprintf('%06d', $object['id']);
	$address_poll_site = $object['address_line_1'].', '.$object['ST'].', '.$object['ZIP'];
	if($object['status'] == '0'){
		$status = "<span style='color: green;'>Open</span>";
		}
		elseif($object['status'] == '2'){
		$status = "<span style='color: grey;'>Cancelled</span>";
		
		}
		else{
		$status = "<span style='color: red;'>Closed</span>";
		
		}
	if($object['response_acceptance'] == '1'){
	$accept_reject = "<span style='color: green;'>Accepted</span>";
	}
	elseif($object['response_acceptance'] == '0'){
	$accept_reject = "<span style='color: red;'>Rejected</span>";
	}
	else{
	$accept_reject = "Not Responded";
	}
  ?>
							<tr id="tr_<?php echo $id; ?>">
								<td><a href="javascript:void(0);" onclick="view_detail_ticket('<?php echo $id; ?>');"><?php echo $sr_ticket_no; ?></a></td>
								 <td><?php echo $object['first_name'].' '.$object['last_name']; ?></td>
								<td><?php echo $address_poll_site; ?></td>
								<td><?php echo  $object['voting_district']; ?></td>
								<td><?php echo  $object['priority_ticket']; ?></td>
								<td class="center">
									<?php echo $object['reason_call']; ?>
								</td>
								<td class="center">
									<?php echo $status; ?>
								</td>
								<td class="center">
									<?php echo $accept_reject; ?>
								</td>
								<td class="center">
									<?php echo $object['created_at']; ?>
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
		
	<div class="modal hide fade" id="myModal" style="width:680px;">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3 id="h3_sr_title"></h3>
		</div>
		<div class="modal-body" id="modal_body">
			<p>Loading data...</p>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Close</a>
			<a href="javascript:void(0);" id="ticket_cancel_link" onclick="cancel_service_ticket();" class="btn btn-primary">Cancel This Ticket</a> 
		</div>
	</div>
	
	<div class="modal hide fade" id="ticketCancelModal" style="width:680px;">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3 >Cancel Ticket</h3>
		</div>
		<div class="modal-body" id="modal_body_cancel">
		<form id="cancel_form_data">
			<table><tr>
			<td>Reason for Cancel Ticket</td>
			<td><input type="hidden" name="ticket_id" id="ticket_id" value=""/><textarea name="reason_cancel" id="reason_cancel"></textarea></td>
			</tr></table>
		</form>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn" data-dismiss="modal">Close</a>
			<a href="javascript:void(0);" id="ticket_cancel_link" onclick="cancel_ticket_submit();" class="btn btn-primary">Submit</a> 
		</div>
	</div>
	<script>
	  $(document).ready(function() {
        $('.datatable_tickets').dataTable( {
           aLengthMenu: [
        [20, 50, 100, 200, -1],
        [25, 50, 100, 200, "All"]
    ],
    iDisplayLength: -1,
		"sDom": "<'row-fluid'<'span6'l><'span6'f>r>t<'row-fluid'<'span12'i><'span12 center'p>>",
			"sPaginationType": "bootstrap",
			"oLanguage": {
			"sLengthMenu": "_MENU_ records per page"
			}
        } );
    } );
	// ----------- View Detail of Ticket -----------------
	function view_detail_ticket(id){
		
		$('#myModal').modal('show');
		$("#ticket_cancel_link").hide();
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
		//	alert($("#status_ticket").val());
			if($("#status_ticket").val() == 'Open'){
			$("#ticket_cancel_link").show();
			$("#ticket_id").val(id);
			}
		
		}
		});
	}
	function pad (str, max) {
	  str = str.toString();
	  return str.length < max ? pad("0" + str, max) : str;
	}
	// ---------------------- CANCEL TICKET -----------------------
	function cancel_service_ticket(){
	//alert("cancel Ticket here");
	$('#ticketCancelModal').modal('show');
	
	}
	
	function cancel_ticket_submit(){
	// Submit ticket cancel with ajax here
	var url  = "<?php echo LIVE_SITE; ?>/process/cancel_ticket.php";
	var cancel_form_data = $("#cancel_form_data").serialize();
	$.ajax({
	url: url,
	method: "POST",
	data: cancel_form_data,
	dataType: "html",
	success: function(data){
	if(data =='success'){
	
	alert("Ticket Cancelled Successfully!");	
	$('#ticketCancelModal').modal('hide');
	$('#myModal').modal('hide');
	}
	}
	});
	
	}
	
	function del_officer(id){
	var url  = "<?php echo LIVE_SITE; ?>/process/delete_service_ticket.php";

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
	</script>
<?php
include('footer.php');
?>