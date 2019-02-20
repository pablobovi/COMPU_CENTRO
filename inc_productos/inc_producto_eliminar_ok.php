<?php
	mysql_select_db($database_conexion_smile,$conexion_smile);

	$idproducto=$_GET['idproducto'];

	$producto="SELECT * FROM producto WHERE idproducto=$idproducto";
	$q_producto=mysql_query($producto);
	$row_producto= mysql_fetch_array($q_producto);
	$nombreproducto=$row_producto['nombreproducto'];
	$marca=$row_producto['marca'];
	$delete_producto="DELETE FROM producto WHERE idproducto=$idproducto";
	mysql_query($delete_producto);
	
	$idempleado=$_SESSION["idempleado"];
	$accion='aliminar';
	$tabla='productos';
	$row_producto= mysql_fetch_array($q_producto);
	$descripcion='elimino el producto '.$nombreproducto.' marca '.$marca.' con id '.$idproducto;
	$formato = 'Y-m-d H:i:s';
	$fecha =new DateTime();
	$dateformat = date_format($fecha, $formato);

	$insertlogin="INSERT INTO auditor (idempleado, accion, tabla, descripcion, fecha)
	 values ($idempleado,'$accion','$tabla','$descripcion','$dateformat') ";
	mysql_query($insertlogin);
?>
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	<div><h2>Eliminaci&oacute;n exitosa!</h2></div>
	<br>
</div>
<div ><img src="images/icono_ok_grande.png"></div>
<div class="clearfix">
</div>
<a href="productos.php">Volver</a>