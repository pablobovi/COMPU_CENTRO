<?php require_once('Connections/conexion_smile.php'); ?>
<?php include('sis_acceso_ok.php'); ?>
<?php date_default_timezone_set('America/Argentina/Tucuman'); ?>
<?php mysql_select_db($database_conexion_smile,$conexion_smile);
  $fechalogin=$_SESSION['fechalogin'];
  $idempleado=$_SESSION["idempleado"];
  $formato = 'Y-m-d H:i:s';
  $fecha =new DateTime();
  $dateformat = date_format($fecha, $formato);



  $seconds = strtotime($dateformat) - strtotime($fechalogin);

  $days    = floor($seconds / 86400);
  $hours   = floor(($seconds - ($days * 86400)) / 3600);
  $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);
  $seconds = floor(($seconds - ($days * 86400) - ($hours * 3600) - ($minutes*60)));

  $seconds = strtotime($dateformat) - strtotime($fechalogin);
  $days    = floor($seconds / 86400);
  $hours   = floor(($seconds - ($days * 86400)) / 3600);
  $minutes = floor(($seconds - ($days * 86400) - ($hours * 3600))/60);

  $horas_reales = $horas_reales + $hours;
  $minutos_acumulados = $minutos_acumulados + $minutes;
  if ($minutos_acumulados >= 60) {
      $minutos_acumulados = $minutos_acumulados - 60;
      $horas_acumuladas = $horas_acumuladas + 1;
  }
  $total_horas_trabajadas = $total_horas_trabajadas + $horas_reales + $horas_acumuladas;
  $total_minutos_trabajados = $minutos_acumulados;


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
