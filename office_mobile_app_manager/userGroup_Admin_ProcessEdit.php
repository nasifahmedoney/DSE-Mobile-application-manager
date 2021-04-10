<?php

include 'connect.php';
session_start();

$user_email = '';
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
}

if(isset($_POST['inv_code']) && isset($_POST['new_purchase_power']) && isset($_POST['purchase_power']) && isset($_POST['found_in']) )
{
	if($user_email != '')
	{
		$investor_code = $_POST['inv_code'];
		$new_purchase_power = $_POST['new_purchase_power'];
		$purchase_power = $_POST['purchase_power'];
		
		if($purchase_power == "not_set")
		{
			$new_purchase_power = "90_percent";
		}
		else if($purchase_power == "set_90_percent")
		{
			$new_purchase_power = "Ledger Balance";
		}
		
		if($_POST['found_in'] == "new")
		{
			$query = "UPDATE documents SET purchase_power = '$new_purchase_power' WHERE investor_code = '$investor_code'";
			$result = mysqli_query($link,$query);
			if($result)
			{
				echo '<script type="text/javascript"> 
				alert("Purchase power Updated successfully.");
				window.location.href = "userGroup_Admin_EditPurchasePower.php";			
					</script>';
			}
		}
		else//old documents
		{
			$query = "UPDATE old_documents SET purchase_power = '$new_purchase_power' WHERE investor_code = '$investor_code'";
			$result = mysqli_query($link,$query);
			if($result)
			{
				echo '<script type="text/javascript"> 
				alert("Purchase power Updated successfully.");
				window.location.href = "userGroup_Admin_EditPurchasePower.php";			
					</script>';
			}
		}
	}
	else
	{
		header("Location:logout_end_session.php");
	}
}
else
{
	header("Location:error.php?error_id=Data Initialization error");
}

?>



