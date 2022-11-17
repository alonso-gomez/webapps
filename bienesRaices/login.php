<?php
  // Inicializamos la sesion o la retomamos
  if(!isset($_SESSION)) {
    session_start();
  }

  // Incluimos las utilidades
  include("connections/conn_localhost.php");
  include("includes/utils.php");

  // Evaluamos si el formulario ha sido enviado
  if(isset($_POST["login_sent"])) {
    // Validamos si las cajas están vacias
    foreach($_POST as $calzon => $caca) {
      if($caca == "") $error[] = "The $calzon field is required";
    }

    // Si estamos libres de errores procedemos con la verificación de los datos del usuario
    if(!isset($error)) {
      // Armamos el query para verificar email y password en la BD
      $queryLogin = sprintf("SELECT id, nombre, apellidos, email FROM usuarios WHERE email = '%s' AND password = '%s'",
          mysqli_real_escape_string($conn_localhost, trim($_POST['email'])),
          mysqli_real_escape_string($conn_localhost, trim($_POST['password']))
      );

      // Ejecutamos el query
      $resQueryLogin = mysqli_query($conn_localhost, $queryLogin) or trigger_error("Login query failed");

      // Determinamos si el login es valido (email y password coincidentes)
      //Contamos el recordset (el resultado esperado para un login valido es 1)
      if(mysqli_num_rows($resQueryLogin)) {
        // Hacemos un fetch del recordset
        $userData = mysqli_fetch_assoc($resQueryLogin);

        // Defninimos variables de sesion en $_SESSION
        $_SESSION['userId'] = $userData['id'];
        $_SESSION['userFullname'] = $userData['nombre']." ".$userData["apellidos"];
        $_SESSION['userEmail'] = $userData['email'];

        // Redireccionamos al usuario al Panel de Control
        header("Location: cpanel.php");
      }
    }
  }

  


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My San Carlos Vacation, San Carlos Property Rentals - Login</title>

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


<div class="txt_navbar" id="navbar"><strong>You are here:</strong> <a href="index.php">Home</a> &raquo; Login
</div>

<div id="content" class="txt_content">
  <h2>Login</h2>
  <p>Please use the form below to login.</p>

  <?php if(isset($error)) printMsg($error, "error"); ?>

  <form action="login.php" method="post">
    <table>
      <tr>
        <td><label for="email">Email:</label></td>
        <td><input type="text" name="email"></td>
      </tr>
      <tr>
        <td><label for="password">Password:</label></td>
        <td><input type="password" name="password"></td>
      </tr>
      <tr>
        <td><input type="submit" value="Login" name="login_sent"></td>
        <td></td>
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
