<?php
include('config.php');
function get_values_technicians( $db ){
$sql="SELECT * FROM technician WHERE is_deleted=0";
$result=mysqli_query($db,$sql);

$return_array = array();
$i=0;
while($results_users=mysqli_fetch_array($result,MYSQLI_ASSOC)){ 

	$object = $results_users;
	$return_array[$i]['id'] = $object['id'];
	$tech_id = $object['id'];
	//$num_open_tkt = getOpenTickets($object['id']);
	// -----------------
	$sql2 = "Select COUNT(*) as number_open_ticket from service_tickets where technician_id = '$tech_id' AND status=0 AND response_acceptance=1";
    $result2 = mysqli_query($db, $sql2);
    $row2 = mysqli_fetch_array($result2, MYSQLI_ASSOC);
	$num_open_tkt = $row2['number_open_ticket'];
	// -----------------
	$is_available =0; // Available means have no open ticket which was accepted
	if($num_open_tkt > 0){
		
		$is_available =1; // have one or more tickets opened which was accepted
	}
	$return_array[$i]['first_name']= $object['first_name'];
	$return_array[$i]['last_name'] = $object['last_name'];
	$return_array[$i]['email'] = $object['email'];
	$return_array[$i]['lat'] = $object['latitude'];
	$return_array[$i]['long'] = $object['longitude'];
	$return_array[$i]['status'] = $object['status'];
	$return_array[$i]['role'] = $object['role'];
	$return_array[$i]['is_available'] = $is_available;
	$return_array[$i]['num_open_tkt'] = $num_open_tkt;
	$i++;
	}
//print_r($return_array);
	return $return_array;
}
// ----------------- CANCEL TICKET ------------------------------

function cancelTicket( $id,$reason_cancel,$technician_id ){
global $db;
$sql="UPDATE service_tickets st SET st.status=2, st.cancel_reason =  '$reason_cancel' WHERE st.id=".$id;
$result=mysqli_query($db,$sql);
if($result){
$ticket_id = $id;
$ticket_num = sprintf('%06d', $ticket_id);
$message = "Ticket id ".$ticket_num." has been cancelled due to following reason: ".$reason_cancel;
$tech_id = $technician_id;
// echo $tech_id."---".$message."---".$ticket_id; die;
sendPushNotificationToTechnician($tech_id, $message, $ticket_id);
return "success";
}
else {
return "failed";
}
}


// ----------------- CANCEL TICKET ------------------------------

function redirectTicket( $id,$redirect_reason,$old_technician_id, $new_technician_id ){
global $db;
$sql="UPDATE service_tickets st SET technician_id='$new_technician_id', st.redirect_reason =  '$redirect_reason' WHERE st.id=".$id;
$result=mysqli_query($db,$sql);
if($result){
$ticket_id = $id;
$ticket_num = sprintf('%06d', $ticket_id);
$cancel_message = "Ticket id ".$ticket_num." has been cancelled due to following reason: ".$redirect_reason;
$new_message = "Ticket id ".$ticket_num." has been assigned to you";
$old_tech_id = $old_technician_id;
$new_tech_id = $new_technician_id;

// echo $tech_id."---".$message."---".$ticket_id; die;
sendPushNotificationToTechnician($old_tech_id, $cancel_message, $ticket_id); // Cancel Notification to old TECHNICIAN
sendPushNotificationToTechnician($new_tech_id, $ticket_num, $ticket_id); // Send New notification to new technician
return "success";
}
else {
return "failed";
}
}

// ----------------- ADD ADDITIONAL NOTES FOR TICKET ------------------------------

function AddNoteForTicket( $st_id,$desc='',$author_type='',$author_name='' ){
	global $db;
	$sql="INSERT ticket_add_notes (description, ticket_id, author_type,author_name ) VALUES ('$desc', $st_id,'$author_type','$author_name')";
	$result=mysqli_query($db,$sql);
	if($result){

	return "success";
	}
	else {
	return "failed";
	}
}

// ----------------- GET ADDITIONAL NOTES FOR TICKET ------------------------------

function getAdditionalNotes($st_id){
	global $db;
	$sql="SELECT * FROM ticket_add_notes WHERE ticket_id = $st_id ORDER BY created_at DESC";
	$result=mysqli_query($db,$sql);
	$return_array = array();
	$i=0;
	while($results_data=mysqli_fetch_array($result,MYSQLI_ASSOC)){ 

	$return_array[] = $results_data;
	}
	return $return_array;
}
 // -======================= GET ALL POLL VENUES ==========================
function get_values_poll_venues($db){
	$sql="SELECT * FROM poll_venues";
	$result=mysqli_query($db,$sql);

	$return_array = array();
	$i=0;
	while($results_users=mysqli_fetch_array($result,MYSQLI_ASSOC)){ 

	$object = $results_users;
	$return_array[$i]['id'] = $object['id'];
	$return_array[$i]['municipality']= $object['municipality'];
	$return_array[$i]['voting_district']= $object['voting_district'];
	$return_array[$i]['latitude']= $object['latitude'];
	$return_array[$i]['longitude']= $object['longitude'];
	$return_array[$i]['ST']= $object['ST'];
	$return_array[$i]['location_poll']= $object['name_of_location'];
	$return_array[$i]['ZIP']= $object['ZIP'];
	$return_array[$i]['address']= $object['address_line_1'].', '.$object['post_office'].', '.$object['ST'].', '.$object['ZIP'];
	$return_array[$i]['name_of_location']= $object['name_of_location'].', '.$object['ST'];
	$return_array[$i]['location_nm']= $object['name_of_location'];
	$return_array[$i]['ward'] = $object['ward'];
	$return_array[$i]['is_assigned'] = $object['is_assigned'];
	$return_array[$i]['assigned_to'] = $object['assigned_to'];
	$i++;
	}
//print_r($return_array);
	return $return_array;
}

 // -======================= GET POLL VENUE DETAIL BY ID ==========================
function get_poll_site_detail($poll_site_id){

global $db;

	$sql="SELECT * FROM poll_venues WHERE id=".$poll_site_id." LIMIT 1"; 
	$result=mysqli_query($db,$sql);

$return_array = array();
$i=0;
while($results_users=mysqli_fetch_array($result,MYSQLI_ASSOC)){ 

	$object = $results_users;
	$return_array[$i]['id'] = $object['id'];
	$return_array[$i]['municipality']= $object['municipality'];
	$return_array[$i]['voting_district']= $object['voting_district'];
	$return_array[$i]['latitude']= $object['latitude'];
	$return_array[$i]['longitude']= $object['longitude'];
	$return_array[$i]['ST']= $object['ST'];
	$return_array[$i]['location_poll']= $object['name_of_location'];
	$return_array[$i]['ZIP']= $object['ZIP'];
	$return_array[$i]['address']= $object['address_line_1'].', '.$object['post_office'].', '.$object['ST'].', '.$object['ZIP'];
	$return_array[$i]['name_of_location']= $object['name_of_location'].', '.$object['ST'];
	$return_array[$i]['location_nm']= $object['name_of_location'];
	$return_array[$i]['ward'] = $object['ward'];
	$return_array[$i]['is_assigned'] = $object['is_assigned'];
	$return_array[$i]['assigned_to'] = $object['assigned_to'];
	$i++;
	}
//print_r($return_array);
	return $return_array[0];
}

// ================ GET ALL TECHNICIANS DETAILS ========================

function get_all_technicians_detail(){
global $db;

	$sql="SELECT T.* FROM technician T WHERE T.is_deleted=0"; 
	$result=mysqli_query($db,$sql);

$return_array = array();
$i=0;
while($results_users=mysqli_fetch_array($result,MYSQLI_ASSOC)){ 

	$object = $results_users;
	$tech_id = $object['id'];
	//get No of Open Ticket of this technician
	
	$num_open_tkt = getOpenTickets($tech_id);
	
	$fname = $object['first_name'];
	$lname = $object['last_name'];
	$return_array[$i]['id'] = $object['id'];
	$return_array[$i]['username']= $fname." ".$lname;
	//$return_array[$i]['username']= $object['username']." - [".$fname." ".$lname."]";
	$return_array[$i]['latitude']= $object['latitude'];
	$return_array[$i]['longitude']= $object['longitude'];
	$return_array[$i]['num_open_tkt']= $num_open_tkt;
	
	$i++;
	}
//print_r($return_array);
	return $return_array;

}
/************************************************

/* ----------- Get Number of Open Ticket of TECHNICIANS -------------------*/

function getOpenTickets($tech_id){
	global $db;
	$sql = "Select COUNT(*) as number_open_ticket from service_tickets where technician_id = '$tech_id' AND status=0 AND response_acceptance=1";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
	return $row['number_open_ticket'];
	
}
/* ----------- Get Number of Open Ticket of TECHNICIANS ENDS---------------*/
/*================= GET ADMIN EMAIL  =============================*/

// -======================= GET ALL POLL VENUES ==========================
function get_admin_emails($db){
$sql="SELECT * FROM admin";
$result=mysqli_query($db,$sql);

$return_array = array();
$i=0;
while($results_users=mysqli_fetch_array($result,MYSQLI_ASSOC)){ 

	$object = $results_users;
	$return_array[$i]['id'] = $object['id'];
	$return_array[$i]['email']= $object['email'];
	$return_array[$i]['username']= $object['username'];
	$i++;
	}
//print_r($return_array);
	return $return_array;
}


/*================= =============================*/
/**
 * Returns information about service tickets 
 * in the form of array with respect to technician id
 * passed.
 * 
 * @param integer $technician_id
 * @author Jaskaran Singh
 * @version 1.0
 * @return array
 */
function getServiceTicketsByTechnician( $db, $technician_id )
{
//	$sql="SELECT * FROM service_tickets where `technician_id` = ".$technician_id;
	$sql = "SELECT ST.*, PV.ward, PV.address_line_1, PV.address_line_2, PV.ST, PV.ZIP , PV.name_of_location,PV.voting_district, PV.latitude, PV.longitude, TH.first_name, TH.last_name, TH.email
			FROM service_tickets  ST

			LEFT JOIN poll_venues PV
			ON ST.polling_site_id=PV.id

			LEFT JOIN technician TH
			ON ST.technician_id=TH.id
			WHERE ST.technician_id ='$technician_id'
			ORDER BY ST.id DESC";
	$result=mysqli_query($db,$sql);
	
	$return_array = array();
	$i=0;
	while($results_users=mysqli_fetch_array($result,MYSQLI_ASSOC)){ 
	
		$object = $results_users;
		if($object['status'] == '0'){
		$status = 'Open';
		}
		elseif($object['status'] == '2'){
		$status = 'Cancelled';
		}
		else{
		$status = 'Closed';
		
		}
		$return_array[$i]['id'] = $object['id'];
		$return_array[$i]['ticket_num'] = sprintf('%06d', $object['id']);
		$return_array[$i]['polling_site_id'] = $object['polling_site_id'];
		$return_array[$i]['voting_district']= $object['voting_district'];
		$return_array[$i]['response_acceptance']= $object['response_acceptance'];
		$return_array[$i]['assigned_on'] = $object['created_at'];
		$return_array[$i]['poll_ward'] = $object['ward'];
		$return_array[$i]['priority_ticket'] = $object['priority_ticket'];
		$return_array[$i]['machine_num'] = $object['machine_num'];
		$return_array[$i]['poll_site_name'] = $object['name_of_location'];
		$return_array[$i]['poll_site_address'] = $object['address_line_1'].', '.$object['ST'].', '.$object['ZIP'];
		$return_array[$i]['lat'] = $object['latitude'];
		$return_array[$i]['long'] = $object['longitude'];
		$return_array[$i]['notes'] = $object['notes'];
		$return_array[$i]['status'] = $status;
		$return_array[$i]['enroute_datetime'] = $object['enroute_datetime'];
		$return_array[$i]['on_scene_datetime'] = $object['on_scene_datetime'];
		$return_array[$i]['poll_site_address'] = $object['address_line_1'].', '.$object['ST'].', '.$object['ZIP'];
		
		$return_array[$i]['caller']= $object['caller'];
		$return_array[$i]['contact_num']= $object['contact_num'];
		
		$return_array[$i]['technician_id']= $object['technician_id'];
		//$return_array[$i]['address']= $object['address'];
		$return_array[$i]['reason_call']= $object['reason_call'];
		$return_array[$i]['supply_needed']= $object['supply_needed'];
		$i++;
		}
	// print_r($return_array);
	return $return_array;
}

// ------------------- GET COMMON SUPPLIES --------------

function get_common_supplies($table_name, $field_name,$db){
$sql="SELECT * FROM $table_name";
$result=mysqli_query($db,$sql);

$return_array = array();
$i=0;
while($results_users=mysqli_fetch_array($result,MYSQLI_ASSOC)){ 

	$object = $results_users;
	$return_array[$i]['id'] = $object['id'];
	$return_array[$i]['common_supply']= $object['common_supply'];
	
	$i++;
	}
//print_r($return_array);
	return $return_array;
}
// ------------------- GET CALL REASONS --------------

function get_call_reasons($table_name, $field_name,$db){
$sql="SELECT * FROM $table_name";
$result=mysqli_query($db,$sql);

$return_array = array();
$i=0;
while($results_users=mysqli_fetch_array($result,MYSQLI_ASSOC)){ 

	$object = $results_users;
	$return_array[$i]['id'] = $object['id'];
	$return_array[$i]['call_reason']= $object['call_reason'];
	
	$i++;
	}
//print_r($return_array);
	return $return_array;
}

// ================== GET SERVICE TICKET DATA FOR PRINT IN PDF ==================

function getServiceTicketData($id){
global $db;

$sql = "SELECT ST.*, AD.name as dispatcher, PV.ward, PV.address_line_1, PV.address_line_2,TD.created_at as closed_time, TD.comments as tech_comments, PV.voting_district, PV.ST, PV.ZIP , PV.post_office , PV.name_of_location, PV.latitude, PV.longitude, TH.first_name, TH.last_name, TH.username,TH.email
			FROM service_tickets  ST

			LEFT JOIN poll_venues PV
			ON ST.polling_site_id=PV.id

			LEFT JOIN technician TH
			ON ST.technician_id=TH.id
			
			LEFT JOIN admin AD
			ON ST.dispatcher_id=AD.id
			
			LEFT JOIN ticket_data TD ON
			ST.id=TD.service_ticket_id

			WHERE ST.id ='$id'
			ORDER BY ST.id";
	$result=mysqli_query($db,$sql);
	
	$return_array = array();
	$i=0;
	while($results_users=mysqli_fetch_array($result,MYSQLI_ASSOC)){ 
	
		$object = $results_users;
		if($object['status'] == '0'){
		$status = 'Open';
		}
		elseif($object['status'] == '2'){
		$status = 'Cancelled';
		}
		else{
		$status = 'Closed';
		
		}
		$object['id'] = sprintf('%06d', $object['id']);
		$return_array[$i]['id'] = $object['id'];
		$return_array[$i]['username'] = $object['username'];
		$return_array[$i]['polling_site_id'] = $object['polling_site_id'];
		$return_array[$i]['voting_district']= $object['voting_district'];
		$return_array[$i]['assigned_on'] = $object['created_at'];
		$return_array[$i]['dispatcher_solve'] = $object['dispatcher_solve'];
		$return_array[$i]['dispatcher'] = $object['dispatcher'];
		$return_array[$i]['poll_ward'] = $object['ward'];
		$return_array[$i]['priority_ticket'] = $object['priority_ticket'];
		$return_array[$i]['machine_num'] = $object['machine_num'];
		$return_array[$i]['poll_site_name'] = $object['name_of_location'];
		$return_array[$i]['notes'] = $object['notes'];
		$return_array[$i]['post_office'] = $object['post_office'];
		$return_array[$i]['poll_site_address'] = $object['address_line_1'].', '.$object['ST'].', '.$object['ZIP'];
		$return_array[$i]['lat'] = $object['latitude'];
		$return_array[$i]['long'] = $object['longitude'];
		$return_array[$i]['status'] = $status;
		$return_array[$i]['closed_time'] =$object['closed_time'];
		$return_array[$i]['tech_comments'] =$object['tech_comments'];
		$return_array[$i]['enroute_datetime'] =$object['enroute_datetime']?date('Y-m-d H:i:s',$object['enroute_datetime']):"NA";
		$return_array[$i]['on_scene_datetime'] =$object['on_scene_datetime']?date('Y-m-d H:i:s',$object['on_scene_datetime']):"NA";
		$return_array[$i]['cancel_reason'] =$object['cancel_reason'];
		$return_array[$i]['poll_site_address'] = $object['address_line_1'].', '.$object['ST'].', '.$object['ZIP'];
		
		
		$return_array[$i]['technician_id']= $object['technician_id'];
		$return_array[$i]['first_name']= $object['first_name'];
		$return_array[$i]['last_name']= $object['last_name'];
		$return_array[$i]['email']= $object['email'];
		//$return_array[$i]['address']= $object['address'];
		$return_array[$i]['reason_call']= $object['reason_call'];
		$return_array[$i]['supply_needed']= $object['supply_needed'];
		$return_array[$i]['caller']= $object['caller'];
		$return_array[$i]['contact_num']= $object['contact_num'];
		
		$i++;
		}
	// print_r($return_array);
	return $return_array;

}

function sendPushNotificationToTechnician($technician_id, $message, $ticket_id) { 
    global $db;
    $sql = "Select push_regid from technician where id = '$technician_id' ";
    $result = mysqli_query($db, $sql);
    $row = mysqli_fetch_array($result, MYSQLI_ASSOC);
    $count = mysqli_num_rows($result);
    if ($count > 0) {
        $msg = array
            (
            'message' => $message,
            'service_ticket_id' => $ticket_id,
            'technician_id'   => $technician_id,
            'service_ticket_data' => getServiceTicketData($ticket_id) 
        );
        //Old
        $registrationIds = array($row['push_regid']);
        //Latest
        /* $registrationIds = array("APA91bFmaluU3botkCK8qsu8chbXzDZFpkiIif3cbY9D5CbViiFyvoqfAfH9jaknrxcXxZewFqcMPhWJpMkcxYmdtyDKVnClfGqAgTQsqtWCOmrm-zcWcqXVn20gCuJ98GJ1oihGbzFe"); */
        $fields = array
            (
            'registration_ids' => $registrationIds,
            'data' => $msg
        );

        $headers = array
            (
            'Authorization: key=' . 'AIzaSyB2GkpTvUm3VqlmfQqXcphTYWuxqGQK46U',
            'Content-Type: application/json'
        );

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://android.googleapis.com/gcm/send');
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($fields));
        $result = curl_exec($ch);
        curl_close($ch);
        //print_r($result);
    }
}
?>