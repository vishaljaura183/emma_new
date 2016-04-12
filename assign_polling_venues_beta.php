<?php
include ('inc/common_func.php');
$techicians_data = get_values_technicians('technician','first_name,last_name',$db); 
$get_poll_venues = get_values_poll_venues($db); 
$get_common_supplies = get_common_supplies('common_election_supplies','',$db); 
$get_call_reasons = get_call_reasons('call_reasons','',$db); 
//echo "<pre>";
//print_r($get_poll_venues); die;
include ('header.php');
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseACL;
use Parse\ParsePush;
use Parse\ParseUser;
use Parse\ParseInstallation;
use Parse\ParseException;
use Parse\ParseAnalytics;
use Parse\ParseFile;
use Parse\ParseCloud;
use Parse\ParseClient;
//Moving file to server=======================================
$uploadedStatus = 0;
if (isset ( $_POST["submit"] ))
{
	//print_r($_POST); die;
	$polling_sites = $_POST['polling_site_id'];
	foreach($polling_sites as $key=>$val_poll_site_id){
	
	$polling_site_id = $val_poll_site_id;
	//$address = $_POST['address'];
	$reason_call = implode(',',$_POST['call_reason']);
	$technician_id = $_POST['technician_id'];
	$supply_needed = implode(',',$_POST['supply_needed']);
	
	 $sql = "INSERT INTO service_tickets SET 
			polling_site_id='$polling_site_id',
			technician_id='$technician_id',
			reason_call='$reason_call', supply_needed='$supply_needed'";
		//	die;
	$result=mysqli_query($db,$sql);
	if($result){
	
	$success_message = 'Service Ticket Submitted Successfully';
	// Update Polling Venue record.
		
		$sql_update_poll_venue = "UPDATE poll_venues 
			SET
			`is_assigned`='1',
			`assigned_to`='".$technician_id."'
			
			 WHERE `id` = ".$polling_site_id;

		mysqli_query($db,$sql_update_poll_venue);
	
	
	}
	else{
	$success_message = 'There was an Error While Processing';
	
	}
	
	}
	$push_message ="You have been assigned a polling site. Address: ".$address;
		$user_id=$technician_id;
		//echo $push_message ;die;
		$data = array("alert" => $push_message);

		// Push to Query
		$query = ParseInstallation::query();
		$query->equalTo("userID",$user_id);
		ParsePush::send(array(
			"where" => $query,
			"data" => $data
		));
		
}
?>

<div id="content" class="span10">
	<ul class="breadcrumb">
		<li><i class="icon-home"></i> <a href="poll_venues.php">Home</a> <i
			class="icon-angle-right"></i></li>
		<li><a href="#">Start Service Ticket</a></li>
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
		
			<form class="form-horizontal" id="myForm" method="post" enctype="multipart/form-data" >
				<fieldset>
					<div class="control-group">
						<label style="color:red"><?php echo @$error; ?></label>
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
									<option value="<?php echo $venues['id']; ?>" <?php echo $disabled; ?> rel = "" title="Full Address = <?php echo $venues['location_nm'].'-'.$venues['address']; ?><?php echo $assigned_to; ?>"><?php echo $venues['name_of_location'];?> </option>
									
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
						
				<!-- 	<div class="control-group hidden-phone">
						  <label class="control-label" for="textarea2">Address</label>
						  <div class="controls">
							<textarea class="cleditor2" id="textarea2" rows="3" name = 'address' onkeyup="preview_ticket();"></textarea>
						  </div>
						</div> -->
						
						<div class="control-group hidden-phone">
						  <label class="control-label" for="textarea2">Reason Of Call</label>
						  <div class="controls">
								  <select id="call_reason" name="call_reason[]"  class="searchable"  onchange="preview_ticket();" multiple>
									<?php foreach($get_call_reasons as $tech){ ?>
									<option value="<?php echo $tech['call_reason']; ?>" rel="<?php echo $tech['call_reason']; ?>"><?php echo $tech['call_reason']; ?></option>
									
									<?php } ?>
								  </select>
								</div>
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
									<label for="supply_needed"  class="control-label">Supplies Needed</label>
									<div class="controls">
									  <select id="supply_needed" name="supply_needed[]" class="searchable"  onchange="preview_ticket();" multiple>
										<?php foreach($get_common_supplies as $tech){ ?>
										<option value="<?php echo $tech['id']; ?>" rel="<?php echo $tech['common_supply']; ?>"><?php echo $tech['common_supply']; ?></option>
										
										<?php } ?>
									  </select>
									</div>
						</div>	
					
					<div class="form-actions">
						<button type="submit" name='submit' value = 'submit' class="btn btn-primary">Submit</button>
						<button type="reset" class="btn">Cancel</button>
					</div>
				</fieldset>
			</form>
		</div>
		<div class="service_ticket_right">
		<h3>Service Ticket View</h3>
		<div id="ticket_view">
		<span>Hi <span id="tech_lbl_name"></span>, </span><br/>
		<span>You have been assigned a polling site.<br/> Below are the details of the service ticket</span>
			<table>
				<tr><td>Polling Site:</td><td><span id="polling_site_span"></span></td></tr>
				<tr><td>Address:</td><td><span id="polling_site_address_span"></span></td></tr>
				<tr><td>Call terms:</td><td><span id="call_terms_span"></span></td></tr>
				<tr><td>Common Supplies Povided:</td><td><span id="common_supply_span"></span></td></tr>
			</table>
		</div>
		</div>
	</div>
</div>

</div>
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
<script src="js/select-multiple/js/quicksearch.js" type="text/javascript"></script>
<script src="js/select-multiple/js/jquery.select-multiple.js" type="text/javascript"></script>
<script type="text/javascript">
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
		// alert("Select value: "+values);
		this.qs1.cache();
	  },
	  afterDeselect: function(values){
		// alert("Deselect value: "+values);
	    this.qs1.cache();
	  }
	});
})
</script>
<script>
$(document).ready(function(){

});
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
  call_reason[i] = $(selected).text(); 
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
  supply_needed[i] = $(selected).text(); 
});

// var tech_val = $("#technician_id").text();
//alert(tech_name);
var address = $("#textarea2").val();
$("span#tech_lbl_name").text(tech_name);
$("span#polling_site_address_span").text(address);
$("span#call_terms_span").text(call_reason);
$("span#polling_site_span").text(polling_site);
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
	'technician_id': {
      required: true
    }
	
  }
});
</script>
<link href="js/select-multiple/css/select-multiple.css" media="screen" rel="stylesheet" type="text/css">
<link rel="stylesheet" href="http://jqueryvalidation.org/files/demo/site-demos.css">
 
