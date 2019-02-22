<?php require_once('Connections/conexion_smile.php'); ?>
<?php include('sis_acceso_ok.php'); ?>
<?php
class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('logo.png',10,-1,70);
    $this->SetFont('Arial','B',13);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(80,10,'Ventas List',1,0,'C');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

$db = new dbObj();
$connString =  $db->getConnstring();
// $display_heading = array('id'=>'ID', 'employee_name'=> 'Name', 'employee_age'=> 'Age','employee_salary'=> 'Salary',);

$q_venta=mysql_query("SELECT * FROM venta
INNER JOIN empleado ON empleado_idempleado=idempleado
INNER JOIN cliente ON cliente_idcliente=idcliente
LEFT JOIN venta_has_pago ON venta_idventa=idventa
LEFT JOIN pago ON pago_idpago=idpago
WHERE idventa!=1 ORDER BY fechaventa DESC");

// $result = mysqli_query($connString, "SELECT id, employee_name, employee_age, employee_salary FROM employee") or die("database error:". mysqli_error($connString));
// $header = mysqli_query($connString, "SHOW columns FROM ventas");

$pdf = new PDF();
//header
$pdf->AddPage();
//foter page
$pdf->AliasNbPages();
$pdf->SetFont('Arial','B',12);
foreach($header as $heading) {
$pdf->Cell(40,12,$display_heading[$heading['Field']],1);
}
foreach($result as $row) {
$pdf->Ln();
foreach($row as $column)
$pdf->Cell(40,12,$column,1);
}
$pdf->Output();
?>
