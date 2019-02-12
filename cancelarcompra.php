<?php require_once('Connections/conexion_smile.php'); ?>
<?php include('sis_acceso_ok.php'); ?>
<?php
	mysql_select_db($database_conexion_smile,$conexion_smile);

	$eliminarcompra = "DELETE FROM lineacomprA WHERE compra_idcompra='1'";
	mysql_query($eliminarcompra);
?>