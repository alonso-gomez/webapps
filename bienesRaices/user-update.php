<?php
// Inicializamos la sesión o la retomamos
if(!isset($_SESSION)) {
  session_start();
  // Verificamos si está definido el indice userId en SESSION, si no lo está quiere decir que el usuario no ha iniciado sesión por lo tanto no puede permanecer en el documento y se le redirecciona
  if(!isset($_SESSION['userId'])) header("Location: user-login.php?auth=false");
}

// Incluimos la conexión a la BD
include('connections/conn_localhost.php');
include('includes/utils.php');

// Recuperamos los datos del usuario tomando como referencia algún valor de $_SESSION
$queryLoggedUserDetails = "SELECT name, lastname, email, phone FROM usuarios WHERE id = {$_SESSION['userId']}";

// Ejecutamos el query
$resQueryLoggedUserDetails = mysqli_query($connLocalhost, $queryLoggedUserDetails)
  or trigger_error("El query para obtener lo detalles del usuario loggeado falló");

// Hacemos un fetch del resultado encontrado
$loggedUserDetails = mysqli_fetch_assoc($resQueryLoggedUserDetails);

// Lo primero que haremos será validar si el formulario ha sido enviado
if(isset($_POST['sent'])) {
  // Vamos a validar que no existan cajas vacias
  foreach ($_POST as $calzon => $caca) {
    if($caca == "" && $calzon != "phone") $error[] = "The field $calzon is required";
  }

  // Procedemos a actualizar los datos del usuario SOLO SI NO HAY ERRORES
  if(!isset($error)) {
    // Preparamos la consulta para actualizar el registro del usuario en la BD
    $queryUpdateUser = sprintf("UPDATE usuarios SET name = '%s', lastname = '%s', phone = '%s' WHERE id = {$_SESSION['userId']}",
      mysqli_real_escape_string($connLocalhost, trim($_POST['name'])),
      mysqli_real_escape_string($connLocalhost, trim($_POST['lastname'])),
      mysqli_real_escape_string($connLocalhost, trim($_POST['phone']))
    );

    // Ejecutamos el query
    $resQueryUpdateUser = mysqli_query($connLocalhost, $queryUpdateUser)
      or trigger_error("El query de actualización de datos de usuario falló");

    // Evaluamos el resultado de la ejecución del query (puede ser true o false)
    if($resQueryUpdateUser) {
      // Actualizamos el saludo de sesión
      $_SESSION['userFullname'] = $_POST['name'].' '.$_POST['lastname'];
      // Hacemos un refresh del documento para que se carguen los datos recien cambiados
      header("Location: user-update.php?updatedProfile=true");
    }
  }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My San Carlos Vacation - Edit my profile </title>

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
<div class="txt_navbar" id="navbar"><strong>You are here:</strong> <a href="index.php">Home</a> &raquo; <a href="cpanel.php">Control Panel</a> &raquo; Edit my profile
</div>

<div id="content" class="txt_content">
  <h2>Edit my profile</h2>
  <p>Use the form below to update your profile.</p>

  <?php 
    if(isset($error)) printMsg($error, "error");
    if(isset($_GET["updatedProfile"])) printMsg("User profile was succesfully updated", "exito");
   ?>

  <form action="user-update.php" method="post">
    <table>
      <tr>
        <td>
          <label for="name">Name:*</label>
        </td>
        <td><input type="text" name="name" value="<?php echo $loggedUserDetails['name']; ?>"></td>
      </tr>
      <tr>
        <td>
          <label for="lastname">Lastname:*</label>
        </td>
        <td><input type="text" name="lastname" value="<?php echo $loggedUserDetails['lastname']; ?>"></td>
      </tr>
      <tr>
        <td>
          <label for="email">Email:*</label>
        </td>
        <td><input type="text" name="email" value="<?php echo $loggedUserDetails['email']; ?>" disabled></td>
      </tr>
      <tr>
        <td>
          <label for="phone">Phone:</label>
        </td>
        <td><input type="text" name="phone" value="<?php echo $loggedUserDetails['phone']; ?>"></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td><input type="submit" value="Update Profile" name="sent"></td>
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