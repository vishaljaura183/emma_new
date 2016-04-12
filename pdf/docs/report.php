<?php
//============================================================+
// File name   : example_006.php
// Begin       : 2008-03-04
// Last Update : 2010-11-20
//
// Description : Example 006 for TCPDF class
//               WriteHTML and RTL support
//
// Author: Nicola Asuni
//
// (c) Copyright:
//               Nicola Asuni
//               Tecnick.com LTD
//               Manor Coach House, Church Hill
//               Aldershot, Hants, GU12 4RQ
//               UK
//               www.tecnick.com
//               info@tecnick.com
//============================================================+

/**
 * Creates an example PDF TEST document using TCPDF
 * @package com.tecnick.tcpdf
 * @abstract TCPDF - Example: WriteHTML and RTL support
 * @author Nicola Asuni
 * @since 2008-03-04
 */


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
$pdf->SetTitle('TEstinggng');
$pdf->SetSubject('TCPDF Tutorial');
$pdf->SetKeywords('TCPDF, PDF, example, test, guide');
$ticket_id = $data['id'];
$header_title = "Service Ticket: ".$ticket_id;
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
$html = '
<table border="0" cellpadding="2">
	<tr>
		<th>
			<table cellpadding="4">
				<tr>
					<td colspan = "2" bgcolor="silver">Technician Information</td>
				</tr>
				<tr>
					<td>First Name:</td>
					<td>'.$data["first_name"].'</td>
				</tr>
				<tr>
					<td>Last Name:</td>
					<td>'.$data["last_name"].'</td>
				</tr>
				<tr>
					<td>Email:</td>
					<td>'.$data["email"].'</td>
				</tr>
				
			</table>
		</th>
		<th>
			<table cellpadding="4">
				<tr>
					<td colspan = "2"  bgcolor="silver">Polling Site Information</td>
				</tr>
				<tr>
					<td>Polling Site Name:</td>
					<td>'.$data["poll_site_name"].'</td>
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
					<td>Reason Of Call:</td>
					<td>'.$data["reason_call"].'</td>
				</tr>
				<tr>
					<td>Supplies Needed:</td>
					<td>'.$data["supply_needed"].'</td>
				</tr>
				<tr>
					<td>Status:</td>
					<td>'.$data["status"].'</td>
				</tr>
				<tr>
					<td>Assigned On:</td>
					<td>'.$data["assigned_on"].'</td>
				</tr>
				
			</table>
		</td>	
	</tr>
</table>';

// output the HTML content
$pdf->writeHTML($html, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();


//Close and output PDF document
$pdf->Output('learner_report.pdf', 'I');

//============================================================+
// END OF FILE                                                
//============================================================+
