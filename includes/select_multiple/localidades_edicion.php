
<?php
$hostname_conexion_smile = "localhost";
$database_conexion_smile = "db_smile";
$username_conexion_smile = "root";
$password_conexion_smile = "";

$conexion_smile = @mysql_connect($hostname_conexion_smile, $username_conexion_smile, $password_conexion_smile) or trigger_error(mysql_error(),E_USER_ERROR);

mysql_select_db($database_conexion_smile,$conexion_smile);

$idlocalidad=$_GET['idlocalidad'];
$idprovincia = $_POST['idprovinciajs'];
$localidad="SELECT * FROM localidad WHERE provincia_idprovincia=$idprovincia";
$q_localidad=mysql_query($localidad);

while ($row_localidad=mysql_fetch_array($q_localidad)) { 
		if ($row_localidad['idlocalidad'] == $idlocalidad) {
		$html.= '<option value="'.$row_localidad['idlocalidad'].'" selected >'.$row_localidad['nombrelocalidad'].'</option>';
		}
        else{       
        $html.= '<option value="'.$row_localidad['idlocalidad'].'">'.$row_localidad['nombrelocalidad'].'</option>';
    	}
    }

echo $html;
?>
