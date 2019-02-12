<?php 
	mysql_select_db($database_conexion_smile,$conexion_smile);
	$tipo = "SELECT * FROM tipocliente";
	$q_tipo = mysql_query($tipo);
?>
	<select name="tipocliente" id="input" class="form-control" required="required">
    <option value="0">Tipo de cliente</option>
    <?php 
		while ($row_tipo = mysql_fetch_array($q_tipo)) {?>
			<option value="<?php echo $row_tipo['idtipocliente']?>"> <?php echo $row_tipo['tipoclientenoombre'] ?> </option>
	<?php } ?>
    </select>