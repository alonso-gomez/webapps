<?php
// Inicializamos la sesión o la retomamos
if(!isset($_SESSION)) {
  session_start();
  // Verificamos si está definido el indice userId en SESSION, si no lo está quiere decir que el usuario no ha iniciado sesión por lo tanto no puede permanecer en el documento y se le redirecciona
  if(!isset($_SESSION['userId'])) header("Location: user-login.php?auth=false");
  // En el caso de este documento que es solo para admins, evaluamos el rol del usuario para determinar "si no es admin", en ese caso lo sacamos del documento
  if($_SESSION['userRole'] != "admin") header("Location: cpanel.php?forbidden=true");
}

// Incluimos la conexión a la BD
include('connections/conn_localhost.php');
include('includes/utils.php');

// Verificamos si esta defninido userID en GET para continuar con el documento
if(isset($_GET['userId'])) {
  // Recuperamos los datos del usuario tomando como referencia algún valor de $_SESSION
  $queryDeleteUser = sprintf("SELECT name, lastname, email, phone, role, id FROM usuarios WHERE id = %s",
      mysqli_real_escape_string($connLocalhost, trim($_GET['userId']))
  );

  // Ejecutamos el query
  $resQueryDeleteUser = mysqli_query($connLocalhost, $queryDeleteUser)
    or trigger_error("El query para obtener lo detalles del usuario loggeado falló");

  // Hacemos un fetch del resultado encontrado
  $userDetails = mysqli_fetch_assoc($resQueryDeleteUser);
}
else {
  // Lo primero que haremos será validar si el formulario ha sido enviado
  if(isset($_POST['sent'])) {

    // Preparamos la consulta para actualizar el registro del usuario en la BD
    $queryDeleteUser = sprintf("DELETE FROM usuarios WHERE id = %d",
      mysqli_real_escape_string($connLocalhost, $_POST['userId'])
    );

    // Ejecutamos el query
    $resQueryDeleteUser = mysqli_query($connLocalhost, $queryDeleteUser)
      or trigger_error("El query de eliminación de usuarios falló");

    // Evaluamos el resultado de la ejecución del query (puede ser true o false)
    if($resQueryDeleteUser) {
      // Hacemos un refresh del documento para que se carguen los datos recien cambiados
      header("Location: user-management.php?deletedUser=true");
    }
  }
  else {
    header("Location: user-management.php");
  }
}



?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My San Carlos Vacation - Delete user </title>

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
<div class="txt_navbar" id="navbar"><strong>You are here:</strong> <a href="index.php">Home</a> &raquo; <a href="cpanel.php">Control Panel</a> &raquo; <a href="user-management.php">User Management</a> &raquo; Edit my profile
</div>

<div id="content" class="txt_content">
  <h2>Delete Users</h2>
  <p>Use the form below to review users details and confirm for deletion.</p>

  <div class="error">Are you sure you want to delete this user? This action can not be undone</div>

  <form action="user-delete.php" method="post">
    <table>
      <tr>
        <td>
          <label for="name">Name:*</label>
        </td>
        <td><input type="text" name="name" value="<?php echo $userDetails['name']; ?>"></td>
      </tr>
      <tr>
        <td>
          <label for="lastname">Lastname:*</label>
        </td>
        <td><input type="text" name="lastname" value="<?php echo $userDetails['lastname']; ?>"></td>
      </tr>
      <tr>
        <td>
          <label for="email">Email:*</label>
        </td>
        <td><input type="text" name="email" value="<?php echo $userDetails['email']; ?>" disabled></td>
      </tr>
      <tr>
        <td>
          <label for="phone">Phone:</label>
        </td>
        <td><input type="text" name="phone" value="<?php echo $userDetails['phone']; ?>"></td>
      </tr>
      <tr>
        <td>
          <label for="phone">Role:</label>
        </td>
        <td>
          <select name="role">
            <option value="agent" <?php echo ($userDetails['role'] == "agent") ? "selected" : ""; ?>>Agent</option>
            <option value="admin" <?php echo ($userDetails['role'] == "admin") ? "selected" : ""; ?>>Admin</option>
          </select>
        </td>
      </tr>
      <tr>
        <td><input type="hidden" name="userId" value="<?php echo $userDetails['id'];?>"></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td><input type="submit" value="Delete Users" name="sent"></td>
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