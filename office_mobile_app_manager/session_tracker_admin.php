<?php
/*
	include 'connect.php';
	session_start();
	//check if isset both
	$email = $_SESSION['email'];
	$userGroup = $_SESSION['userGroup'];
	
	if($email == null)
	{
		session_unset();
		session_destroy();
		header("Location:index.php");
	}
	else if($userGroup != "Admin")
	{
		header("Location:logout_end_session.php");
	}
	*/
	
	
	include 'connect.php';
	session_start();
	if(isset($_SESSION['email']) == false)
	{
		header("Location:index.php");
	}
	else if($_SESSION['userGroup'] != "Admin")
	{
		header("Location:logout_end_session.php");
	}
?>