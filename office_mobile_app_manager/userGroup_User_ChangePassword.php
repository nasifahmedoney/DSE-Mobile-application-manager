<?php
include 'connect.php';
session_start();

$user_email = '';
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
}

function before ($this_, $inthat)
{
    return substr($inthat, 0, strpos($inthat, $this_));
};

if(isset($_POST["new_password"]))
{
	if($user_email != '')
	{
		$new_password = $_POST["new_password"];
		$query = "UPDATE user SET password = '$new_password' WHERE email = '$user_email'";
		$result = mysqli_query($link,$query);
		
		if($result)
		{
			echo '<script type="text/javascript"> 
				alert("Password Successfully Changed."); 
				window.location.href = "userGroup_User.php";
			</script>';
		}
		else
		{
			header("Location:error.php?error_id=password Change query error");
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
<title></title>
<script>
function passwordMatch() {
      var x = document.forms["change_password"]["new_password"].value;
	  var y = document.forms["change_password"]["confirm_new_password"].value;
      if (x != y) {
        alert("passwords does not match");
        document.forms["change_password"]["new_password"].value = '';
		document.forms["change_password"]["confirm_new_password"].value= '';
        return false;
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
		  <a class="dropdown-item" href="#">Change Password</a><!--not created-->
        </div>
      </li>
	  
	  <li class="nav-item">
        <a class="nav-link" href="#"><b>Change Password</b></a>
      </li>
	  
    </ul>
    </div>
    <span class="nav navbar-nav navbar-right">
	<a href='logout_end_session.php'><button type="button" class="btn btn-light">Logout</button></a>
    <span>
</nav>

<center>

		<form name = "change_password" id = "form" action = "userGroup_User_ChangePassword.php" method = "POST">
            <table>
            <tr>	
            <div class="form-group">
			    <td style="text-align:right"><label for="new_password">Enter New Password: &nbsp;</label></td>
			    <td><input type="password" class="form-control" id="new_password" maxlength="20" placeholder="Password" name = "new_password" required></td>
            </div>
            </tr>

            <tr>
            <div class="form-group">
				<td style="text-align:right"><label for="confirm_new_password">Confirm New Password: &nbsp;</label></td>
				<td><input type="password" class="form-control" id="confirm_new_password" maxlength="20" placeholder="Confirm Password" name = "confirm_new_password" required></td>
            </div>    
            </tr>
            </table>
            <br>
            <input class="btn btn-primary" onclick="return passwordMatch()" type="submit" value="Change Password">
        </form>
		
</center>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>


</html>

