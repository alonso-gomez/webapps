<?php
  // Hice este comentario
  function printMsg($msg){
    if(is_array($msg)){
      echo "<ul>";
      foreach ($msg as $caca) {
        echo "<li>$caca</li>";
      }
      echo "</ul>";
    }
    else {
      echo $msg;
    }
  }

  // Definimos las constantes
  define("CUOTA_HN",20);
  define("CUOTA_HE",40);
  define("HORAS_N",40);

  // Capturamos los datos del empleado
  $nombre = $_POST['nombre'];
  $apellidos = $_POST['apellidos'];
  $ht = $_POST['ht'];
  $total = 0;

  // Evaluamos si hay cajas vacias
  foreach ($_POST as $calzon => $caca) {
    if($caca == "") $error[] = "La caja $calzon no puede ser vacia";
  }

  // Si no hay cajas vacias, continuamos con el script
  if(!isset($error)) {
    // Evaluamos si las horas trabajadas son númericas y son mayores que 0
    if(is_numeric($ht) && $ht > 0) {
      // Primeramente evaluar las horas trabajadas para determinar si hay horas extras o no
      if($ht > HORAS_N) {
        // Calculo para horas extras
        $ingreso_hn = HORAS_N * CUOTA_HN;
        $ingreso_he = ($ht - HORAS_N) * CUOTA_HE;
        $total = $ingreso_hn + $ingreso_he;
      }
      else {
        // Calculo normal
        $total = $ht * CUOTA_HN;
      }
    }
    else {
      $error[] = "El valor capturado en horas trabajadas no es un número o es menor o igual a 0";
    }
  }

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Sueldo empleado</title>
</head>
<body>
  <h1>Sueldo empleado</h1>

  <?php
  if(isset($error)){
    printMsg($error);
  }
  else { ?>
    <p>El empleado <?php echo $nombre.' '.$apellidos; ?> trabajó <?php echo $ht; ?> horas por las que se le pagó $<?php echo $total; ?>, a continuación se presenta un desglose de su sueldo:</p>

    <?php
      if($ht > HORAS_N) {
        include("vistas/sueldo_he.php");
      }
      else {
        include("vistas/sueldo_hn.php");
      }
  } ?>

</body>
</html>