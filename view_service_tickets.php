<?php
include ('inc/common_func.php');
include('header.php');
//$sql="SELECT * FROM service_tickets";
/*$sql = "SELECT service_tickets.*, poll_venues.ward, poll_venues.address_line_1, poll_venues.address_line_2, poll_venues.ST, poll_venues.ZIP 
FROM service_tickets
LEFT JOIN poll_venues
ON service_tickets.polling_site_id=poll_venues.id
ORDER BY service_tickets.id"; 
*/
$techicians_data = get_values_technicians($db); 

if(isset($_GET['sr_type'])){
$st_type = $_GET['sr_type'];
$whr_condition = "WHERE ST.status=".$st_type;
}
else{
$whr_condition = "";
}
	$sql = "SELECT DISTINCT ST.id, ST.*, AD.name as dispatcher,AD.name as dispatcher, PV.ward, PV.address_line_1,PV.voting_district, PV.ST, PV.ZIP ,TH.first_name, TH.last_name, TH.email, TH.role
	FROM service_tickets  ST

	LEFT JOIN poll_venues PV
	ON ST.polling_site_id=PV.id

	LEFT JOIN admin AD
	ON ST.dispatcher_id=AD.id

	LEFT JOIN technician TH
	ON ST.technician_id=TH.id

	".$whr_condition."
	ORDER BY ST.id ASC";

$result=mysqli_query($db,$sql);
date_default_timezone_set("America/New_York");
?>
			<!-- start: Content -->
			<div id="content" class="span10">
			
			
			<ul class="breadcrumb">
				<li>
					<i class="icon-home"></i>
					<a href="index.php">Home</a> 
					<i class="icon-angle-right"></i>
				</li>
				<li><a href="#">Service Tickets</a></li>
			</ul>
			<?php if($_SESSION['usertype'] < 3 ) { ?>
			<a href="assign_polling_venues.php">Add Service Ticket</a>
			<?php } ?>
			<a class="download_btn" href="<?php echo LIVE_SITE;?>/export_ser_tickets.php">Export Data to CSV</a>
			
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
								  <th width="5%">Dispatcher</th>
								  <th width="20%">Call Reason</th>
								  <th width="10%">Voting District</th>
								  <th width="9%">Enroute Time</th>
								  <th width="9%">Onscene Time</th>
								  <th width="2%">Priority</th>
								  <th width="10%">Status</th>
								  <th width="6%">Received</th>
								  <th width="10%">Date Created</th>
								  <th width="20%">Actions</th>
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
	$accept_reject = "<span style='color: green;'>Yes</span>";
	}
	elseif($object['response_acceptance'] == '0'){
	$accept_reject = "<span style='color: red;'>Rejected</span>";
	}
	else{
	$accept_reject = "No";
	}
	if($object['dispatcher_solve']=='1'){
		$solve_by = "Dispatcher Solve";
	}
	else{
		$role=$object['role']=='rover'?' (R) ':'';
		$solve_by = $object['first_name'].' '.$object['last_name'].$role;
	}
	
  ?>
							<tr id="tr_<?php echo $id; ?>">
								<td><a href="javascript:void(0);" onclick="view_detail_ticket('<?php echo $id; ?>');"><?php echo $sr_ticket_no; ?></a></td>
								 <td><?php echo $solve_by; ?></td>
								 <td><?php echo $object['dispatcher']; ?></td>
								<td><?php echo $object['reason_call']; ?></td>
								<td><?php echo  $object['voting_district']; ?></td>
								<td><?php echo  $object['enroute_datetime']?date('Y-m-d H:i:s',$object['enroute_datetime']): 'NA'; ?></td>
								<td class="center">
									<?php echo  $object['on_scene_datetime']?date('Y-m-d H:i:s',$object['on_scene_datetime']): 'NA'; ?>
								</td>
								<td class="center">
									<?php echo  $object['priority_ticket']; ?>
								</td>
								<td class="center">
									<?php echo $status;
									//echo date_default_timezone_get();
									?>
								</td>
								<td class="center">
									<?php echo $accept_reject; ?>
								</td>
								<td class="center">
									<?php echo $object['created_at']; ?>
								</td>
								<td class="center">
									
									
								<!--	<a class="btn btn-danger" title="Delete" href="javascript:void(0);" onclick="del_officer('<?php echo $id; ?>')">
										<i class="halflings-icon white trash"></i> 
									</a> -->
									<a  target="_blank" title="View PDF" href="<?php echo LIVE_SITE; ?>/pdf/docs/service_tkt_pdf.php?id=<?php echo $id; ?>">
										<img src="<?php echo LIVE_SITE; ?>/img/pdf.png"  />
									</a>
									<a  title="View Ticket Detail" href="javascript:void(0);" onclick="view_detail_ticket('<?php echo $id; ?>');">
										<img src="<?php echo LIVE_SITE; ?>/img/look.jpg" width="40" height="30"  />
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
		
	<div class="modal hide fade" id="myModal" style="width:680px;">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3 id="h3_sr_title"></h3>
		</div>
		<div class="modal-body" id="modal_body">
			<p>Loading data...</p>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
			<?php if($_SESSION['usertype'] < 3 ) { ?>
			<a href="javascript:void(0);" id="add_notes_link" onclick="add_notes();" class="btn btn-primary">Add Notes</a> 
			<a href="javascript:void(0);" id="ticket_cancel_link" onclick="cancel_service_ticket();" class="btn btn-primary">Cancel This Ticket</a> 
			<a href="javascript:void(0);" id="redirect_ticket_link" onclick="redirect_service_ticket();" class="btn btn-primary">Redirect</a> 
			<?php } ?>
		</div>
	</div>
	<!-- =========================== CANCEL TICKETS WINDOW ========================================== -->
	
	<div class="modal hide fade" id="ticketCancelModal" style="width:680px;  background: lightgray;">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3 >Cancel Ticket</h3>
		</div>
		<div class="modal-body" id="modal_body_cancel" style="height:500px;">
		<form id="cancel_form_data">
			<table><tr>
			<td><label>Reason for Cancel Ticket</label><input type="hidden" name="ticket_id" id="ticket_id" value=""/>
			<input type="hidden" name="tech_id" id="tech_id" value=""/></td>
			
			</tr>
			
			<tr>
			<td>
			<textarea name="reason_cancel" id="reason_cancel" maxlength="300" style="width:326px; height:150px" ></textarea>
			</td>
			</tr></table>
		</form>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
			<a href="javascript:void(0);" id="ticket_cancel_link" onclick="cancel_ticket_submit();" class="btn btn-primary">Submit</a> 
		</div>
	</div>
	
	<!-- =========================== REDIRECT TICKETS WINDOW ========================================== -->
	
	<div class="modal hide fade" id="ticketRedirectModal" style="width:680px;  background: lightgray;">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3 >Redirect Ticket</h3>
		</div>
		<div class="modal-body" id="modal_body_cancel" style="height:500px;">
		<form id="redirect_form">
		
			<table>
			<tr>
			
			<td>
			
			<div class="controls"><label>Select Technician</label>
									  <select id="new_technician_id" name="new_technician_id" required>
									  <option value='' >Select</option>
										<?php foreach($techicians_data as $tech){ ?>
										<option value="<?php echo $tech['id']; ?>" rel="<?php echo $tech['first_name']; ?>"><?php echo $tech['first_name']; ?></option>
										
										<?php } ?>
										
									  </select>
									</div>
			</td>
			</tr>
			<tr>
			<td><label>Redirect Notes</label><input type="hidden" name="ticket_id_redirect" id="ticket_id_redirect" value=""/>
			<input type="hidden" name="old_tech_id" id="old_tech_id" value=""/></td>
			
			</tr>
			
			<tr>
			<td>
			<textarea name="redirect_reason" id="redirect_reason" maxlength="300" style="width:326px; height:150px" ></textarea>
			</td>
			</tr></table>
		</form>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
			<a href="javascript:void(0);" id="redirect_submit_btn" onclick="redirect_ticket_submit();" class="btn btn-primary">Submit</a> 
		</div>
	</div>
	
	<!--  =================== ADDITIONAL NOTES ON CLOSED TICKETS ===================================== -->
	
	<div class="modal hide fade" id="addNotesModal" style="width:680px;  background: lightgray;">
		<div class="modal-header">
			<button type="button" class="close" data-dismiss="modal">×</button>
			<h3 >Additional Notes</h3>
		</div>
		<div class="modal-body" id="modal_body_cancel" style="height:500px;">
		<form id="add_notes_data">
			<table><tr>
			<td><label>Notes</label><input type="hidden" name="ticket_id_notes" id="ticket_id_notes" value=""/>
			<input type="hidden" name="tech_id_notes" id="tech_id_notes" value=""/>
			<input type="hidden" name="author_type" id="author_type" value="<?php echo $_SESSION['author_type']; ?>"/>
			<input type="hidden" name="author_name" id="author_name" value="<?php echo $_SESSION['email']; ?>"/>
			</td>
			
			</tr>
			
			<tr>
			<td>
			<textarea name="add_notes" id="add_notes" maxlength="300" style="width:326px; height:150px" ></textarea>
			</td>
			</tr></table>
		</form>
		</div>
		<div class="modal-footer">
			<a href="#" class="btn btn-primary" data-dismiss="modal">Close</a>
			<a href="javascript:void(0);" id="ticket_cancel_link" onclick="add_notes_submit();" class="btn btn-primary">Submit</a> 
		</div>
	</div>
	<!--- ===================================================================================================== -->
	<script>
	  $(document).ready(function() {
        $('.datatable_tickets').dataTable( {
           aLengthMenu: [
        [20, 50, 100, 200, -1],
        [25, 50, 100, 200, "All"]
    ],
	"aaSorting": [[ 0, "desc" ]],
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
		$("#redirect_ticket_link").hide();
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
			$("#redirect_ticket_link").show();
			$("#add_notes_link").hide();
			$("#ticket_id").val(id);
			$("#ticket_id_redirect").val(id);
			}
			else if($("#status_ticket").val() == 'Closed'){
			$("#add_notes_link").show();
			$("#ticket_id").val(id);	
			$("#ticket_id_notes").val(id);	
			$("#ticket_id_redirect").val(id);	
			}
			else if($("#status_ticket").val() == 'Cancelled'){
				
			$("#ticket_id_notes").val(id);	
				
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
	$("#reason_cancel").val("");
	var technician_id = $("#technician_id").val();
	$("#tech_id").val(technician_id);
	
	}
	
	// ---------------------- REDIRECT TICKET -----------------------
	function redirect_service_ticket(){
	//alert("cancel Ticket here");
	$('#ticketRedirectModal').modal('show');
	$("#reason_cancel").val("");
	var technician_id = $("#technician_id").val();
	//alert(technician_id);
	$("#old_tech_id").val(technician_id);
	
	}
	
	// ---------------------- ADDITIONAL NOTES ON CLOSED TICKET -----------------------
	function add_notes(){
	//alert("cancel Ticket here");
	$('#addNotesModal').modal('show');
	//$("#reason_cancel").val("");
	var technician_id = $("#technician_id").val();
	$("#tech_id_notes").val(technician_id);
	
	}
	
	// ============= CANCEL TICKET ==============
	function cancel_ticket_submit(){
	// Submit ticket cancel with ajax here
	var url  = "<?php echo LIVE_SITE; ?>/process/cancel_ticket.php";
	var reason = $("#reason_cancel").val();
	if(reason !=""){
	
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
	else{
	alert("Please enter reason for cancel");
	}
	}
	
	// ============= REDIRECT TICKET ==============
	function redirect_ticket_submit(){
	
	// Submit ticket cancel with ajax here
	var url  = "<?php echo LIVE_SITE; ?>/process/redirect_ticket.php";
	var reason = $("#redirect_reason").val();
	var new_tech_id = $("#new_technician_id").val();
	if(reason !="" && new_tech_id != ''){
	$("#redirect_submit_btn").text("Redirecting...");
	$("#redirect_submit_btn").attr("onclick","false");
	var redirect_form_data = $("#redirect_form").serialize();
	$.ajax({
	url: url,
	method: "POST",
	data: redirect_form_data,
	dataType: "html",
	success: function(data){
	if(data =='success'){
	
	//alert("Ticket Redirected Successfully!");	
	location.reload();
	$('#ticketRedirectModal').modal('hide');
	$('#myModal').modal('hide');
	}
	}
	});
	}
	else{
	alert("Please select both techcian and fill redirect reason.");
	}
	}
	
	function add_notes_submit(){
	// Submit ticket cancel with ajax here
	var url  = "<?php echo LIVE_SITE; ?>/process/add_notes_ticket.php";
	var notes = $("#add_notes").val();
	if(notes !=""){
	
	var cancel_form_data = $("#add_notes_data").serialize();
	$.ajax({
	url: url,
	method: "POST",
	data: cancel_form_data,
	dataType: "html",
	success: function(data){
	if(data =='success'){
	
	alert("Note  Added Successfully!");	
	$('#addNotesModal').modal('hide');
	$('#myModal').modal('hide');
	}
	}
	});
	}
	else{
	alert("Please enter Note");
	}
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