<?php
// Inicializamos la sesión o la retomamos
if(!isset($_SESSION)) {
  session_start();
}

// Incluimos la conexión a la BD y utilerias
include('connections/conn_localhost.php');
include('includes/utils.php');

// Evaluamos si el formulario ha sido enviado
if(isset($_POST['sent'])) {
  // Validamos si las cajas están vacias
  foreach($_POST as $calzon => $caca) {
    if($caca == "") $error[] = "The field $calzon is required";
  }

  if(!isset($error)) {
    // Armamos el query para verificar el email y el password en la BD
    $queryLogin = sprintf("SELECT id, name, lastname, email, role FROM usuarios WHERE email = '%s' AND password = '%s'",
        mysqli_real_escape_string($connLocalhost, trim($_POST['email'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['password']))
    );

    // Ejecutamos el query
    $resQueryLogin = mysqli_query($connLocalhost, $queryLogin) or trigger_error("The user login query failed");

    // Determinamos si el login es valido (email y password coincidentes)
    // Contamos el recordset (el resultado para un login valido es 1)
    if(mysqli_num_rows($resQueryLogin)) {
      // Hacemos un fetch del recordet
      $userData = mysqli_fetch_assoc($resQueryLogin);

      // Definimos variables de sesion en $_SESSION
      $_SESSION['userId'] = $userData['id'];
      $_SESSION['userFullname'] = $userData['name'].' '.$userData['lastname'];
      $_SESSION['userEmail'] = $userData['email'];
      $_SESSION['userRole'] = $userData['role'];

      // Redireccionamos al usuario al panel de control
      header("Location: cpanel.php");
    }
    else {
      $error[] = "Login failed";
    }
  }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My San Carlos Vacation, San Carlos Property Rentals - User login</title>

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
<div class="txt_navbar" id="navbar"><strong>You are here:</strong> <a href="index.php">Home</a> &raquo; Login
</div>

<div id="content" class="txt_content">
  <h2>Login</h2>
  <p>Use the form below to login:</p>

  <?php if(isset($error)) printMsg($error, "error"); ?>

  <form action="user-login.php" method="post">
    <table cellpadding="3">
      <tr>
        <td><label for="email">Email:</label></td>
        <td><input type="text" name="email"></td>
      </tr>
      <tr>
        <td><label for="password">Password:</label></td>
        <td><input type="password" name="password"></td>
      </tr>
      <tr>
        <td colspan="2"><input type="submit" value="Login" name="sent"></td>
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