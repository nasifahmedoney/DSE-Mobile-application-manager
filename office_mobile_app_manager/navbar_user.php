
<!-- editing -->
<nav class="navbar navbar-expand-lg navbar-light bg-light">
<a class="navbar-brand" href="userGroup_User.php" ><?php echo before('@',$user_email); ?></a>
    
    <div class="collapse navbar-collapse" id="navbarNav">
    <ul class="navbar-nav">
	  <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Options
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
          <a class="dropdown-item" href="userGroup_User_Pending.php">Pending Codes</a>
          <a class="dropdown-item" href="userGroup_User_Approved.php">Approved Codes</a>
          <a class="dropdown-item" href="userGroup_User_Reupload_ui.php">Reupload Requests</a><!--not created-->
		  <a class="dropdown-item" href="userGroup_User_newCodeEntry_ui.php">New Code Entry</a>
		  <a class="dropdown-item" href="userGroup_User_SearchCode.php">Search Code</a>
		  <a class="dropdown-item" href="userGroup_User_ChangePassword.php">Change Password</a><!--not created-->
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


<!--
<a class = "btn btn-light" href="userGroup_User_Pending.php" role = "button">Pending Codes</a>
<a class = "btn btn-light" href="userGroup_User_Approved.php" role = "button">Approved Codes</a>
<a class = "btn btn-light" href="userGroup_User_Unapproved.php" role = "button">Unapproved Codes</a>
<a class = "btn btn-light" href="userGroup_User_newCodeEntry_ui.php" role = "button">New Code Entry</a>  
<a class = "btn btn-light" href="userGroup_User_SearchCode.php" role = "button">Search Code</a>
      -->