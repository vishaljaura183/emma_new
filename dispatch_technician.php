<?php
include ('header.php');
use Parse\ParseObject;
use Parse\ParseQuery;
use Parse\ParseUser;
//Moving file to server=======================================
$uploadedStatus = 0;
if (isset ( $_POST["submit"] ))
{
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
			$error = "Oops and error occurred. Return Code: " . $_FILES ["poll_venue_import_file"] ["error"];
		}
		else if ($extension == 'xlsx' || $extension == 'xls')
		{
			$storagename = "poll_venues_temp_file.xlsx";
			move_uploaded_file ( $_FILES ["poll_venue_import_file"] ["tmp_name"], 'temp_poll_venue_files/'.$storagename );
			$uploadedStatus = 1;
			
			//Reading file==============================================
			set_include_path(get_include_path() . PATH_SEPARATOR . 'Classes/');
			include 'PHPExcel/IOFactory.php';
			
			// This is the file path to be uploaded.
			$inputFileName = 'temp_poll_venue_files/'.$storagename; 
			
			try {
				$objPHPExcel = PHPExcel_IOFactory::load($inputFileName);
			} catch(Exception $e) {
				die('Error loading file "'.pathinfo($inputFileName,PATHINFO_BASENAME).'": '.$e->getMessage());
			}
			
			
			$allDataInSheet = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
			foreach ( $allDataInSheet as $key=>$indx )
			{
				if($key!=1)
				{
					// Create a new object
					$post = ParseObject::create('pollVenues');
					$post->set('ADA_Accessible', $indx['A']);
					$post->set('Municipality', $indx['B']);
					$post->set('Ward', $indx['C']);
					$post->set('Precinct', $indx['D']);
					$post->set('Name_of_Location', $indx['E']);
					$post->set('Directions', $indx['F']);
					$post->set('Address_Line_1', $indx['G']);
					$post->set('Address_Line_2', $indx['H']);
					$post->set('Post_Office', $indx['I']);
					$post->set('ST', $indx['J']);
					$post->set('ZIP', strval($indx['K']) );
					
					//Getting lat long from address, with the service from google.
					$address = $indx['G'].' '.$indx['H'].', '.$indx['J'].' '.$indx['K'];
	//				$address = '201 S. Division St., Ann Arbor, MI 48104'; // Google HQ
					$prepAddr = str_replace(' ','+',$address);
					
					$geocode=file_get_contents('http://maps.google.com/maps/api/geocode/json?address='.$prepAddr.'&sensor=false');
					
					$output= json_decode($geocode);
					
					$lat = $output->results[0]->geometry->location->lat;
					$long = $output->results[0]->geometry->location->lng;
		
					
					$post->set('latitude', $lat);
					$post->set('longitude', $long);
					
								
					// Save it to Parse
					$post->save();
				}
			}
			$success_message = 'Data saved successfully.';
		}
		else 
		{
			$error = "Please only use microsoft excel file for importing data.";
		}		
	}
}
?>

<div id="content" class="span10">
	<ul class="breadcrumb">
		<li><i class="icon-home"></i> <a href="poll_venues.php">Home</a> <i
			class="icon-angle-right"></i></li>
		<li><a href="#">Start Service Ticket</a></li>
	</ul>

	<div class="row-fluid sortable">
		<div class="box span12">
			<div class="box-header" data-original-title>
				<h2>
					<i class="halflings-icon edit"></i>
						<span class="break"></span>
						Start Service Ticket &nbsp;&nbsp;<span style = 'color: green'><?php echo @$success_message ?></span>
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
						<label class="control-label" for="selectError3">Polling site</label>
						<div class="controls">
						  <select id="selectError3">
							<option>-Select-</option>
							<option>Option 1</option>
							<option>Option 2</option>
							<option>Option 3</option>
							<option>Option 4</option>
							<option>Option 5</option>
						  </select>
						</div>
					  </div>
					<div class="control-group hidden-phone">
					  <label class="control-label" for="textarea2">Address</label>
					  <div class="controls">
						<textarea class="" id="textarea2" rows="3" name = 'address'></textarea>
					  </div>
					</div>
					<div class="control-group hidden-phone">
					  <label class="control-label" for="textarea2">Address</label>
					  <div class="controls">
						<textarea class="" id="textarea2" rows="3" name = 'reason_of_call'></textarea>
					  </div>
					</div>
					<div class="control-group">
						<label class="control-label" for="selectError3">Supplies Needed</label>
						<div class="controls">
						  <select id="selectError3">
							<option>-Select-</option>
							<option>Option 1</option>
							<option>Option 2</option>
							<option>Option 3</option>
							<option>Option 4</option>
							<option>Option 5</option>
						  </select>
						</div>
					  </div>
					  <div class="control-group">
						<label class="control-label" for="selectError3">Technnician</label>
						<div class="controls">
						  <select id="selectError3">
							<option>-Select-</option>
							<option>Option 1</option>
							<option>Option 2</option>
							<option>Option 3</option>
							<option>Option 4</option>
							<option>Option 5</option>
						  </select>
						</div>
					  </div>
					<div class="form-actions">
						<button type="button" name='home' value = 'Home' class="btn btn-primary">Home</button>
						<button type="submit" name='submit' value = 'submit' class="btn btn-primary">Dispatch Technician</button>
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