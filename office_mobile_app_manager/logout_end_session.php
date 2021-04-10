<?php
	include 'connect.php';
	session_start();
	if(isset($_SESSION['email']))
	{
		$email = $_SESSION['email'];
		$query = "UPDATE user SET loginStatus = 'logged_out' WHERE email = '$email'";
		$result = mysqli_query($link,$query);
		
		if($result)
		{
			session_unset();
			session_destroy();
			header("Location:index.php");
		}
	}
	else
	{
		//session_unset();
		//session_destroy();
		header("Location:index.php");		
	}
	
	
?>

