<?php 
  
  $num_total_registros = mysql_num_rows($q_liquidacion);
  if ($num_total_registros>0) {?>
  <table class="table">
      <tr>
        <th class="col-xs-1 col-sm-1 col-md-1 col-lg-1">id</th>
        <th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Fecha</th>
        <th class="col-xs-3 col-sm-3 col-md-3 col-lg-3">Empleado</th>
        <th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Basico</th>
        <th class="col-xs-1 col-sm-1 col-md-1 col-lg-1">Aportes</th>
        <th class="col-xs-1 col-sm-1 col-md-1 col-lg-1">Retenciones</th>
        <th class="col-xs-2 col-sm-2 col-md-2 col-lg-2">Salario Neto</th>
        <th class="col-xs-1 col-sm-1 col-md-1 col-lg-1"></th>
      </tr>
    <?php 
      
      while ($row_consulta=mysql_fetch_array($q_liquidacion)) { 
        ?>
      <tr>
        <td><?php echo $row_consulta['idliquidacion'] ?></td>
        <td><?php echo $row_consulta['fechaliquidacion'] ?></td>
        <td><?php echo $row_consulta['apellidoempleado'] ?> <?php echo $row_consulta['nombreempleado'] ?></td>
        <td><?php echo $row_consulta['salariobasicocategoria'] ?></td>
        <td align="center"><?php echo $row_consulta['totalaportes'] ?></td>
        <td align="center"><?php echo $row_consulta['totalretenciones'] ?></td>
        <td align="center"><?php echo $row_consulta['salarioneto'] ?></td>
        <td class="col-xs-1 col-sm-1 col-md-1 col-lg-1"><a href="ver_liquidacion.php?idliquidacion=<?php echo $row_consulta['idliquidacion'] ?>&idempleado=<?php echo $row_consulta['idempleado'] ?>"><button type="button" class= "btn btn-warning btn-xs"><span class="glyphicon glyphicon-list"> Detalle</span> </button></a></td>
      </tr>
   <?php  } ?>
   </table>
  <? }  
   else { ?>
  
   <?php }?>