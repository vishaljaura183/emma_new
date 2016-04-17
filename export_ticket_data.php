<?php
include ('inc/common_func.php');
//include ('inc/config.php');
//include('header.php');
//$sql="SELECT * FROM service_tickets";
/*$sql = "SELECT service_tickets.*, poll_venues.ward, poll_venues.address_line_1, poll_venues.address_line_2, poll_venues.ST, poll_venues.ZIP 
FROM service_tickets
LEFT JOIN poll_venues
ON service_tickets.polling_site_id=poll_venues.id
ORDER BY service_tickets.id"; 
*/
if(isset($_POST['from_date'])){
	$from_date = $_POST['from_date'];
	$to_date = $_POST['to_date'];
	$whr_condition = "WHERE DATE(ST.created_at) BETWEEN DATE('".$from_date."') AND DATE('".$to_date."')";
}
else{
	$whr_condition = "";
	
}

 //$sql = "SELECT DISTINCT ST.id, ST.reason_call,ST.caller,ST.contact_num,ST.supply_needed,ST.priority_ticket,ST.machine_num,ST.notes,ST.status as status_ticket,ST.enroute_datetime, ST.on_scene_datetime,ST.cancel_reason,ST.redirect_reason,ST.created_at as ticket_created_at, PV.ward, PV.address_line_1,PV.voting_district, PV.ST, PV.ZIP ,TH.first_name, TH.last_name
 $sql = "SELECT DISTINCT ST.id, ST.*, PV.ward, PV.address_line_1,PV.voting_district, PV.ST, PV.ZIP ,TH.first_name, TH.last_name, TD.created_at as closed_time, TD.comments as tech_comments, TD.image_name, TD.signature_image
FROM service_tickets  ST

LEFT JOIN poll_venues PV
ON ST.polling_site_id=PV.id

LEFT JOIN ticket_data TD ON
			ST.id=TD.service_ticket_id

			
LEFT JOIN technician TH
ON ST.technician_id=TH.id

WHERE ST.status =1
ORDER BY ST.id ASC";

$result=mysqli_query($db,$sql);

// die;
$result=mysqli_query($db,$sql);

date_default_timezone_set("America/New_York");


$i=0;
$image_name_path = LIVE_SITE.'/uploads/poll_site_data/images/';
$image_sign_path = LIVE_SITE.'/uploads/poll_site_data/sign_images/';
while($row = mysqli_fetch_assoc($result)) {
	$object = $row;
	$id = $object['id'];
	$sr_ticket_no = sprintf('%06d', $object['id']);
	if($object['status'] == '0'){
		$status = "Open";
		}
		elseif($object['status'] == '2'){
		$status = "Cancelled";
		
		}
		else{
		$status = "Closed";
		
		}
		
	if($object['response_acceptance'] == '1'){
	$accept_reject = "Yes";
	}
	elseif($object['response_acceptance'] == '0'){
	$accept_reject = "Rejected";
	}
	else{
	$accept_reject = "No";
	}
	
	$address_poll_site = $object['address_line_1'].', '.$object['ST'].', '.$object['ZIP'];
	if($object['dispatcher_solve']=='1'){
		$solve_by = "Dispatcher Solve";
	}
	else{
		$solve_by = $object['first_name'].' '.$object['last_name'];
	}
	$enroute_time = $object['enroute_datetime']?date('Y-m-d H:i:s',$object['enroute_datetime']): 'NA';
	$on_scene_datetime = $object['on_scene_datetime']?date('Y-m-d H:i:s',$object['on_scene_datetime']): 'NA';
	
	$data[$i]['id']=$sr_ticket_no;
	$data[$i]['technician']=$solve_by;
	$data[$i]['dispatcher']=$solve_by;

	$data[$i]['status']=$status;
	
	$data[$i]['closed_time']=$object['closed_time'];
	$data[$i]['tech_comments']=$object['tech_comments'];
	$data[$i]['image_name']=$object['image_name']?$image_name_path.$object['image_name']:'';
	$data[$i]['signature_image']=$object['signature_image']?$image_sign_path.$object['signature_image']:'';
	
	$i++;
}

	//print_r($data); die;
$filename = "tickets_data.csv";
$output = fopen('php://output', 'w');

	
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);
fputcsv($output, array('Ticket Number', 'Technician','Dispatcher','Ticket Status','Action Taken', 'Image Taken', 'Signature Image' ));

		
if(mysqli_num_rows($result)>0){

foreach($data as $data_rows) {
	fputcsv($output, $data_rows);
}
}

else{
//mysqli_num_rows($result); die('--');
echo $data_rows = 'No Data Found.';

}
//echo $output
//echo 'test';
//header("Location: reports.php");
exit;
?>