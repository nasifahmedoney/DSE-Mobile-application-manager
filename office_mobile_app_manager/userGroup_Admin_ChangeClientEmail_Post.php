<?php
//
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

function before ($this_, $inthat)
{
    return substr($inthat, 0, strpos($inthat, $this_));
};
//



if(isset($_POST['inv_code']) && isset($_POST['new_email']) && isset($_POST['found_in']) )
{
	$investor_code = $_POST['inv_code'];
	$new_email = $_POST['new_email'];
	$code_found_in = $_POST['found_in'];
	
	if($code_found_in == "new")
	{
		$query3 = "UPDATE documents SET client_email = '$new_email' WHERE investor_code = '$investor_code'";
		$result3 = mysqli_query($link,$query3);
		if($result3)
		{
			echo '<script type="text/javascript"> 
			alert("Client Email Updated successfully.");
			window.location.href = "userGroup_Admin_ChangeClientEmail_ui.php";			
			</script>';
		}
		else
		{
			header("Location:error.php?error_id=query error");
		}
	}
	else
	{
		$query4 = "UPDATE old_documents SET client_email = '$new_email' WHERE investor_code = '$investor_code'";
		$result4 = mysqli_query($link,$query4);
		if($result4)
		{
			echo '<script type="text/javascript"> 
			alert("Client Email Updated successfully.");
			window.location.href = "userGroup_Admin_ChangeClientEmail_ui.php";			
			</script>';
		}
		else
		{
			header("Location:error.php?error_id=query error");
		}
	}
}


?>