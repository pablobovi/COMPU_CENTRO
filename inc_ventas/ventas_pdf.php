<?php require_once('../Connections/conexion_compucentro.php'); ?>
<?php include('../sis_acceso_ok.php'); ?>
<?php
include_once('../lib/pdf/fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->SetTitle('IVA_VENTA');
    $this->Image('../images/logo.png',10,5,25);
    $this->SetFont('Arial','B',13);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->SetTextColor(39, 138, 226);

    $this->Cell(80,10,'LIBRO IVA VENTA',1,0,'C');
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

// $q_compra=mysql_query("SELECT * FROM compra");
mysql_select_db($database_conexion_compucentro,$conexion_compucentro);
if (isset($_POST['fechadesde']) && $_POST['fechadesde']!=''&& isset($_POST['fechahasta']) && $_POST['fechahasta']!='') {
  	$fecha_desde = $_POST['fechadesde'];
    $fecha_hasta = $_POST['fechahasta'];

  $result = mysqli_query($connString, "SELECT fechaventa,nombreorsocial,cuilcliente,tiponombre, numerofactura,totalventa,
    subtotal, ivaventa FROM venta
    INNER JOIN cliente on cliente_idcliente=idcliente
    INNER JOIN tipo on tipo_idtipo = idtipo
      where fechaventa >= '$fecha_desde' && fechaventa <= '$fecha_hasta'") or die("database error:". mysqli_error($connString));

}else {
  if (isset($_POST['fechadesde']) && $_POST['fechadesde']!='') {
    $fecha_desde = $_POST['fechadesde'];
    $result = mysqli_query($connString, "SELECT fechaventa,nombreorsocial,cuilcliente,tiponombre, numerofactura,totalventa,
      subtotal, ivaventa FROM venta
      INNER JOIN cliente on cliente_idcliente=idcliente
      INNER JOIN tipo on tipo_idtipo = idtipo
        where fechaventa >= '$fecha_desde'") or die("database error:". mysqli_error($connString));
  } else {
      if (isset($_POST['fechahasta']) && $_POST['fechahasta']!='') {
        $fecha_hasta = $_POST['fechahasta'];
        $result = mysqli_query($connString, "SELECT fechaventa,nombreorsocial,cuilcliente,tiponombre, numerofactura,totalventa,
          subtotal, ivaventa FROM venta
          INNER JOIN cliente on cliente_idcliente=idcliente
          INNER JOIN tipo on tipo_idtipo = idtipo
            where fechaventa <= '$fecha_hasta'") or die("database error:". mysqli_error($connString));
      } else{
        $result = mysqli_query($connString, "SELECT fechaventa,nombreorsocial,cuilcliente,tiponombre, numerofactura,totalventa,
          subtotal, ivaventa FROM venta
          INNER JOIN cliente on cliente_idcliente=idcliente
          INNER JOIN tipo on tipo_idtipo = idtipo

        ") or die("database error:". mysqli_error($connString));

      }
  }
}
$total = 0;
while($row=mysqli_fetch_assoc($result))
  {
    $total = $total + $row['ivaventa'];
  }

$pdf = new PDF();
//header
$pdf->AddPage('L','A4',-90);
//foter page
$pdf->AliasNbPages();
$pdf->SetTextColor(39, 138, 226);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(32,8,"Fecha de Venta",1,0,'C');
$pdf->Cell(32,8,"Cliente",1,0,'C');
$pdf->Cell(32,8,"Cuil Cliente",1,0,'C');
$pdf->Cell(32,8,"Cond. IVA",1,0,'C');
$pdf->Cell(32,8,"Nro Factura",1,0,'C');
$pdf->Cell(32,8,"Total Impor.\t Fact.",1,0,'C');
$pdf->Cell(32,8,"Importes\t Gravados",1,0,'C');
$pdf->Cell(32,8,"IVA Credito\t Fiscal",1,0,'C');
foreach($result as $row) {
  $pdf->SetTextColor(100);
  $pdf->SetFont('Arial','',9);
$pdf->Ln();
foreach($row as $column)
$pdf->Cell(32,8,$column,1,0,'C');
}
$pdf->Ln();

$pdf->SetX(202);
$pdf->SetTextColor(208, 49, 53);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(32,8,'Total',1,0,'C');
$pdf->Cell(32,8,round($total, 2),1,0,'C');
$pdf->SetTextColor(100);

$pdf->Output('','IVA_VENTA.pdf');
?>
