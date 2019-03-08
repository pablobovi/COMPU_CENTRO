<?php require_once('../Connections/conexion_compucentro.php'); ?>
<?php include('../sis_acceso_ok.php'); ?>
<?php include_once('../lib/pdf/fpdf.php');
$idempleado=$_POST['idempleado'];
$mesliquidacion=$_POST['mesliquidacion'];

class PDF extends FPDF
{
// Page header
function Header()
{
  $idempleado=$_POST['idempleado'];
$mesliquidacion=$_POST['mesliquidacion'];
  $db = new dbObj();
$connString =  $db->getConnstring();
  $nombreempleado =  mysqli_query($connString, "SELECT nombreempleado, apellidoempleado
FROM empleado 
WHERE idempleado = '$idempleado'")
or die("database error:". mysqli_error($connString));
//$nombreempleado1 = NULL;
while($row=mysqli_fetch_assoc($nombreempleado))
  {
    $nombreempleado1 = ("Nombre Empleado: ").($row['nombreempleado']).(" ").($row['apellidoempleado']);
  }
    $fechaingreso =  mysqli_query($connString, "SELECT fechaingresoempleado
    FROM empleado 
    WHERE idempleado = '$idempleado'")
    or die("database error:". mysqli_error($connString));
    //$nombreempleado1 = NULL;
    while($row=mysqli_fetch_assoc($fechaingreso))
      {
        $fechaingreso1 = ("Fecha de ingreso: ").($row['fechaingresoempleado']);
      }
    // Logo
    $this->SetTitle('BOLETA');
    $this->Image('../images/logo.png',40,5,25);
    $this->SetFont('Times','B',13);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->SetTextColor(39, 138, 226);
    $this->Write(5,'Boleta de Sueldo');
    $this->Ln(20);
    $this->Cell(80,5,'CompuCentro',0,0,'C');
    $this->Cell(80,5,$nombreempleado1,20,2,'C');
    $this->Ln(1);
    $this->Cell(80,5,'Cordoba 828',0,0,'C');
    $this->Cell(80,5,$fechaingreso1,20,2,'C');
    $this->Ln(1);
    $this->Cell(80,5,'Cuit: 3070881234',0,0,'C');
    $this->Cell(80,5,$apellidoempleado1,20,2,'C');
    $this->Ln(1);
    $this->Cell(80,5,'Liquidacion: Febrero',0,0,'C');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Times italic 8

    $this->SetFont('Times','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

$db = new dbObj();
$connString =  $db->getConnstring();


// mysql_select_db($database_conexion_compucentro,$conexion_compucentro);
// $result = mysqli_query($connString, "SELECT descripcionconcepto, cantidad, subtotal,  NULL
// FROM detalleliquidacion
// INNER JOIN detalleconcepto ON detalleliquidacion_iddetalleliquidacion=iddetalleliquidacion
// INNER JOIN concepto ON concepto_idconcepto=idconcepto
// WHERE empleado_idempleado=$idempleado AND tipoconcepto='1'
// AND iddetalleliquidacion IN (SELECT MAX(iddetalleliquidacion) FROM detalleliquidacion
//                             where  empleado_idempleado = $idempleado
//                             )
// UNION
//
// SELECT descripcionconcepto, cantidad,  NULL, subtotal
// FROM detalleliquidacion
// INNER JOIN detalleconcepto ON detalleliquidacion_iddetalleliquidacion=iddetalleliquidacion
// INNER JOIN concepto ON concepto_idconcepto=idconcepto
// WHERE empleado_idempleado=$idempleado AND tipoconcepto='0'
// AND iddetalleliquidacion IN (SELECT MAX(iddetalleliquidacion) FROM detalleliquidacion
//                               where  empleado_idempleado = $idempleado  )") or die("database error:". mysqli_error($connString));
//
// $pagototal =  mysqli_query($connString, "SELECT pagototal
// FROM detalleliquidacion
// WHERE iddetalleliquidacion
// in ( SELECT MAX(iddetalleliquidacion) FROM detalleliquidacion)")
// or die("database error:". mysqli_error($connString));

$total = 0;
while($row=mysqli_fetch_assoc($pagototal))
  {
    $total = $total + ($row['pagototal']* -1);
  }
$total1 = 0;
while($row=mysqli_fetch_assoc($totaldebe))
  {
    $total1 = $total1 + ($row['totaldebe']);
  }
$total2 = 0;
while($row=mysqli_fetch_assoc($totalhaber))
  {
    $total2 = $total2 + ($row['totalhaber']);
  }
$pdf = new PDF();
//header
$pdf->AddPage('L','A4',0);
//foter page
$pdf->SetTextColor(39, 138, 226);
$pdf->SetFont('Times','B',9);
$pdf->Cell(31,8,"Concepto",1,0,'C');
$pdf->Cell(31,8,"Cantidad",1,0,'C');
$pdf->Cell(31,8,"Haber",1,0,'C');
$pdf->Cell(31,8,"Debe",1,0,'C');

foreach($result as $row) {
  $pdf->SetTextColor(100);
  $pdf->SetFont('Times','',9);
  $pdf->Ln();
  foreach($row as $column)
  $pdf->Cell(31,8,$column,1,0,'L');
}

$pdf->Ln();

$pdf->SetX(72);
$pdf->SetTextColor(208, 49, 53);
$pdf->SetFont('Times','B',9);
$pdf->Cell(31,8,round($total1, 2),1,0,'L');
$pdf->Cell(31,8,round($total2, 2),1,0,'L');
$pdf->Ln();
$pdf->SetX(72);
$pdf->Cell(31,8,'Total',1,0,'L');
$pdf->Cell(31,8,round($total, 2),1,0,'L');

$pdf->SetTextColor(100);
$pdf->Output('','Boleta.pdf');
?>
