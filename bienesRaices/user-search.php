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

// Recuperamos los usuarios de la BD
// Definimos el query de recuperación de usuarios
$searchQuery = mysqli_real_escape_string($connLocalhost,trim($_GET['s']));
$queryUserSearch = "SELECT name, lastname, email, id FROM usuarios WHERE name LIKE '%$searchQuery%' OR lastname LIKE '%$searchQuery%' OR email LIKE '%$searchQuery%'";

// Ejecutamos el query
$resQueryUserSearch = mysqli_query($connLocalhost, $queryUserSearch)
  or trigger_error("El query búsqueda de usuarios falló");

// Contamos los resultados obtenidos por la BD
$totalUsers = mysqli_num_rows($resQueryUserSearch);

// Hacemos un fetch del primer resultado
$usersData = mysqli_fetch_assoc($resQueryUserSearch);


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My San Carlos Vacation - User search </title>

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
<div class="txt_navbar" id="navbar"><strong>You are here:</strong> <a href="index.php">Home</a> &raquo; <a href="cpanel.php">Control Panel</a> &raquo; User Search
</div>

<div id="content" class="txt_content">
  <h2>User search results</h2>
  <?php
  if($totalUsers == 0) { ?>
    <div class="announce">Your search query didn't match any value. Please try again.</div>
  <?php }
  else { ?>
    <p>This are your search results.</p>

    <p>Total users: <?php echo $totalUsers; ?></p>

    <ul class="listadoUsuarios">
      <?php 
      do { ?>
      <li>
        <p class="nombreUsuario"><?php echo $usersData['name'].' '.$usersData['lastname']; ?> | <?php echo $usersData['email']; ?></p>
        <p class="accionesUsuario"><a href="user-update-admin.php?userId=<?php echo $usersData['id'] ;?>">Update</a> | <a href="user-delete.php?userId=<?php echo $usersData['id'] ;?>">Delete</a></p>
      </li>
      <?php
      } while($usersData = mysqli_fetch_assoc($resQueryUserSearch));
      ?>
    </ul>
  <?php }?>
  
  
  
</div>

<!--CONTENT END -->


<?php include("includes/sidebar.php"); ?>
<!-- SIDEBAR END -->
<div style="clear: both;"></div>

<?php include("includes/footer.php"); ?>
</div>

</body>
</html>