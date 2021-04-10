<?php

include 'connect.php';
session_start();
$user_email = $_SESSION['email'];
function before ($this_, $inthat)
{
    return substr($inthat, 0, strpos($inthat, $this_));
};
$error = $_GET['error_id'];



?>


<html>
<head>
<title></title>
<link rel="stylesheet" href="css/center.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
<a class="navbar-brand" href="#" ><?php echo before('@',$user_email); ?></a>
    
    <div class="collapse navbar-collapse" id="navbarNav">
    </div>
    <span class="nav navbar-nav navbar-right">
	<a href='logout_end_session.php'><span class="glyphicon glyphicon-log-out">Logout</span></a>
    </span>
</nav>
		<br>
		<h3><?php echo "Error: ".$error; ?></h3><br>
		<p><?php echo "Please Contact Administrator" ?></p>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>



</body>


</html>