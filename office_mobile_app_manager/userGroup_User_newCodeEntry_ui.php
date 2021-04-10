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

?>
<html>
    <head>
    <title></title>
    <script>
    function validateForm() {
      var x = document.forms["newCodeEntry"]["investor_code"].value;
      if (x.includes(" ") || x.includes("-") || x.includes("_") || x.includes("/") || x.includes("\\") || x.includes(".")) 
	  {
        alert("Space,'-', '_' not allowed in bo id");
        document.forms["newCodeEntry"]["investor_code"].value = '';
        return false;
      }
    }
    
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
		  <a class="dropdown-item" href="#">New Code Entry</a>
		  <a class="dropdown-item" href="userGroup_User_SearchCode.php">Search Code</a>
		  <a class="dropdown-item" href="userGroup_User_ChangePassword.php">Change Password</a><!--not created-->
        </div>
      </li>
	  
	  <li class="nav-item">
        <a class="nav-link" href="#"><b>New Code Entry</b></a>
      </li>
	  
    </ul>
    </div>
    <span class="nav navbar-nav navbar-right">
	<a href='logout_end_session.php'><button type="button" class="btn btn-light">Logout</button></a>
    <span>
</nav>
    <center>
        <form name = "newCodeEntry" id = "form" action = "userGroup_User_newCodeEntry.php" method = "POST" enctype="multipart/form-data">
            <table>
            <tr>	
            <div class="form-group">
			    <td style="text-align:right"><label for="investor_code">Investor Code: &nbsp;</label></td>
			    <td><input type="text" class="form-control" id="investor_code" placeholder="Enter Investor Code" name = "investor_code" onchange="return validateForm()" required></td>
            </div>
            </tr>

            <tr>
            <div class="form-group">
            <td style="text-align:right"><label for="email">Client Email: &nbsp;</label></td>
            <td><input type="email" class="form-control" id="email" maxlength="80" placeholder="Enter Email" name = "email" required></td>
            </div>    
            </tr>

            <tr>
            <div class="form-group">
            <td style="text-align:right"><label for="userfile">Upload: &nbsp;</label></td>
            <td>
            <input class="form-control" name="userfile" id = "userfile" type="file" onchange="return fileTypeValidation()" required>
            </td>		
            </div>
            </tr>
            </table>
            <br>
            <input class="btn btn-primary" type="submit" value="Save">
        </form>
        
    </center>


    
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>

</body>
</html>

