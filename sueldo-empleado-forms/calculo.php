<?php
function printMsg($msg) {
	echo "<div class=\"error\">";
	if(is_array($msg)) {
		// el mensaje ES array
		echo "<ul>";
		foreach($msg as $caca) {
			echo "<li>$caca</li>";
		}
		echo "</ul>";
	}
	else {
		// el mensaje NO ES array
		echo $msg;
	}
	echo "</div>";
}

// Evaluamos si contamos con los datos del formulario
if(isset($_POST["sent"])) {
	// Declaración de variables
	$nombre = $_POST['nombre'];
	$apellidos = $_POST['apellidos'];
	$ht = $_POST['horas_trabajadas'];

	// Declaración de constantes
	define("HORAS_NORMALES", 20);
	define("HORAS_EXTRAS", 40);

	// Validación de cajas vacias
	foreach ($_POST as $calzon => $caca) {
		if($caca == "") $error[] = "La caja $calzon está vacia";
	}

	// Analizamos el número de trabajadas
	// caja vacia es igual a "" /= null
	if($ht >= 0 && is_numeric($ht)) { // "reloj" => :(
		if($ht <= 40) { // Cualquier número positivo hasta el +40
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
	}
	else {
		$error[] = "Las horas trabajadas debe de ser un número mayor o igual que cero";
	}
}
else {
	header("Location: index.php");
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
			background-color: #F9B4B7;
			padding: 10px;
			border-radius: 5px;
		}
	</style>
</head>
<body>
	<h1>Sueldo de un empleado.</h1>

	<?php
	if(!isset($error)) { ?>
		<p>El empleado <?php echo "$nombre $apellidos"; ?> trabajó <?php echo $ht; ?> horas por lo que obtuvo un sueldo de: $<?php echo $sueldo; ?>, a continuación se presenta su desglose:</p>
		<?php
		if($ht <=40){
			include("includes/vista_hn.php");
		}
		else {
			include("includes/vista_he.php");
		}
		?>
	<?php }
	else {
		//echo "<p>".var_dump($error)."</p>";
		//echo $error;
		printMsg($error);
		printMsg("Mensaje de ejemplo");
	} 
	?>
	
</body>
</html>