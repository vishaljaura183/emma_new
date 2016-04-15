<?php
include_once("inc/config.php");

if($_SERVER["REQUEST_METHOD"] == "POST")
{
	//Check if email ID exists in DB.
	$email_id = $_POST['emai_id'];
	$sql="SELECT * FROM admin WHERE email='$email_id' LIMIT 1";
	$result=mysqli_query($db,$sql);
	$row=mysqli_fetch_array($result,MYSQLI_ASSOC);
	
	

	if($row)
	{
		//Generate new password.
		$length = 10;
		$characters = '0123456789@#$&*!abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	    $charactersLength = strlen($characters);
	    $randomString = '';
	    for ($i = 0; $i < $length; $i++) {
	        $randomString .= $characters[rand(0, $charactersLength - 1)];
	    }
	    $new_pass = $randomString;
		
	    //Set new_password field in database. It is the feild holds
	    //password to be set on user approval.
	    $np_sql = "UPDATE admin SET new_password='".$new_pass."' WHERE email='".$email_id."'";
	    $db->query($np_sql);
	    
		//Email template.
		$to = $email_id;
		$subject = "Elections USA - Admin Password Recovery Email";
		
		$message = "
		<html>
		<head>
		<title>Elections USA - Admin Password Recovery Email</title>
		</head>
		<body>
		<p>Hi Admin,</p>
		<p>Your new password is: <b>".$new_pass."</b></p>
		<p>Please click on following link to activate your new password.</p>
		</body>
		</html>
		";
		
		// Always set content-type when sending HTML email
		$headers = "MIME-Version: 1.0" . "\r\n";
		$headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
		
		// More headers
		$headers .= 'From: <karansamra.it@gmail.com>' . "\r\n";
		
	    //Send email.
		if(mail($to,$subject,$message,$headers))
		{
			header("location:forgot_password.php?msg=email_sent");
		}
		else
		{
			header("location:forgot_password.php?msg=error_sending_email");
		}
	}
	else
	{
		header("location:forgot_password.php?msg=admin_does_not_exist");
	}
}
?>
