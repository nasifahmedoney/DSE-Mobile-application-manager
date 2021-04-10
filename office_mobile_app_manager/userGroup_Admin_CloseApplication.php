<?php
include 'connect.php';
session_start();

$user_email = '';
$purchase_power = '';
//active,not_set->90_percent
//active,90_percent->90_percent

//active,Ledger Balance->set_90_percent
//active,set_90_percent->set_90_percent

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

if(isset($_GET['inv_code']))
{
	$inv_code = $_GET['inv_code'];
	if($inv_code!=null)
	{
		$query = "SELECT * FROM documents WHERE investor_code = '$inv_code'";
		$result = mysqli_query($link,$query);
		if($result)
		{
			$row = $result->fetch_array(MYSQLI_ASSOC);
			if(is_array($row))
			{
				if($row['purchase_power'] == "not_set" || $row['purchase_power'] == "90_percent")
				{
					$purchase_power = "90_percent";
				}
				else if($row['purchase_power'] == "Ledger Balance" || $row['purchase_power'] == "set_90_percent")
				{
					$purchase_power = "set_90_percent";
				}
				$query1 = "UPDATE documents SET status = 'Deactive', purchase_power = '$purchase_power' WHERE investor_code = '$inv_code'";
				$result1 = mysqli_query($link,$query1);
				if($result1)
				{
					echo '<script type="text/javascript"> 
					alert("Deactivated successfully in New Documents.");
					window.location.href = "userGroup_Admin_CloseMobileAccount.php";			
						</script>';
				}
				else
				{
					header("Location:error.php?error_id=error");
				}
			}
			else
			{
				$query2 = "SELECT * FROM old_documents WHERE investor_code = '$inv_code'";
				$result2 = mysqli_query($link,$query2);
				if($result2)
				{
					$row1 = $result2->fetch_array(MYSQLI_ASSOC);
					if(is_array($row1))
					{
						if($row1['purchase_power'] == "not_set" || $row1['purchase_power'] == "90_percent")
						{
							$purchase_power = "90_percent";
						}
						else if($row1['purchase_power'] == "Ledger Balance" || $row1['purchase_power'] == "set_90_percent")
						{
							$purchase_power = "set_90_percent";
						}
						$query3 = "UPDATE old_documents SET status = 'Deactive', purchase_power = '$purchase_power' WHERE investor_code = '$inv_code'";
						$result3 = mysqli_query($link,$query3);
						if($result3)
						{
							echo '<script type="text/javascript"> 
							alert("Deactivated successfully in Old Documents.");
							window.location.href = "userGroup_Admin_CloseMobileAccount.php";			
								</script>';
						}
						else
						{
							header("Location:error.php?error_id=error");
						}
					}
					else
					{
						header("Location:error.php?error_id=error");
					}
				}
				else
				{
					header("Location:error.php?error_id=error");
				}
			}
		}
		else
		{
			header("Location:error.php?error_id=query error");
		}
	}
	else
	{
		header("Location:userGroup_Admin_CloseMobileAccount.php");
	}
}




?>