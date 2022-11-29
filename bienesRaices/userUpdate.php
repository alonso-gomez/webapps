<?php
// Inicializamos la sesion o la retomamos
if(!isset($_SESSION)) {
  session_start();
  // Protegemos el documento para que solamente los usuarios que HAN INICIADO sesión puedan visualizarlo
  if(!isset($_SESSION['userId'])) header('Location: login.php?auth=false');
}

// Incluimos la conexión a la base de datos
include("connections/conn_localhost.php");
include("includes/utils.php");

// Vamos a recuperar todos los datos del usuario usando como referencia el id que tenemos en $_SESSION
$queryLoggedUser = "SELECT * FROM usuarios WHERE id = {$_SESSION['userId']}";

// Ejecutamos el query
$resQueryLoggedUser = mysqli_query($conn_localhost, $queryLoggedUser) or trigger_error("El query para obtener los datos del usuario loggeado falló");

// Hacemos fetch a un array asociativo del resultado obtenido
$loggedUserData = mysqli_fetch_assoc($resQueryLoggedUser);

// Lo primero que vamos a validar es si el forumulario ha sido enviado o no
if(isset($_POST['userUpdate'])) {
  // Vamos a validar que no existan cajas vacias
  foreach($_POST as $calzon => $caca) {
    if($caca == '' && $calzon != "telephone" ) $error[] = "The $calzon field is required";
  }

  // Validamos que los passwords coincidan
  if($_POST['password'] != $_POST['password2']) $error[] = "The password do not match";

  // Si estamos libres de errores, continuamos a actualizar el registro en la BD
  if(!isset($error)) {
    // Preparamos el query de insercion
    $queryUpdateUser = sprintf("UPDATE usuarios SET nombre = '%s', apellidos = '%s', password = '%s', telefono = '%s' WHERE id = {$_SESSION['userId']}",
        mysqli_real_escape_string($conn_localhost, trim($_POST['name'])),
        mysqli_real_escape_string($conn_localhost, trim($_POST['lastname'])),
        mysqli_real_escape_string($conn_localhost, trim($_POST['password'])),
        mysqli_real_escape_string($conn_localhost, trim($_POST['telephone']))
    );

    // Ejecutamos el query
    mysqli_query($conn_localhost, $queryUpdateUser) or trigger_error("El query de actualizacion de datos de usuarios falló");

    // Redireccionamos al usuario al Panel de Control
    header("Location: cpanel.php?updateUser=true");
  }

  
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My San Carlos Vacation, San Carlos Property Rentals - Edit profile</title>

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


<div class="txt_navbar" id="navbar"><strong>You are here:</strong> <a href="index.php">Home</a> &raquo; <a href="cpanel.php">Control Panel</a> &raquo; Edit profile
</div>

<div id="content" class="txt_content">
  <h2>Edit Profile</h2>
  <p>Please use the form below for updating your user profile.</p>

  <?php if(isset($error)) printMsg($error,"error"); ?>

  <form action="userUpdate.php" method="post">
    <table cellpadding="2">
      <tr>
        <td><label for="name">Name:*</label></td>
        <td><input type="text" name="name" value="<?php echo $loggedUserData["nombre"] ?>"></td>
      </tr>
      <tr>
        <td><label for="lastname">Last name:*</label></td>
        <td><input type="text" name="lastname" value="<?php echo $loggedUserData["apellidos"] ?>"></td>
      </tr>
      <tr>
        <td><label for="email">Email:*</label></td>
        <td><input type="text" name="email" disabled="disabled" value="<?php echo $loggedUserData["email"] ?>"></td>
      </tr>
      <tr>
        <td><label for="password">Password:*</label></td>
        <td><input type="password" name="password" value="<?php echo $loggedUserData["password"] ?>"></td>
      </tr>
      <tr>
        <td><label for="password2">Confirm password:*</label></td>
        <td><input type="password" name="password2"></td>
      </tr>
      <tr>
        <td><label for="telephone">Telephone:</label></td>
        <td><input type="text" name="telephone" value="<?php echo $loggedUserData["telefono"] ?>"></td>
      </tr>
      <tr>
        <td></td>
        <td><input type="submit" value="Update User" name="userUpdate"></td>
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
