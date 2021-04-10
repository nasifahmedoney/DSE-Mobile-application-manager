<?php
include 'connect.php';
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
function before ($this_, $inthat)
{
    return substr($inthat, 0, strpos($inthat, $this_));
};

$inv_code = '';
if(isset($_GET['inv_code']))
{
	if($_GET['inv_code'] != null)
	{
		$inv_code = $_GET['inv_code'];
	}
	else
	{
		header("Location:userGroup_Settlement.php");
	}
}
else
{
    header("Location:userGroup_Settlement.php");
}

$document_url = '';
$client_email = '';
$open_date = '';
$status = '';//
$query = "SELECT * FROM documents WHERE investor_code = '$inv_code' AND status = 'Pending'";
$result = mysqli_query($link,$query);

if($result)
{
	$row = $result->fetch_array(MYSQLI_ASSOC);
	if(is_array($row))
	{
		$document_url = $row['app_dir'];
		$open_date = $row['open_date'];
		$client_email = $row['client_email'];
		$status = $row['status'];
    }
    else
    {
        header("Location:error.php?error_id='no row found'");
    }
}
else
{
    header("Location:error.php?error_id='query error'");
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
        <a class="nav-link" href="#"><b>View Application</b></a>
      </li>
    </ul>
    </div>
    <span class="nav navbar-nav navbar-right">
	<a href='logout_end_session.php'><button type="button" class="btn btn-light">Logout</button></a>
    <span>
</nav>

<center>

<form id = "form" action = "userGroup_Settlement_UpdateStatus.php" method = "POST">
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
            <th style="text-align:right">Client Email: &nbsp;</th>
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
            <input type="text" readonly class="form-control-plaintext" value="<?php echo $status; ?>">
            </td>
		</div>
	</tr>
    <tr>
		<div class="form-group">
            <th style="text-align:right">Update Status: &nbsp;</th>
            <td>
                <select class="custom-select" name="new_status" required>
                <option value="">Please Select</option>
                <option value="Approved">Approve</option>
                <option value="Reupload">Re-upload Document</option>
                </select>
            </td>
		</div>
	</tr>
	<tr>
		<div class="form-group">
			<th style="text-align:right">Remarks: &nbsp;</th>
			<td>
				<textarea class="form-control" id="remarks" placeholder="Enter remarks if any..." name="remarks" rows="2" maxlength="50"></textarea>	
			</td>
		</div>
	</tr>	
		
	</table>
	<br>
		<button type="submit" class="btn btn-primary">Update</button>
	</form>
</center>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>


</html>

