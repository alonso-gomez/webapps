<?php

// Incluimos la conexión a la base de datos
include("connections/conn_localhost.php");
include("includes/utils.php");

// Lo primero que vamos a validar es si el forumulario ha sido enviado o no
if(isset($_POST['userAddSent'])) {
  // Vamos a validar que no existan cajas vacias
  foreach($_POST as $calzon => $caca) {
    if($caca == '' && $calzon != "telephone" ) $error[] = "The $calzon field is required";
  }

  
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My San Carlos Vacation, San Carlos Property Rentals - Home page</title>

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


<div class="txt_navbar" id="navbar"><strong>You are here:</strong> <a href="index.php">Home</a> &raquo; <a href="cpanel.php">Control Panel</a> &raquo; User Add
</div>

<div id="content" class="txt_content">
  <h2>User Add</h2>
  <p>Please use the form below to add a new user.</p>

  <?php if(isset($error)) printMsg($error,"error"); ?>

  <form action="userAdd.php" method="post">
    <table cellpadding="2">
      <tr>
        <td><label for="name">Name:*</label></td>
        <td><input type="text" name="name" value="<?php if(isset($_POST['name'])) echo $_POST['name']; ?>"></td>
      </tr>
      <tr>
        <td><label for="lastname">Last name:*</label></td>
        <td><input type="text" name="lastname" value="<?php if(isset($_POST['lastname'])) echo $_POST['lastname']; ?>"></td>
      </tr>
      <tr>
        <td><label for="email">Email:*</label></td>
        <td><input type="text" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>"></td>
      </tr>
      <tr>
        <td><label for="password">Password:*</label></td>
        <td><input type="password" name="password"></td>
      </tr>
      <tr>
        <td><label for="telephone">Telephone:</label></td>
        <td><input type="text" name="telephone" value="<?php if(isset($_POST['telephone'])) echo $_POST['telephone']; ?>"></td>
      </tr>
      <tr>
        <td></td>
        <td><input type="submit" value="Save User" name="userAddSent"></td>
      </tr>
    </table>
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
