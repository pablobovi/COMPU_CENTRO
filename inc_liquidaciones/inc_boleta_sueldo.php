<?php mysql_select_db($database_conexion_compucentro,$conexion_compucentro);
$q_empleado=mysql_query("SELECT idempleado,nombreempleado,apellidoempleado FROM empleado");
?>
<form class="form" method="POST" action="inc_liquidaciones/boleta_pdf.php" role="form" >

  <div class="row control-group">
    <div class="form-group controls col-xs-12 col-sm-6 col-md-6 col-lg-3 col-sm-offset-6 col-md-offset-6 col-lg-offset-9">
        <input type="text" name="fechaliquidacion" id="inputFechaLiquidacion" class="form-control" value="<?php echo date("Y-m-d h:i:s");?>" required="required" readonly>
    </div>
  </div>
  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="row control-group">
      <div class="form-group controls col-xs-12 col-sm-6 col-md-6 col-lg-6">
          Apellido y nombre del empleado
          <div class="clearfix"></div>
          <?php include "includes/chosen/index_select_empleado.php" ?>
      </div>
    </div>
    <div class="form-group controls col-xs-12 col-sm-6 col-md-6 col-lg-4">
Desde
    											<label class="sr-only" for="">Desde:</label>
    											<input type="date" class="form-control" id="fechaliquidacion" name="fechadesde" placeholder="Input field">
                          <input type="hidden" name="verifica" id="inputverificafechainicio" class="form-control" value="">

    </div>



  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <br>
  <br>

  <button type="submit" class="btn boton-send btn-info pull-right btn-md" >Generar Reporte</button>

    </div>
</form>
