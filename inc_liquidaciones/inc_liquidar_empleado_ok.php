<?php
	mysql_select_db($database_conexion_smile,$conexion_smile);

  $idliquidacion=$_POST['idliquidacion'];
	$idempleado=$_POST['idempleado'];
  //$id_tipoliquidacion=$_POST['idtipoliquidacion'];

  for ($i=0 ; $i<count($idempleado) ; $i++)
    {
      $insert_detalleliquidacion="INSERT INTO detalleliquidacion (liquidacion_idliquidacion, empleado_idempleado) VALUES ('$idliquidacion','$idempleado[$i]')";
			mysql_query($insert_detalleliquidacion) or die(mysql_error());
/*

      $q_empleado="SELECT * FROM empleado
	                 INNER JOIN categoriaempleado ON categoriaempleado_idcategoriaempleado=idcategoriaempleado
	                 INNER JOIN horastrabajadas ON horastrabajadas_idhorastrabajadas=idhotastrabajadas
	                 WHERE idempleado=$idempleado[$i]";
      $row_empleados=mysql_fetch_array($q_empleado);
  //CALCULO EL SUELDO DEPENDIENDO SI EL EMPLEADO TRABAJA 8 O 4 HS
      $jornadaempleado=$row_empleados['cantidadhoras'];
		      if ($jornadaempleado==4) {
			        $basicoempleado=$row_empleados['salariobasicocategoria']/2;
		           }
		      else{
		          $basicoempleado=$row_empleados['salariobasicocategoria'];
		          }
		$basicoempleado;
    //PARA CALCULAR ANTIGUEDAD
    $fechaingreso=$row_empleados['fechaingresoempleado'];
    $separafecha= explode('-', $fechaingreso);
   		$dia = $separafecha[2];
   		$mes = $separafecha[1];
     	$anio = $separafecha[0];

      	$diac =date("d");
       	$mesc =date("m");
       	$anioc =date("Y");

        //saco la cantidad de años de antiguedad del empleado

      	$antiguedad =  $anioc-$anio;
      	if($mesc < $mes && $diac < $dia || $mesc < $mes || $diac < $dia){
    		$antiguedad_aux = $antiguedad - 1;
     		$antiguedad = $antiguedad_aux;
     	}
     	$antiguedad;

      $q_tipoliquidacion_concepto= "SELECT * FROM tipoliquidacion_concepto WHERE tipoliquidacion_dtipoliquidacion=$id_tipoliquidacion";
      $row_tipoliquidacion_concepto=mysql_fetch_array($q_tipoliquidacion);


      for ($j=0 ; $j<count($tipoliquidacion_idtipoliquidacion) ; $j++){


      }

*/
		  		}
		?>
?>

<?php //si el tipo liquidacion se carga ?>
<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
	<div><h2>Alta de Liquidacion exitosa!</h2></div>
	<br>
</div>
<div ><img src="images/icono_ok_grande.png"></div>
<div class="clearfix">
</div>
<a href="liquidar.php">Volver</a>
<?php //Si no se carga mostrtar error?>
