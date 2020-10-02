<?php
// Definimos variables con los datos necesarios para la conexión
$servidor = "localhost";
$baseDatos = "bienesRaices";
$usuarioBd = "root";
$passwordBd = "iswug";

// Creamos la conexión
$connLocalhost = mysqli_connect($servidor, $usuarioBd, $passwordBd) or trigger_error(mysql_error(), E_USER_ERROR);

// Definimos el cotejamiento para la conexion (igual al cotejamiento de la BD)
mysqli_query($connLocalhost, "SET NAMES 'utf8'");

// Seleccionamos la base de datos por defecto para el proyecto
mysqli_select_db($connLocalhost, $baseDatos);

?>