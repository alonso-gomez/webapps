<?php
// Evaluamos si el formulario ha sido enviado
if(isset($_GET['submit']) && $_GET['submit'] == "Calcular sueldo") {
	// Continuamos con el resto del script

	// Definimos variables
	$nombre = $_GET['nombre'];
	$apellidos = $_GET['apellidos'];
	$ht = $_GET['ht'];

	// Definimos constantes
	define("HORA_NORMAL", 20);
	define("HORA_EXTRA", 40);

	// Evaluamos que las cajas del formulario tengan valor
	// Recorremos el array GET indice por indice
	foreach ($_GET as $calzon => $caca) {
		// Evaluamos si el valor de la iteración es igual a vacio, eso es un error por lo que generamos un indice en la array $error
		if($caca == "") $error[] = "La caja $calzon no puede estar vacia";
	}

	// Evaluamos que las horas trabajas sea un valor numerico y positivo
	if(!is_numeric($ht)) $error[] = "Las horas trabajadas deben de ser un número";
	if($ht < 0) $error[] = "Las horas trabajadas deben ser un número positivo";

	// Continuamos con el script siempre y cuando estemos exentos de errores
	if(!isset($error)) {
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
	}
}
else {
	header("Location: index.php?error=true");
}

function printMsg($msg,$type){
	echo "<div class=\"$type\">";
	if (is_array($msg)) {
		echo "<ul>";
		foreach($msg as $caca) {
			echo "<li>$caca</li>";
		}
		echo "</ul>";
	}
	else {
		echo $msg;
	}
	echo "</div>";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sueldo de un empleado</title>
	<style>
		.error {
			border: solid 1px red;
	    padding: 10px;
	    border-radius: 5px;
	    background-color: #fdc6d6;
		}

		.exito {
			border: solid 1px #21b917;
    padding: 10px;
    border-radius: 5px;
    background-color: #d1f5d5;
		}
	</style>
</head>
<body>
	<?php
	// Si estamos libres de errores, procedemos a mostrar el resultado
	if(!isset($error)) { ?>
		<h1>Sueldo empleado</h1>
		<p>El empleado <?php echo "$nombre $apellidos"; ?> trabajó <?php echo $ht; ?> horas por lo que percibe un sueldo de: $<?php echo $total; ?></p>
		<p>A continuación se presenta el desglose del sueldo:</p>

		<?php
			include ($ht <= 40) ? "vistas/desglose_hn.php" : "vistas/desglose_he.php";
		?>
	<?php }
	else {
		//print_r($error);
		printMsg("Todo salio mal, cambiate de carrera","error");
		printMsg("Todo salio perfecto","exito");
		printMsg($error,"error");
		$mensaje = "Esto es un mensaje en variable";
		printMsg($mensaje,"exito");
	}

	?>
</body>
</html>