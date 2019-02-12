<?php

$hostname_conexion_smile = "localhost";
$database_conexion_smile = "db_compu";
$username_conexion_smile = "root";
$password_conexion_smile = "";
$conexion_smile = @mysql_connect($hostname_conexion_smile, $username_conexion_smile, $password_conexion_smile) or trigger_error(mysql_error(),E_USER_ERROR);
?>
