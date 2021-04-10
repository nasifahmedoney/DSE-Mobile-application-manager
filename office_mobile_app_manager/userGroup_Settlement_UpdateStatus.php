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
else if($_SESSION['userGroup'] != "Settlement")
{
	header("Location:logout_end_session.php");
}
else
{
	$user_email = $_SESSION['email'];
	$userGroup = $_SESSION['userGroup'];
}
//
function before ($this_, $inthat)
{
    return substr($inthat, 0, strpos($inthat, $this_));
};

$success_msg = '';
if(isset($_POST['inv_code']) && isset($_POST['new_status']))
{
	if($user_email != '')
	{
		$investor_code = $_POST['inv_code'];
		$new_status = $_POST['new_status'];
		$remarks = 'No remarks';
		if(!empty($_POST['remarks']))
		{
			$remarks = $_POST['remarks'];
		}
		
		$query = "UPDATE documents SET status = '$new_status',approved_by = '$user_email',remarks = '$remarks'  WHERE investor_code = '$investor_code'";
		$result = mysqli_query($link,$query);
		
		if($result)
		{
			$success_msg = "Application Status Updated Successfully."; 
		}
		else
		{
			header("Location:error.php?error_id=error updating application status");
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


<html>
<head>
<title></title>

<link rel="stylesheet" href="css/center.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
<a class="navbar-brand" href="userGroup_Settlement.php" ><?php echo before('@',$user_email); ?></a>
    
    <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
	  <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Options
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="userGroup_Settlement_Pending.php">Pending Codes</a>
          <a class="dropdown-item" href="userGroup_Settlement_Approved.php">Approved Codes</a>
          <a class="dropdown-item" href="userGroup_Settlement_Reupload.php">Reupload Requested</a>
		  <a class="dropdown-item" href="userGroup_Settlement_SearchCode.php">Search Code</a>
		  <a class="dropdown-item" href="userGroup_Settlement_ChangePassword.php">Change Password</a>
        </div>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="#"><b>Update Application Status</b></a>
      </li>
    </ul>
    </div>
    <span class="nav navbar-nav navbar-right">
	<a href='logout_end_session.php'><button type="button" class="btn btn-light">Logout</button></a>
    <span>
</nav>

<center>

<?php echo $success_msg;echo '<br>' ?>
<a href="userGroup_Settlement_Pending.php">Click here to view other pending codes</a>


</center>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>


</html>
