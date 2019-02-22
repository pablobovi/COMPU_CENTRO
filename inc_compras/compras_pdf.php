<?php require_once('../Connections/conexion_smile.php'); ?>
<?php include('../sis_acceso_ok.php'); ?>
<?php
 ob_start();
include_once('../lib/pdf/fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('../images/logo.png',10,5,25);
    $this->SetFont('Arial','B',13);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(80,10,'Listado IVA Compra',1,0,'C');
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
$display_heading = array('idcompra'=>'ID', 'numerofactura'=> 'numero de factura', 'fechacompra'=> 'fecha de compra','totalcompra'=> 'Total',);

// $q_compra=mysql_query("SELECT * FROM compra");

$result = mysqli_query($connString, "SELECT idcompra, numerofactura,fechacompra, totalcompra FROM compra") or die("database error:". mysqli_error($connString));
$header = mysqli_query($connString, "SHOW idcompra,numerofactura,fechacompra,totalcompra FROM compras");

$pdf = new PDF();
//header
$pdf->AddPage();
//foter page
$pdf->AliasNbPages();
foreach($header as $heading) {
$pdf->Cell(40,12,$display_heading[$heading['Field']],1);
}
$pdf->SetFont('Arial','B',12);
$pdf->Cell(45,12,"ID Compra",1,0,'C');
$pdf->Cell(45,12,"Nro Factura",1,0,'C');
$pdf->Cell(45,12,"Fecha de compra",1,0,'C');
$pdf->Cell(45,12,"Total($)",1,0,'C');
foreach($result as $row) {
$pdf->Ln();
foreach($row as $column)
$pdf->Cell(45,12,$column,1,0,'C');
}
$pdf->Output();
ob_end_flush();
?>
