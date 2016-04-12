<?php
include('../inc/common_func.php');
$WS_obj = new Election_web_services();

class Election_web_services
{
	protected $params;
	protected $json_response = array();
	protected $ws_response = array();
	public function __construct()
	{
		
		
		$handle = fopen ( 'php://input', 'r' );
		$jsonInput = fgets ( $handle );
		$this->params = json_decode( $jsonInput );
		//	print_r($this->params); die;
		$this->process();
	}
	
	private function process()
	{
		
		if( $this->params->method == "get_all_poll_venues" )
		{
			$result = $this->get_all_poll_venues();
		}
		else if( $this->params->method == "regsiter_technician" )
		{
			$result = $this->regsiter_technician();
		}
		else if( $this->params->method == "update_technician_profile" )
		{
			$result = $this->update_technician_profile();
		}
		
		else if( $this->params->method == "ticket_acceptance_response" )
		{
			$result = $this->ticket_acceptance_response();
		}
		
		else if( $this->params->method == "update_payment_method" )
		{
			$result = $this->update_payment_method();
		}
		else if( $this->params->method == "get_service_tickets_by_technician" )
		{
			$result = $this->get_service_tickets_by_technician();
		}
		
		else if( $this->params->method == "submit_poll_site_data" )
		{
			$result = $this->submit_poll_site_data();
		}
		
		else if( $this->params->method == "login_technician" )
		{
			$result = $this->login_technician();
		}
        
        else if( $this->params->method == "set_app_regid" )
        {
            $result = $this->set_app_regid();
        }
        
		echo json_encode($this->ws_response);
	}
	
	private function success_failure_msgs( $code, $message, $result = array())
	{
		$currentDateTime = new \DateTime();
		if($code == 200)
		{
			$this->ws_response = array("Response"=>array("Code"=>$code,"Status"=>"OK","Message"=>$message,"result"=>$result, "CurrentDateTime"=>$currentDateTime));
		}
		else
		{
			$this->ws_response = array("Response"=>array("Code"=>$code,"Status"=>"Error","Message"=>$message));
		}
		return $this->ws_response;
	}
	
	private function get_service_tickets_by_technician()
	{
		global $db;
		if( @$this->params->technician_id )
		{
			$result = getServiceTicketsByTechnician( $db, $this->params->technician_id );
			if( $result )
			{
				$ret_array['success'] = '1';
				$ret_array['data'] = $result;
				array_push($this->json_response, $ret_array);
				$this->success_failure_msgs(200, 'Results found.', $this->json_response);
				
			}
			else
			{
				$this->success_failure_msgs(301, 'No results found.', $this->json_response);
			}
		}
		else
		{
			$this->success_failure_msgs(301, 'Required parameter technician_id missing!', $this->json_response);
		} 
	}
	// --------------- UPDATE RESPONSE OF TECHNICIAN WHEN HE RECEIVES SERVICE TICKET ---------------
	
	private function ticket_acceptance_response()
	{
		global $db;
		if( @$this->params->service_ticket_id  )
		{
		$response_acceptance = @$this->params->response_acceptance;
		$service_ticket_id = @$this->params->service_ticket_id;
		if($response_acceptance == '1'){
		$response = "Accepted";
		}
		else{
		$response = "Rejected";
		}
		
		$sql = "UPDATE  service_tickets SET response_acceptance = '$response_acceptance' WHERE id= $service_ticket_id";
		$result=mysqli_query($db,$sql);
		if( $result )
			{
				$ret_array['success'] = '1';
				$ret_array['message'] = 'Response updated successfully to '.$response;
				array_push($this->json_response, $ret_array);
				$this->success_failure_msgs(200, 'Service ticket response updated', $this->json_response);
				
			}
			else
			{
				$this->success_failure_msgs(301, 'No results found.', $this->json_response);
			}
		}
		else
		{
			$this->success_failure_msgs(301, 'Required parameter service_ticket_id or  response_acceptance is missing!', $this->json_response);
		} 
	}
	
	// -------------- UPDATE PROFILE OF TECHNICIAN ---------------------------------
	
	private function update_technician_profile(){
	global $db;
	//$submerchant_id ="janesladders2_instant_3rdnbz3y";
	if( $this->params->technician_id && $this->params->username)
		{
		$technician_id = 	$this->params->technician_id;
		$first_name = 	$this->params->first_name;
		$last_name = @$this->params->last_name;
		$username = @$this->params->username;
		$email = @$this->params->email;
		$address = @$this->params->address;
		$city = @$this->params->city;
		$state = @$this->params->state;
		$zip = @$this->params->zip;
		$phone = @$this->params->cellphone;
		$officephone = @$this->params->officephone;
		
		$sql=	"UPDATE technician SET 
		first_name='$first_name', 
		last_name='$last_name', 
		username='$username', 
		address='$address',
		city='$city',
		state='$state',
		zip='$zip',
		phone='$phone',
		officephone='$officephone',
		email='$email'
		WHERE id = '$technician_id'"; 
		// echo $sql;
		$result=mysqli_query($db,$sql);
			
			if($result)
			{
				$ret_array['success']='1';
				$ret_array['message']='Technician Profile Updated Successfully';
				$ret_array['user_id']=$db->insert_id;
				array_push($this->json_response,$ret_array);
				$msg = 'Technician Profile Updated Successfully';
				$this->success_failure_msgs(200, "Technician Profile Update Success.", $this->json_response);
			}
			else
			{
				$msg = "Failed To Update Technician!";
				//echo("Validation errors:<br/>");
				
				$this->success_failure_msgs(301, $msg, $this->json_response);
			}
		}
			
		else
		{
		$msg = "Required Parameters Are Missing.";
		$this->json_response = "";
		$this->success_failure_msgs(301, $msg, $this->json_response);
		}
			
	}

	
	// ------------- GET all POLL SITES DATA -------------------
	private function get_all_poll_venues()
	{
		global $db;
		$result = get_values_poll_venues($db);
		if( $result )
		{
			$ret_array['success'] = '1';
			$ret_array['data'] = $result;
			array_push($this->json_response, $ret_array);
			$this->success_failure_msgs(200, 'Poll venues fetched successfully', $this->json_response);
			
		}
		else
		{
			$this->success_failure_msgs(301, 'No poll venues found', $this->json_response);
		}
	}
	
	/* METHOD: regsiter_technician */
	private function regsiter_technician(){
	global $db;
	//$submerchant_id ="janesladders2_instant_3rdnbz3y";
	if( $this->params->first_name && $this->params->password && $this->params->email && $this->params->username)
		{
		$first_name = 	$this->params->first_name;
		$last_name =$this->params->last_name;
		$username = $this->params->username;
		$password = $this->params->password;
		$email = $this->params->email;
		$address = $this->params->address;
		$city = $this->params->city;
		$state = $this->params->state;
		$zip = $this->params->zip;
		$phone = $this->params->cellphone;
		$officephone = $this->params->officephone;
		
		$sql=	"INSERT INTO technician SET 
		first_name='$first_name', 
		last_name='$last_name', 
		username='$username', 
		address='$address',
		city='$city',
		state='$state',
		zip='$zip',
		phone='$phone',
		officephone='$officephone',
		email='$email',
		password='$password'"; 
		
		$result=mysqli_query($db,$sql);
			
			if($result)
			{
				$ret_array['success']='1';
				$ret_array['message']='Technician Registered Successfully';
				$ret_array['user_id']=$db->insert_id;
				array_push($this->json_response,$ret_array);
				$this->success_failure_msgs(200, "Technician Registered Success.", $this->json_response);
			}
			else
			{
				$msg = "Failed To Insert Technician!";
				//echo("Validation errors:<br/>");
				
				$this->success_failure_msgs(301, $msg, $this->json_response);
			}
		}
			
		else
		{
		$msg = "Required Parameters Are Missing.";
		$this->json_response = "";
		$this->success_failure_msgs(301, $msg, $this->json_response);
		}
			
	}
	
	// ========================== LOGIN TECHNICIAN ============================
	
	private function login_technician(){
	global $db;
	//$submerchant_id ="janesladders2_instant_3rdnbz3y";
	if( $this->params->username && $this->params->password )
		{
		$username = 	$this->params->username;
		$password =$this->params->password;
		
		
		
		$sql="SELECT * FROM technician WHERE username='$username' and password='$password'";
		$result=mysqli_query($db,$sql);
		$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
		
		$count=mysqli_num_rows($result);

		// If result matched $myusername and $mypassword, table row must be 1 row
	
			if($count>0)
			{
				$ret_array['success']='1';
				$ret_array['id']=$row['id'];
				$ret_array['message']='Login Technician Successfully';
				array_push($this->json_response,$ret_array);
				$this->success_failure_msgs(200, "Login Technician Successfully", $this->json_response);
			}
			else
			{
				$msg = "Login Failure!";
					$ret_array['success']='0';
				$ret_array['message']='Invalid Username or Password!';
				array_push($this->json_response,$ret_array);
				//echo("Validation errors:<br/>");
				
				$this->success_failure_msgs(301, $msg, $this->json_response);
			}
		}
			
		else
		{
		$msg = "Required Parameters Are Missing.";
		$this->json_response = "";
		$this->success_failure_msgs(301, $msg, $this->json_response);
		}
			
	}
	/* --------------- Collect Polling Site Data ----------------- */
	
	/* METHOD: regsiter_technician */
	private function submit_poll_site_data(){
	global $db;
	
	if( $this->params->clerk_name && $this->params->service_ticket_id)
		{
		$clerk_name = 	$this->params->clerk_name;
		$cellphone =$this->params->cellphone;
		$homephone = $this->params->homephone;
		$inspector_dropoff_loc = $this->params->inspector_dropoff_loc;
		$service_ticket_id = $this->params->service_ticket_id;
		$num_votes_cast = $this->params->num_votes_cast;
		$comments = $this->params->comments;
		$base64_string_img = $this->params->poll_image_data;
		$base64_string_signature = $this->params->poll_image_signature;
		$filename = md5(time().uniqid()).".jpg"; 
		$filename_sign = md5(time().uniqid())."_sign.jpg"; 
		$output_file = '../uploads/poll_site_data/images/'.$filename;
		$output_file_sign = '../uploads/poll_site_data/sign_images/'.$filename_sign;
		
		$this->base64_to_jpeg($base64_string_signature,$output_file_sign);
		$this->base64_to_jpeg($base64_string_img,$output_file);
		

	//die('heee');
		$sql=	"INSERT INTO ticket_data SET 
		clerk_name='$clerk_name', 
		cellphone='$cellphone', 
		homephone='$homephone', 
		inspector_dropoff_loc='$inspector_dropoff_loc',
		service_ticket_id='$service_ticket_id',
		num_votes_cast='$num_votes_cast',
		image_name='$filename',
		signature_image='$filename_sign',
		comments='$comments'"; 
		
		$result=mysqli_query($db,$sql);
		
		$sql_update_service_ticket = "UPDATE service_tickets 
									SET status='1' 
									WHERE id='$service_ticket_id'";
		
		$result_updation=mysqli_query($db,$sql_update_service_ticket);
		
			
			if($result)
			{
				$ret_array['success']='1';
				$ret_array['message']='Polling Site Data Submitted Successfully';
				$ret_array['user_id']=$db->insert_id;
				array_push($this->json_response,$ret_array);
				$this->success_failure_msgs(200, "Polling Site Data Submitted Success.", $this->json_response);
			}
			else
			{
				$msg = "Failed To Submit Polling Site Data!";
				//echo("Validation errors:<br/>");
				
				$this->success_failure_msgs(301, $msg, $this->json_response);
			}
		}
			
		else
		{
		$msg = "Required Parameters Are Missing.";
		$this->json_response = "";
		$this->success_failure_msgs(301, $msg, $this->json_response);
		}
			
	}
	
	    private function set_app_regid(){
            global $db;
            if($this->params->username && $this->params->regid){
                $username = $this->params->username;
                $regid = $this->params->regid;
                $sql = "Select id from technician where username = '$username' ";
                $result=mysqli_query($db,$sql);
                $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
                $count=mysqli_num_rows($result);
                if($count>0){
                    $technicianID = $row['id'] ;
                    $update_sql = "UPDATE technician SET push_regid = '$regid'
                        where id = '$technicianID' ";
                    $update_result = mysqli_query($db, $update_sql);
                    $ret_array['status'] = 1;
                    $ret_array['message'] = "Regid updated successfully";
                    array_push($this->json_response, $ret_array);
                    $this->success_failure_msgs(200, 'Regid updated successfully', $this->json_response);
                } else{
                    $ret_array['status'] = 0;
                    $ret_array['message'] = "User not found";
                    array_push($this->json_response, $ret_array);
                    $this->success_failure_msgs(301, 'User not found', $this->json_response);
                }
            } else{
                    $ret_array['status'] = 0;
                    $ret_array['message'] = "One of the params empty";
                    array_push($this->json_response, $ret_array);
                    $this->success_failure_msgs(301, 'One of the params empty', $this->json_response);
            }
        }
	// --------- Updates the Location of the Technician in database -------------------
	function update_tech_location(){
	        global $db;
            if($this->params->lat && $this->params->long && $this->params->username){
                $username = $this->params->username;
                $regid = $this->params->regid;
                $sql = "Select id from technician where username = '$username' ";
                $result=mysqli_query($db,$sql);
                $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
                $count=mysqli_num_rows($result);
                if($count>0){
                    $technicianID = $row['id'] ;
                    $update_sql = "UPDATE technician SET latitude = '$lat',longitude = '$long'
                        where id = '$technicianID' ";
                    $update_result = mysqli_query($db, $update_sql);
                    $ret_array['status'] = 1;
                    $ret_array['message'] = "Location updated successfully";
                    array_push($this->json_response, $ret_array);
                    $this->success_failure_msgs(200, 'Location updated successfully', $this->json_response);
                } else{
                    $ret_array['status'] = 0;
                    $ret_array['message'] = "User not found";
                    array_push($this->json_response, $ret_array);
                    $this->success_failure_msgs(301, 'User not found', $this->json_response);
                }
            } else{
                    $ret_array['status'] = 0;
                    $ret_array['message'] = "One of the params empty";
                    array_push($this->json_response, $ret_array);
                    $this->success_failure_msgs(301, 'One of the params empty', $this->json_response);
            }
	}
	public function base64_to_jpeg($base64_string, $output_file) {
	//echo $base64_string; die;
		$ifp = fopen($output_file, "wb"); 
		$base64_decode = base64_decode($base64_string);
		// die;
		$data = explode(',', $base64_string);

		fwrite($ifp, $base64_decode); 
		fclose($ifp); 

		return $output_file; 
		}
		
}

?>