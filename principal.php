<?php require_once('Connections/conexion_smile.php'); ?>
<?php include('sis_acceso_ok.php'); ?>
<!doctype html>
<html lang="es">
<head>
	<?php include "sis_header.php" ?>
</head>
<body class=" theme-blue">
<?php include "sis_script.php" ?>
<?php include "sis_menu_usuario.php" ?>
<?php include "sis_menu.php" ?>

<div class="content">

<div class="main-content">

	<center>
	     <img src="images/logo.png" alt="Logo">
	</center>
<?php
/*	if($_SESSION["tipo_usuario"]==1)
	{
		include "inc_principal/inc_principal_grafica_circular.php";
	}
	else
	{
		include "inc_principal/inc_principal_grafica_circular.php";

	}*/



?>



<?php include "inc_footer.php" ?>
</div>
</div>
<?php include "sis_script_bootstrap.php" ?>

</body>
</html>
