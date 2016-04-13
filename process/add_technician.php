<?php
if(isset($_POST['submit']))
{
// username and password sent from form 

$first_name=$_POST['first_name']; 
$last_name=$_POST['last_name']; 
$username=$_POST['username']; 
$email=$_POST['email']; 
$role=$_POST['role']; 
$phone=$_POST['phonee']; 
$password=$_POST['new_pass']; 


$sql=	"INSERT INTO technician SET 
		first_name='$first_name', 
		last_name='$last_name', 
		username='$username', 
		email='$email',
		role='$role',
		phone='$phone',
		password='$password'"; 
$result=mysqli_query($db,$sql);
if($result){

// Updated
header("location:technicians.php?msg=success");
}
else{
// Failed Update
header("location:add_technician.php?msg=failed");
}
}

// ================ CHANGE PASSWORD ================
if(isset($_POST['change_pass']) && $_POST['change_pass']!=''){

$curr_pass 	= $_POST['curr_pass'];
$new_pass 	= $_POST['new_pass'];
$conf_pass 	= $_POST['conf_pass'];



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
