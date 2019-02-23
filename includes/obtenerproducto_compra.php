
<?php
$hostname_conexion_smile = "localhost";
$database_conexion_smile = "db_compu_nuevo";
$username_conexion_smile = "root";
$password_conexion_smile = "";

$conexion_smile = @mysql_connect($hostname_conexion_smile, $username_conexion_smile, $password_conexion_smile) or trigger_error(mysql_error(),E_USER_ERROR);

mysql_select_db($database_conexion_smile,$conexion_smile);


$idproductojs = $_POST['idproductojs'];
$q_productos=mysql_query("SELECT * FROM producto
  WHERE idproducto=$idproductojs
  ORDER BY nombreproducto"); 
$row_producto=mysql_fetch_array($q_productos);
	echo $row_producto['idproducto'].",".$row_producto['preciocompra'];
?>