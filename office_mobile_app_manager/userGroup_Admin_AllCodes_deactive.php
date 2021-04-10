<?php
include 'connect.php';
$query1 = "SELECT * FROM documents WHERE status = 'Deactive'";
$result1 = mysqli_query($link,$query1);

$query2 = "SELECT * FROM old_documents WHERE status = 'Deactive'";
$result2 = mysqli_query($link,$query2);



if($result1)
{
	echo 'New Documents<br>';
    while($row1 = $result1->fetch_array(MYSQLI_ASSOC))
    {
        if(is_array($row1))
        {
			echo $row1['investor_code'];echo '<br>';
		}
	}
}
if($result2)
{
	echo 'Old Documents<br>';
    while($row2 = $result2->fetch_array(MYSQLI_ASSOC))
    {
        if(is_array($row2))
        {
			echo $row2['investor_code'];echo '<br>';
		}
	}
}


?>