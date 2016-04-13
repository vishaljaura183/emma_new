<?php
session_start();
if($_POST)
{
	if($_POST['action'] == "delete_poll_venues")
	{
		Ajax_call_functions::del_poll_venues( array($_POST['id']) );
	}
}
if( $_GET )
{
	if($_GET['action'] == "get_poll_venues_n_techs")
	{
		Ajax_call_functions::getPollVenuesNTechs();
	}
	if( $_GET['action'] == "check_tech_username_uniqueness" )
	{
		Ajax_call_functions::checkTechnicianExistanceByUsername( $_GET['username'] );
	}
	if( $_GET['action'] == "check_tech_email_uniquenes" )
	{
		Ajax_call_functions::checkTechnicianExistanceByEmailId( $_GET['email'] );
	}
}



class Ajax_call_functions
{
	public static function del_poll_venues( $ids_arr ){
		include_once("inc/config.php");
		$ids = implode(',', $ids_arr);
		$sql = "DELETE from poll_venues WHERE id IN (".$ids.")";
		$results = $db->query($sql);	
		echo json_encode(1);
	}
	
	/**
	 * Checks the existance of technician on the basis of
	 * username passed as a parameter.
	 * @param string $username
	 * @author Jaskaran
	 * @version 1.0
	 */
	public static function checkTechnicianExistanceByUsername($username)
	{
		include_once("inc/config.php");
		$sql 		= "SELECT * from technician WHERE username ='".$username."' AND is_deleted = 0";
		$result 	= mysqli_query($db, $sql);
    	
    	if($result->num_rows)
    		echo json_encode(FALSE);
    	else
    		echo json_encode(TRUE);
	}
	
	/**
	 * Checks the existance of technician on the basis of
	 * email id passed as a parameter.
	 * @param string $username
	 * @author Jaskaran
	 * @version 1.0
	 */
	public static function checkTechnicianExistanceByEmailId($email)
	{
		include_once("inc/config.php");
		$sql 		= "SELECT * from technician WHERE email = '".$email."' AND is_deleted = 0";
		$result 	= mysqli_query($db, $sql);
    	
    	if($result->num_rows)
    		echo json_encode(FALSE);
    	else
    		echo json_encode(TRUE);
	}
	
	public static function getPollVenuesNTechs(){
		include ('inc/common_func.php');
		
		$get_poll_venues 	= get_values_poll_venues($db);
		$get_technicians 	= get_values_technicians($db);
		
		//Poll venues
		$lats_arr 			= array();
		$longs_arr 			= array();
		
		//Technicians
		$lat_longs_arr 			= array();
		$lat_longs_arr2 		= array();
		
		foreach ($get_poll_venues as $key => $poll_venue) {
			$lat_longs_arr[$key]['lat'] 					= $poll_venue['latitude'];
			$lat_longs_arr[$key]['long'] 					= $poll_venue['longitude'];
			$lat_longs_arr[$key]['address'] 				= $poll_venue['address'];
			$lat_longs_arr[$key]['location_nm'] 			= $poll_venue['location_poll'];
			$lat_longs_arr[$key]['voting_district'] 		= $poll_venue['voting_district'];
		}
		foreach ($get_technicians as $key => $techs) {
			$lat_longs_arr2[$key]['lat'] 				= $techs['lat'];
			$lat_longs_arr2[$key]['long'] 				= $techs['long'];
			$lat_longs_arr2[$key]['role'] 				= $techs['role'];
			if( !$techs['is_available'] )
			{
				$lat_longs_arr2[$key]['is_available'] 		= 0;
			}
			else
			{
				$lat_longs_arr2[$key]['is_available'] 		= intval( $techs['is_available'] );
			} 
			$lat_longs_arr2[$key]['tech_detail'] 		= $techs['first_name'].' '.$techs['last_name'].' [ OPEN TICKETS: '.$techs['num_open_tkt'].' ]';
			$lat_longs_arr2[$key]['rover_detail'] 		= $techs['first_name'].' '.$techs['last_name'];
		}
		
		//Merging arrays.
		$final_arr = array();
		$final_arr['poll_venues'] 	= $lat_longs_arr;
		$final_arr['techs'] 		= $lat_longs_arr2;
		echo json_encode($final_arr);
		
	}
}