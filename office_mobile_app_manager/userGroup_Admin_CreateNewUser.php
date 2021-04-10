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

if(isset($_POST['new_email']) && isset($_POST['password']) && isset($_POST['user_group']))
{
	if($user_email != '')
	{
		$new_email = $_POST['new_email'];
		$password = $_POST['password'];
		$user_group = $_POST['user_group'];
		$branch = "Head Office";
		
		$query = "INSERT INTO user(email,password,branch,userGroup,loginStatus) VALUES('$new_email','$password','$branch','$user_group','logged_out')";
		$result = mysqli_query($link,$query);
		
		if($result)
		{
			echo '<script type="text/javascript"> 
				alert("New User Created Successfully.");			
			</script>';
		}
		else
		{
			echo '<script type="text/javascript"> 
				alert("User Already Exists, New User Creation Failed.");			
			</script>';
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
		  <a class="dropdown-item" href="userGroup_Admin_CodeEntry.php">Code Entry</a>
		  <a class="dropdown-item" href="userGroup_Admin_SearchCode.php">Search Code</a>
		  <a class="dropdown-item" href="userGroup_Admin_ChangeClientEmail_ui.php">Change Client Email</a><!--incomplete -->
		  <a class="dropdown-item" href="userGroup_Admin_AllCodes.php">All Available Codes</a><!--incomplete -->
		  <a class="dropdown-item" href="userGroup_Admin_ChangePassword.php">Change Password</a>
		  <a class="dropdown-item" href="#">Create New User</a>
        </div>
      </li>

	  <li class="nav-item">
        <a class="nav-link" href="#"><b>Create New User</b></a>
      </li>
    </ul>
    </div>
    <span class="nav navbar-nav navbar-right">
	<a href='logout_end_session.php'><button type="button" class="btn btn-light">Logout</button></a>
    <span>
</nav>

<center>

<form id = "form" action = "userGroup_Admin_CreateNewUser.php" method = "POST">
	<table>
	<tr>
		<div class="form-group">
			<td style="text-align:right"><label for="new_email">Email address: &nbsp;</label></td>
			<td><input type="email" class="form-control" id="new_email" aria-describedby="emailHelp" maxlength="80" placeholder="Enter email" name = "new_email" required></td>
		</div>
	</tr>
	<tr>
		<div class="form-group">
		<td style="text-align:right"><label for="password">Password: &nbsp;</label></td>
		<td><input type="text" class="form-control" id="password" maxlength="20" placeholder="Password" name = "password" required></td>
		</div>
	</tr>
	<tr>
		<div class="form-group">
            <td style="text-align:right">Select User Group: &nbsp;</td>
            <td>
                <select class="custom-select" name="user_group" required>
                <option value="">Please Select</option>
                <option value="User">User</option>
				<option value="Admin">Admin</option>
				<option value="Settlement">Settlement</option>
                </select>
            </td>
		</div>
	</tr>
	</table>
	<br>
		<button type="submit" class="btn btn-primary">Create New User</button>
</form>

</center>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>


</html>

