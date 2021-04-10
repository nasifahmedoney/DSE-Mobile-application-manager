<?php
include 'connect.php';
//
session_start();

$user_email = '';
$userGroup = '';
if(!isset($_SESSION['email']))
{
	header("Location:logout_end_session.php");
}
else if($_SESSION['userGroup'] != "Settlement")
{
	header("Location:logout_end_session.php");
}
else
{
	$user_email = $_SESSION['email'];
	$userGroup = $_SESSION['userGroup'];
}
//
function before ($this_, $inthat)
{
    return substr($inthat, 0, strpos($inthat, $this_));
};

?>

<html>
<head>
<title></title>
<style>
.tableposition {
    position: fixed;
    width: 90%;
	top: 20%;
    left: 5%;
	height: 75%;
	overflow: auto;
}
</style>
<link rel="stylesheet" href="css/center.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
<a class="navbar-brand" href="userGroup_Settlement.php" ><?php echo before('@',$user_email); ?></a>
    
    <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
	  <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Options
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="userGroup_Settlement_Pending.php">Pending Codes</a><!--done-->
          <a class="dropdown-item" href="#">Approved Codes</a>
          <a class="dropdown-item" href="userGroup_Settlement_Reupload.php">Reupload Requested</a>
		  <a class="dropdown-item" href="userGroup_Settlement_SearchCode.php">Search Code</a>
		  <a class="dropdown-item" href="userGroup_Settlement_ChangePassword.php">Change Password</a>
        </div>
      </li>
	  
	  <li class="nav-item">
        <a class="nav-link" href="#"><b>Approved Codes</b></a>
      </li>
	  
    </ul>
    </div>
    <span class="nav navbar-nav navbar-right">
	<a href='logout_end_session.php'><button type="button" class="btn btn-light">Logout</button></a>
    <span>
</nav>

<div class = "tableposition">
<?php echo "<p style = 'text-align:center'><b>Showing all approved codes</b></p>"; ?>
<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col" style="text-align:center">Initiated by</th>
      <th scope="col" style="text-align:center">Investor Code</th>
	  <th scope="col" style="text-align:center">Open Date</th>
      <th scope="col" style="text-align:center">Status</th>
	  <th scope="col" style="text-align:center">Client Email</th>
    </tr>
  </thead>


<?php
$query = "SELECT * FROM documents WHERE status = 'Approved' ORDER BY open_date DESC";
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
                    <td style="text-align:center"><?php echo $row['email']; ?></td>
                    <td style="text-align:center"><?php echo $row['investor_code']; ?></td>
					<td style="text-align:center"><?php echo $row['open_date']; ?></td>
                    <td style="text-align:center"><?php echo $row['status']; ?></td>
					<td style="text-align:center"><?php echo $row['client_email']; ?></td>
                </tr>
            </tbody>
            
            <?php
            //html end php start
        }
        else
        {
            header("Location:error.php?error_id=No data found");
        }
    }
}
else
{
    header("Location:error.php?error_id=Query error");
}

//php end
?>
  
</table>
</div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>


</body>


</html>

