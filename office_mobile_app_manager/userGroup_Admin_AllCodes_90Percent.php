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

?>


<html>
<head>
<title></title>
<style>
.tableposition {
    position: fixed;
    width: 90%;
	top: 20%;
    left: 5%;
	height: 75%;
	overflow: auto;
}
</style>
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
		  <a class="dropdown-item" href="userGroup_Admin_AllCodes.php">All Available Codes</a><!--incomplete -->
		  <a class="dropdown-item" href="userGroup_Admin_ChangePassword.php">Change Password</a>
		  <a class="dropdown-item" href="userGroup_Admin_CreateNewUser.php">Create New User</a>
		</div>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="#"><b>90 Percent(Scan Document Available)</b></a>
      </li>
    </ul>
    </div>
    <span class="nav navbar-nav navbar-right">
	<a href='logout_end_session.php'><button type="button" class="btn btn-light">Logout</button></a>
    <span>
</nav>

<div class="tableposition">
<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">Initiated by</th>
      <th scope="col">Investor Code</th>
      <th scope="col">Status</th>
	  <th scope="col">Client Email</th>
      <th scope="col">View Application</th>
    </tr>
  </thead>


<?php
$query = "SELECT * FROM documents WHERE status = 'Active' AND purchase_power = '90_percent' ORDER BY doc_id DESC";
$result = mysqli_query($link,$query);

if($result)
{
    while($row = $result->fetch_array(MYSQLI_ASSOC))
    {
        if(is_array($row))
        {
            //php end html start
            ?>
            
            <tbody>
                <tr>
                    <td><?php echo $row['email']; ?></th>
                    <td><?php echo $row['investor_code']; ?></td>
                    <td><?php echo $row['status']; ?></td>
					<td><?php echo $row['client_email']; ?></td>
                    <td><a href="user_openpdf.php?app_dir=<?php echo $row['app_dir']; ?>" target = "_blank">Document</a></td>
                </tr>
            </tbody>
            
            <?php
            //html end php start
        }
        else
        {
            header("Location:error.php");
        }
    }
}
else
{
    header("Location:error.php");
}

//php end
?>
  
</table>
</div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>


</html>



