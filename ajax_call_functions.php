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
	if( $_GET['action'] == "check_disp_username_uniqueness" )
	{
		Ajax_call_functions::checkDispatcherExistanceByUsername( $_GET['username'] );
	}
	if( $_GET['action'] == "check_disp_email_uniquenes" )
	{
		Ajax_call_functions::checkDispatcherExistanceByEmailId( $_GET['email'] );
	}
	if($_GET['action'] == "get_service_ticket")
	{
		Ajax_call_functions::get_all_service_tickets( $_GET['sr_type'] );
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
	 * Checks the existance of dispatcher on the basis of
	 * username passed as a parameter.
	 * @param string $username
	 * @author Jaskaran
	 * @version 1.0
	 */
	public static function checkDispatcherExistanceByUsername($username)
	{
		include_once("inc/config.php");
		$sql 		= "SELECT * from admin WHERE username ='".$username."'";
		$result 	= mysqli_query($db, $sql);
    	
    	if($result->num_rows)
    		echo json_encode(FALSE);
    	else
    		echo json_encode(TRUE);
	}
	
	/**
	 * Checks the existance of technician on the basis of
	 * email id passed as a parameter.
	 * @param string $email
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

	/**
	 * Checks the existance of dispatcher on the basis of
	 * email id passed as a parameter.
	 * @param string $email
	 * @author Jaskaran
	 * @version 1.0
	 */
	public static function checkDispatcherExistanceByEmailId($email)
	{
		include_once("inc/config.php");
		$sql 		= "SELECT * from admin WHERE email ='".$email."'";
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
	
	public static function get_all_service_tickets($st_type)
	{
		include ('inc/common_func.php');
		
		$techicians_data = get_values_technicians($db); 
		
		if($st_type){
			$whr_condition = "WHERE ST.status=".$st_type;
		} else {
			$whr_condition = "";
		}
		
		$sql = "SELECT DISTINCT ST.id, ST.*, 
		AD.name as dispatcher,
		AD.name as dispatcher, 
		PV.ward, 
		PV.address_line_1,
		PV.voting_district, 
		PV.ST, 
		PV.ZIP, 
		TH.first_name, 
		TH.last_name, 
		TH.email, 
		TH.role
		FROM service_tickets  ST
	
		LEFT JOIN poll_venues PV
		ON ST.polling_site_id=PV.id
	
		LEFT JOIN admin AD
		ON ST.dispatcher_id=AD.id
	
		LEFT JOIN technician TH
		ON ST.technician_id=TH.id
	
		".$whr_condition."
		ORDER BY ST.id ASC";
	
		$result = mysqli_query($db, $sql);
		$ret_array = array();
		$i = 0;	
		while ($results_users=mysqli_fetch_array($result, MYSQLI_ASSOC)) {
			
	   		$object = $results_users;
			$id = $object['id'];
			$sr_ticket_no = sprintf('%06d', $object['id']);
			$address_poll_site = $object['address_line_1'].', '.$object['ST'].', '.$object['ZIP'];
			if ($object['status'] == '0') {
				$status = '<span style="color: green;">Open</span>';
			} elseif ($object['status'] == '2') {
				$status = '<span style="color: grey;">Cancelled</span>';
			} else {
				$status = '<span style="color: red;">Closed</span>';
			}
			
			if ($object['response_acceptance'] == '1') {
				$accept_reject = '<span style=\"color: green;\">Yes</span>';
			} elseif ($object['response_acceptance'] == '0') {
				$accept_reject = '<span style=\"color: red;\">Rejected</span>';
			} else {
				$accept_reject = "No";
			}
			
			if ($object['dispatcher_solve']=='1'){
				$solve_by = "Dispatcher Solve";
		
			} else {
				$role=$object['role']=='rover'?' (R) ':'';
				$solve_by = $object['first_name'].' '.$object['last_name'].$role;
			}
			
			/*id*/$ret_array[$i][0] 				= '<a href="javascript:void(0);" onclick="view_detail_ticket("'.$id.'");">'.$sr_ticket_no.'</a>';
			/*solve_by*/$ret_array[$i][1] 			= $solve_by;
			/*dispatcher*/$ret_array[$i][2] 		= $object['dispatcher'];
			/*reason_call*/$ret_array[$i][3] 		= $object['reason_call'];
			/*voting_district*/$ret_array[$i][4] 	= $object['voting_district'];
			/*enroute_datetime*/$ret_array[$i][5] 	= $object['enroute_datetime']?date('Y-m-d H:i:s',$object['enroute_datetime']): 'NA';
			/*on_scene_datetime*/$ret_array[$i][6] 	= $object['on_scene_datetime']?date('Y-m-d H:i:s',$object['on_scene_datetime']): 'NA';
			/*priority_ticket*/$ret_array[$i][7] 	= $object['priority_ticket'];
			/*status*/$ret_array[$i][8] 			= $status;
			/*accept_reject*/$ret_array[$i][9] 		= $accept_reject;
			/*'created_at'*/$ret_array[$i][10] 		= $object['created_at'];
			/*actions*/$ret_array[$i][11] 			= '<a target=" " title="View PDF" href="'.LIVE_SITE.'"/pdf/docs/service_tkt_pdf.php?id="'.$id.'">
														<img src="'.LIVE_SITE.'/img/pdf.png"  />
													</a>
													<a  title="View Ticket Detail" href="javascript:void(0);" 
													onclick="view_detail_ticket("'.$id.'");">
														<img src="'.LIVE_SITE.'/img/look.jpg" width="40" height="30"  />
													</a>';
			
			$data['data'] = $ret_array;
			$i++;
		}
		echo json_encode($data);
	}
}