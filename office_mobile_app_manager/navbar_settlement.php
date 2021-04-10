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





<nav class="navbar navbar-expand-lg navbar-light bg-light">
<a class="navbar-brand" href="userGroup_Settlement.php" ><?php echo before('@',$user_email); ?></a>
    
    <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
	  <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Options
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="userGroup_Settlement_Pending.php">Pending Codes</a>
          <a class="dropdown-item" href="userGroup_Settlement_Approved.php">Approved Codes</a>
          <a class="dropdown-item" href="userGroup_Settlement_Reupload.php">Reupload Requested</a>
		  <a class="dropdown-item" href="userGroup_Settlement_SearchCode.php">Search Code</a>
		  <a class="dropdown-item" href="userGroup_Settlement_ChangePassword.php">Change Password</a>
        </div>
      </li>
	  <!--
	  <li class="nav-item">
        <a class="nav-link" href="#"><b>Pending Codes</b></a>
      </li>
	  -->
    </ul>
    </div>
    <span class="nav navbar-nav navbar-right">
	<a href='logout_end_session.php'><button type="button" class="btn btn-light">Logout</button></a>
    <span>
</nav>