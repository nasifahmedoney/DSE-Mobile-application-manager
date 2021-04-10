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

function before ($this_, $inthat)
{
    return substr($inthat, 0, strpos($inthat, $this_));
};
$inv_code = '';
$document_url = '';
$present_status = '';
$purchase_power = '';
$open_date = '';
$found_in = '';
if(isset($_GET['inv_code']))
{
	$inv_code = $_GET['inv_code'];
	if($inv_code!='')
	{
		$inv_code = $_GET['inv_code'];
		
		$query = "SELECT * FROM documents WHERE investor_code = '$inv_code'";
		$result = mysqli_query($link,$query);

		if($result)
		{
			$row = $result->fetch_array(MYSQLI_ASSOC);
			if(is_array($row))
			{
				$document_url = $row['app_dir'];
				$open_date = $row['open_date'];
				$present_status = $row['status'];
				$purchase_power = $row['purchase_power'];
				$found_in = "new";
			}
			else
			{
				$query1 = "SELECT * FROM old_documents WHERE investor_code = '$inv_code'";
				$result1 = mysqli_query($link,$query1);
				if($result1)
				{
					$row1 = $result1->fetch_array(MYSQLI_ASSOC);
					if(is_array($row1))
					{
						$document_url = $row1['app_dir'];
						$open_date = "Not Available";
						$present_status = $row1['status'];
						$purchase_power = $row1['purchase_power'];
						$found_in = "old";
					}
					else
					{
						header("Location:error.php?error_id=query error row not found000");
					}
				}
				else
				{
					header("Location:error.php?error_id='query error'");
				}
			}
		}
		else
		{
			header("Location:error.php?error_id='query error'");
		}
	}
	else
	{
		header("Location:userGroup_Admin_EditPurchasePower.php");
	}
}
else
{
	header("Location:userGroup_Admin_EditPurchasePower.php");
}
?>




<html>
<head>
<title></title>
<script>
function validateformdata() {
      var x = document.forms["purchase_power_form"]["purchase_power"].value;
	  var y = document.forms["purchase_power_form"]["new_purchase_power"].value;
      if (x == "Ledger Balance" || x == "not_set") 
	  {
		if(y == "not_set")
		{
			alert("Ledger Balance already set");
			document.forms["purchase_power_form"]["new_purchase_power"].value= '';
			return false;
		}
      }
	  else if(x == "90_percent" || x == "set_90_percent")
	  {
		if(y == "set_90_percent")
		{
			alert("90 percent already set");
			document.forms["purchase_power_form"]["new_purchase_power"].value= '';
			return false;
		}  
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
		  <a class="dropdown-item" href="userGroup_Admin_CloseMobileAccount.php">Deactivate Code</a>
		  <a class="dropdown-item" href="userGroup_Admin_ActivateDeactivatedCodes_ui.php">Activate Deactive Codes</a>
		  <a class="dropdown-item" href="userGroup_Admin_CodeEntry.php">Code Entry</a>
		  <a class="dropdown-item" href="userGroup_Admin_SearchCode.php">Search Code</a>
		  <a class="dropdown-item" href="userGroup_Admin_ChangeClientEmail_ui.php">Change Client Email</a><!--incomplete -->
		  <a class="dropdown-item" href="userGroup_Admin_AllCodes.php">All Avalable Codes</a><!--incomplete -->
		  <a class="dropdown-item" href="userGroup_Admin_ChangePassword.php">Change Password</a>
		  <a class="dropdown-item" href="userGroup_Admin_CreateNewUser.php">Create New User</a>
        </div>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="#"><b>Change Purchase Power</b></a>
      </li>
    </ul>
    </div>
    <span class="nav navbar-nav navbar-right">
	<a href='logout_end_session.php'><button type="button" class="btn btn-light">Logout</button></a>
    <span>
</nav>

<center>
	<form name = "purchase_power_form" id = "form" action = "userGroup_Admin_ProcessEdit.php" method = "POST">
	<table>
	<tr>
		<div class="form-group">
            <th style="text-align:right">Investor Code: &nbsp;</th>
            <td>
            <input type="text" readonly class="form-control-plaintext" value="<?php echo $inv_code; ?>" name="inv_code">
            </td>
		</div>
	</tr>
	<tr>
		<div class="form-group">
            <th style="text-align:right">Opening Date: &nbsp;</th>
            <td>
            <input type="text" readonly class="form-control-plaintext" value="<?php echo $open_date; ?>">
            </td>
		</div>
	</tr>
	<tr>
		<div class="form-group">
            <th style="text-align:right">View Application: &nbsp;</th>
            <td><a href="user_openpdf.php?app_dir=<?php echo $document_url; ?>" target = "_blank"><button type="button" class="btn btn-secondary">Document</button></a></td>
		</div>
	</tr>
	<tr>
		<div class="form-group">
            <th style="text-align:right">Current Purchase Power: &nbsp;</th>
            <td>
            <input type="text" readonly class="form-control-plaintext" value="<?php echo $purchase_power; ?>" name = "purchase_power">
            </td>
		</div>
	</tr>
    <tr>
		<div class="form-group">
            <th style="text-align:right">Update Purchase Power: &nbsp;</th>
            <td>
                <select class="custom-select" name="new_purchase_power" required>
                <option value="">Please Select</option>
                <option value="not_set">Ledger Balance</option>
				<option value="set_90_percent">90 Percent</option>
                </select>
            </td>
		</div>
	</tr>
	<tr>
		<div class="form-group">
			<td><input type="hidden" name="found_in" value="<?php echo $found_in; ?>"></td>
		</div>	
	</tr>
	
	</table>
	<br>
		<button type="submit" onclick="return validateformdata()" class="btn btn-primary">Update</button>
	</form>

</center>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>


</html>

