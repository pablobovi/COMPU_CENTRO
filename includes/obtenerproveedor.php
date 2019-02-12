
<?php
$hostname_conexion_smile = "localhost";
$database_conexion_smile = "db_smile";
$username_conexion_smile = "root";
$password_conexion_smile = "";

$conexion_smile = @mysql_connect($hostname_conexion_smile, $username_conexion_smile, $password_conexion_smile) or trigger_error(mysql_error(),E_USER_ERROR);

mysql_select_db($database_conexion_smile,$conexion_smile);


$idproveedorjs = $_POST['idproveedorjs'];
$q_proveedores=mysql_query("SELECT * FROM proveedor
 	WHERE idproveedor=$idproveedorjs");
$row_proveedor=mysql_fetch_array($q_proveedores);
	echo $row_proveedor['cuilproveedor'];
?>
