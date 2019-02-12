<?php

mysql_select_db($database_conexion_smile,$conexion_smile);

$consulta="SELECT * FROM lineaventa
INNER JOIN producto ON producto_idproducto=idproducto
WHERE venta_idventa=1";
$q_consulta=mysql_query($consulta);

?>