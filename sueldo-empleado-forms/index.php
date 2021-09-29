<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sueldo empleado formularios</title>
</head>
<body>
	<h1>Sueldo empleado con formularios.</h1>
	<p>Utiliza el siguiente formulario para calcular el sueldo de un empleado.</p>

	<form action="calculo.php" method="post">
		<label for="nombre">Nombre:</label>
		<input type="text" name="nombre">
		<br>
		<br>

		<label for="apellidos">Apellidos:</label>
		<input type="text" name="apellidos">
		<br>
		<br>

		<label for="horas_trabajadas">Horas trabajadas:</label>
		<input type="text" name="horas_trabajadas">
		<br>
		<br>

		<input type="submit" value="Calcular sueldo" name="sent">

	</form>
</body>
</html>