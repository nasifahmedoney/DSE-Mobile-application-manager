<?php
//office
//$link = mysqli_connect('localhost','root','Bracepl@1','mobile_manager_test');

//home
//$link = mysqli_connect('localhost','root','test@app','mobile_manager_test');

//server
$link = mysqli_connect('localhost','root','User@admin0#','mobile_manager_test');

//server_office
//$link = mysqli_connect('localhost','root','User@admin0#','mobile_manager_test');
if (!$link) {
    echo "Connection error";
}
?>