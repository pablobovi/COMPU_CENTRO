
<?php
$hostname_conexion_smile = "localhost";
$database_conexion_smile = "db_compu_nuevo";
$username_conexion_smile = "root";
$password_conexion_smile = "";

$conexion_smile = @mysql_connect($hostname_conexion_smile, $username_conexion_smile, $password_conexion_smile) or trigger_error(mysql_error(),E_USER_ERROR);

mysql_select_db($database_conexion_smile,$conexion_smile);

$fechaliquidacionjs = $_POST['fechaliquidacionjs'];
$idempleadojs=$_POST['idempleado'];
$band=0;
if (isset($fechaliquidacionjs) && $fechaliquidacionjs!="") {
	$separaperiodo= explode('-', $fechaliquidacionjs);
    $anioperiodoing = $separaperiodo[0];
    $mesperiodoing = $separaperiodo[1];
}
else{
    $anioperiodoing=date("Y");
	    $mesperiodoing =date("m");
}
$anioperiodoing;
$mesperiodoing;
$anioactual=date("Y");

if ($anioperiodoing>=$anioactual) {

	$empleados="SELECT * FROM empleado
	WHERE idempleado IN ($idempleadojs) AND estado=1 ORDER BY idempleado DESC LIMIT 0,1";
	$q_empleados=mysql_query($empleados);
	$row_empleado=mysql_fetch_array($q_empleados);
	$idempleado=$row_empleado['idempleado'];

	$liquidaciones="SELECT * FROM liquidacion
	WHERE empleado_idempleado=$idempleado";
	$q_liquidacion=mysql_query($liquidaciones);

	while ($row_liquidaciones=mysql_fetch_array($q_liquidacion)) {

		$separaperiodoliq= explode('-', $row_liquidaciones['fechaliquidacion']);
   		$mesperiodoliq = $separaperiodoliq[1];
   		if ($mesperiodoliq==$mesperiodoing) {
   			$band=1;
   		}
	}
	 echo $band;
}

else echo $band=1;

?>
