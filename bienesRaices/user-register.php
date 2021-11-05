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

// Validación del formulario
// Primeramente evaluamos si el formulario ha sido enviado
if(isset($_POST['sent'])) {
  // Validación de cajas vacias
  foreach ($_POST as $calzon => $caca) {
    if($caca == "" && $calzon != "phone") $error[] = "The field $calzon is required";
  }

  // Validación de password coincidentes
  if($_POST['password'] != $_POST['password2']) $error[] = "Both passwords must match";

  // Validación de email
  // Preparamos la consulta para determinar si el email proporcionado ya existe en la BD
  // ESTE NO ES UN RECORDSET
  $queryCheckEmail = sprintf("SELECT id FROM usuarios WHERE email = '%s'",
    mysqli_real_escape_string($connLocalhost, trim($_POST['email']))
  );

  // Ejecutamos el query
  // ESTE ES UN RECORDSET
  $resQueryCheckEmail = mysqli_query($connLocalhost, $queryCheckEmail)
    or trigger_error("El query de validación de email falló");

  // Contar el recordset para determinar si se encontró el correo en la BD
  if(mysqli_num_rows($resQueryCheckEmail)) $error[] = "The given email is already taken";

  // Procedemos a guardar en la base de datos SOLO SI NO HAY ERRORES
  if(!isset($error)) {
    // Preparamos la consulta para guardar el registro del usuario en la BD
    $queryInsertUser = sprintf("INSERT INTO usuarios (name, lastname, email, password, phone, role) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')",
        mysqli_real_escape_string($connLocalhost, trim($_POST['name'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['lastname'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['email'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['password'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['phone'])),
        mysqli_real_escape_string($connLocalhost, trim($_POST['role']))
    );

    // Ejecutamos el query en la BD
    mysqli_query($connLocalhost, $queryInsertUser) or trigger_error("La inserción del registro del usuario ha fallado");

    // Reporte de errores detallado
    // mysqli_query($connLocalhost, $queryInsertUser) or trigger_error(mysqli_error($connLocalhost), E_USER_ERROR);

    // Si todo sale bien (se guardó en la BD), redireccionamos al usuario al Panel de Control
    header("Location: cpanel.php?insertUser=true");
  }
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>My San Carlos Vacation - User register </title>

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
<div class="txt_navbar" id="navbar"><strong>You are here:</strong> <a href="index.php">Home</a> &raquo; <a href="cpanel.php">Control Panel</a> &raquo; User Register
</div>

<div id="content" class="txt_content">
  <h2>User register</h2>
  <p>Use the form below to register a new user.</p>

  <?php if(isset($error)) printMsg($error, "error"); ?>

  <form action="user-register.php" method="post">
    <table>
      <tr>
        <td>
          <label for="name">Name:*</label>
        </td>
        <td><input type="text" name="name" value="<?php echo isset($_POST['name']) ? $_POST['name'] : ""; ?>"></td>
      </tr>
      <tr>
        <td>
          <label for="lastname">Lastname:*</label>
        </td>
        <td><input type="text" name="lastname" value="<?php if(isset($_POST['lastname'])) echo $_POST['lastname']; ?>"></td>
      </tr>
      <tr>
        <td>
          <label for="email">Email:*</label>
        </td>
        <td><input type="text" name="email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : ""; ?>"></td>
      </tr>
      <tr>
        <td>
          <label for="password">Password:*</label>
        </td>
        <td><input type="password" name="password"></td>
      </tr>
      <tr>
        <td>
          <label for="password2"> Repeat password:*</label>
        </td>
        <td><input type="password" name="password2"></td>
      </tr>
      <tr>
        <td>
          <label for="phone">Phone:</label>
        </td>
        <td><input type="text" name="phone" value="<?php echo isset($_POST['phone']) ? $_POST['phone'] : ""; ?>"></td>
      </tr>
      <tr>
        <td>
          <label for="role">Role:*</label>
        </td>
        <td>
          <select name="role">
            <option value="agent" <?php if(isset($_POST['role']) && $_POST['role'] == "agent") { echo "selected"; } ?>>Agent</option>
            <option value="admin" <?php if(isset($_POST['role']) && $_POST['role'] == "admin") { echo "selected"; } ?>>Administrator</option>
            <option value="editor" <?php if(isset($_POST['role']) && $_POST['role'] == "editor") { echo "selected"; } ?>>Editor</option>
          </select>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td></td>
        <td><input type="submit" value="Register User" name="sent"></td>
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