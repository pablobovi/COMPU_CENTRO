<?php require_once('Connections/conexion_smile.php'); ?>
<?php include('sis_acceso_ok.php'); ?>
<?php 
	$idempleado=$_SESSION["idempleado"];
  $accion=$_POST['accion'];
  $tabla=$_POST['tabla'];
  $descripcion=$_POST['descripcion'];
  $formato = 'Y-m-d H:i:s';
  $fecha =new DateTime();
  $dateformat = date_format($fecha, $formato);

  $insertlogin="INSERT INTO auditor (idempleado, accion,tabla, descripcion,fecha)
                VALUES ('$idempleado','$accion','$tabla',$descripcion,'$dateformat')";
  
  $q_insertarlogin = mysql_query($insertlogin);
  mysql_fetch_array($q_insertarlogin);
?>
