<?php
session_start();
include_once("inc/config.php");

error_reporting(DEBUG_MODE);
$sess_id = $_SESSION['login_user']; 
$user_role = $_SESSION['usertype']; 
//echo 'header-'.$sess_id;die;
if($sess_id == ''){
header("location:login.php?msg=plslogin");
}
// die;
 ?>
<!DOCTYPE html>
<html lang="en">

<head>
	
	<!-- start: Meta -->
	<meta charset="utf-8">
	<title>Election USA - Admin</title>
	<meta name="description" content="LogBook - Admin">
	<meta name="author" content="Karan">
	<meta name="keyword" content="Election USA">
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no">
    <meta charset="utf-8">
	<!-- end: Meta -->
	
	<!-- start: Mobile Specific -->
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- end: Mobile Specific -->
	
	<!-- start: CSS -->
	<link id="bootstrap-style" href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
	<link id="base-style" href="css/style.css" rel="stylesheet">
	<link id="base-style-responsive" href="css/style-responsive.css" rel="stylesheet">
	<link href='http://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800&subset=latin,cyrillic-ext,latin-ext' rel='stylesheet' type='text/css'>
	<!-- end: CSS -->
	 	<script src="js/jquery-1.9.1.min.js"></script>
	<script src="js/jquery-migrate-1.0.0.min.js"></script>
	
		<script src="js/jquery-ui-1.10.0.custom.min.js"></script>
	
	

	<!-- The HTML5 shim, for IE6-8 support of HTML5 elements -->
	<!--[if lt IE 9]>
	  	<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<link id="ie-style" href="css/ie.css" rel="stylesheet">
	<![endif]-->
	
	<!--[if IE 9]>
		<link id="ie9style" href="css/ie9.css" rel="stylesheet">
	<![endif]-->
		
	<!-- start: Favicon -->
	<link rel="shortcut icon" href="img/favicon.ico">
	<!-- end: Favicon -->
	
		
		
		
</head>

<body>
	<style>
	div.fixedLoader
	{
		display: none;
	    background-color: #e2e2e2;
	    border: 2px solid grey;
	    border-radius: 5px;
	    color: black;
	    padding: 5px 10px;
	    position: fixed;
	    right: 50px;
	    top: 5px;
	    width: auto;
	    z-index: 1;
	}
	div.fixedSuccessMessage, div.fixedErrorMessage
	{
		display: none;
	    background-color: #e2e2e2;
	    border-radius: 5px;
	    padding: 5px 10px;
	    position: fixed;
	    right: 50px;
	    top: 50px;
	    width: auto;
	    z-index: 2;
		cursor: pointer;
	}
	div.fixedSuccessMessage
	{
	    border: 2px solid green;
		color: green;
	}
	div.fixedErrorMessage
	{
	    border: 2px solid red;
		color: red;
	}
	</style>
	<?php
	// ------------------------------- OPEN TICKETS -----------------
	$sql_open="SELECT count(status) as total_open FROM `service_tickets` WHERE  `status`=0";
	$result_open=mysqli_query($db,$sql_open);
	
	$result_open_execute=mysqli_fetch_all($result_open,MYSQLI_ASSOC);
	$total_open_tickets = $result_open_execute[0]['total_open'];
	//print_r($total_open_tickets);die;
	// --------------- CLOSED TICKETS ----------------
	$sql_closed="SELECT count(status) as total_open FROM `service_tickets` WHERE  `status`=1";
	$result_closed=mysqli_query($db,$sql_closed);
	
	$result_closed_execute=mysqli_fetch_all($result_closed,MYSQLI_ASSOC);
	$total_closed_tickets = $result_closed_execute[0]['total_open'];
	//print_r($total_open_tickets);die;
	
	// --------------- CANCELLED TICKETS ----------------
	$sql_cancelled="SELECT count(status) as total_open FROM `service_tickets` WHERE  `status`=2";
	$result_cancelled=mysqli_query($db,$sql_cancelled);
	
	$result_cancelled_execute=mysqli_fetch_all($result_cancelled,MYSQLI_ASSOC);
	$total_cancelled_tickets = $result_cancelled_execute[0]['total_open'];
	//print_r($total_open_tickets);die;
	?>
	<div class = "fixedLoader" >
		<span>
			<img src = "img/loader.GIF"></img>
		</span>
		&nbsp;Processing...
	</div>
	
		<!-- start: Header -->
	<div class="navbar">
		<div class="navbar-inner">
			<div class="container-fluid">
				<a class="btn btn-navbar" data-toggle="collapse" data-target=".top-nav.nav-collapse,.sidebar-nav.nav-collapse">
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</a>
				<a class="brand" href="<?php echo LIVE_SITE; ?>/poll_venues_listing.php"><span>Election USA</span></a>
								
				<!-- start: Header Menu -->
				<div class="nav-no-collapse header-nav">
					<ul class="nav pull-right">
						
						<!-- start: User Dropdown -->
						<li class="dropdown">
							<a class="btn dropdown-toggle" data-toggle="dropdown" href="#">
								<i class="halflings-icon white user"></i> 
								<?php
									if($_SESSION['name']!=''){
									echo $_SESSION['name'];
									}
									else{
									echo $_SESSION['login_user'];
									}
									?>
								<span class="caret"></span>
							</a>
							<ul class="dropdown-menu">
								<li class="dropdown-menu-title">
 									<span>Account Settings</span>
								</li>
								<li><a href="profile_admin.php"><i class="halflings-icon user"></i> Profile</a></li>
								<li><a href="logout.php"><i class="halflings-icon off"></i> Logout</a></li>
							</ul>
						</li>
						<!-- end: User Dropdown -->
					</ul>
				</div>
				<!-- end: Header Menu -->
				
			</div>
		</div>
	</div>
	<!-- start: Header -->
	
		<div class="container-fluid-full">
		<div class="row-fluid">
				
			<!-- start: Main Menu -->
			<div id="sidebar-left" class="span2">
				<div class="nav-collapse sidebar-nav">
					<ul class="nav nav-tabs nav-stacked main-menu">
					<!--	<li><a href="users.php"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Dashboard</span></a></li> -->	
					<?php if($_SESSION['usertype']<2) {
					?>
						<li><a href="poll_venues.php"><i class="icon-align-justify"></i><span class="hidden-tablet">Election Setup</span></a></li>
					
						
				
					<!--	<li><a href="users.php"><i class="icon-bar-chart"></i><span class="hidden-tablet"> Dashboard</span></a></li> -->	
					
						<li><a href="poll_venues_listing.php"><i class="icon-reorder"></i><span class="hidden-tablet">Poll Venues </span></a></li>
						<li><a href="reason_listing.php"><i class="icon-reorder"></i><span class="hidden-tablet">Call Reasons </span></a></li>
						<li><a href="supplies_listing.php"><i class="icon-reorder"></i><span class="hidden-tablet">Common Supplies </span></a></li>
						<?php } ?>
						<!--<li><a href="assign_polling_venues.php"><i class="icon-tasks"></i><span class="hidden-tablet">Service Ticket</span></a></li> -->
						<li>
							<a class="dropmenu" href="#"><i class="icon-folder-close-alt"></i><span class="hidden-tablet"> Service Ticket</span>
							
							<i class="icon-list-ul"></i></a>
							<ul>
							<?php if($_SESSION['usertype'] <3 ) {
					?>
								<li><a class="submenu" href="assign_polling_venues.php"><i class="icon-plus"></i><span class="hidden-tablet"> Assign New Ticket</span></a></li>
								<?php } ?>
								<li><a class="submenu" href="view_service_tickets.php"><i class="icon-reorder"></i><span class="hidden-tablet"> View All Tickets</span></a></li>
								
								<li><a class="submenu" href="view_service_tickets.php?sr_type=0"><i class="icon-file-alt"></i><span class="hidden-tablet"> Open Tickets</span>
								<span class="label label-important green_clr font_bigger" >  <?php echo $total_open_tickets;?> </span></a></li>
								
								<li><a class="submenu" href="view_service_tickets.php?sr_type=1"><i class="icon-file-alt"></i><span class="hidden-tablet"> Closed Tickets</span>
								<span class="label label-important font_bigger">  <?php echo $total_closed_tickets;?> </span></a></li>
								
								<li><a class="submenu" href="view_service_tickets.php?sr_type=2"><i class="icon-file-alt"></i><span class="hidden-tablet"> Cancelled Tickets</span>
								<span class="label label-important gray_clr font_bigger" >  <?php echo $total_cancelled_tickets;?> </span></a></li>
							</ul>
						</li>
						
						<?php if($_SESSION['usertype'] < 2 ) {
					?>
						<li><a href="#" class="dropmenu" ><i class="icon-user"></i><span class="hidden-tablet">Manage Personnel</span>
						<i class="icon-list-ul"></i></a>
							<ul>
								
								<li><a class="submenu" href="technicians.php"><i class="icon-reorder"></i><span class="hidden-tablet"> View All Personnel</span></a></li>
								<li><a class="submenu" href="add_technician.php"><i class="icon-plus"></i><span class="hidden-tablet"> Add New Personnel</span></a></li>
								<li><a class="submenu" href="technicians.php?role=tech"><i class="icon-reorder"></i><span class="hidden-tablet"> Technicians</span></a></li>
								<li><a class="submenu" href="technicians.php?role=rover"><i class="icon-reorder"></i><span class="hidden-tablet"> Rovers</span></a></li>
								
							</ul>
						</li>
						<?php } ?>
						<?php if($_SESSION['usertype'] <2 ) {
						?>
						<li><a href="#" class="dropmenu"  ><i class="icon-user"></i><span class="hidden-tablet">Manage Web Users</span>
						<i class="icon-list-ul"></i></a>
						<ul>
								
							<li><a class="submenu" href="officers.php"><i class="icon-reorder"></i><span class="hidden-tablet"> View All Users</span></a></li>
							<li><a class="submenu" href="add_user.php"><i class="icon-plus"></i><span class="hidden-tablet"> Add New User</span></a></li>
							<li><a class="submenu" href="officers.php?usertype=1"><i class="icon-reorder"></i><span class="hidden-tablet"> Admins</span></a></li>
							<li><a class="submenu" href="officers.php?usertype=2"><i class="icon-reorder"></i><span class="hidden-tablet"> Dispatchers</span></a></li>
							<li><a class="submenu" href="officers.php?usertype=3"><i class="icon-reorder"></i><span class="hidden-tablet"> View Only Users</span></a></li>
								
						</ul>
						
						</li>
						<?php } ?>
						<li><a href="poll_data_collected.php"><i class="icon-briefcase"></i><span class="hidden-tablet">Ticket Data Collected</span></a></li>
						<li><a href="poll_site_data.php"><i class="icon-briefcase"></i><span class="hidden-tablet">Poll Data Collected</span></a></li>
						<li><a href="poll_sites_map.php" target="blank"><i class="icon-map-marker"></i><span class="hidden-tablet">Poll Sites Map</span></a></li>
						<li><a href="reports.php"><i class="icon-reorder"></i><span class="hidden-tablet">Reports</span></a></li>
					<!--	<li><a href="#"><i class="icon-tasks"></i><span class="hidden-tablet">Manage Common Supply</span></a></li>
						<li><a href="#"><i class="icon-tasks"></i><span class="hidden-tablet">Manage Election Data</span></a></li> -->
						
					</ul>
				</div>
			</div>
			<!-- end: Main Menu -->
			
			<noscript>
				<div class="alert alert-block span10">
					<h4 class="alert-heading">Warning!</h4>
					<p>You need to have <a href="http://en.wikipedia.org/wiki/JavaScript" target="_blank">JavaScript</a> enabled to use this site.</p>
				</div>
			</noscript>
			
			
<?php

define('DS', DIRECTORY_SEPARATOR);

// echo "here"; die;
// Timezone: Set it to your timezone
//date_default_timezone_set("Europe/Zurich"); 

// Do not autostart session
//ini_set("session.auto_start", "Off");

// Session path: Change is according to your liking or just remove it if you are using some other session management
//ini_set("session.save_path", dirname(__DIR__) . DS . "tmp" . DS . "sessions");

// Load the compose autoload
require_once (dirname(__DIR__) . DS . PROJECT_LIB.'/vendor' . 	DS . 'autoload.php');
use Parse\ParseClient;

$app_id ="O8woN94uRKMmWia3bnErXKzELMZ5bitqXUP4Vk6A";

$rest_key = "0kC22QE0fFCMYHvt4yz9WvXyIxNzJTqOkn4da9WF";

$master_key ="VryAAnF4wj7f1RJbTlJ4kFe0D6CBN8YkQNa5PXg7";
// ParseClient::initialize('z4L1HepwrtxsUeHlRhuI1sXghdYJYTXxvJqtrCcF', '98chs65eaOddM7H5XuHlv5FrX77aW7Dlia3k9OsJ', 'vxVmriTkJGYlPp49NxWSfaG6u0QlfmIEW8c1rew5');
ParseClient::initialize($app_id,$rest_key, $master_key);

// Start the session. Note the session should be started after loading the vendor/autoload.php

// session_start();


 
 //print_r($results); die;
?>
