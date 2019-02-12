<?php require_once('Connections/conexion_smile.php'); ?>
<?php include('sis_acceso_ok.php'); ?>
<?php
    mysql_select_db($database_conexion_smile, $conexion_smile);
    $q_empleado=mysql_query("SELECT idempleado,nombreempleado,apellidoempleado FROM empleado");
    $q_concepto=mysql_query("SELECT idconcepto,descripcionconcepto FROM concepto");
?>
<form class="" action="liquidacion_alta_ok.php" method="POST" class="form-inline" role=form onsubmit="return verificar();" onsubmit="validad();">

<div id="selectempleado" class="form-group">
		<label>Empleados:</label>
		<select name="idempleado" id="idempleado" multiple class='form-control'>
		<?php
		while ($row_empleado=mysql_fetch_array($q_empleado)) {
				?>
				 <option value="<?php echo $row_empleado['idempleado'] ?>"><?php echo $row_empleado['nombreempleado'] ?><?php echo  $row_empleado['apellidoempleado']?></option>
		 <?php } ?>
		</select>
</div>

<div id="selectconcepto" class="form-group">
		<label>Conceptos:</label>
		<select name="idconcepto" id="idconcepto" multiple class='form-control'>
		<?php
		while ($row_concepto=mysql_fetch_array($q_concepto)) {
				?>
				 <option value="<?php echo $row_concepto['idconcepto'] ?>"><?php echo $row_concepto['descripcionconcepto'] ?></option>
		 <?php } ?>
		</select>
</div>
<div class="form-group">
											<label class="sr-only" for="">Fecha de Liquidacion:</label>
											<input type="date" class="form-control" id="fechaliquidacion" name="fechaliquidacion" placeholder="Input field">
                      <input type="hidden" name="verifica" id="inputverifica" class="form-control" value="">


</div>

<div id="success"></div>
<button id="reset" class="btn btn-default">Limpiar</button>
<button id="habilitar" type='submit' class="btn btn-default pull-right" onclick="liquidar()">Aceptar</button>
</div>
</div>

</form>


    <script type="text/javascript">

    function liquidar(){
      var fechaliquidacionjs = $('#fechaliquidacion').val();
      $.post("includes/validarperiodo.php", { fechaliquidacionjs: fechaliquidacionjs }, function(data){
                  $("#inputverifica").val(data);

              });
      var selectedempleado= $('#idempleado').val();
      var selectedconcepto= $('#idconcepto').val();
      $post("includes/inc_liquidacion_alta_ok.php", {fechaliquidacion: fechaliquidacion, selectedempleado: selectedempleado, selectedconcepto:selectedconcepto})
    );
    }

    /*$('#fechaliquidacion').on('change',function(){
    var fechaliquidacionjs = $('#fechaliquidacion').val();
    alert (fechaliquidacion);
    $.post("includes/validarperiodo.php", { fechaliquidacionjs: fechaliquidacionjs }, function(data){
                $("#inputverifica").val(data);
            });
    });*/
    </script>

		<script type="text/javascript">
/*	$(document).ready(function() {
					$('#habilitar').click(function(event) {
							var fechaliquidacion = $('#fechaliquidacion').val();

/*
EN ESTA PARTE TOMAS LOS VALORES DEL SELECT SIMPLEMENTE CON EL ID Y AL SER MULTIPLE TE TOMA TODOS LOS QUE ESTAN SELECIONADOS
ANTERIORMENTE TOMABAS EL VALOR DEL SELECT SIN HACER REFERENCIA A NINGUN NAME NI ID POR LO TANTO EN LAS DOS VARIABLES (selectedpersona y selectedrecurso) TOMABA LOS MISMOS DATOS Y AHI ESTABA EL ERROR EN LA CANTIDAD.
DE TODAS FORMAS SI HUBIESES REFERENCIADO BIEN LO MISMO IBAS A TENER UN ERROR YA QUE PARA TOMAR EL VALOR USABAS LA PROPIEDAD CHECKED QUE ES DE LOS CHECKBOX, EN LOS SELECTS SE USA
LA PROPIEDAD SELECTED.
LOS ERRORES EN EL OTRO ARCHIVO ERAN PROPIOS DE LO QUE ESTABAS MANDANDO DESDE ACA (ERROR DE CLAVE FORANEA) POR QUE INTENTABA GUARDAR UNA CLAVE FORANEA DE PERSONA EN LA TABLA DE RECURSOS_HAS_TAREA Y AL NO EXISTIR TE DABA ERROR.
Y POR ULTIMO ESTABAS MANDANDO UNA CADENA DESDE ACA Y EN EL OTRO ARCHIVO TENIAS Q USAR EL EXPLODE CUANDO NO ES NECESARIO. SI NECESITAS MANDAR UN ARRAY NO LO CONCATENES COMO UNA CADENA. DECLARALO COMO new Array() Y PARA AGREGARLE ELEMENTOS SE HACE PUSH EN EL ARRAY.

*/
/*
							var selectedempleado= $('#idempleado').val();
							var selectedconcepto= $('#idconcepto').val();
							$.ajax({
									url: "inc_liquidaciones/inc_liquidacion_alta_ok.php",
									type: "POST",
									dataType: 'html',
									data: {fechaliquidacion: fechaliquidacion, selectedempleado: selectedempleado, selectedconcepto:selectedconcepto},
									beforeSend: function(){
												//imagen de carga
												$("#resultado").html("<p align='center'><img src='images/ajax-loader.gif' /></p>");
									},
									error: function(){
												alert("error petición ajax");
									},
									success: function(data){
												$("#resultado").empty();
												$("#resultado").append(data);
									}
						});
					});
			});*/
	</script>
