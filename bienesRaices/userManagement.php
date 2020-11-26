<?php
  // Inicializamos la sesion o la retomamos
  if(!isset($_SESSION)) {
    session_start();
    // Protegemos el documento para que solamente sea visible cuando HAS INICIADO sesión
    if(!isset($_SESSION['userId'])) header('Location: login.php?auth=false');
    // En el caso de este documento que es solo par admin, evaluamos el rol del usuario para determinar "si no es admin", en ese caso lo sacamos del documento
    if($_SESSION['userRole'] != "admin") header('Location: cpanel.php?forbidden=true');
  }

  // Incluimos la conexión a la base de datos
  include("connections/conn_localhost.php");
  include("includes/common_functions.php");

  // Recuperamos los usuarios de la BD
  // Definimos el query de recuperación de usuarios
  $queryGetUsers = "SELECT nombre, apellidos, email, id FROM usuarios";

  // Ejecutamos el query
  $resQueryGetUsers = mysqli_query($connLocalhost, $queryGetUsers) or trigger_error("El query de obtención de todos los usuarios falló");

  // Contamos los resultados obtenidos por la BD
  $totalUsers = mysqli_num_rows($resQueryGetUsers);

  // Hacemos un fetch del primer resultado
  $usersData = mysqli_fetch_assoc($resQueryGetUsers);

  
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My San Carlos Vacation, San Carlos Property Rentals - User management</title>

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


<div class="txt_navbar" id="navbar"><strong>You are here:</strong> <a href="index.php">Home</a> &raquo; <a href="cpanel.php">Control Panel</a> &raquo; User management
</div>

<div id="content" class="txt_content">
  <h2>User management</h2>
  <p>Please use the options below to manage users.</p>

  <?php
    if(isset($error)) printMsg($error, "error");
    if(isset($_GET["auth"])) printMsg("We're sorry... You need to login first!", "announce");
    if(isset($_GET["loggedOff"])) printMsg("Bye bye :)", "exito");
    if(isset($_GET["deletedUser"])) printMsg("The user was deleted succesfully", "exito");
  ?>

  <p>Total users: <?php echo $totalUsers; ?></p>

  <ul class="listadoUsuarios">
    <?php
    do { ?>
    <li>
      <p class="nombreUsuario"><?php echo $usersData['nombre']." ".$usersData['apellidos']; ?> | <?php echo $usersData['email']; ?></p>
      <p class="accionesUsuario"><a href="userUpdateAdmin.php?userId=<?php echo $usersData['id']; ?>">Editar</a> | <a href="userDelete.php?userId=<?php echo $usersData['id']; ?>">Eliminar</a></p>
    </li>
    <?php 
    } while ($usersData = mysqli_fetch_assoc($resQueryGetUsers));
    ?>
  </ul>

  

  
  
</div>

<!--CONTENT END -->

<?php include("includes/sidebar.php"); ?>
<!-- SIDEBAR END -->
<div style="clear: both;"></div>
<?php include("includes/footer.php"); ?>

</div>

</body>
</html>
