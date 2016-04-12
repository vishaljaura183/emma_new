<?php

// include("inc/config.php");
// session_start();
$userid= $_SESSION['userid'];
// Get User data
$sql="SELECT * FROM admin WHERE id='$userid'";
$result=mysqli_query($db,$sql);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
//print_r($row); die;
$userid=$row['id'];

if(isset($_POST['userid']) && $_POST['userid']!='')
{
// username and password sent from form 

$name=$_POST['name']; 
$username=$_POST['username']; 
$email=$_POST['email']; 
$userid=$_POST['userid']; 



$sql=	"UPDATE admin SET 
		name='$name', 
		username='$username', 
		email='$email'
		WHERE id=$userid";
$result=mysqli_query($db,$sql);
if($result){
$_SESSION['name']=$name;
// Updated
header("location:profile_admin.php?msg=success");
}
else{
// Failed Update
header("location:profile_admin.php?msg=failed");
}
}

// ================ CHANGE PASSWORD ================
if(isset($_POST['change_pass']) && $_POST['change_pass']!=''){

$curr_pass = $_POST['curr_pass'];
$new_pass = $_POST['new_pass'];
$conf_pass = $_POST['conf_pass'];



$sql="SELECT id,passcode FROM admin WHERE id='$userid'";
$result=mysqli_query($db,$sql);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
//print_r($row); die;
$passcode=$row['passcode'];

if($curr_pass != $passcode){
header("location:profile_admin.php?msg=currpass");
}
else{
$sql=	"UPDATE admin SET 
		passcode='$new_pass'
		WHERE id=$userid";
$result=mysqli_query($db,$sql);
if($result){
// Updated
header("location:profile_admin.php?msg=pass_success");
}
}
}
?>
