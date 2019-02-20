<?php require_once('Connections/conexion_smile.php'); ?>
<?php include('sis_acceso_ok.php'); ?>
<?php
	mysql_select_db($database_conexion_smile,$conexion_smile);

	$eliminarventa = "DELETE FROM lineaventa WHERE venta_idventa='1'";
	mysql_query($eliminarventa);
	

?>
	<?php include('auditor.php');?>
