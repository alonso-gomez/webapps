<?php
// Definimos variables con los datos necesarios para la conexion
$servidor = "localhost";
$baseDatos = "bienes_raices";
$usuarioBD = "root";
$passwordBD = "iswguaymas";

// Creamos la conexión
$conn_localhost = mysqli_connect($servidor, $usuarioBD, $passwordBD) 
	or trigger_error(mysqli_error(), E_USER_ERROR);

// Definimos el cotejamiento de la conexion (igual al cotejamiento de la BD)
mysqli_query($conn_localhost, "SET NAMES 'utf8'");

// Seleccionamos la base de datos activa
mysqli_select_db($conn_localhost, $baseDatos);

?>