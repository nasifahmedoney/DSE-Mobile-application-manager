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
else if($_SESSION['userGroup'] != "User")
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




//this page
$inv_code = '';
$client_email = '';
$status = '';
$document_url = '';
$remarks = '';
//get method from reupload_ui
if(isset($_GET['inv_code']))
{
	if($_GET['inv_code'] != null)
	{
		$inv_code = $_GET['inv_code'];
		$query1 = "SELECT * FROM documents WHERE investor_code = '$inv_code'";
		$result1 = mysqli_query($link,$query1);
		if($result1)
		{
			$row = $result1->fetch_array(MYSQLI_ASSOC);
			if(is_array($row))
			{
				$client_email = $row['client_email'];
				$status = $row['status'];
				$document_url = $row['app_dir'];
				$remarks = $row['remarks'];
			}
		}
	}
	else
	{
		header("Location:userGroup_User_Reupload_ui.php");
	}
}
else
{
	header("Location:userGroup_User_Reupload_ui.php");
}


//post method reupload



?>





<html>
<head>
<title></title>
<script>
    function fileTypeValidation()
    {
        var filePath = document.getElementById('userfile').value;
        var allowedExtensions = /(\.pdf)$/i;
        if(!allowedExtensions.exec(filePath)){
            alert('Please upload PDF file only.');
            document.getElementById('userfile').value = '';
            return false;
        }
		else
		{
			var fileSize = document.getElementById('userfile').files[0].size / 1024 / 1024; // in MiB
			if (fileSize > 2) 
			{
				alert('File size should be less than 2 MB');
			    document.getElementById('userfile').value = '';
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
<a class="navbar-brand" href="userGroup_User.php" ><?php echo before('@',$user_email); ?></a>
    
    <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
	  <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Options
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="userGroup_User_Pending.php">Pending Codes</a>
          <a class="dropdown-item" href="userGroup_User_Approved.php">Approved Codes</a>
          <a class="dropdown-item" href="userGroup_User_Reupload_ui.php">Reupload Requests</a><!--not created-->
		  <a class="dropdown-item" href="userGroup_User_newCodeEntry_ui.php">New Code Entry</a>
		  <a class="dropdown-item" href="userGroup_User_SearchCode.php">Search Code</a>
		  <a class="dropdown-item" href="userGroup_User_ChangePassword.php">Change Password</a><!--not created-->
        </div>
      </li>
	  
	  <li class="nav-item">
        <a class="nav-link" href="#"><b>Reupload</b></a>
      </li>
	  
    </ul>
    </div>
    <span class="nav navbar-nav navbar-right">
	<a href='logout_end_session.php'><button type="button" class="btn btn-light">Logout</button></a>
    <span>
</nav>

<center>

<!--edit -->
<form id = "form" action = "userGroup_User_Reupload_Post.php" method = "POST" enctype="multipart/form-data">
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
					<th style="text-align:right">Previous Uploaded Document: &nbsp;</th>
					<td>
					<a href="user_openpdf.php?app_dir=<?php echo $document_url; ?>" target = "_blank"><button type="button" class="btn btn-secondary">View Document</button></a>
					</td>
				</div>
			</tr>
			<tr>
				<div class="form-group">
					<th style="text-align:right">Remarks: &nbsp;</th>
					<td>
					<textarea readonly class="form-control-plaintext" id="remarks" rows="1" maxlength="50"><?php echo $remarks; ?></textarea>
					</td>
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
				<th style="text-align:right"><label for="userfile">Reupload New Document: &nbsp;</label></th>
				<td>
					<input class="form-control" name="userfile" id = "userfile" type="file" onchange="return fileTypeValidation()" required>
				</td>		
            </div>
            </tr>
            </table>
            <br>
            <input class="btn btn-primary" type="submit" value="Reupload">
        </form>

</center>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>


</html>