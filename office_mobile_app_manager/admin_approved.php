--approved
<html>
<head>
<title></title>

<link rel="stylesheet" href="css/center.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-light bg-light">
	<span class="navbar-brand mb-0 h1"><?php echo before('@',$user_email);?></span>
    <span class="nav navbar-nav navbar-right">
	<a href='logout_end_session.php'><span class="glyphicon glyphicon-log-out"></span> Logout</a>
<span>
</nav>

<a href='userGroup_Admin_SetPurchasePower.php'><span class="glyphicon glyphicon-log-out"></span>set purchase power</a>
<a href='userGroup_Admin_RemovePurchasePower.php'><span class="glyphicon glyphicon-log-out"></span>Remove purchase power</a>
<a href='userGroup_Admin_SearchCode.php'><span class="glyphicon glyphicon-log-out"></span>Search</a>

<center>
<?php echo $user_email;echo '<br>'; echo $userGroup; ?>
<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">Branch</th>
      <th scope="col">Initiated by</th>
      <th scope="col">Investor Code</th>
      <th scope="col">Status</th>
      <th scope="col">View Application</th>
    </tr>
  </thead>


<?php
$query = "SELECT * FROM documents WHERE status = 'Approved'";
$result = mysqli_query($link,$query);

if($result)
{
    while($row = $result->fetch_array(MYSQLI_ASSOC))
    {
        if(is_array($row))
        {
            //php end html start
            ?>
            
            <tbody>
                <tr>
                    <td><?php echo $row['branch']; ?></th>
                    <td><?php echo $row['email']; ?></th>
                    <td><?php echo $row['investor_code']; ?></td>
                    <td><?php echo $row['status']; ?></td>
                    <td><a href="userGroup_Admin_ViewApplication.php?inv_code=<?php echo $row['investor_code']; ?>">[link]</a></td>
                </tr>
            </tbody>
            
            <?php
            //html end php start
        }
        else
        {
            header("Location:error.php?error_id='error'");
        }
    }
}
else
{
    header("Location:error.php?error_id='error'");
}

//php end
?>
  
</table>
</center>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>


</html>