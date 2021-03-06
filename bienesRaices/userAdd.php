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

  // Lo primero que haremos será validar si el formulario ha sido enviado
  if(isset($_POST['userAddSent'])) {
    // Vamos a validar que no existan cajas vacias
    foreach($_POST as $calzon => $caca) {
      if($caca == '' && $calzon != "telefono") $error[] = "La caja $calzon es requerida";
    }

    // Validación de passwords coincidentes
    if($_POST['password'] != $_POST['password2']){
      $error[] = "Los passwords no son coincidentes";
    }

    // Validación de email
    // Preparamos la consulta para determinar si el email porporcionado ya existe en la BD
    $queryCheckEmail = sprintf("SELECT id FROM usuarios WHERE email = '%s'",
      mysqli_real_escape_string($connLocalhost, trim($_POST['email']))
    );

    // Ejecutamos el query 
    $resQueryCheckEmail = mysqli_query($connLocalhost, $queryCheckEmail) or trigger_error("El query de validación de email falló"); // Record set o result set siempre y cuando el query sea de tipo SELECT

    // Contar el recordset para determinar si se encontró el correo en la BD
    if(mysqli_num_rows($resQueryCheckEmail)) {
      $error[] = "El correo proporcionado ya está siendo utilizado";
    }

    // Procedemos a añadir a la base de datos al usuario SOLO SI NO HAY ERRORES
    if(!isset($error)) {
      // Preparamos la consulta para guardar el registro en la BD
      $queryInsertUser = sprintf("INSERT INTO usuarios (nombre, apellidos, email, password, telefono, rol) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')",
          mysqli_real_escape_string($connLocalhost, trim($_POST['nombre'])),
          mysqli_real_escape_string($connLocalhost, trim($_POST['apellidos'])),
          mysqli_real_escape_string($connLocalhost, trim($_POST['email'])),
          mysqli_real_escape_string($connLocalhost, trim($_POST['password'])),
          mysqli_real_escape_string($connLocalhost, trim($_POST['telefono'])),
          mysqli_real_escape_string($connLocalhost, trim($_POST['rol']))
      );

      // Ejecutamos el query en la BD
      mysqli_query($connLocalhost, $queryInsertUser) or trigger_error("El query de inserción de usuarios falló");

      // Redireccionamos al usuario al Panel de Control
      header("Location: cpanel.php?insertUser=true");
    }

  }
  else {
    
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

  <?php
    if(isset($error)) printMsg($error, "error"); 
  ?>
  <form action="userAdd.php" method="post">
    <table cellpadding="3">
      <tr>
        <td><label for="nombre">Name:*</label></td>
        <td><input type="text" name="nombre" value="<?php if(isset($_POST['nombre'])) echo $_POST['nombre']; ?>"></td>
      </tr>
      <tr>
        <td><label for="apellidos">Last name:*</label></td>
        <td><input type="text" name="apellidos" value="<?php if(isset($_POST['apellidos'])) echo $_POST['apellidos']; ?>"></td>
      </tr>
      <tr>
        <td><label for="email">Email:*</label></td>
        <td><input type="text" name="email" value="<?php if(isset($_POST['email'])) echo $_POST['email']; ?>"></td>
      </tr>
      <tr>
        <td><label for="password">Pasword:*</label></td>
        <td><input type="password" name="password"></td>
      </tr>
      <tr>
        <td><label for="password2">Repeat pasword:*</label></td>
        <td><input type="password" name="password2"></td>
      </tr>
      <tr>
        <td><label for="telefono">Telephone:</label></td>
        <td><input type="text" name="telefono" value="<?php if(isset($_POST['telefono'])) echo $_POST['telefono']; ?>"></td>
      </tr>
      <tr>
        <td><label for="rol">Role:*</label></td>
        <td>
          <select name="rol">
            <option value="agente" <?php if(isset($_POST['rol']) && $_POST['rol'] == "agente") echo 'selected="selected"'; ?>>Agent</option>
            <option value="admin" <?php if(isset($_POST['rol']) && $_POST['rol'] == "admin") echo 'selected="selected"'; ?>>Administrator</option>
          </select>  
        </td>
      </tr>
      <tr>
        <td></td>
        <td><br><input type="submit" value="Save User" name="userAddSent"></td>
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
