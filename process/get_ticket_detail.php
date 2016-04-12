<?php
require_once('../inc/common_func.php');
if(isset($_REQUEST['id']) && !empty($_REQUEST['id'])){
$id = $_REQUEST['id'];
$data = getServiceTicketData($id);

$data = $data[0];
$ticket_id = $data['id'];
if($data['dispatcher_solve']=='1'){
	$solve_by ='<tr>
					<td rowspan="3" valign="top">Dispatcher Solve</td>
					
				
				
				</tr>';
}
else{
	
$solve_by ='<tr>
					<td>First Name:</td>
					<td>'.$data["first_name"].'<input type="hidden" id="technician_id" name="technician_id" value="'.$data["technician_id"].'" /></td>
				</tr>
				<tr>
					<td>Last Name:</td>
					<td>'.$data["last_name"].'</td>
				</tr>
				<tr>
					<td>Username</td>
					<td>'.$data["username"].'</td>
				</tr>';
}
$html = '
<table border="0" cellpadding="2" style="margin:auto;">
	<tr>
		<th valign="top">
			<table cellpadding="4">
				<tr>
					<td colspan = "2"  valign="top" bgcolor="silver">Technician Information</td>
				</tr>
				'.$solve_by.'
				
			</table>
		</th>
		<th>
			<table cellpadding="4">
				<tr>
					<td colspan = "2"  bgcolor="silver">Polling Site Information</td>
				</tr>
				<tr>
					<td>Voting District:</td>
					<td>'.$data["voting_district"].'</td>
				</tr>
				<tr>
					<td>Polling Site Name:</td>
					<td>'.$data["poll_site_name"].'</td>
				</tr>
				<tr>
					<td>Post Office:</td>
					<td>'.$data["post_office"].'</td>
				</tr>
				
				<tr>
					<td>Address:</td>
					<td>'.$data["poll_site_address"].'</td>
					
				</tr>
			</table>
		</th>
	</tr>
	<tr>
		<td colspan = "2">
			<table cellpadding="4" >
				<tr>
					<td colspan = "2"  bgcolor="silver">Service Ticket Details</td>
				</tr>
				
				<tr>
					<td>Service Ticket Number:</td>
					<td>'.$ticket_id.'</td>
				</tr>
				<tr>
					<td>Dispatcher:</td>
					<td>'.$data["dispatcher"].'</td>
				</tr>
				<tr>
					<td>Reason Of Call:</td>
					<td>'.$data["reason_call"].'</td>
				</tr>
				<tr>
					<td>Caller:</td>
					<td>'.$data["caller"].'</td>
				</tr>
				<tr>
					<td>Contact Number:</td>
					<td>'.$data["contact_num"].'</td>
				</tr>
				<tr>
					<td>Priority Level:</td>
					<td>'.$data["priority_ticket"].'</td>
				</tr>
				<tr>
					<td>Machine Number:</td>
					<td>'.$data["machine_num"].'</td>
				</tr>
				<tr>
					<td>Supplies Needed:</td>
					<td>'.$data["supply_needed"].'</td>
				</tr>
				
				<tr>
					<td>Enroute Time:</td>
					<td>'.$data["enroute_datetime"].'</td>
				</tr>
				<tr>
					<td>On Scene Time:</td>
					<td>'.$data["on_scene_datetime"].'</td>
				</tr>
				<tr>
					<td>Notes:</td>
					<td>'.$data["notes"].'</td>
				</tr>
				
				<tr>
					<td>Status:</td>
					<td>'.$data["status"].'<input type="hidden" id="status_ticket" value="'.$data["status"].'" /></td>
				</tr>
				<tr>
					<td>Assigned On:</td>
					<td>'.$data["assigned_on"].'</td>
				</tr>
				';
				if($data["status"] =='Closed'){ 
				$html .= '<tr>
					<td>Closed Time:</td>
					<td>'.$data["closed_time"].'</td>
				</tr>
				<tr>
					<td>Action Taken:</td>
					<td>'.$data["tech_comments"].'</td>
				</tr>
				';
				}
				elseif($data["status"] =='Cancelled'){ 
				$html .= '
				<tr>
					<td>Cancel Reason:</td>
					<td>'.$data["cancel_reason"].'</td>
				</tr>
				';
				}
			$html .='</table>
		</td>	
	</tr>
</table>';

if($data["status"] =='Closed' || $data["status"] =='Cancelled'){ 
$get_additional_notes = getAdditionalNotes($id); //Passign Service Ticket Id

$html .= "<hr/><h2>Additional Notes</h2>";
if(count($get_additional_notes) > 0){
//print_r($get_additional_notes); die;
$html .='<table   cellpadding="2" style="width:100%;">';
foreach($get_additional_notes as $get_note){
	$html .='<tr>
	<td style="border-bottom:1pt solid black;"><div><h4 style="display:inline-block; margin-right:15px;">'.$get_note['author_name'].' ['.$get_note['author_type'].']</h4><span>'.$get_note['created_at'].'</span><div>'.$get_note['description'].'</div></div></td></tr>';
}
$html .='</table>';

} 
else{
	$html .="No Addtional Notes Found.";
}
}
}
echo $html;
?>