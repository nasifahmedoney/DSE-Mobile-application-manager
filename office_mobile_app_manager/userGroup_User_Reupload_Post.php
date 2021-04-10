<?php
//
include 'connect.php';

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


function before ($this_, $inthat)
{
    return substr($inthat, 0, strpos($inthat, $this_));
};
$success_msg = '';
//office
//$uploaddir = 'D:/uploads/';
//
//$uploaddir = 'C:/uploads/HeadOffice/';
//server
$uploaddir = 'C:/uploads/';
//server_office
//$uploaddir = 'F:/mobile_applications/';

if(isset($_POST['inv_code']) && $_FILES['userfile']['name'])
{
	$investor_code = $_POST['inv_code'];
	
	$tmp_filename = $_FILES['userfile']['tmp_name'];
	$file_name = $_FILES['userfile']['name'];
	$dir_checking = $uploaddir.$investor_code.'/';
	if($user_email != '')
	{
		if(is_dir($dir_checking)==true)
		{
			//Reupload
			array_map('unlink', glob($dir_checking.'/*.*'));
			$final_upload_dir = $dir_checking.$file_name;
			if(move_uploaded_file($tmp_filename, $final_upload_dir))
			{
				$query2 = "UPDATE documents SET app_dir = '$final_upload_dir',status = 'Pending' WHERE investor_code = '$investor_code'";
				$result2 = mysqli_query($link,$query2);
				if($result2)
				{
					if(file_exists($final_upload_dir))
					{
						$success_msg = "Document Reuploaded Successfully.";	
					}
					else
					{
						header("Location:error.php?error_id=final upload directory checking issue.");
					}
				}
				else
				{
					header("Location:error.php?error_id=query error");
				}
			}
			else
			{
				header("Location:error.php?error_id=error moving file to upload directory");
			}
		}
		else
		{
			header("Location:error.php?error_id=Directory Not Found");
		}
	}
	else
	{
		header("Location:logout_end_session.php");
	}
}
else
{
	echo "error";
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
<?php echo $success_msg; echo '<br>'; ?>
<a href="userGroup_User_Reupload_ui.php">Click here to see other reupload requested applications</a>
</center>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>


</html>
