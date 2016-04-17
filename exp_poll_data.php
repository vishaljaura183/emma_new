<?php
include ('inc/common_func.php');


if(isset($_POST['from_date']) && $_POST['from_date']!=''){
	$from_date = $_POST['from_date'];
	$to_date = $_POST['to_date'];
	$whr_condition = " WHERE DATE(PD.created_at) BETWEEN DATE('".$from_date."') AND DATE('".$to_date."')";
}
else{
	$whr_condition = "";
	
}

	$sql = "SELECT PD.*, PV.id as poll_venue_id, PV.voting_district, TH.first_name, TH.last_name, TH.email
	FROM poll_site_data  PD

	LEFT JOIN poll_venues PV
	ON PD.poll_venues_id=PV.id

	LEFT JOIN technician TH
	ON PD.technician_id=TH.id 
	".$whr_condition."
	ORDER BY PD.created_at"; //die;

$result=mysqli_query($db,$sql);
date_default_timezone_set("America/New_York");


$i=0;
while($row = mysqli_fetch_assoc($result)) {
	$object = $row;
	$voting_district = $object['voting_district'];
	$first_name = $object['first_name'];
	$last_name = $object['last_name'];
	$tech_name =  $first_name.' '.$last_name;
	$clerk_name = $object['clerk_name'];
	
	$inspector_dropoff_loc = $object['drop_off_location'];
	
	$cellphone = $object['cellphone'];
	$homephone = $object['homephone'];
	$notes = $object['notes'];
	
	$submitted_on = $object['created_at'];
	
	
	$data[$i]['voting_district']=$object['voting_district'];
	$data[$i]['technician']=$tech_name;
	$data[$i]['clerk_name']=$clerk_name;
	$data[$i]['inspector_dropoff_loc']=$inspector_dropoff_loc;
	$data[$i]['cellphone']=$cellphone;
	$data[$i]['homephone']=$homephone;
	$data[$i]['notes']=$notes;
	$data[$i]['submitted_on']=$submitted_on;
	
	$i++;
}

	//print_r($data); die;
$filename = "Poll_Dite_Data.csv";
$output = fopen('php://output', 'w');

	
header('Content-type: application/csv');
header('Content-Disposition: attachment; filename='.$filename);
fputcsv($output, array('Voting District', 'Technician','Clerk','Inspector Dropoff Loc.','Cellphone','Homephone', 'Notes','Submitted Time'));


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
exit;
?>