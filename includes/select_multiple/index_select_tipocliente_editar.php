<?php 
	mysql_select_db($database_conexion_smile,$conexion_smile);
	$tipo = "SELECT * FROM tipocliente";
	$q_tipo = mysql_query($tipo);
?>
	<select name="tipocliente" id="input" class="form-control" required="required">
    <?php 
		while ($row_tipo = mysql_fetch_array($q_tipo)) {
			if ($row_cliente['tipocliente_idtipocliente']==$row_tipo['idtipocliente']) {?>
				<option value="<?php echo $row_tipo['idtipocliente']?>" selected> <?php echo $row_tipo['tipoclientenoombre'] ?> </option>		
	<?php 	} else{ ?>
<option value="<?php echo $row_tipo['idtipocliente']?>"> <?php echo $row_tipo['tipoclientenoombre'] ?> </option>
	<?php } 
		}?>
    </select>