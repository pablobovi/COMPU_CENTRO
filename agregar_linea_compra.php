<?php require_once('Connections/conexion_compucentro.php'); ?>
<?php include('sis_acceso_ok.php'); ?> 
<?php
mysql_select_db($database_conexion_compucentro,$conexion_compucentro);
$id=$_POST['idproducto'];
$cantidad=$_POST['cantidad'];
$preciocompra=$_POST['preciocompra'];
$neto=$cantidad*$preciocompra;
$bruto=$neto/1.21;
$ivalc=$neto*0.21


$insertlineacompra="INSERT INTO lineacompra (cantidad, bruto,compra_idcompra, neto, producto_idproducto, iva_lineacompra) 
VALUES ('$cantidad', '$bruto', '1', '$neto','$id', '$ivalc')";
$q_insertarlineacompra=mysql_query($insertlineacompra);
header ("Location: compra_nueva.php");
?>
