<?php
$hostname_conexion_smile = "localhost";
$database_conexion_smile = "db_compu_nuevo";
$username_conexion_smile = "root";
$password_conexion_smile = "";
$conexion_smile = @mysql_connect($hostname_conexion_smile, $username_conexion_smile, $password_conexion_smile) or trigger_error(mysql_error(),E_USER_ERROR);
Class dbObj{
  var $hostname_conexion_smile = "localhost";
  var $database_conexion_smile = "db_compu_nuevo";
  var $username_conexion_smile = "root";
  var $password_conexion_smile = "";

function getConnstring() {
$con = mysqli_connect($this->hostname_conexion_smile, $this->username_conexion_smile, $this->password_conexion_smile, $this->database_conexion_smile) or die("Connection failed: " . mysqli_connect_error());

/* check connection */
if (mysqli_connect_errno()) {
printf("Connect failed: %s\n", mysqli_connect_error());
exit();
} else {
$this->conn = $con;
}
return $this->conn;
}
}
?>
