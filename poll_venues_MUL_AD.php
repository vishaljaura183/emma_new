<?php
include ('header.php');
//	echo "<style> #sidebar-left {display: none;} </style>";
// print_r($_SESSION); die;
$admin_id = $_SESSION['userid'];
//Reading file==============================================
set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
include 'PHPExcel/IOFactory.php';


//use Parse\ParseObject;
//use Parse\ParseQuery;
//use Parse\ParseUser;

//Moving file to server=======================================
$uploadedStatus = 0;
if (isset ( $_POST["submit"] ))
{
	$sql = "UPDATE setup_elections 
			SET
			service_personal='".$_POST['setup_service_personel']."'
			WHERE id=1";		
				
	if ($db->query($sql) === TRUE) {
	} else {
	    echo "Error: " . $sql . "<br>" . $db->error;
	}
	
	if ( isset ( $_FILES ["poll_venue_import_file"] ) )
	{
		$extension = '';
		if( $_FILES ["poll_venue_import_file"]['name'] )
		{
			$temp = explode('.', $_FILES ["poll_venue_import_file"]['name']);
			$extension = end($temp);
		}
		//if there was an error uploading the file
		if ($_FILES ["poll_venue_import_file"] ["error"] > 0) 
		{
			//$error = "Oops and error occurred. Return Code: " . $_FILES ["poll_venue_import_file"] ["error"];
		}
		else if ($extension == 'xlsx' || $extension == 'xls')
		{
			$storagename = "poll_venues_temp_file.xlsx";
			move_uploaded_file ( $_FILES ["poll_venue_import_file"] ["tmp_name"], 'temp_poll_venue_files/'.$storagename );
			$uploadedStatus = 1;
			
			// This is the file path to be uploaded.
			$inputFileName = 'temp_poll_venue_files/'.$storagename; 
			
			try {
				$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
			} catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}
			
			//  Get worksheet dimensions
				$sheet = $objPHPExcel->getSheet(0); 
				$highestRow = $sheet->getHighestRow(); 
				$highestColumn = $sheet->getHighestColumn();
			//	var_dump($highestRow); die;
			$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
		//	print_r($allDataInSheet); die;
			// sql to delete a record
			$sql = "SET FOREIGN_KEY_CHECKS = 0";
			if ($db->query($sql) === TRUE) {
			    //echo "Record deleted successfully";
			} else {
			    echo "Error deleting record: " . $db->error;
			}
			$sql = "DELETE FROM poll_venues WHERE admin_id=$admin_id";
			
			if ($db->query($sql) === TRUE) {
			    //echo "Record deleted successfully";
			} else {
			    echo "Error deleting record: " . $db->error;
			}
			
			
			$sql = "INSERT INTO poll_venues (
							 
							voting_district,
							name_of_location,
							Directions,
							address_line_1,
							
							post_office,
							ST,
							ZIP,
							latitude,
							longitude,
							admin_id
							)
							VALUES";
			$i = 0;
			$len = count($allDataInSheet)-1;
			// echo $len; die('-');
			foreach ( $allDataInSheet as $key=>$indx )
			{
				//print_r($allDataInSheet[1]); die;
				if($key!=1 && @$indx['A'])
				{
					//Getting lat long from address, with the service from google.
					$address = $indx['B'].', '.$indx['D'].', '.$indx['F'].' '.$indx['G'];
	//				$address = '201 S. Division St., Ann Arbor, MI 48104'; // Google HQ
					$prepAddr = str_replace(' ','+',$address);
					
					$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
					
					$output= json_decode($geocode);
					
					if( @$output->results[0] )
					{
						$lat = $output->results[0]->geometry->location->lat;
						$long = $output->results[0]->geometry->location->lng;
					}
					else
					{
						$lat = '';
						$long = '';
					}
					
					 
					$sql_sql_arr[] .= '(
							"'.addslashes($indx['A']).'", 
							"'.addslashes($indx['B']).'", 
							"'.addslashes($indx['C']).'", 
							"'.addslashes($indx['D']).'", 
							 
							"'.addslashes($indx['E']).'", 
							"'.addslashes($indx['F']).'", 
							"'.addslashes($indx['G']).'", 
							
							"'.addslashes($lat).'", 
							"'.addslashes($long).'",
							"'.addslashes($admin_id).'"
							)';
					//	print_r($sql_sql_arr);
					/*	
					if ($allDataInSheet[$i+1]['A'] =='') {
					//if ($i == $len - 1) {
						$sql .= '';
					}
					else
					{
						$sql .= ',';
					}
					*/
					$i++;
				
				}
			}
			// print_r($sql_sql_arr); die;
			$sql_implode = implode(',',$sql_sql_arr); 
			$sql .= $sql_implode;
		//	echo $sql;
		//	die;
			if ($db->query($sql) === TRUE) {
			    //echo "New record created successfully";
			} else {
			    echo "Error: " . $sql . "<br>" . $db->error;
			}
			$success_message = 'Data saved successfully.';
		}
		else 
		{
			$error = "Please use only microsoft excel file for importing data.";
		}		
	}
	
	if ( isset ( $_FILES ["common_election_supplies_file"] ) )
	{
		$extension = '';
		if( $_FILES ["common_election_supplies_file"]['name'] )
		{
			$temp = explode('.', $_FILES ["common_election_supplies_file"]['name']);
			$extension = end($temp);
		}
		//if there was an error uploading the file
		if ($_FILES ["common_election_supplies_file"] ["error"] > 0)
		{
			//$error = "Oops and error occurred. Return Code: " . $_FILES ["common_election_supplies_file"] ["error"];
		}
		else if ($extension == 'xlsx' || $extension == 'xls')
		{
			$storagename = "common_election_supplies_temp_file.xlsx";
			move_uploaded_file ( $_FILES ["common_election_supplies_file"] ["tmp_name"], 'temp_poll_venue_files/'.$storagename );
			$uploadedStatus = 1;
			
			// This is the file path to be uploaded.
			$inputFileName = 'temp_poll_venue_files/'.$storagename;
			
			try {
				$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
			} catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}
			
			
			$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			
			// sql to delete a record
			$sql = "TRUNCATE TABLE common_election_supplies";
			
			if ($db->query($sql) === TRUE) {
			    //echo "Record deleted successfully";
			} else {
			    echo "Error deleting record: " . $db->error;
			}
			
			foreach ( $allDataInSheet as $key=>$indx )
			{
				if($key!=1)
				{
					// Create a new object
					//$post = ParseObject::create('commonElectionSupplies');
					//$post->set('commonSupply', $indx['A']);
					
					// Save it to Parse
					//$post->save();
					
					$sql = "INSERT INTO common_election_supplies (
							common_supply
							)
							VALUES (
							'".$indx['A']."'
							)";
				
					if ($db->query($sql) === TRUE) {
					    //echo "New record created successfully";
					} else {
					    echo "Error: " . $sql . "<br>" . $db->error;
					}
				}
			}
			$success_message = 'Data saved successfully.';
		}
		else 
		{
			$error = "Please use only microsoft excel file for importing data.";
		}		
	}
	
	//Call_reasons file upload functionality.
	if ( isset ( $_FILES ["call_reasons"] ) )
	{
		$extension = '';
		if( $_FILES ["call_reasons"]['name'] )
		{
			$temp = explode('.', $_FILES ["call_reasons"]['name']);
			$extension = end($temp);
		}
		//if there was an error uploading the file
		if ($_FILES ["call_reasons"] ["error"] > 0)
		{
			//$error = "Oops and error occurred. Return Code: " . $_FILES ["common_election_supplies_file"] ["error"];
		}
		else if ($extension == 'xlsx' || $extension == 'xls')
		{
			$storagename = "call_reasons.xlsx";
			move_uploaded_file ( $_FILES ["call_reasons"] ["tmp_name"], 'temp_poll_venue_files/'.$storagename );
			$uploadedStatus = 1;
			
			// This is the file path to be uploaded.
			$inputFileName = 'temp_poll_venue_files/'.$storagename;
			
			try {
				$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
			} catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}
			
			
			$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			
			// sql to delete a record
			$sql = "TRUNCATE TABLE call_reasons";
			
			if ($db->query($sql) === TRUE) {
			    //echo "Record deleted successfully";
			} else {
			    echo "Error deleting record: " . $db->error;
			}
			$i = 0;
			$len = count($allDataInSheet)-1;
			$sql = "INSERT INTO call_reasons (
							call_reason
							)
							VALUES";
			foreach ( $allDataInSheet as $key=>$indx )
			{
				if($key!=1)
				{
					 $sql .= "(
							'".$indx['A']."'
							)";
					 
					if ($i == $len - 1) {
						$sql .= '';
					}
					else
					{
						$sql .= ',';
					}
					$i++;
				
					
				}
			}
			if ($db->query($sql) === TRUE) {
					    //echo "New record created successfully";
					} else {
					    echo "Error: " . $sql . "<br>" . $db->error;
					}
			$success_message = 'Data saved successfully.';
		}
		else 
		{
			$error = "Please use only microsoft excel file for importing data.";
		}		
	}
}
?>

<div id="content" class="span10">
	<ul class="breadcrumb">
		<li><i class="icon-home"></i> <a href="poll_venues.php">Home</a> <i
			class="icon-angle-right"></i></li>
		<li><a href="#">Election Setup</a></li>
	</ul>

	<div class="row-fluid sortable">
		<div class="box span12">
			<div class="box-header" data-original-title>
				<h2>
					<i class="halflings-icon edit"></i>
						<span class="break"></span>
						Upload Excel &nbsp;&nbsp;<span style = 'color: green'><?php echo @$success_message ?></span>
				</h2>
				<div class="box-icon">
					<a href="#" class="btn-minimize">
						<i class="halflings-icon chevron-up"></i>
					</a> 
					<a href="#" class="btn-close">
						<i class="halflings-icon remove"></i>
					</a>
				</div>
			</div>
		<div class="box-content">
			<form class="form-horizontal" method="post" enctype="multipart/form-data">
				<fieldset>
					<div class="control-group">
						<label style="color:red"><?php echo @$error; ?></label>
					</div>
					<div class="control-group">
						<label class="control-label" for="focusedInput">Setup service personel</label>
						<div class="controls">
						  <input class="input-xlarge" id="" type="text" value="" name = 'setup_service_personel'>
						</div>
					  </div>
					  <div class="control-group hidden-phone">
						  <label class="control-label" for="textarea2">Enter common repair call terms</label>
						  <div class="controls">
							<input class="input-file uniform_on" name = 'call_reasons' id="fileInput" type="file">
							<span><i>(First row will be removed treating it as header)</i></span>
						  </div>
						</div>
					<div class="control-group" style="">
						<label class="control-label" for="fileInput">Upload polling sites</label>
						<div class="controls">
							<input class="input-file uniform_on" name = 'poll_venue_import_file' id="fileInput" type="file">
							<span><i>(First row will be removed treating it as header)</i></span>
						</div>
					</div>
					<div class="control-group" style="">
						<label class="control-label" for="fileInput">Enter common election supplies</label>
						<div class="controls">
							<input class="input-file uniform_on" name = 'common_election_supplies_file' id="common_election_supplies_file" type="file">
							<span><i>(First row will be removed treating it as header)</i></span>
						</div>
					</div>
					<div class="control-group" style="">
						<label class="control-label" for="fileInput">Polling site phone</label>
						<div class="controls">
							<input class="input-file uniform_on" name = 'polling_site_phone' id="polling_site_phone" type="file">
							<span><i>(First row will be removed treating it as header)</i></span>
						</div>
					</div>
					<div class="control-group" style="">
						<label class="control-label" for="fileInput">Upload machine or equipment id</label>
						<div class="controls">
							<input class="input-file uniform_on" name = 'machine_or_equipment_id' id="machine_or_equipment_id" type="file">
							<span><i>(First row will be removed treating it as header)</i></span>
						</div>
					</div>
					<div class="form-actions">
						<button type="submit" name='submit' value = 'submit' class="btn btn-primary">Submit</button>
						<button type="reset" class="btn">Cancel</button>
					</div>
				</fieldset>
			</form>
		</div>
	</div>
</div>

</div>
<div class="modal hide fade" id="myModal">
	<div class="modal-header">
		<button type="button" class="close" data-dismiss="modal">×</button>
		<h3>Settings</h3>
	</div>
	<div class="modal-body">
		<p>Here settings can be configured...</p>
	</div>
	<div class="modal-footer">
		<a href="#" class="btn" data-dismiss="modal">Close</a>
		<a href="#" class="btn btn-primary">Save changes</a>
	</div>
</div>
<?php
include('footer.php');
?>