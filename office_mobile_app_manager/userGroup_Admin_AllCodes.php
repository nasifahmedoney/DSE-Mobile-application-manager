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
//$query = "COUNT(SELECT * FROM documents WHERE status = 'Active' AND purchase_power = 'Ledger Balance' ORDER BY doc_id DESC)";

$ledgerBalanceDoc = '';
$query1 = "SELECT COUNT(*) FROM documents WHERE status = 'Active' AND purchase_power = 'Ledger Balance'";
$result1 = mysqli_query($link,$query1);

if($result1)
{
	$row1 = $result1->fetch_array(MYSQLI_ASSOC);
	if(is_array($row1))
	{
		$ledgerBalanceDoc = $row1['COUNT(*)'];
	}
}

$ledgerBalanceNoDoc = '';
$query2 = "SELECT COUNT(*) FROM old_documents WHERE status = 'Active' AND purchase_power = 'Ledger Balance'";
$result2 = mysqli_query($link,$query2);

if($result2)
{
	$row2 = $result2->fetch_array(MYSQLI_ASSOC);
	if(is_array($row2))
	{
		$ledgerBalanceNoDoc = $row2['COUNT(*)'];
	}
}

$ninetyPercentDoc = '';
$query3 = "SELECT COUNT(*) FROM documents WHERE status = 'Active' AND purchase_power = '90_percent'";
$result3 = mysqli_query($link,$query3);

if($result3)
{
	$row3 = $result3->fetch_array(MYSQLI_ASSOC);
	if(is_array($row3))
	{
		$ninetyPercentDoc = $row3['COUNT(*)'];
	}
}

$ninetyPercentNoDoc = '';
$query4 = "SELECT COUNT(*) FROM old_documents WHERE status = 'Active' AND purchase_power = '90_percent'";
$result4 = mysqli_query($link,$query4);

if($result4)
{
	$row4 = $result4->fetch_array(MYSQLI_ASSOC);
	if(is_array($row4))
	{
		$ninetyPercentNoDoc = $row4['COUNT(*)'];
	}
}


$deactiveCodes1 = '';
$deactiveCodes2 = '';

$query5 = "SELECT COUNT(*) FROM documents WHERE status = 'Deactive'";
$result5 = mysqli_query($link,$query5);

if($result5)
{
	$row5 = $result5->fetch_array(MYSQLI_ASSOC);
	if(is_array($row5))
	{
		$deactiveCodes1 = $row5['COUNT(*)'];
	}
}

$query6 = "SELECT COUNT(*) FROM old_documents WHERE status = 'Deactive'";
$result6 = mysqli_query($link,$query6);
if($result6)
{
	$row6 = $result6->fetch_array(MYSQLI_ASSOC);
	if(is_array($row6))
	{
		$deactiveCodes2 = $row6['COUNT(*)'];
	}
}
$deactiveCodes = $deactiveCodes1+$deactiveCodes2;

$pending_codes = '';
$query7 = "SELECT COUNT(*) FROM documents WHERE status = 'Pending'";
$result7 = mysqli_query($link,$query7);
if($result7)
{
	$row7 = $result7->fetch_array(MYSQLI_ASSOC);
	if(is_array($row7))
	{
		$pending_codes = $row7['COUNT(*)'];
	}
}

$approved_codes = '';
$query8 = "SELECT COUNT(*) FROM documents WHERE status = 'Approved'";
$result8 = mysqli_query($link,$query8);
if($result8)
{
	$row8 = $result8->fetch_array(MYSQLI_ASSOC);
	if(is_array($row8))
	{
		$approved_codes = $row8['COUNT(*)'];
	}
}

$reupload_req = '';
$query9 = "SELECT COUNT(*) FROM documents WHERE status = 'Reupload'";
$result9 = mysqli_query($link,$query9);
if($result9)
{
	$row9 = $result9->fetch_array(MYSQLI_ASSOC);
	if(is_array($row9))
	{
		$reupload_req = $row9['COUNT(*)'];
	}
}
?>


<html>
<head>
<title></title>
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
		  <a class="dropdown-item" href="#">All Available Codes</a>
		  <a class="dropdown-item" href="userGroup_Admin_ChangePassword.php">Change Password</a>
		  <a class="dropdown-item" href="userGroup_Admin_CreateNewUser.php">Create New User</a>
		</div>
      </li>
	  <li class="nav-item">
        <a class="nav-link" href="#"><b>All Available Codes</b></a>
      </li>
    </ul>
    </div>
    <span class="nav navbar-nav navbar-right">
	<a href='logout_end_session.php'><button type="button" class="btn btn-light">Logout</button></a>
    <span>
</nav>

<div class="tableposition">
<?php echo "Total Active Mobile Application Codes With Ledger Balance: ";echo $ledgerBalanceDoc+$ledgerBalanceNoDoc; ?><br>
<?php echo "Total Active Mobile Application Codes With 90 percent Balance: ";echo $ninetyPercentDoc+$ninetyPercentNoDoc; ?><br>
<?php echo "Total Deactive/Cancelled Mobile Application Codes: ";echo $deactiveCodes; ?><br>
<hr>
<a class="btn btn-light" href="userGroup_Admin_AllCodes_LedgerBalance.php" role="button">Ledger Balance (Scan Document Available) - <?php echo $ledgerBalanceDoc; ?></a>
<hr>
<a class="btn btn-light" href="userGroup_Admin_AllCodes_LedgerBalance_old.php" role="button">Ledger Balance (Scan Document Not Available) - <?php echo $ledgerBalanceNoDoc; ?></a>
<hr>
<a class="btn btn-light" href="userGroup_Admin_AllCodes_90Percent.php" role="button">90 Percent (Scan Document Available) - <?php echo $ninetyPercentDoc; ?></a>
<hr>
<a class="btn btn-light" href="userGroup_Admin_AllCodes_90Percent_old.php" role="button">90 Percent (Scan Document Not Available) - <?php echo $ninetyPercentNoDoc; ?></a>
<hr>
<a class="btn btn-light" href="userGroup_Admin_AllCodes_deactive.php" target = "_blank" role="button">Deactive Codes - <?php echo $deactiveCodes; ?></a>
<hr>
<a class="btn btn-light" href="userGroup_Admin_AllCodes_Pending.php" role="button">All Pending Codes - <?php echo $pending_codes; ?></a>
<hr>
<a class="btn btn-light" href="userGroup_Admin_AllCodes_Approved.php" role="button">All Approved Codes - <?php echo $approved_codes; ?></a>
<hr>
<a class="btn btn-light" href="userGroup_Admin_AllCodes_Reupload.php" role="button">All Reupload Requested Codes - <?php echo $reupload_req; ?></a>

</div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>


</html>



