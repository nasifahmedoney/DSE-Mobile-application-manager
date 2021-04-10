<?php
$app_dir = $_GET['app_dir'];
if($app_dir != "Not Available" && file_exists($app_dir))
{
	header("Content-type: application/pdf");
	readfile($app_dir);
}
else
{
	header("Location:error.php?error_id=Document Not Found");
}
?>