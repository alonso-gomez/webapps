<?php
// Inicializamos la sesion o la retomamos
if(!isset($_SESSION)) {
  session_start();
  // Protegemos el documento para que solamente los usuarios que HAN INICIADO sesión puedan visualizarlo
  if(!isset($_SESSION['userId'])) header('Location: login.php?auth=false');
  // Este documento es solo para administradores, evaluamos el rol del usuario para determinar "si no es admin", en ese caso lo pateamos cordialmente
  if($_SESSION['userRole'] != "admin") header("Location: cpanel.php?forbidden=true");
}

// Incluimos la conexión a la base de datos
include("connections/conn_localhost.php");
include("includes/utils.php");

// Lo primero que vamos a validar es si el forumulario ha sido enviado o no
if(isset($_POST['userAddSent'])) {
  // Vamos a validar que no existan cajas vacias
  foreach($_POST as $calzon => $caca) {
    if($caca == '' && $calzon != "telephone" ) $error[] = "The $calzon field is required";
  }

  // Validamos que los passwords coincidan
  if($_POST['password'] != $_POST['password2']) $error[] = "The password do not match";

  // Si estamos libres de errores, continuamos a insertar el registro en la BD
  if(!isset($error)) {
    // Preparamos el query de insercion
    $queryInsertUser = sprintf("INSERT INTO usuarios (nombre, apellidos, email, password, telefono) VALUES ('%s', '%s', '%s', '%s', '%s')",
        mysqli_real_escape_string($conn_localhost, trim($_POST['name'])),
        mysqli_real_escape_string($conn_localhost, trim($_POST['lastname'])),
        mysqli_real_escape_string($conn_localhost, trim($_POST['email'])),
        mysqli_real_escape_string($conn_localhost, trim($_POST['password'])),
        mysqli_real_escape_string($conn_localhost, trim($_POST['telephone']))
    );

    // Ejecutamos el query
    mysqli_query($conn_localhost, $queryInsertUser) or trigger_error("El query de inserción de usuarios falló");

    // Redireccionamos al usuario al Panel de Control
    header("Location: cpanel.php?insertUser=true");
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
        <td><label for="password2">Confirm password:*</label></td>
        <td><input type="password" name="password2"></td>
      </tr>
      <tr>
        <td><label for="telephone">Telephone:</label></td>
        <td><input type="text" name="telephone" value="<?php if(isset($_POST['telephone'])) echo $_POST['telephone']; ?>"></td>
      </tr>
      <tr>
        <td><label for="rol">Role:*</label></td>
        <td>
          <select name="rol">
            <option value="agent" <?php if(isset($_POST['rol']) && $_POST['rol'] == "agent") echo 'selected="selected"'; ?>>Agent</option>
            <option value="admin" <?php if(isset($_POST['rol']) && $_POST['rol'] == "admin") echo 'selected="selected"'; ?>>Admin</option>
          </select>
        </td>
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
