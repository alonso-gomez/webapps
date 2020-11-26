<?php
  // Inicializamos la sesion o la retomamos
  if(!isset($_SESSION)) {
    session_start();
    // Protegemos el documento para que solamente sea visible cuando HAS INICIADO sesión
    if(!isset($_SESSION['userId'])) header('Location: login.php?auth=false');
        // En el caso de este documento que es solo par admin, evaluamos el rol del usuario para determinar "si no es admin", en ese caso lo sacamos del documento
    if($_SESSION['userRole'] != "admin") header('Location: cpanel.php?forbidden=true');
  }

  include("connections/conn_localhost.php");
  include("includes/common_functions.php");

  // Redirigimos al usuario si no está definido userId en GET
  if(!isset($_GET['userId'])) header("Location: userManagement.php");

  // Recuperamos los datos del usuario tomando la referencia de $_SESSION
  $queryUserData = sprintf("SELECT * FROM usuarios WHERE id = %d",
    mysqli_real_escape_string($connLocalhost, trim($_GET['userId']))
  );

  // Ejecutamos el query
  $resQueryUserData = mysqli_query($connLocalhost, $queryUserData) or trigger_error("El query para obtener los detalles del usuario loggeado falló");

  // Hacemos un fetch del resultado obtenido
  $userData = mysqli_fetch_assoc($resQueryUserData);

  // Lo primero que haremos será validar si el formulario ha sido enviado
  if(isset($_POST['userDeleteSent'])) {

    // Preparamos la consulta para guardar el registro en la BD
    $queryUserDelete = sprintf("DELETE FROM usuarios WHERE id = %d",
      mysqli_real_escape_string($connLocalhost, trim($_POST['userId']))
    );

    // Ejecutamos el query
    $resQueryUserDelete = mysqli_query($connLocalhost, $queryUserDelete) or trigger_error("El query de eliminar usuario falló");

    // Evaluamos el resultado de la ejecución del query
    if($resQueryUserDelete) {
      header("Location: userManagement.php?deletedUser=true");
    }

  }
  else {
    
  }

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My San Carlos Vacation, San Carlos Property Rentals - Delete Users</title>

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


<div class="txt_navbar" id="navbar"><strong>You are here:</strong> <a href="index.php">Home</a> &raquo; <a href="cpanel.php">Control Panel</a> &raquo; <a href="userManagement.php">Manage Users</a> &raquo; User Delete
</div>

<div id="content" class="txt_content">
  <h2>User Delete</h2>
  <p>Please use the form below to update other users profiles.</p>

  <?php
    if(isset($error)) printMsg($error, "error");
    if(isset($_GET['updatedProfile'])) printMsg("The user profile has been updated", "exito");
  ?>
  <form action="userDelete.php" method="post">
    <table cellpadding="3">
      <tr>
        <td><label for="nombre">Name:*</label></td>
        <td><input type="text" name="nombre" value="<?php echo $userData['nombre']; ?>"></td>
      </tr>
      <tr>
        <td><label for="apellidos">Last name:*</label></td>
        <td><input type="text" name="apellidos" value="<?php echo $userData['apellidos']; ?>"></td>
      </tr>
      <tr>
        <td><label for="email">Email:*</label></td>
        <td><input type="text" name="email" value="<?php echo $userData['email']; ?>" disabled></td>
      </tr>
      <tr>
        <td><label for="password">Pasword:*</label></td>
        <td><input type="password" name="password" value="<?php echo $userData['password']; ?>"></td>
      </tr>
      <tr>
        <td><label for="telefono">Telephone:</label></td>
        <td><input type="text" name="telefono" value="<?php echo $userData['telefono']; ?>"></td>
      </tr>
      <tr>
        <td><label for="rol">Role:</label></td>
        <td>
          <select name="rol" id="rol">
            <option value="agente" <?php echo ($userData['rol'] == "agente") ? "selected" : ""; ?>>Agent</option>
            <option value="admin" <?php echo ($userData['rol'] == "admin") ? "selected" : ""; ?>>Administrator</option>
          </select>
        </td>
      </tr>
      <tr>
        <td><input type="hidden" name="userId" value="<?php echo $userData['id']; ?>"></td>
        <td><br><input type="submit" value="Delete User" name="userDeleteSent"></td>
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
