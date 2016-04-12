<?php
require_once('../inc/common_func.php');
// print_r($_REQUEST);
if(isset($_REQUEST['poll_site_id']) && !empty($_REQUEST['poll_site_id'])){
 $poll_site_id = $_REQUEST['poll_site_id'][0];
//die;
// GET THIS POLL SITE DETAIL
$get_poll_site_detail = get_poll_site_detail($poll_site_id);
$voting_district = $get_poll_site_detail['voting_district']; 
$latitude_poll_site = $get_poll_site_detail['latitude']; 
$longitude_poll_site = $get_poll_site_detail['longitude']; 

// GET ALL TECHNICIANS DETAIL
$get_all_technicians =  get_all_technicians_detail(); 

 $arr = array();
foreach($get_all_technicians as $tech_data)
{
	
 $num_open_tkt = $tech_data['num_open_tkt'];
 $username = $tech_data['username'].";".$tech_data['id'].";".$num_open_tkt;
 $latitude_tech = $tech_data['latitude'];
 $longitude_tech = $tech_data['longitude'];
 //echo "distance from ".$latitude_poll_site. "-".$longitude_poll_site . " to ". $latitude_tech."--".$longitude_tech. " = 2.36 Miles.";
 if($latitude_tech != '' && $longitude_tech !=''){
 $distance = floatval(round(distance($latitude_poll_site, $longitude_poll_site, $latitude_tech, $longitude_tech, "M"),2)) . "<br>";
 
 }
 else{
 $distance = "NA";
 }
 $distance = floatval($distance);
 
 $arr[$username] = $distance;
 //die;
}
asort($arr);
$html="<h3>Please Select Technician</h3>
<table border='1' align='center'  cellpadding='10' class='datatable'>
<tr>
<th>Name</th>
<th>Distance (in Miles)</th>
<th>Open Tickets</th>

</tr>
";
foreach($arr as $key=>$val){
$exp_val = explode(";",$key);
$user_nm = $exp_val[0];
$technician_id = $exp_val[1];
$open_tickets = $exp_val[2];
$html .= "<tr>
<td cellspacing='5'  align='center'><a href='javascript:void(0);' onclick='select_tech(".$technician_id.");'>".$user_nm."</a></td>
<td colspan='1'  align='center'>".$val."</td>
<td colspan='1'  align='center'>".$open_tickets."</td>

</tr>";

}
$html .= "</table>";

echo $html;
die;
}
function distance($lat1, $lon1, $lat2, $lon2, $unit) {

  $theta = $lon1 - $lon2;
  $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2)) +  cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
  $dist = acos($dist);
  $dist = rad2deg($dist);
  $miles = $dist * 60 * 1.1515;
  $unit = strtoupper($unit);

  if ($unit == "K") {
    return ($miles * 1.609344);
  } else if ($unit == "N") {
      return ($miles * 0.8684);
    } else {
        return $miles;
      }
}

//echo $html;
?>