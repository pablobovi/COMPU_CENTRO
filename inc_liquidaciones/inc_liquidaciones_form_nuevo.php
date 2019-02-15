<?php mysql_select_db($database_conexion_smile,$conexion_smile);
$q_empleado=mysql_query("SELECT idempleado,nombreempleado,apellidoempleado FROM empleado");
?>
<form action="alta_compra.php" method="POST" role="form" onsubmit="return validar();">
  <div class="row control-group">
    <div class="form-group controls col-xs-12 col-sm-6 col-md-6 col-lg-3 col-sm-offset-6 col-md-offset-6 col-lg-offset-9">
        <input type="text" name="fechaliquidacion" id="inputFechaLiquidacion" class="form-control" value="<?php echo date("Y-m-d h:i:s");?>" required="required" readonly>
    </div>
  </div>
Nueva Liquidacion
<legend></legend>

  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="row control-group">
      <div class="form-group controls col-xs-12 col-sm-6 col-md-6 col-lg-6">
Liquidacion
          <div class="clearfix"></div>
          <?php include "includes/chosen/index_select_tipoliquidacion.php" ?>
      </div>
</div>
<div class="row control-group">

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
  <div class="form-group">
    Empleado/s: <br>
    <select multiple class='form-control' name="idempleado[]">
    <?php
    while ($row_empleado=mysql_fetch_array($q_empleado)){
      ?>
      <option value="<?php echo $row_empleado['idempleado']?>"><?php echo $row_empleado['apellidoempleado'] ?></option>
    <?php      }?>
    ...
    </select><br>
</div>
    <legend></legend>

  </div>


  <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <br>
  <br>

  <button type="submit" class="btn boton-send btn-info pull-right btn-md">Aceptar Compra</button>

  <button type="button" id="cancelar" class="btn btn-danger btn-primary pull-left btn-md">Cancelar Compra</button>
    </div>
</form>

<script type="text/javascript">
    $('#cancelar').on('click',function(){
    $.post("cancelarcompra.php", {}, function(data){
                 location.reload();
            });
    });
    </script>
<!-- valida que el cliente este registrado si se ingresa condicion de pago cuenta corriente -->
<script>
function validar(){
var idproveedor = $('#inputidproveedor').val();
var total = $('#inputsubtotal').val();
        if(idproveedor==0){
        alert('Debe seleccionar un proveedor');
        return false;
        }
        else {
          if (total==0) {
            alert('cargar al menos un producto');
            return false;
          }
        }
}
</script>
