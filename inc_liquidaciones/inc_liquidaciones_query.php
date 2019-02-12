<?php

mysql_select_db($database_conexion_smile,$conexion_smile);

if (isset($_GET['busca_liquidaciones'])) {
	$busqueda_liquidacion = $_GET['busca_liquidaciones'];
	$q_liquidacion=mysql_query("SELECT * FROM liquidacion 
	INNER JOIN empleado ON empleado_idempleado=idempleado
	INNER JOIN categoriaempleado ON categoriaempleado_idcategoriaempleado=idcategoriaempleado
	WHERE nombreempleado LIKE '%$busqueda_liquidacion%' OR apellidoempleado LIKE '%$busqueda_liquidacion%' AND empleado.estado=1 ORDER BY fechaliquidacion DESC");
	
}
else{
	$q_liquidacion=mysql_query("SELECT * FROM liquidacion 
	INNER JOIN empleado ON empleado_idempleado=idempleado
	INNER JOIN categoriaempleado ON categoriaempleado_idcategoriaempleado=idcategoriaempleado
	WHERE empleado.estado=1 ORDER BY fechaliquidacion DESC");
}

?>