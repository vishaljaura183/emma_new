<?php

// include("inc/config.php");
// session_start();
if(isset($_GET['id'])){

$userid= $_GET['id'];

// Get User data
$sql="SELECT * FROM technician WHERE id='$userid'";
$result=mysqli_query($db,$sql);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
//print_r($row); die;
$userid=$row['id'];
}
if(isset($_POST['userid']) && $_POST['userid']!='')
{
// username and password sent from form 

$first_name=$_POST['first_name']; 
$last_name=$_POST['last_name']; 

$phone=$_POST['phone']; 
 

$new_pass = $_POST['new_pass'];
$extra_field = '';
if($new_pass != ''){
$extra_field = " password='$new_pass' ";
}


$sql=	"UPDATE technician SET 
		first_name='$first_name', 
		last_name='$last_name', 
		phone='$phone',
		$extra_field
		WHERE id=$userid";
$result=mysqli_query($db,$sql);
if($result){
// $_SESSION['name']=$name;
// Updated
header("location:profile_technician.php?id=$userid&msg=success");
}
else{
// Failed Update
header("location:profile_technician.php?id=$userid&msg=failed");
}
}

// ================ CHANGE PASSWORD ================
/*
if(isset($_POST['change_pass']) && $_POST['change_pass']!=''){
$curr_pass = $_POST['curr_pass'];
$new_pass = $_POST['new_pass'];
$conf_pass = $_POST['conf_pass'];



$sql="SELECT id,password FROM technician WHERE id='$userid'";
$result=mysqli_query($db,$sql);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
//print_r($row); die;
$passcode=$row['password'];



$sql=	"UPDATE technician SET 
		password='$new_pass'
		WHERE id=$userid";
$result=mysqli_query($db,$sql);
if($result){
// Updated
header("location:profile_technician.php?msg=pass_success&id=$userid");
}
}
*/
?>
