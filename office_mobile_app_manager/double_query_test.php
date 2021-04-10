<?php

$link = mysqli_connect('localhost','root','Bracepl@1','new_schema');

//$link = mysqli_connect('localhost','root','test@app','mobile_manager_test');

if (!$link) {
    echo "Connection error";
}

$investor_code = 'G0000';
//

$query_result1 = '';
$query_result2 = '';

$query1 = "SELECT * FROM new_documents WHERE investor_code = '$investor_code'";
$result1 = mysqli_query($link,$query1);
if($result1)
{
	$row = $result1->fetch_array(MYSQLI_ASSOC);
	if(is_array($row))
	{
		//echo "code found in new_documents";
		$query_result1 = $row;
	}
	
}



$query2 = "SELECT * FROM old_documents WHERE investor_code = '$investor_code'";
$result2 = mysqli_query($link,$query2);

if($result2)
{
	$row = $result2->fetch_array(MYSQLI_ASSOC);
	if(is_array($row))
	{
		//echo "<br>code found in old_documents";
		$query_result2 = $row;
	}
	
}

if(is_array($query_result1))
{
	echo $query_result1['investor_code'];
}
else
{
	echo "code found in new_documents";
}

echo "<br>";


if(is_array($query_result2))
{
	echo $query_result2['investor_code'];
}
else
{
	echo "code found in old_documents";
}

//useful for code search
//useful for new code entry

//not useful when using while


?>