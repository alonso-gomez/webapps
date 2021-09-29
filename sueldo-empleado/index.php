<?php
	// Declaración de variables
	$nombre = "Alonso";
	$apellidos = "Gómez Avila";
	$ht = 5;

	// Declaración de constantes
	define("HORAS_NORMALES", 20);
	define("HORAS_EXTRAS", 40);

	// Analizamos el númerode trabajadas
	if($ht <= 40) { // Cualquier número negativo hasta el +40
		// Calculo de horas normales
		$sueldo = $ht * HORAS_NORMALES; // 30 * 20 = 600
	}
	else {
		// Calculo de horas extras
		$total_hn = 40 * HORAS_NORMALES;
		$he = $ht - 40;
		$total_he = $he * HORAS_EXTRAS;
		$sueldo = $total_hn + $total_he;
	}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sueldo de un empleado</title>
</head>
<body>
	<h1>Sueldo de un empleado.</h1>
	<p>El empleado <?php echo "$nombre $apellidos"; ?> trabajó <?php echo $ht; ?> horas por lo que obtuvo un sueldo de: $<?php echo $sueldo; ?>, a continuación se presenta su desglose:</p>
	<?php
	if($ht <=40){
		include("includes/vista_hn.php");
	}
	else {
		include("includes/vista_he.php");
	}
	?>
	
</body>
</html>