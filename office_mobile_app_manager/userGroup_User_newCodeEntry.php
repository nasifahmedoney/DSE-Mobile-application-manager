<?php
include 'connect.php';
//
session_start();

$user_email = '';
$userGroup = '';
$branch = '';
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
	$user_email =  $_SESSION['email'];
	$userGroup =  $_SESSION['userGroup'];
	$branch =  $_SESSION['branch'];
}
//

function before ($this_, $inthat)
{
    return substr($inthat, 0, strpos($inthat, $this_));
};
	$success_msg = '';

	//$uploaddir = 'D:/uploads/';
	//
	//$uploaddir = 'C:/uploads/HeadOffice/';
	//server
	$uploaddir = 'C:/uploads/';
	//server_office
	//$uploaddir = 'F:/mobile_applications/';
	
	if(isset($_POST['investor_code']) && isset($_POST['email']))
	{
		$investor_code_userentry = $_POST['investor_code'];
		$investor_code = strtoupper($investor_code_userentry);
		$client_email = $_POST['email'];
		$tmp_filename = $_FILES['userfile']['tmp_name'];
		$file_name = $_FILES['userfile']['name'];
		$dir_checking = $uploaddir.$investor_code.'/';

		$query_result1 = '';
		$query_result2 = '';

		$query1 = "SELECT * FROM documents WHERE investor_code = '$investor_code'";
		$result1 = mysqli_query($link,$query1);
		if($result1)
		{
			$row = $result1->fetch_array(MYSQLI_ASSOC);
			if(is_array($row))
			{
				$query_result1 = $row;
			}
	
		}


		$query2 = "SELECT * FROM old_documents WHERE investor_code = '$investor_code'";
		$result2 = mysqli_query($link,$query2);

		if($result2)
		{
			$row = $result2->fetch_array(MYSQLI_ASSOC);
			if(is_array($row))
			{
				$query_result2 = $row;
			}
	
		}

		if(is_array($query_result1))
		{
			//header("Location:error.php?error_id=Error: code already exists in documents");
			echo '<script type="text/javascript"> 
			alert("code already exists in documents.");
			window.location.href = "userGroup_User_newCodeEntry_ui.php";			
				</script>';
		}
		else if(is_array($query_result2))//runs on old table
		{
			//header("Location:error.php?error_id=Error: code already exists in old documents");
			echo '<script type="text/javascript"> 
			alert("code already exists in old documents.");
			window.location.href = "userGroup_User_newCodeEntry_ui.php";			
				</script>';
		}
		else
		{
			if($user_email != '')
			{
				mkdir("$dir_checking",0700);
				$final_upload_dir = $dir_checking.$file_name;
				$query_insert = "INSERT INTO documents(email,branch,investor_code,client_email,status,app_dir) VALUES('$user_email','$branch','$investor_code','$client_email','Pending','$final_upload_dir')";
				$result_insert = mysqli_query($link,$query_insert);
				if($result_insert)
				{
					if(move_uploaded_file($tmp_filename, $final_upload_dir))
					{
						if(file_exists($final_upload_dir))
						{
							$success_msg = "New Mobile Application Successfully Created.";
						} 
					}
					else
					{
						header("Location:error.php?error_id=error movig file to upload directory");
					}
				}
				else
				{
					header("Location:error.php?error_id=insert query error");
				}
			}
			else
			{
				header("Location:logout_end_session.php");
			}
			
		}
	}
	/*

	for testing purpose
	echo "</p>";
	echo '<pre>';
	echo 'Here is some more debugging info:';
	print_r($_FILES);
	print "</pre>";	
	*/
	
	//if(is_dir($dir_checking)==true)
	//	{
			/* Reupload
			array_map('unlink', glob($dir_checking.'/*.*'));
			$final_upload_dir = $dir_checking.$file_name;
			if(move_uploaded_file($tmp_filename, $final_upload_dir))
			{
				//header redirect to user page where query runs for displaying data
				//run query
			}
			else
			{
				//alert
			}
			*/
			//file already exists run query redirect to application page

	//	}
	//	else
	//	{
	//		mkdir("$dir_checking",0700);
	//		$final_upload_dir = $dir_checking.$file_name;
	//		if(move_uploaded_file($tmp_filename, $final_upload_dir))
	//		{
	//			//header redirect to user page where query runs for displaying data
	//			//run query
	//			header("Location:userGroup_User.php");
	//		}
	//		else
	//		{
	//			//alert
	//		}
	//	}

		

?>

<!--
<html>
<head>
<title></title>

<script>
function validateForm() {
  var x = document.forms["newCodeEntry"]["bo_id"].value;
  if (x.includes(" ")) {
    alert("Space not allowed in bo id");
    return false;
  }
}

function fileTypeValidation()
{
	var filePath = document.getElementById('userfile').value;
    var allowedExtensions = /(\.pdf)$/i;
    if(!allowedExtensions.exec(filePath)){
        alert('Please upload PDF file only.');
        fileInput.value = '';
        return false;
    }
}
</script>
</head>
<body>
<center>
	<form name = "newCodeEntry" id = "form" action = "userGroup_User_newCodeEntry.php" method = "POST" enctype="multipart/form-data">
		<table>
		<tr>
		<td>	
		<label for = "bo_id">Bo Code:</label>
		</td>
		<td>
		<input type = "text" id = "bo_id" name = "bo_id" onchange="return validateForm()" required>
		</td>
		</tr>
		<tr>
		<td>
		<label for = "email">Email:</label>
		</td>
		<td>
		<input type = "email" id = "email" name = "email" required>
		</td>
		</tr>
		<tr>
		<td>
		<input name="userfile" id = "userfile" type="file" onchange="return fileTypeValidation()" required>
		</td>		
		</tr>
		</table>
		<br>
		<input type = "submit" value = "Save">
	</form>
	
	<button type="submit" class="btn btn-default"><a href = 'logout_end_session.php'>Logout</a></button>
</center>
</body>
</html>
-->
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
        <a class="nav-link" href="#"><b>Pending Codes</b></a>
      </li>
	  
    </ul>
    </div>
    <span class="nav navbar-nav navbar-right">
	<a href='logout_end_session.php'><button type="button" class="btn btn-light">Logout</button></a>
    <span>
</nav>

<center>
<?php echo $success_msg; echo '<br>'; ?>
<a href="userGroup_User_Pending.php">Click here to see application status</a>
</center>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>


</html>
