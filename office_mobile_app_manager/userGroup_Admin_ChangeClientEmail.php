<?php
include 'connect.php';
//
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
$inv_code = '';
$client_email = '';
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
				$client_email = $row['client_email'];
				$found_in = 'new';
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
						if($row1['client_email'] == null)
						{
							$client_email = "Not Available";
						}
						else
						{
							$client_email = $row1['client_email'];
						}
						$found_in = 'old';
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
		header("Location:userGroup_Admin_ChangeClientEmail_ui.php");
	}
}
else
{
	header("Location:userGroup_Admin_ChangeClientEmail_ui.php");
}


?>


<html>
<head>
<title></title>

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
		  <a class="dropdown-item" href="userGroup_Admin_EditPurchasePower.php">Change Purchase Power</a>
		  <a class="dropdown-item" href="userGroup_Admin_CloseMobileAccount.php">Deactivate Codes</a>
		  <a class="dropdown-item" href="userGroup_Admin_ActivateDeactivatedCodes_ui.php">Activate Deactive Codes</a>
		  <a class="dropdown-item" href="userGroup_Admin_CodeEntry.php">Code Entry</a>
		  <a class="dropdown-item" href="userGroup_Admin_SearchCode.php">Search Code</a>
		  <a class="dropdown-item" href="userGroup_Admin_ChangeClientEmail_ui.php">Change Client Email</a><!--incomplete -->
		  <a class="dropdown-item" href="userGroup_Admin_AllCodes.php">All Available Codes</a>
		  <a class="dropdown-item" href="userGroup_Admin_ChangePassword.php">Change Password</a>
		  <a class="dropdown-item" href="userGroup_Admin_CreateNewUser.php">Create New User</a>
		</div>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="#"><b>Change Client Email</b></a>
      </li>
    </ul>
    </div>
    <span class="nav navbar-nav navbar-right">
	<a href='logout_end_session.php'><button type="button" class="btn btn-light">Logout</button></a>
    <span>
</nav>

<center>
<form id = "form" action = "userGroup_Admin_ChangeClientEmail_Post.php" method = "POST">
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
            <th style="text-align:right">Existing Email: &nbsp;</th>
            <td>
            <input type="text" readonly class="form-control-plaintext" value="<?php echo $client_email; ?>">
            </td>
		</div>
	</tr>
	<tr>
		<div class="form-group">
			<td style="text-align:right"><label for="new_email">New Email address: &nbsp;</label></td>
			<td><input type="email" class="form-control" id="new_email" maxlength="80" placeholder="Enter email" name = "new_email" required></td>
		</div>
	</tr>
    
	<tr>
		<div class="form-group">
			<td><input type="hidden" name="found_in" value="<?php echo $found_in; ?>"></td>
		</div>	
	</tr>
	
	</table>
	<br>
		<button type="submit" class="btn btn-primary">Change Client Email</button>
	</form>

</center>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>


</html>



