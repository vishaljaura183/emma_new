<?php
include('inc/common_func.php');

if( $_POST['tech_id'] )
{
	$sql = "Select * from technician where email = '".$_POST['tech_id']."' LIMIT 1";
                $result=mysqli_query($db,$sql);
                $row=mysqli_fetch_array($result,MYSQLI_ASSOC);
                
                
	$update_sql = "UPDATE technician SET  password = '".$row["new_password_to_set"]."' where email = '".$_POST['tech_id']."'";
					$update_result = mysqli_query($db, $update_sql);
					
	echo "<H2>Your password has been reset to new password. Form now onwards please use the new password which was sent you in your registered email.</H2>";			
					
}