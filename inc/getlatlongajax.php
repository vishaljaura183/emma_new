<?php
include ('common_func.php');

$get_poll_venues = get_values_poll_venues($db); 

echo json_encode($get_poll_venues); die;
//echo "<pre>";
// print_r($get_poll_venues); die;
//include ('header.php');
$poll_sites_lat_long = '';
$i=0;
$num_poll_sites = count($get_poll_venues);
foreach( $get_poll_venues as $poll_site){
	$name=$poll_site['location_nm'];
	$latitude=$poll_site['latitude'];
	$longitude=$poll_site['longitude'];
	$index=$i;
	
	$poll_sites_lat_long .= "['".$name."',".$latitude.", ".$longitude.", ".$index."]";
	$i++;
		if($i === $num_poll_sites) {
		echo "";
		}
		else{
		$poll_sites_lat_long .=",";
		}
}
$poll_sites_lat_long = "[".$poll_sites_lat_long."]";
echo $poll_sites_lat_long; die;