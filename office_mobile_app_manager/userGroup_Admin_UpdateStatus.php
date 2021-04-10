<?php

include 'connect.php';
session_start();

$user_email = '';
$userGroup = '';
if(!isset($_SESSION['email']))
{
	header("Location:logout_end_session.php");
}
else if($_SESSION['userGroup'] != "Admin")
{
	header("Location:logout_end_session.php");
}
else
{
	$user_email = $_SESSION['email'];
	$userGroup = $_SESSION['userGroup'];
}

if(isset($_POST['inv_code']) && isset($_POST['new_status']) )
{
	if($user_email != '')
	{
		$investor_code = $_POST['inv_code'];
		$new_status = $_POST['new_status'];

		$query = "UPDATE documents SET status = '$new_status', purchase_power = 'not_set' WHERE investor_code = '$investor_code'";
		$result = mysqli_query($link,$query);
		
		if($result)
		{
			echo '<script type="text/javascript"> 
				alert("Investor Code Activated Successfully.");
				window.location.href = "userGroup_Admin_ActivateCodes.php";			
			</script>';
		}
	}
	else
	{
		header("Location:logout_end_session.php");
	}
}
else
{
	header("Location:error.php?error_id=data initialization error");
}

?>