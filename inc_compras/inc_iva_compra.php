<?php mysql_select_db($database_conexion_smile,$conexion_smile);
$q_empleado=mysql_query("SELECT idempleado,nombreempleado,apellidoempleado FROM empleado");
?>
<form class="form-inline" method="POST" action="inc_compras/compras_pdf.php">
  <div class="row control-group">
    <div class="form-group controls col-xs-12 col-sm-6 col-md-6 col-lg-3 col-sm-offset-6 col-md-offset-6 col-lg-offset-9">
        <input type="text" name="fechaliquidacion" id="inputFechaLiquidacion" class="form-control" value="<?php echo date("Y-m-d h:i:s");?>" required="required" readonly>
    </div>
  </div>
<legend></legend>

    <div class="form-group controls col-xs-12 col-sm-6 col-md-6 col-lg-4">
Desde
    											<label class="sr-only" for="">Desde:</label>
    											<input type="date" class="form-control" id="fechaliquidacion" name="fechaliquidacion" placeholder="Input field">
                          <input type="hidden" name="verifica" id="inputverifica" class="form-control" value="">

    </div>
    <div class="form-group controls col-xs-12 col-sm-6 col-md-6 col-lg-4">
Hasta
   										   	<label class="sr-only" for="">Hasta:</label>
    											<input type="date" class="form-control" id="fechaliquidacion" name="fechaliquidacion" placeholder="Input field">
                          <input type="hidden" name="verifica" id="inputverifica" class="form-control" value="">

    </div>
  </div>

    <legend></legend>

  </div>


  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <br>
  <br>

  <button type="submit" class="btn boton-send btn-info pull-right btn-md" id="pdf" name="compras_pdf">Generar Reporte</button>

  <button type="button" id="cancelar" class="btn btn-danger btn-primary pull-left btn-md">Cancelar Reporte</button>
    </div>
</form>


<!-- valida que el cliente este registrado si se ingresa condicion de pago cuenta corriente -->
