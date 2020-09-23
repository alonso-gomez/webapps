<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Sueldo de un empleado con formularios</title>
</head>
<body>
	<h1>Sueldo de un empleado con formularios</h1>
	<p>Captura los siguientes datos para calcular el sueldo del trabajadorsssss.</p>
	<p>Añadí este parrafo</p>

	<form action="procesamiento.php" method="post">
		<label for="nombre">Nombre:</label>
		<input type="text" name="nombre">
		<br><br>

		<label for="apellidos">Apellidos:</label>
		<input type="text" name="apellidos">
		<br><br>

		<label for="ht">Horas trabajadas:</label>
		<input type="text" name="ht">
		<br><br>

		<input type="submit" value="Calcular sueldo" name="calc_sent">
	</form>
</body>
</html>