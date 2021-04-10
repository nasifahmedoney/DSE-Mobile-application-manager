<?php
	include 'connect.php';
	session_start();
	
	$email = $_SESSION['email'];
	$userGroup = $_SESSION['userGroup'];
	
	if($email == null)
	{
		session_unset();
		session_destroy();
		header("Location:index.php");
	}
	else if($userGroup != "Settlement")
	{
		header("Location:logout_end_session.php");
	}
	
?>