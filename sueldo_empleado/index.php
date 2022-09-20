<?php
	// Definimos variables
	$nombre = "Alonso";
	$apellidos = "Gomez Avila";
	$ht = 20;

	// Definimos constantes
	define("HORA_NORMAL", 20);
	define("HORA_EXTRA", 40);

	// Determinamos si hay horas extras
	if($ht <= 40) {
		// El calculo es hace directo
		$total = $ht * HORA_NORMAL;
	}
	else {
		// Primero determinamos las horas extras trabajadas
		$he = $ht - 40;
		$total_hn = (40 * HORA_NORMAL);
		$total_he = ($he * HORA_EXTRA);
		$total = $total_hn + $total_he;
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
	<h1>Sueldo empleado</h1>
	<p>El empleado <?php echo "$nombre $apellidos"; ?> trabajó <?php echo $ht; ?> horas por lo que percibe un sueldo de: $<?php echo $total; ?></p>
	<p>A continuación se presenta el desglose del sueldo:</p>

	<?php
		if($ht <= 40) {
			include("vistas/desglose_hn.php");
		}
		else {
			include("vistas/desglose_he.php");
		}

		include ($ht <= 40) ? "vistas/desglose_hn.php" : "vistas/desglose_he.php";
	?>
</body>
</html>