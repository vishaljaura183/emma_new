<?php
include_once("../inc/config.php");
if(!empty($_POST['del_id']))
{
// username and password sent from form 
$id=$_POST['del_id'];



$sql=	"DELETE FROM admin WHERE id=$id";
$result=mysqli_query($db,$sql);
if($result){
echo "success";
// Delted
//header("location:officers.php?msg=success");
}
else{

// Failed Delete
// header("location:add_officers.php?msg=failed");
}
}


?>
