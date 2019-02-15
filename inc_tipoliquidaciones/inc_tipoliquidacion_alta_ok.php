<?php
	mysql_select_db($database_conexion_smile,$conexion_smile);

	$descripcion=$_POST['descripcion'];
	$idconcepto=$_POST['selectedconcepto'];

	$alta_tipoliquidacion=mysql_query("INSERT INTO tipoliquidacion (descripcion) VALUES ('$descripcion')");

  $ultimo_tipoliquidacion = mysql_query("SELECT MAX(idtipoliquidacion) AS idtipoliquidacion FROM tipoliquidacion");
	$row_ultimo=mysql_fetch_array($ultimo_tipoliquidacion);
	$ultimo_tipoliquidacion=$row_ultimo['idtipoliquidacion'];

		for ($i=0 ; $i<count($idconcepto) ; $i++)
		{
			$insert_tipoliquidacion_concepto="INSERT INTO tipoliquidacion_concepto (concepto_idconcepto, tipoliquidacion_idtipoliquidacion) VALUES ('$idconcepto[$i]','$ultimo_tipoliquidacion')";
			mysql_query($insert_tipoliquidacion_concepto) or die(mysql_error());		}
		?>
?>

<?php //si el tipo liquidacion se carga ?>
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	<div><h2>Alta de Tipo de Liquidacion exitosa!</h2></div>
	<br>
</div>
<div ><img src="images/icono_ok_grande.png"></div>
<div class="clearfix">
</div>
<a href="tipo_liquidaciones.php">Volver</a>
<?php //Si no se carga mostrtar error?>
