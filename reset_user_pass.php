<?php
include_once("inc/config.php");

if(isset($_GET['pass_reset']))
{
$encoded_id = $_GET['id'];
$encoded_pass = $_GET['pass'];
$id=base64_decode($encoded_id);
$password=base64_decode($encoded_pass);
	//Check if email ID exists in DB.
	$email_id = $_POST['emai_id'];
	$sql="UPDATE admin SET passcode='$password' WHERE id=$id";
	$result=mysqli_query($db,$sql);
	
	
	header("location:login.php?msg=pass_reset_success");
	}
	
	?>