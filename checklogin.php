<?php

include_once("inc/config.php");
session_start();

if($_SERVER["REQUEST_METHOD"] == "POST")
{
// username and password sent from form 

$myusername=mysqli_real_escape_string($db,$_POST['username']); 
$mypassword=mysqli_real_escape_string($db,$_POST['password']); 


$sql="SELECT * FROM admin WHERE username='$myusername' and passcode='$mypassword'";
$result=mysqli_query($db,$sql);
$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
$userid=$row['id'];
$name=$row['name'];
$usertype=$row['usertype'];
$email=$row['email'];

$count=mysqli_num_rows($result);


// If result matched $myusername and $mypassword, table row must be 1 row
if($count==1)
{
// session_register("myusername");
$_SESSION['login_user']=$myusername;
$_SESSION['userid']=$userid;
$_SESSION['name']=$name;
$_SESSION['usertype']=$usertype;
if($usertype =='1'){
	
$_SESSION['author_type']="Admin";
}
elseif($usertype =='2'){
	
$_SESSION['author_type']="Dispatcher";
}
$_SESSION['email']=$email;
//echo $_SESSION['login_user']; die;
header("location:poll_venues.php");
}
else 
{
header("location:login.php?msg=error");
// $error="Your Login Name or Password is invalid";
}
}
?>
