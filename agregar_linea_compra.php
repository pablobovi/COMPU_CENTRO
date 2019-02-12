<?php require_once('Connections/conexion_smile.php'); ?>
<?php include('sis_acceso_ok.php'); ?> 
<?php
mysql_select_db($database_conexion_smile,$conexion_smile);
$id=$_POST['idproducto'];
$cantidad=$_POST['cantidad'];
$preciocompra=$_POST['preciocompra'];
$neto=$cantidad*$preciocompra;
$bruto=$neto/1.21;


$insertlineacompra="INSERT INTO lineacompra (cantidad, bruto,compra_idcompra, neto, producto_idproducto) 
VALUES ('$cantidad', '$bruto', '1', '$neto','$id')";
$q_insertarlineacompra=mysql_query($insertlineacompra);
header ("Location: compra_nueva.php");
?>
