<?php
/**
 * PHPExcel
 *
 * Copyright (C) 2006 - 2014 PHPExcel
 *
 * This library is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 2.1 of the License, or (at your option) any later version.
 *
 * This library is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public
 * License along with this library; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301  USA
 *
 * @category   PHPExcel
 * @package    PHPExcel
 * @copyright  Copyright (c) 2006 - 2014 PHPExcel (http://www.codeplex.com/PHPExcel)
 * @license    http://www.gnu.org/licenses/old-licenses/lgpl-2.1.txt	LGPL
 * @version    1.8.0, 2014-03-02
 */

/** Error reporting */
error_reporting(E_ALL);
ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');


// Query to fetch data to list in excel file.
include_once("inc/config.php");
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

$result_arr = array();
$i = 0;
while($results_users=mysqli_fetch_array($result,MYSQLI_ASSOC)){

   $result_arr[$i]['id'] = $results_users['id'];
   $result_arr[$i]['service_ticket_number'] 		= sprintf('%06d', $results_users['id']);
   $result_arr[$i]['technician_name'] 			= $results_users['first_name'].' '.$results_users['last_name'];
   $address_poll_site 							= $results_users['address_line_1'].', '.$results_users['ST'].', '.$results_users['ZIP'];
   $result_arr[$i]['poll_site_address'] 			= $address_poll_site;
   $result_arr[$i]['voting_district'] 			= $results_users['voting_district'];
   $result_arr[$i]['priority'] 					= $results_users['priority_ticket'];
   $result_arr[$i]['reason_of_call'] 			= $results_users['reason_call'];
	
	if ($results_users ['status'] == '0') {
		$status = "Open";
	} elseif ($results_users ['status'] == '2') {
		$status = "Cancelled";
	} else {
		$status = "Closed";
	}
   
   $result_arr[$i]['status']		 				= $status;
   
	if($results_users['response_acceptance'] == '1'){
	$accept_reject = "Accepted";
	}
	elseif($results_users['response_acceptance'] == '0'){
	$accept_reject = "Rejected";
	}
	else{
	$accept_reject = "Not Responded";
	}
   
   $result_arr[$i]['accept_or_reject']		 	= $accept_reject;
   $result_arr[$i]['created_at'] 				= $results_users['created_at'];
   
   $i++;
}





if (PHP_SAPI == 'cli')
	die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . '/Classes/PHPExcel.php';


// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Jaskaran Singh")
							 ->setLastModifiedBy("Jaskaran Singh")
							 ->setTitle("Office 2007 XLSX Test Document")
							 ->setSubject("Office 2007 XLSX Test Document")
							 ->setDescription("This documented for reports of election project.")
							 ->setKeywords("office 2007 openxml php")
							 ->setCategory("Reports");

//Setting header of the excel file.
$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A1', 'Ticket Number')							 
            ->setCellValue('B1', 'Technician')							 
            ->setCellValue('C1', 'Polling Site')							 
            ->setCellValue('D1', 'Voting District')							 
            ->setCellValue('E1', 'Priority [1-Lowest, 5-Highest]')							 
            ->setCellValue('F1', 'Reason Of Call')							 
            ->setCellValue('G1', 'Status')							 
            ->setCellValue('H1', 'Accept/Reject')	 
            ->setCellValue('I1', 'Date Created');

            
							 
// Add some data
$j = 2;
foreach ($result_arr as $key=>$value) {
		
		$objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue('A'.$j, $value['service_ticket_number'])							 
            ->setCellValue('B'.$j, $value['technician_name'])							 
            ->setCellValue('C'.$j, $value['poll_site_address'])							 
            ->setCellValue('D'.$j, $value['voting_district'])							 
            ->setCellValue('E'.$j, $value['priority'])							 
            ->setCellValue('F'.$j, $value['reason_of_call'])							 
            ->setCellValue('G'.$j, $value['status'])							 
            ->setCellValue('H'.$j, $value['accept_or_reject'])							 
            ->setCellValue('I'.$j, $value['created_at']);
			$j++;
}


// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Service Ticket Report');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="service_tikect_report.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;
