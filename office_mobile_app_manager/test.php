<?php
include 'connect.php';
session_start();


if(isset($_POST['inv_codes']))
{
	$codes_to_approve = $_POST['inv_codes'];
	$purchase_power = 'Default';
	$counter = 0;
	$total = count($codes_to_approve);
	for($x = 0; $x < $total; $x++)
	{
		$codes = strval($codes_to_approve[$x]);
		
		$query = "UPDATE documents SET purchase_power = '$purchase_power' WHERE investor_code = '$codes'";
		$result = mysqli_query($link,$query);
	
		if($result)
		{
			echo "query executed ".$x ."times.";echo '<br>';
		}
		
	}
}



?>

<a href='logout_end_session.php'>Logout</a>