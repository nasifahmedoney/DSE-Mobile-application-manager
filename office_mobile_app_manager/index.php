<?php
include 'connect.php';
session_start();
if(isset($_SESSION['email']))
{
	header("Location:logout_end_session.php");
}
if(isset($_POST['email']) && isset($_POST['password']))
{
	$email = $_POST['email'];
	$password = $_POST['password'];

	$query = "SELECT * FROM user WHERE email = '$email' AND password = '$password'";
	$result = mysqli_query($link,$query);
	
	if($result)
	{
		$row = $result->fetch_array(MYSQLI_ASSOC);
		if(is_array($row))
		{
			//session_start();
			$_SESSION['email'] = $row['email'];
			$_SESSION['userGroup'] = $row['userGroup'];
			$_SESSION['branch'] = $row['branch'];
			$_SESSION['loginStatus'] = $row['loginStatus'];
			
			header("Location:login_redirect.php");
		}
		else
		{
			?>
			<script type="text/javascript">
				window.alert("invalid username or password");
				</script>
			<?php
		}
	}
	else
	{
		
		?>
			<script type="text/javascript">
				window.alert("Query Error");
				</script>
			<?php
	}
	
}

?>

<!DOCTYPE html>
<html>
<head>
<style>
.footer {
   position: fixed;
   bottom: 1%;
   width: 100%;
   color: grey;
   text-align: center;
}
</style>
	<title>DSE Mobile Application Manager</title>
	<link rel="stylesheet" href="css/center.css">
	<script src="myscript.js"></script>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

</head>
<body>



	<nav class="navbar navbar-light bg-light">
		<span class="navbar-brand mb-0 h1">DSE Mobile Application Manager</span>
        <span class="nav navbar-nav navbar-right">
		<!--<a href='end_session.php'><span class="glyphicon glyphicon-log-out"></span> Logout</a>-->
		<span>
	</nav>


	<center>
	<form id = "form" action = "index.php" method = "POST">
	<table>
	<tr>
		<div class="form-group">
			<td style="text-align:right"><label for="email">Email address: &nbsp;</label></td>
			<td><input type="email" class="form-control" id="email" aria-describedby="emailHelp" placeholder="Enter email" name = "email" required></td>
		</div>
	</tr>
	<tr>
		<div class="form-group">
		<td style="text-align:right"><label for="password">Password: &nbsp;</label></td>
		<td><input type="password" class="form-control" id="password" placeholder="Password" name = "password" required></td>
		</div>
	</tr>	
	</table>
	<br>
		<button type="submit" class="btn btn-primary">Login</button>
	</form>
	</center>
	
<div class="footer">
  <small>BRAC EPL Stock Brokerage Ltd.</small>
</div>
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>
</html>

