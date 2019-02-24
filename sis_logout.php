<?php require_once('Connections/conexion_smile.php'); ?>
<?php include('sis_acceso_ok.php'); ?>
<?php date_default_timezone_set('America/Argentina/Tucuman'); ?>
<?php mysql_select_db($database_conexion_smile,$conexion_smile);
  $fechalogin=$_SESSION['fechalogin'];
  $idempleado=$_SESSION["idempleado"];
  $formato = 'Y-m-d H:i:s';
  $fecha =new DateTime();
  $dateformat = date_format($fecha, $formato);
  echo "$dateformat";
  $insertlogout="UPDATE asistencia set logout='$dateformat'
  WHERE login='$fechalogin' AND empleado_idempleado='$idempleado'";
  $q_insertarlogout=mysql_query($insertlogout);
  $row_logout=mysql_fetch_array($q_insertarlogout);
  ?>
<?php
header("Location: index.php");
session_destroy();
?>
