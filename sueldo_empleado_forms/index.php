<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sueldo de un empleado con formularios</title>
</head>
<body>
	<h1>Sueldotron 3000</h1>
	<p>Captura los siguientes datos para calcular el sueldo:</p>

	<form action="resultado.php" method="get">
		<label for="nombre">Nombre:</label>
		<input type="text" name="nombre">
		<br>

		<label for="apellidos">Apellidos:</label>
		<input type="text" name="apellidos">
		<br>

		<label for="ht">Horas trabajadas:</label>
		<input type="text" name="ht">
		<br><br>

		<input type="submit" value="Calcular sueldo" name="submit">
	</form>
	
</body>
</html>