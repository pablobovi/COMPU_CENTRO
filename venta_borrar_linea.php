<?php require_once('Connections/conexion_compucentro.php'); ?>
<?php include('sis_acceso_ok.php'); ?>
<?php
mysql_select_db($database_conexion_compucentro,$conexion_compucentro);
$idlineaventa=$_GET['idlineaventa'];
$consulta="DELETE FROM lineaventa WHERE idlineaventa=$idlineaventa and venta_idventa='1'";
mysql_query($consulta);
header ("Location: venta_nueva.php");

?>
