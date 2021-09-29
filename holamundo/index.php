<?php
	$miPrimerVariable = "Hola mundo"; // esta es string
	$miSegundaVariable = 23; // esta es númerica
	$miTercerVariable = true;

	define("MI_PRIMER_CONSTANTE", "Juana la Cubana");

	$otroNombre = "Sor Juana";

	function miPrimerFuncion($nombre){
		//$otroNombre = "Andres Manuel";
		echo "<p><strong>".MI_PRIMER_CONSTANTE."</strong></p>";
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Hola Mundo con PHP</title>
</head>
<body>
	<h1><?php echo $miPrimerVariable; ?></h1>
	<?php
		$miPrimerVariable = 23;
		//MI_PRIMER_CONSTANTE = "Pepillo Origel";

		echo "<p>El valor de MI_PRIMER_CONSTANTE es: ".MI_PRIMER_CONSTANTE."</p>\n";

		echo "<hr>\n";

		miPrimerFuncion($otroNombre);

		$ok = "asklndljndfjas";
		if($ok){
			echo "La expresion es verdadera";
		}
		else {
			echo "La expresion es falsa";
		}

		echo "<hr>";

		echo '<p>Este \'parrafo\' se imprimió usando comillas simples.</p>';
		echo "<p>Este es con \"comillas\" dobles y puedo devolver variables, por ejemplo el valor de la \\ variable \$miPrimerVariable es $miPrimerVariable</p>";

		echo "<hr>";

		$a = 23;
		$b = "24arbol";

		if($a == $b) {
			echo "<p>Funcionó</p>";
		}
		else {
			echo "<p>No funcionó</p>";
		}














	?>
</body>
</html>