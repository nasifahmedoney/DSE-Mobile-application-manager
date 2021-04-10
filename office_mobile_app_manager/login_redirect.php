<?php
include 'connect.php';
session_start();

$email = $_SESSION['email']; 


$query = "SELECT * FROM user WHERE email = '$email'";
$result = mysqli_query($link,$query);

if($result)
{
	$row = $result->fetch_array(MYSQLI_ASSOC);
	if(is_array($row))
	{
		if($row['loginStatus'] == "logged_out")//no->logged out, yes->logged in
		{
			
			$userGroup = $row['userGroup'];
			if($userGroup == "Admin")
			{
				//$_SESSION['session_tracker_id'] = uniqid();
				//$session_tracker_id = $_SESSION['session_tracker_id'];
				//$query1 = "UPDATE user SET loginStatus = 'Logged_in', session_tracker_id = '$session_tracker_id' WHERE email = '$email'";
				$query1 = "UPDATE user SET loginStatus = 'Logged_in' WHERE email = '$email'";
				$result1 = mysqli_query($link,$query1);
				if($result1)
				{
					header("Location:userGroup_Admin.php");
				}
				else
				{
					header("Location:error.php?error_id=Query Error");
				}
			}
			else if($userGroup == "Settlement")
			{
				//$_SESSION['session_tracker_id'] = uniqid();
				//$session_tracker_id = $_SESSION['session_tracker_id'];
				//$query2 = "UPDATE user SET loginStatus = 'Logged_in', session_tracker_id = '$session_tracker_id' WHERE email = '$email'";
				$query2 = "UPDATE user SET loginStatus = 'Logged_in' WHERE email = '$email'";
				$result2 = mysqli_query($link,$query2);
				if($result2)
				{
					header("Location:userGroup_Settlement.php");
				}
				else
				{
					header("Location:error.php?error_id=Query Error");
				}
			}
			else
			{
				//$_SESSION['session_tracker_id'] = uniqid();
				//$session_tracker_id = $_SESSION['session_tracker_id'];
				//$query3 = "UPDATE user SET loginStatus = 'Logged_in', session_tracker_id = '$session_tracker_id' WHERE email = '$email'";
				$query3 = "UPDATE user SET loginStatus = 'Logged_in' WHERE email = '$email'";
				$result3 = mysqli_query($link,$query3);
				if($result3)
				{
					header("Location:userGroup_User.php");
				}
				else
				{
					header("Location:error.php?error_id=Query Error");
				}
			}
		}
		else
		{
			header("Location:logout_end_session.php");
		}
	}
}

?>

