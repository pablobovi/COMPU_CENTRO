<?php
	mysql_select_db($database_conexion_smile,$conexion_smile);

  $idliquidacion=$_POST['idliquidacion'];
	$idempleado=$_POST['idempleado'];
	$fechadeposito=$_POST['fechadeposito'];
	$idtipoliquidacion=$_POST['idtipoliquidacion'];

	$getfecha=mysql_query("SELECT * from liquidacion where idliquidacion=$idliquidacion")
						or die(mysql_error());
	$fecha=mysql_fetch_array($getfecha)['desde'];
	$separafecha= explode('-', $fecha);
	$dia = $separafecha[2];
	$mes = $separafecha[1];
	$anio = $separafecha[0];
	$mesc =date("m");
	$anioc =date("Y");

	$fechaliquidacion=$anioc."-".$mes;



  for ($i=0 ; $i<count($idempleado) ; $i++)
    	{
      		$insert_detalleliquidacion="INSERT INTO detalleliquidacion (fechadeposito, liquidacion_idliquidacion, empleado_idempleado)
																	VALUES ('$fechadeposito','$idliquidacion','$idempleado[$i]')";
					mysql_query($insert_detalleliquidacion) or die(mysql_error());

			//CONSULTA DE LA ULTIMA FILA DE DETALLE LIQUIDACION PARA LUEGO PONER EL IDDETALLELIQUIDACION EN DETALLE CONCEPTO

					$q_ult_detalleliquidacion = mysql_query("SELECT MAX(iddetalleliquidacion) AS iddetalleliquidacion FROM detalleliquidacion")
																			or die(mysql_error());
					$row_ult_detalleliquidacion=mysql_fetch_array($q_ult_detalleliquidacion);
		 			$ult_detalleliq=$row_ult_detalleliquidacion['iddetalleliquidacion'];


   //saco los datos del empleado para calcular el basico
	  			$q_empleado=mysql_query("SELECT * FROM empleado
	                 								INNER JOIN categoriaempleado ON categoriaempleado_idcategoriaempleado=idcategoriaempleado
	                 								INNER JOIN horastrabajadas ON horastrabajadas_idhorastrabajadas=idhotastrabajadas
	                 								WHERE idempleado=$idempleado[$i]")
		 									or die(mysql_error());
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
      		if($mesc < $mes && $diac < $dia || $mesc < $mes || $diac < $dia)
							{
							$antiguedad_aux = $antiguedad - 1;
     					$antiguedad = $antiguedad_aux;
     					}
     			$antiguedad;


				$q_presentismo=0;
				$presentismo=1;
//Salario familir
$grupo_fam=mysql_query("SELECT parentesco_idparentesco FROM grupofamiliar
																WHERE empleado_idempleado=$row_empleados[idempleado]")or die(mysql_error());
				$cant_grupo_fam= mysql_num_rows($grupo_fam);


				$hijos=0;
				$hijosdis=0;
				while($row=mysql_fetch_assoc($grupo_fam)){
					if ($row['parentesco_idparentesco']==4){
						$hijos=$hijos+1;
					}
						else {
						$hijosdis=$hijosdis+1;
						}
				}

// CONSULTO LOS CONCEPTOS ASOCIADOS AL TIPO DE LIQUIDACION QUE TRAIGO DE LA VENTANA LIQUIDACION
				      $q_tipoliquidacion_concepto=mysql_query("SELECT * FROM tipoliquidacion_concepto
																											INNER JOIN concepto ON concepto_idconcepto= idconcepto
																											WHERE tipoliquidacion_idtipoliquidacion=$idtipoliquidacion")
																					or die(mysql_error());

//RECORRO TODOS LOS CONCEPTOS ASOCIADOS AL TIPO DE LIQUIDACION

				while($row_tipoliquidacion_concepto=mysql_fetch_array($q_tipoliquidacion_concepto)){
					$idconcepto=$row_tipoliquidacion_concepto['concepto_idconcepto'];

					$q_concepto= mysql_query("SELECT * FROM concepto
																			WHERE idconcepto=$idconcepto")
												or die(mysql_error());
					$row_concepto=mysql_fetch_array($q_concepto);

					$cant_concepto=1;

					switch ($row_concepto['idconcepto']) {
					            case 2:
					                 $totalconcepto=$antiguedad*$row_concepto['montofijo'];
					                break;
											case 12:
											$tiempotrabajado = 0;
											$totalconcepto=0;
											$q_presentismo=mysql_query("SELECT * FROM asistencia WHERE empleado_idempleado=$idempleado[$i] and login like '%$fechaliquidacion%'") or die(mysql_error());
											while($row_presentismo=mysql_fetch_array($q_presentismo)){
														$tiempotrabajado= $tiempotrabajado + $row_presentismo['tiempotrabajado'];
													}

													if ($jornadaempleado==4) {
														 if ($tiempotrabajado>4500) {
															 $totalconcepto=($row_concepto['montovariable']/100)*$basicoempleado;
														 }
													}else {
														if($tiempotrabajado>9000){
															$totalconcepto=($row_concepto['montovariable']/100)*$basicoempleado;
														}
													}

														break;
											case 11:
												$totalconcepto=$hijos*$row_concepto['montofijo'];
												$cant_concepto=$hijos;
												break;
											case 15:
													$totalconcepto=$hijosdis*$row_concepto['montofijo'];
													$cant_concepto=$hijosdis;
												break;
												case 16:
														$totalconcepto=$basicoempleado;
													break;
											case 14:
												$totalconcepto=($row_concepto['montovariable']/100)*$basicoempleado;
												 break;
											default:
											if ($row_concepto['montofijo']==0)//entonces es un porcentaje
														{
															$totalconcepto=($row_concepto['montovariable']/100)*$basicoempleado;
														}
											else 	{
															$totalconcepto=$row_concepto['montofijo'];
														}
											}


								$insert_detalleconcepto=mysql_query("INSERT INTO detalleconcepto (subtotal, concepto_idconcepto, detalleliquidacion_iddetalleliquidacion, cantidad)
																											VALUES ('$totalconcepto','$idconcepto','$ult_detalleliq','$cant_concepto')");

						}
			/*PARA AGREGAR EN DETALLELIQUIDACION DEBE, HABER Y PAGO TOTAL, DEBO ANALIZAR QUE TIPO DE CONCEPTO ES:
			YA SEA UN APORTE = 1 O RETENCION =0. LUEGO LO INCREMENTO EN LA VARIABLE DEBE O HABER.
			----SUMO BASISCO Y RESTO HABER-DEBE PARA OBTENER EL PAGO TOTAL*/
				$q_detalleconcepto=mysql_query("SELECT * FROM detalleconcepto
													INNER JOIN concepto ON concepto_idconcepto=idconcepto
													WHERE detalleliquidacion_iddetalleliquidacion='$ult_detalleliq'")
				or die(mysql_error());

						$haber=0;
						$debe=0;

						while ($row_detalleconcepto=mysql_fetch_array($q_detalleconcepto)) {

							if ($row_detalleconcepto['tipoconcepto']==0){ // fijarse que tipo de concepto
								$haber=$row_detalleconcepto['subtotal']+$haber;

									}//SE AGREGA AL HABER

							if($row_detalleconcepto['tipoconcepto']==1)
							 {
								 $debe=$row_detalleconcepto['subtotal']+$debe;
							 }//se agrega al debe

						 }
       $pagototal=$haber-$debe;

						 $update_detalleliquidacion=mysql_query("UPDATE detalleliquidacion
							 																			SET  totaldebe=$debe, totalhaber=$haber, pagototal=$pagototal
							 																			WHERE iddetalleliquidacion=$ult_detalleliq")
																				or die(mysql_error());
			/*CALCULAR SALARIO POR HIJO*/
			$q_grupofamiliar=mysql_query("SELECT parentesco_idparentesco FROM grupofamiliar WHERE empleado_idempleado=$idempleado[$i]")
			or die(mysql_error());
			$subtotal_asignacionporhijo=0;
			while($row=mysql_fetch_assoc($q_grupofamiliar)){
				if($row['parentesco_idparentesco']==5)
				$subtotal_asignacionporhijo=$basicoempleado + 500;
			}

		}

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
