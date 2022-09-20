<?php
	$mensaje = "Hola mundo con PHP";
	define("MENSAJE", "Hola Mundo");
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Hola Mundo con PHP</title>
</head>
<body>
	<h1><?php echo $mensaje; ?></h1>

	<p>Este es un Hola Mundo pero utilizando una constante.</p>

	<blockquote><?php echo MENSAJE; ?></blockquote>

	<?php
		$mensaje = 39;
		$var1 = "años 12";
		$var2 = "años 15";

		//$total = $var1 + $var2;

		//echo "<h3>$total</h3>";

		$ok = true;

		if($ok) {
			echo "<h3>La expresión es verdadera</h3>";
		}
		else {
			echo "<h3>La expresión es falsa</h3>";
		}
	?>

	<p>El valor de la variable $mensaje es ahora: <?php echo $mensaje; ?></p>

	<hr>

	<?php
		$name = "Alonso Gómez";

		echo "<p>Mi nombre es: $name</p>";
		echo '<p>Mi nombre es: $name</p>';
		echo '<p>Mi nombre es: '.$name.'</p>';

		$a = 10;
		$b = 5;

		echo $a == $b;

		$a = $a + $b;
		echo "\n$a\n<br/>\n<br/>\n";

		$a += $b;
		echo $a;
	?>
</body>
</html>