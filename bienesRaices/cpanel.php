<?php
// Inicializamos la sesión o la retomamos
if(!isset($_SESSION)) {
  session_start();
  // Verificamos si está definido el indice userId en SESSION, si no lo está quiere decir que el usuario no ha iniciado sesión por lo tanto no puede permanecer en el documento y se le redirecciona
  if(!isset($_SESSION['userId'])) header("Location: user-login.php?auth=false");
}

include('includes/utils.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My San Carlos Vacation - Control Panel</title>

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


<!-- HEADER END -->

<?php include("includes/header.php"); ?>
<div class="txt_navbar" id="navbar"><strong>You are here:</strong> <a href="index.php">Home</a> &raquo; Control Panel
</div>

<div id="content" class="txt_content">
  <?php 
  if(isset($_GET['insertUser'])) printMsg("The user was succesfully added", "exito");
  if(isset($_GET['forbidden'])) printMsg("Access denied", "error");
  ?>
  
  <h2>Control Panel</h2>
  <p>Use the options below to manage users and properties.</p>

  <h3>My Profile</h3>
  <ul>
    <li><a href="#">Edit my profile</a></li>
  </ul>

  <h3>Properties</h3>
  <ul>
    <li><a href="#">Add property</a></li>
    <li><a href="#">Manage my properties</a></li>
  </ul>

  <?php
  if($_SESSION['userRole'] == "admin") { ?>
  <h3>Admin options</h3>
  <ul>
    <li><a href="user-register.php">Add user</a></li>
    <li><a href="#">Manage users</a></li>
    <li><a href="#">Manage other users properties</a></li>
  </ul>
  <?php } ?>
  
</div>

<!--CONTENT END -->


<?php include("includes/sidebar.php"); ?>
<!-- SIDEBAR END -->
<div style="clear: both;"></div>

<?php include("includes/footer.php"); ?>
</div>

</body>
</html>