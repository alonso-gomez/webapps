﻿<?php
// Inicializamos la sesion o la retomamos
if(!isset($_SESSION)) {
  session_start();
  // Protegemos el documento para que solamente los usuarios que HAN INICIADO sesión puedan visualizarlo
  if(!isset($_SESSION['userId'])) header('Location: login.php?auth=false');
}

// Incluimos las utilidades
include("includes/utils.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My San Carlos Vacation, San Carlos Property Rentals - Control Panel</title>

<link href='http://fonts.googleapis.com/css?family=Droid+Sans:400,700' rel='stylesheet' type='text/css' />

<link href="css_main.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">
<!--
function MM_jumpMenuGo(objId,targ,restore){ //v9.0
  var selObj = null;  with (document) { 
  if (getElementById) selObj = getElementById(objId);
  if (selObj) eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0; }
}
//-->
</script>
</head>

<body>
<div id="main">

<?php include("includes/header.php"); ?>
<!-- HEADER END -->


<div class="txt_navbar" id="navbar"><strong>You are here:</strong> <a href="index.php">Home</a> &raquo; Control Panel
</div>

<div id="content" class="txt_content">
  <h2>Control Panel</h2>
  <p>Please use the options below to manage user and properties.</p>

  <?php if(isset($_GET['insertUser'])) printMsg("The user was added succesfully","exito"); ?>
  <?php if(isset($_GET['updateUser'])) printMsg("Your user profile was updated succesfully","exito"); ?>
  <?php if(isset($_GET['forbidden'])) printMsg("You don't have enough privileges to access that part of the app","error"); ?>

  <h3>My Profile</h3>
  <ul>
    <li><a href="userUpdate.php">Edit my profile</a></li>
  </ul>

  <?php if($_SESSION['userRole'] == "admin") { ?>
  <h3>Users</h3>
  <ul>
    <li><a href="userAdd.php">Add user</a></li>
    <li><a href="userManagement.php">User management</a></li>
  </ul>
  <?php } ?>

  <h3>Properties</h3>
  <ul>
    <li><a href="#">Add property</a></li>
    <li><a href="#">Manage my properties</a></li>
    <li><a href="#">Manage other users properties</a></li>
  </ul>

  <h3>Search</h3>
  <p>User the search box below to quickly find a property.</p>
  <form action="#" method="get">
    <input type="text" name="search">
    <input type="submit" value="Search">
  </form>

</div>

<!--CONTENT END -->

<?php include("includes/sidebar.php"); ?>
<!-- SIDEBAR END -->
<div style="clear: both;"></div>
<?php include("includes/footer.php"); ?>

</div>

</body>
</html>
