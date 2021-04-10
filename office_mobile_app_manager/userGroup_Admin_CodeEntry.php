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

function before ($this_, $inthat)
{
    return substr($inthat, 0, strpos($inthat, $this_));
};


//search results on both databases
$query_result1 = '';
$query_result2 = '';

//display on table

if(isset($_POST['investor_code']) && isset($_POST['purchase_power']) && isset($_POST['client_email']) )
{
	if($user_email != '')
	{
		$investor_code_userentry = $_POST['investor_code'];
		$investor_code = strtoupper($investor_code_userentry);
		
		$purchase_power = $_POST['purchase_power'];
		$client_email = $_POST['client_email'];
		$query1 = "SELECT * FROM documents WHERE investor_code = '$investor_code'";
		$result1 = mysqli_query($link,$query1);
		if($result1)
		{
			$row = $result1->fetch_array(MYSQLI_ASSOC);
			if(is_array($row))
			{
				$query_result1 = $row;
			}
		}
		$query2 = "SELECT * FROM old_documents WHERE investor_code = '$investor_code'";
		$result2 = mysqli_query($link,$query2);
		
		if($result2)
		{
			$row = $result2->fetch_array(MYSQLI_ASSOC);
			if(is_array($row))
			{
				$query_result2 = $row;
			}
			
		}
		
		if(is_array($query_result1))//runs on new table
		{
		  
			echo '<script type="text/javascript"> 
					alert("Code already exists.Please search code for details");
					window.location.href = "userGroup_Admin_SearchCode.php";			
					</script>';
		}
		else if(is_array($query_result2))//runs on old table
		{
			echo '<script type="text/javascript"> 
					alert("Code already exists.Please search code for details");
					window.location.href = "userGroup_Admin_SearchCode.php";			
					</script>';
		}
		else
		{
			$query_insert = "INSERT INTO old_documents(investor_code,status,purchase_power,client_email) VALUES('$investor_code','Active','$purchase_power','$client_email')";
			$result_insert = mysqli_query($link,$query_insert);
			if($result_insert)
			{
				echo '<script type="text/javascript"> 
					alert("Code Entry Successfull.");
					window.location.href = "userGroup_Admin.php";			
					</script>';
			}
		}
	}
	else
	{
		header("Location:logout_end_session.php");
	}
}
?>


<html>
<head>
<title></title>
<script>
    function validateForm() {
      var x = document.forms["admin_entry_form"]["investor_code"].value;
      if (x.includes(" ") || x.includes("-") || x.includes("_") || x.includes("/") || x.includes("\\") || x.includes(".")) {
        alert("Space, - , _ not allowed in Investor Code");
        document.forms["admin_entry_form"]["investor_code"].value = '';
        return false;
      }
    }

</script>
<link rel="stylesheet" href="css/center.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
<a class="navbar-brand" href="userGroup_Admin.php" ><?php echo before('@',$user_email); ?></a>
    
    <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
	  <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Options
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="userGroup_Admin_SetPurchasePower.php">Set Purchase Power</a>
          <a class="dropdown-item" href="userGroup_Admin_ActivateCodes.php">Activate Codes</a>
		  <a class="dropdown-item" href="userGroup_Admin_EditPurchasePower.php">Change Purchase Power</a><!--incomplete -->
		  <a class="dropdown-item" href="userGroup_Admin_CloseMobileAccount.php">Deactivate Codes</a>
		  <a class="dropdown-item" href="userGroup_Admin_ActivateDeactivatedCodes_ui.php">Activate Deactive Codes</a>
		  <a class="dropdown-item" href="#">Code Entry</a>
		  <a class="dropdown-item" href="userGroup_Admin_SearchCode.php">Search Code</a>
		  <a class="dropdown-item" href="userGroup_Admin_ChangeClientEmail_ui.php">Change Client Email</a><!--incomplete -->
		  <a class="dropdown-item" href="userGroup_Admin_AllCodes.php">All Available Codes</a><!--incomplete -->
		  <a class="dropdown-item" href="userGroup_Admin_ChangePassword.php">Change Password</a>
		  <a class="dropdown-item" href="userGroup_Admin_CreateNewUser.php">Create New User</a>
        </div>
      </li>
	 
	  <li class="nav-item">
        <a class="nav-link" href="#"><b>New Code Entry Without Scan Document</b></a>
      </li>
	
    </ul>
    </div>
    <span class="nav navbar-nav navbar-right">
	<a href='logout_end_session.php'><button type="button" class="btn btn-light">Logout</button></a>
    <span>
</nav>

<center>

<form name = "admin_entry_form" id = "form" action = "userGroup_Admin_CodeEntry.php" method = "POST">
	<table>
	<tr>
		<div class="form-group">
			<td style="text-align:right"><label for="investor_code">Investor Code: &nbsp;</label></td>
			<td><input type="text" class="form-control" id="investor_code" placeholder="Enter investor code" onchange="return validateForm()" name = "investor_code" required></td>
		</div>
	</tr>
	<tr>
		<div class="form-group">
			<td style="text-align:right"><label for="client_email">Client Email: &nbsp;</label></td>
			<td><input type="email" class="form-control" id="client_email" placeholder="Enter Client Email" maxlength="80" name = "client_email" required></td>
		</div>
	</tr>
    <tr>
		<div class="form-group">
            <td style="text-align:right">Purchase Power: &nbsp;</td>
            <td>
                <select class="custom-select" name="purchase_power" required>
                <option value="">Please Select</option>
                <option value="not_set">Ledger Balance</option>
				<option value="90_percent">90 Percent</option>
                </select>
            </td>
		</div>
	</tr>
	</table>
	<br>
		<button type="submit" class="btn btn-primary">Save</button>
</form>

</center>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>


</html>



