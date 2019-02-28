<?php require_once('../Connections/conexion_smile.php'); ?>
<?php include('../sis_acceso_ok.php'); ?>
<?php include_once('../lib/pdf/fpdf.php');
$idempleado=$_POST['idempleado'];

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->SetTitle('BOLETA');
    $this->Image('../images/logo.png',10,5,25);
    $this->SetFont('Arial','B',13);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->SetTextColor(39, 138, 226);

    $this->Cell(80,10,'Boleta de Sueldo',1,0,'C');
    $this->Ln(20);
    $this->Cell(80,5,'Empresa: CompuCentro',0,0,'C');
    $this->Ln(5);
    $this->Cell(80,5,'Domicilio: Cordoba 828',0,0,'C');
    $this->Ln(5);
    $this->Cell(80,5,'Localidad: S. M. de Tuc.',0,0,'C');
    $this->Ln(5);
    $this->Cell(80,5,'Cuit: 3070881234',0,0,'C');
    $this->Ln(5);
    $this->Cell(80,5,'Liquidacion: Febrero',0,0,'C');
    $this->Ln(5);
    $this->Cell(80,5,'L. Pago: S. M. de Tuc.',0,0,'C');
    $this->Cell(80,5,'F. Pago: 27/02/2019.',0,0,'C');
    $this->Ln(5);
    $this->Cell(80,5,'Nombre Empleado',0,0,'C');
    $this->Cell(80,5,'DNI',0,0,'C');
    $this->Ln(5);
    $this->Cell(80,5,'Fecha Ingreso',0,0,'C');
    $this->Cell(80,5,'Categoria',0,0,'C');



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

/* 
// $q_compra=mysql_query("SELECT * FROM compra");
mysql_select_db($database_conexion_smile,$conexion_smile);
$result = mysqli_query($connString, "SELECT descripcionconcepto, cantidad, totalhaber, tipoconcepto FROM detalleliquidacion 
INNER JOIN detalleconcepto ON detalleliquidacion_iddetalleliquidacion=iddetalleliquidacion
INNER JOIN concepto ON concepto_idconcepto=idconcepto WHERE empleado_idempleado=$idempleado AND tipoconcepto='0'") or die("database error:". mysqli_error($connString));

$total1 = 0;
while($row=mysqli_fetch_assoc($result))
  {
    $total1 = $total1 + $row['totalhaber'];
  }

$pdf = new PDF();
//header
$pdf->AddPage('L','A4',0);
//foter page
$pdf->AliasNbPages();
$pdf->SetTextColor(39, 138, 226);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(31,8,"Concepto",1,0,'C');
$pdf->Cell(31,8,"Cantidad",1,0,'C');
$pdf->Cell(31,8,"Haber",1,0,'C');
$pdf->Cell(31,8,"Tipo concepto",1,0,'C');

foreach($result as $row) {
  $pdf->SetTextColor(100);
  $pdf->SetFont('Arial','',9);
  $pdf->Ln();
  foreach($row as $column)
  $pdf->Cell(31,8,$column,1,0,'C');
}
*/
mysql_select_db($database_conexion_smile,$conexion_smile);
$result = mysqli_query($connString, "SELECT descripcionconcepto, cantidad, subtotal,  NULL 
FROM detalleliquidacion 
INNER JOIN detalleconcepto ON detalleliquidacion_iddetalleliquidacion=iddetalleliquidacion
INNER JOIN concepto ON concepto_idconcepto=idconcepto 
WHERE empleado_idempleado=7 AND tipoconcepto='0' 
AND iddetalleliquidacion IN (SELECT MAX(iddetalleliquidacion) FROM detalleliquidacion)
UNION

SELECT descripcionconcepto, cantidad,  NULL, subtotal 
FROM detalleliquidacion 
INNER JOIN detalleconcepto ON detalleliquidacion_iddetalleliquidacion=iddetalleliquidacion
INNER JOIN concepto ON concepto_idconcepto=idconcepto 
WHERE empleado_idempleado=7 AND tipoconcepto='1'
AND iddetalleliquidacion IN (SELECT MAX(iddetalleliquidacion) FROM detalleliquidacion)") or die("database error:". mysqli_error($connString));

$pagototal =  mysqli_query($connString, "SELECT pagototal 
FROM detalleliquidacion 
WHERE iddetalleliquidacion 
in ( SELECT MAX(iddetalleliquidacion) FROM detalleliquidacion)")
or die("database error:". mysqli_error($connString));

$total = 0;
while($row=mysqli_fetch_assoc($pagototal))
  {
    $total = $total + $row['pagototal'];
  }

$pdf = new PDF();
//header
$pdf->AddPage('L','A4',0);
//foter page
$pdf->AliasNbPages();
$pdf->SetTextColor(39, 138, 226);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(31,8,"Concepto",1,0,'C');
$pdf->Cell(31,8,"Cantidad",1,0,'C');
$pdf->Cell(31,8,"Haber",1,0,'C');
$pdf->Cell(31,8,"Debe",1,0,'C');

foreach($result as $row) {
  $pdf->SetTextColor(100);
  $pdf->SetFont('Arial','',9);
  $pdf->Ln();
  foreach($row as $column)
  $pdf->Cell(31,8,$column,1,0,'C');
}

$pdf->Ln();

$pdf->SetX(103);
$pdf->SetTextColor(208, 49, 53);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(31,8,'Total',1,0,'C');
$pdf->Cell(31,8,round($total, 2),1,0,'C');

$pdf->SetTextColor(100);
$pdf->Output('','Boleta.pdf');
?>
