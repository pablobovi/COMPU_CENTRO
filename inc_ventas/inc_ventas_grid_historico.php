<?php 

	// $venta=mysql_query("SELECT * FROM venta");
	// $row_ventas=mysql_fetch_array($venta);
	// echo($row_ventas);
	$num_total_registros = mysql_num_rows($row_venta);
	if ($num_total_registros>0) {?>
		<table class="table">
			<tr>
				<th class="col-xs-3 col-sm-3 col-md-3 col-lg-3">id</th>
				<th class="col-xs-3 col-sm-3 col-md-3 col-lg-3">Fecha</th>
				<th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Empleado</th>
				<th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Cliente</th>
				<th class="col-xs-1 col-sm-1 col-md-1 col-lg-1">Total</th>
				<th class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></th>
			</tr>
<?php 
	 while ($row_venta=mysql_fetch_array($row_venta)) { ?>
	 	<tr>
	 		<td class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><?php echo $row_venta['idventa'] ?></td>
	 		<td class="col-xs-3 col-sm-3 col-md-3 col-lg-3"><?php echo $row_venta['fechaventa'] ?></td>
	 		<td class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><?php echo $row_venta['apellidoempleado'] ?></td>
	 		<td class="col-xs-2 col-sm-2 col-md-2 col-lg-2"><?php echo $row_venta['nombreorsocial'] ?></td>
	 		<td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><?php echo $row_venta['totalventa'] ?></td>
	 		<td class="col-xs-1 col-sm-1 col-md-1 col-lg-1">
					 <a href="ver_venta.php?idventa=<?php echo $row_venta['idventa'] 
															 ?>&idcliente=<?php echo $row_venta['idcliente'] 
															?>&idempleado=<?php echo $row_venta['idempleado'] ?>"><button type="button" class= "btn btn-warning btn-xs"><span class="glyphicon glyphicon-list"> Detalle</span> </button></a></td>
	 	</tr>
	 <?php 	}
	 }	?>
</table>