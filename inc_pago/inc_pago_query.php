<?php

mysql_select_db($database_conexion_smile,$conexion_smile);

$q_pago=mysql_query("SELECT * FROM cuenta inner join cliente on cliente_idcliente= idcliente where cuenta.estado=1");


?>