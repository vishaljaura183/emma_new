<?php
include('config.php');
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
	$return_array[$i]['latitude']= $object['latitude'];
	$return_array[$i]['longitude']= $object['longitude'];
	$return_array[$i]['ST']= $object['ST'];
	$return_array[$i]['ZIP']= $object['ZIP'];
	$return_array[$i]['address']= $object['address_line_1'].', '.$object['address_line_2'].', '.$object['ST'].', '.$object['ZIP'];
	$return_array[$i]['name_of_location']= $object['name_of_location'].', '.$object['ST'];
	$return_array[$i]['ward'] = $object['ward'];
	$i++;
	}
//print_r($return_array);
	return $return_array;
}

function do_regsiter_technician($db){


$sql=	"INSERT INTO technician SET 
		first_name='$first_name', 
		last_name='$last_name', 
		username='$username', 
		email='$email',
		phone='$phone',
		password='$password'"; 
$result=mysqli_query($db,$sql);
if($result){

}
}
?>