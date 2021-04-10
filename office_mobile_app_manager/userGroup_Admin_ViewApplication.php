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

$inv_code = '';
if(isset($_GET['inv_code']))
{
	$inv_code = $_GET['inv_code'];
	if($inv_code==null)
	{
		header("Location:userGroup_Admin_ActivateCodes.php");
	}
    
}


$document_url = '';
$present_status = '';//dropdown
$open_date = '';
$client_email = '';
$query = "SELECT * FROM documents WHERE investor_code = '$inv_code' AND status = 'Approved'";
$result = mysqli_query($link,$query);

if($result)
{
	$row = $result->fetch_array(MYSQLI_ASSOC);
	if(is_array($row))
	{
		$document_url = $row['app_dir'];
		$open_date = $row['open_date'];
		$present_status = $row['status'];
		$client_email = $row['client_email'];
    }
    else
    {
        header("Location:error.php?error_id=no row found");
    }
	
}
else
{
    header("Location:error.php?error_id=query error");
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
		  <a class="dropdown-item" href="userGroup_Admin_CreateNewUser.php">Create New User</a>
		</div>
      </li>
	  
	  <li class="nav-item">
        <a class="nav-link" href="#"><b>View Application</b></a>
      </li>
	 
    </ul>
    </div>
    <span class="nav navbar-nav navbar-right">
	<a href='logout_end_session.php'><button type="button" class="btn btn-light">Logout</button></a>
    <span>
</nav>

<center>

<form id = "form" action = "userGroup_Admin_UpdateStatus.php" method = "POST">
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
            <th style="text-align:right">Investor Email: &nbsp;</th>
            <td>
            <input type="text" readonly class="form-control-plaintext" value="<?php echo $client_email; ?>">
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
            <th style="text-align:right">Present Status: &nbsp;</th>
            <td>
            <input type="text" readonly class="form-control-plaintext" value="<?php echo $present_status; ?>">
            </td>
		</div>
	</tr>
    <tr>
		<div class="form-group">
            <th style="text-align:right">Update Status: &nbsp;</th>
            <td>
                <select class="custom-select" name="new_status" required>
                <option value="">Please Select</option>
                <option value="Active">Activate</option>
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

