<?php
include 'connect.php';
session_start();

$user_email = '';
$purchase_power = '';
//
//deactive,90_percent->not_set
//deactive,90_percent->not_set

//deactive,set_90_percent->Ledger Balance
//deactive,set_90_percent->Ledger Balance

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
	if($user_email != '')
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
					if($row['purchase_power'] == "90_percent")
					{
						$purchase_power = "not_set";
					}
					else if($row['purchase_power'] == "set_90_percent")
					{
						$purchase_power = "Ledger Balance";
					}
					$query1 = "UPDATE documents SET status = 'Active', purchase_power = '$purchase_power' WHERE investor_code = '$inv_code'";
					$result1 = mysqli_query($link,$query1);
					if($result1)
					{
						echo '<script type="text/javascript"> 
						alert("Investor Code activated successfully in New Documents.");
						window.location.href = "userGroup_Admin_ActivateDeactivatedCodes_ui.php";			
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
							if($row1['purchase_power'] == "90_percent")
							{
								$purchase_power = "not_set";
							}
							else if($row1['purchase_power'] == "set_90_percent")
							{
								$purchase_power = "Ledger Balance";
							}
							$query3 = "UPDATE old_documents SET status = 'Active', purchase_power = '$purchase_power' WHERE investor_code = '$inv_code'";
							$result3 = mysqli_query($link,$query3);
							if($result3)
							{
								echo '<script type="text/javascript"> 
								alert("Investor Code activated successfully in Old Documents.");
								window.location.href = "userGroup_Admin_ActivateDeactivatedCodes_ui.php";			
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
			header("Location:userGroup_Admin_ActivateDeactivatedCodes_ui.php");
		}
		
	}
	else
	{
		header("Location:logout_end_session.php");
	}
}




?>