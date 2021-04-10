<?php
session_start();
if(isset($_SESSION['email']))
{
	echo $_SESSION['email'];
	echo '<br>';
}
else
{
	echo 'empty<br>';
}

//session_destroy();
echo session_id();
echo '<br>';
echo session_status ();
echo '<br>';
echo session_name();
echo '<br>';


/*
session_destroy();
echo '<br>';
echo session_id();
echo '<br>';
echo session_status ();
echo '<br>';
echo session_name();
*/
?>