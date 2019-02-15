<?php
 mysql_select_db($database_conexion_smile,$conexion_smile);

  $q_tipoliquidacion=mysql_query("SELECT * FROM tipoliquidacion
  ORDER BY idtipoliquidacion");
?>
  <select data-placeholder="Tipo Liquidacion" class="form-control chosen-select" tabindex="4" name="idtipoliquidacion" id="inputidtipoliquidacion">
       <option value="0">Seleccionar Tipo de Liquidacion</option>
      <?php
      while ($row_tipoliquidacion=mysql_fetch_array($q_tipoliquidacion)){
        if ($row_tipoliquidacion['idtipoliquidacion']!=0) { ?>
          <option value="<?php echo $row_tipoliquidacion['idtipoliquidacion']?>"><?php echo $row_tipoliquidacion['descripcion']?></option>

      <?php }
      } ?>
  </select>

  <script type="text/javascript">
    var config = {
      '.chosen-select'           : {},
      '.chosen-select-deselect'  : {allow_single_deselect:true},
      '.chosen-select-no-single' : {disable_search_threshold:10},
      '.chosen-select-no-results': {no_results_text:'No encontrado'},
      '.chosen-select-width'     : {width:"95%"}
    }
    for (var selector in config) {
      $(selector).chosen(config[selector]);
    }
  </script>

      <script type="text/javascript">
    $('select#inputidtipoliquidacion').on('change',function(){
    var idtipoliquidacionjs = $(this).val();
    $.post("includes/obtenertipoliquidacion.php", { idtipoliquidacionjs: idtipoliquidacionjs }, function(data){
                $("#inputidtipoliquidacion").val(data);
            });
    });
    </script>
