<?php
include ('inc/common_func.php');
$techicians_data = get_values_technicians($db); 
$get_poll_venues = get_values_poll_venues($db); 
$get_common_supplies = get_common_supplies('common_election_supplies','',$db); 
$get_call_reasons = get_call_reasons('call_reasons','',$db); 
//echo "<pre>";
//print_r($get_poll_venues); die;
include ('header.php');

$uploadedStatus = 0;
if (isset ( $_POST["submit"] ))
{
	//print_r($_POST); die;
	$polling_sites = $_POST['polling_site_id'];
	$all_address = $_POST['all_address'];
	$technician_id = $_POST['technician_id'];
	$priority_ticket = $_POST['priority_ticket'];
	$machine_num = $_POST['machine_num'];
	$caller = $_POST['caller'];
	$contact_num = $_POST['contact_num'];
	$tickets_count = count($polling_sites);
	foreach($polling_sites as $key=>$val_poll_site_id){
	
	$polling_site_id = $val_poll_site_id;
	//$address = $_POST['address'];
	$reason_call_array = $_POST['call_reason'];
	$supply_needed_array = $_POST['supply_needed'];
	$notes = $_POST['notes'];
	
	

	$reason_call_array = array_flip($reason_call_array);
	unset($reason_call_array['Other']);
	$reason_call_array = array_flip($reason_call_array);
	
	$supply_needed_array = array_flip($supply_needed_array);
	unset($supply_needed_array['Other']);
	$supply_needed_array = array_flip($supply_needed_array);


	$other_call_reason = $_POST['other_call_reason'];
	$other_supply_needed = $_POST['other_supply_needed'];
	// print_r($reason_call_array); die;
	if(!empty($other_call_reason)){
	
	array_push($reason_call_array, $other_call_reason);
	
	}
	if(!empty($other_supply_needed)){
	
	array_push($supply_needed_array, $other_supply_needed);
	
	}
	
	$reason_call = implode(',',$reason_call_array);
	$supply_needed = implode(',',$supply_needed_array);
	
	 $sql = "INSERT INTO service_tickets SET 
			polling_site_id='$polling_site_id',
			technician_id='$technician_id',
			reason_call='$reason_call',
			priority_ticket='$priority_ticket',
			machine_num='$machine_num',
			caller='$caller',
			contact_num='$contact_num',
			notes='$notes',
			supply_needed='$supply_needed'";
		//	die;
	$result=mysqli_query($db,$sql);
	if($result){
	$last_inserted_id = mysqli_insert_id($db);
	$success_message = 'Service Ticket Submitted Successfully';
	$service_ticket = "Service Ticket Number: <b>".sprintf('%06d', $last_inserted_id)."</b>";
	$ticket_id = $last_inserted_id;
	
		
	// Update Polling Venue record.
		
		$sql_update_poll_venue = "UPDATE poll_venues 
			SET
			`is_assigned`='1',
			`assigned_to`='".$technician_id."'
			
			 WHERE `id` = ".$polling_site_id;

		mysqli_query($db,$sql_update_poll_venue);
        sendPushNotificationToTechnician ($technician_id,$reason_call,$ticket_id) ;
	}
	else{
	$success_message = 'There was an Error While Processing';
	
	}
	}
	/*$push_message ="You have been assigned ".$tickets_count." Service Ticket(s). Polling Site(s): ".$all_address;
		$user_id=$technician_id;
		//echo $push_message ;die;
		$data = array("alert" => $push_message);

		// Push to Query
		$query = ParseInstallation::query();
		$query->equalTo("userID",$user_id);
		ParsePush::send(array(
			"where" => $query,
			"data" => $data
		));*/
	
}
?>

<div id="content" class="span10">
	<ul class="breadcrumb">
		<li><i class="icon-home"></i> <a href="poll_venues.php">Home</a> <i
			class="icon-angle-right"></i></li>
		<li><a href="#">Pre Assign Technicians</a></li>
	</ul>
	<div style="float:right;"><a href="view_service_tickets.php" >View All Service Tickets</a></div>
	<div class="row-fluid sortable">
		<div class="box span12">
			<div class="box-header" data-original-title>
				<h2>
					<i class="halflings-icon edit"></i>
						<span class="break"></span>
						Service Ticket &nbsp;&nbsp;<span style = 'color: green'><?php echo @$success_message ?></span>
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
		<div class="box-content service_ticket_left">
		<?php
		if(@$ticket_id){ ?>
		<div style="text-align:center;"><?php echo @$service_ticket; ?> <a href="pdf/docs/service_tkt_pdf.php?id=<?php echo $ticket_id;?>" target="blank" > | Create PDF</a></div>
		<?php } ?>
			<form class="form-horizontal" id="myForm" method="post" enctype="multipart/form-data" >
				<fieldset>
					<div class="control-group">
						<label style="color:red"><?php echo @$error; ?></label>
					</div>
					
					<div class="control-group">
									<label for="tech_id" class="control-label">Technicians</label>
									<div class="controls">
									  <select id="technician_id" name="technician_id" onchange="preview_ticket();" required>
									  <option value='' >Select</option>
										<?php foreach($techicians_data as $tech){ ?>
										<option value="<?php echo $tech['id']; ?>" rel="<?php echo $tech['first_name']; ?>"><?php echo $tech['first_name']; ?></option>
										
										<?php } ?>
										
									  </select>
									</div>
						</div>	
						
						<div class="control-group">
								<label for="polling_site_id" class="control-label">Polling Sites</label>
								<div class="controls">
								  <select id="polling_site_id" class="searchable" name="polling_site_id[]" multiple="" onchange="preview_ticket();">
									<?php foreach($get_poll_venues as $venues){ 
									if($venues['is_assigned'] =='1'){
									$disabled = 'disabled';
									$assigned_to = "->Already Assigned";
									}
									else{
									$disabled = '';
									$assigned_to = '';
									}
									?>
									<option value="<?php echo $venues['id']; ?>" <?php  //echo $disabled; ?> rel = "" title="Full Address = <?php echo $venues['location_nm'].'-'.$venues['address']; ?><?php // echo $assigned_to; ?>"><?php echo $venues['voting_district'];?> </option>
									
									<?php } ?>
									</select>
								</div>
						</div>
				<!--	<div class="control-group">
								<label for="polling_site_id" class="control-label">Polling Sites</label>
								<div class="controls">
								  <select id="polling_site_id" name="polling_site_id"  class="searchable" onchange="preview_ticket();" required multiple>
								  <option value='' >Select</option>
									<?php foreach($get_poll_venues as $venues){ ?>
									<option value="<?php echo $venues['id']; ?>"><?php echo $venues['name_of_location']; ?></option>
									
									<?php } ?>
								  </select>
								</div>
						</div> -->
						<input type="hidden" name="all_address" id="all_address" />
				<!-- 	<div class="control-group hidden-phone">
						  <label class="control-label" for="textarea2">Address</label>
						  <div class="controls">
							<textarea class="cleditor2" id="textarea2" rows="3" name = 'address' onkeyup="preview_ticket();"></textarea>
						  </div>
						</div> -->

						
	
					<div class="form-actions">
						<button type="submit" name='submit' value = 'submit' class="btn btn-primary">Submit</button>
						<button type="reset" class="btn">Cancel</button>
					</div>
				</fieldset>
			</form>
		</div>
	
	</div>
</div>

</div>
<div class="modal hide fade" id="modal_poll_tech_distance">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h3>Polling Site - Technicians Distance</h3>
	</div>
	<div class="modal-body" id="poll_tech_distance_div">
		<p>Loading data...</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Close</a>
	</div>
</div>
<?php
include('footer.php');
?>
<script src="js/select-multiple/js/quicksearch.js" type="text/javascript"></script>
<script src="js/select-multiple/js/jquery.select-multiple.js" type="text/javascript"></script>
<script type="text/javascript">
var count_site =0;
$(document).ready(function(){
	
	$('.searchable').selectMultiple({
	  selectableHeader: "<input type='text' class='search-input' autocomplete='off' name='search_item' placeholder='Search'>",
	  afterInit: function(ms){
	    var that = this,
	        $selectableSearch = that.$selectableUl.prev(),
	        selectableSearchString = '#'+that.$container.attr('id')+' .ms-elem-selectable';

	    that.qs1 = $selectableSearch.quicksearch(selectableSearchString)
	    .on('keydown', function(e){
	      if (e.which === 40){
	        that.$selectableUl.focus();
	        return false;
	      }
	    });
	  },
	  afterSelect: function(values){
	//	alert("Select value: "+values);
		//var id_select = this.id;
		
		var other_id = this.$element.attr("id");
		if(other_id == 'polling_site_id'){
		count_site = count_site +1;
		//alert(count_site);
		if(count_site > 1){
		alert("Sorry! You cannot assign multiple polling sites");
		this.deselect(values);
		
		}
		else{
		showDistance(values);
		// alert("poll site id selected is"+values);
		}
		//this.deselect_all();
		}
		if(values == 'Other'){
		$("#div_other_"+other_id).show();
		}
		this.qs1.cache();
	  },
	  afterDeselect: function(values){
		//alert("Deselect value: "+values);
		var other_id = this.$element.attr("id");
		if(other_id == 'polling_site_id'){
		count_site = count_site -1;
		
		//this.deselect_all();
		}
		
		if(values == 'Other'){
		$("#div_other_"+other_id).hide();
		}
	    this.qs1.cache();
	  }
	});
});
// =============== SHOW DISTANCE POP UP ===================
function showDistance(poll_id){

var url  = "<?php echo LIVE_SITE; ?>/process/get_distace_technician.php";
	
	if(poll_id !=""){
	$("#modal_poll_tech_distance").modal('show');
	//var cancel_form_data = $("#cancel_form_data").serialize();
	$.ajax({
	url: url,
	method: "POST",
	data: {poll_site_id: poll_id},
	dataType: "html",
	success: function(data){
	//if(data =='success'){
	$("#poll_tech_distance_div").html(data);
	//alert("Ticket Cancelled Successfully!");	
	//$('#ticketCancelModal').modal('hide');
	//$('#myModal').modal('hide');
	//}
	}
	});
	}
	else{
	alert("Please enter valid Poll site id");
	}

// alert("poll id is"+poll_id);
}

// =============== SELECT TECHNICIAN FROM DROP DOWN ================

function select_tech(id){
$("#technician_id").val(id);
$("#modal_poll_tech_distance").modal('hide');
}
// Autofill Ticket Views
function preview_ticket(){
//alert(label_nm);
//alert(multiple);
var tech_name = []; 
$('#technician_id :selected').each(function(i, selected){ 
	
  tech_name[i] = $(selected).text(); 
});
if(tech_name =='Select'){
tech_name = '';
}
var call_reason = []; 
$('#call_reason :selected').each(function(i, selected){ 
	var text_sel = $(selected).text();
	if(text_sel == 'Other'){
		text_sel = $("#other_call_reason").val();
	}
	call_reason[i] = text_sel; 
});
//alert(call_reason);
//var call_reason_new = call_reason.replace(',', '<br/>')

// alert(call_reason_new);

var polling_site = []; 
$('#polling_site_id :selected').each(function(i, selected){ 
  polling_site[i] = $(selected).text(); 
});
var supply_needed = []; 
$('#supply_needed :selected').each(function(i, selected){ 
	var text_sel = $(selected).text();
	if(text_sel == 'Other'){
		text_sel = $("#other_supply_needed").val();
	}
	
  supply_needed[i] = text_sel; 
});

// var tech_val = $("#technician_id").text();
//alert(tech_name);
//var address = $("#textarea2").val();
$("span#tech_lbl_name").text(tech_name);
//$("span#polling_site_address_span").text(address);
$("span#call_terms_span").text(call_reason);
$("span#polling_site_span").text(polling_site);
$("#all_address").val(polling_site);

$("span#common_supply_span").text(supply_needed);
}

</script>
<script src="http://jqueryvalidation.org/files/dist/jquery.validate.min.js"></script>
<script>

$( "#myForm" ).validate({
  rules: {
    'polling_site_id[]': {
      required: true
    },
	'call_reason[]': {
      required: true
    },
	'priority_ticket': {
      required: true
    },
	'technician_id': {
      required: true
    }
	
  }
});
</script>
<link href="js/select-multiple/css/select-multiple.css" media="screen" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="http://jqueryvalidation.org/files/demo/site-demos.css">
 
