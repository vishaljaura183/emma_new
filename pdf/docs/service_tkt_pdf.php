<?php
require_once('../config/lang/eng.php');
require_once('../tcpdf.php');
require_once('../../inc/common_func.php');

if(isset($_GET['id']) && !empty($_GET['id'])){
$id = $_GET['id'];
$data = getServiceTicketData($id);
$data = $data[0];
//print_r($data); die;
}
else{
echo "Invalid Id!! Please contact Admin.";

}
// create new PDF document
$pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

// set document information
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Nicola Asuni');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
$ticket_id = $data['id'];
$header_title = "Service Ticket: ".$ticket_id;
$pdf->SetTitle($header_title);
$header_string = "Assigned On: ".$data['assigned_on'];
// set default header data
$pdf->SetHeaderData(PDF_HEADER_LOGO, '40',$header_title, $header_string);

// set header and footer fonts
$pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
$pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

// set default monospaced font
 $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

//set margins
$pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
$pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
$pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

//set auto page breaks
$pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

//set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

//set some language-dependent strings
$pdf->setLanguageArray($l);

// ---------------------------------------------------------

// set font
//$pdf->SetFont('times', '', 10);
$pdf->SetFont('dejavusans', '', 12, '', true);

// - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
// Print a table

// add a page
$pdf->AddPage();



// create some HTML content
// create some HTML content
// create some HTML content
if($data['dispatcher_solve']=='1'){
	$solve_by ='<tr>
					<td rowspan="3" valign="top">Dispatcher Solve</td>
					
				
				
				</tr>';
}
else{
	$role = $data['role']=='rover'?'Rover':'Technician';
$solve_by ='<tr>
					<td>First Name:</td>
					<td>'.$data["first_name"].'<input type="hidden" id="technician_id" name="technician_id" value="'.$data["technician_id"].'" /></td>
				</tr>
				<tr>
					<td>Last Name:</td>
					<td>'.$data["last_name"].'</td>
				</tr>
				<tr>
					<td>Personnel Role:</td>
					<td>'.$role.'</td>
				</tr>
				<tr>
					<td>Username</td>
					<td>'.$data["username"].'</td>
				</tr>';
}

$html = '
<table border="0" cellpadding="2" style="width:100%;">
	<tr>
		<th>
			<table cellpadding="4">
				<tr>
					<td colspan = "2" bgcolor="silver">Technician Information</td>
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
					<td>'.$data["status"].'</td>
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
			$html .='</table>
		</td>	
	</tr>
</table>';


if($data["status"] =='Closed'){ 
$get_additional_notes = getAdditionalNotes($id); //Passign Service Ticket Id

$html .= "<hr/><h2>Additional Notes</h2>";
if(count($get_additional_notes) > 0){
//print_r($get_additional_notes); die;
$html .='<table  cellpadding="2" style="width:100%;">';
foreach($get_additional_notes as $get_note){
	$html .='<tr>
	<td style="border-bottom:1pt solid black;"><div><span><b>'.$get_note['author_name']."</b> &nbsp; &nbsp;&nbsp;&nbsp;".$get_note['created_at'].'</span>&nbsp; &nbsp;&nbsp;&nbsp;<div style="float:right; font-size:28px;"><b>'.$get_note['author_type'].'</b></div><br/><div>'.$get_note['description'].'</div></div></td></tr>';
}
$html .='</table>';

} 
else{
	$html .="No Addtional Notes Found.";
}
}


// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();


//Close and output PDF document
$pdf->Output('learner_report.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+
