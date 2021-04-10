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

$success_count = 0;
if(isset($_POST['inv_codes_new']))
{
	if($user_email != '')
	{
		$codes_to_approve = $_POST['inv_codes_new'];
		$purchase_power = 'Ledger Balance';
		$total = count($codes_to_approve);
		
		for($x = 0; $x < $total; $x++)
		{
			$codes = strval($codes_to_approve[$x]);
			
			$query = "UPDATE documents SET purchase_power = '$purchase_power' WHERE investor_code = '$codes'";
			$result = mysqli_query($link,$query);
		
			if($result)
			{
				$success_count++;
			}
			else
			{
				header("Location:error.php?error_id=query error");
			}
			
		}
		if($success_count == $total)
		{
			echo '<script type="text/javascript"> 
				alert("Purchase power set successfully.");
				window.location.href = "userGroup_Admin_SetPurchasePower.php";			
			</script>';
		}
		else
		{
			header("Location:error.php?error_id=query execution error");
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
<style>
.tableposition {
    position: fixed;
	top: 50%;
    left: 50%;
	height: 75%;
	overflow: auto;
	transform: translate(-50%,-50%);
	text-align:center;
}
</style>
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
        <a class="nav-link" href="#"><b>Add Purchase Power</b></a>
      </li>
	  
    </ul>
    </div>
    <span class="nav navbar-nav navbar-right">
	<a href='logout_end_session.php'><button type="button" class="btn btn-light">Logout</button></a>
    <span>
</nav>

<div class="tableposition">

<?php echo '<b>New Mobile Application Codes From New Database</b>';echo '<br><p></p>'; ?>

<form id = "form" action = "userGroup_Admin_AddPurchasePower.php" method = "POST">

<table class="table table-bordered">
  <thead>
    <tr>
     
      <th scope="col">Investor Code</th>
      
    </tr>
  </thead>
<?php

$query = "SELECT * FROM documents WHERE status = 'Active' AND purchase_power ='not_set'";
//$query = "SELECT * FROM documents WHERE status = 'Approved' AND purchase_power = 'null'";
$result = mysqli_query($link,$query);

if($result)
{
    while($row = $result->fetch_array(MYSQLI_ASSOC))
    {
        if(is_array($row))
        {
            ?>
            <tbody>
                <tr>
                    <td><input type="hidden" name="inv_codes_new[]" value="<?php echo $row['investor_code']; ?>"><?php echo $row['investor_code']; ?></td>
                </tr>
            </tbody>

            <?php
        }
        else
        {
            header("Location:error.php?error_id=Row error");
        }
    }
}
else
{
    header("Location:error.php?error_id=Query error");
}

?>

</table>

<button type="submit" class="btn btn-primary">Approve All</button>

</form>
</div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>


</html>


