<?php require_once('../Connections/conexion_smile.php'); ?>
<?php include('../sis_acceso_ok.php'); ?>
<?php
include_once('../lib/pdf/fpdf.php');

class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->SetTitle('LIBRO SUELDO');
    $this->Image('../images/logo.png',10,5,25);
    $this->SetFont('Arial','B',13);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->SetTextColor(39, 138, 226);

    $this->Cell(80,10,'LIBRO UNICO DE SUELDOS',1,0,'C');
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
mysql_select_db($database_conexion_smile,$conexion_smile);
if (isset($_POST['fechadesde']) && $_POST['fechadesde']!=''&& isset($_POST['fechahasta']) && $_POST['fechahasta']!='') {
  	$fecha_desde = $_POST['fechadesde'];
    $fecha_hasta = $_POST['fechahasta'];

  $result = mysqli_query($connString, "SELECT apellidoempleado,nombreempleado,fecha,totalhaber,totaldebe,pagototal FROM detalleliquidacion
     INNER JOIN empleado on empleado_idempleado=idempleado
      where fecha >= '$fecha_desde' && fecha <= '$fecha_hasta'") or die("database error:". mysqli_error($connString));

}else {
  if (isset($_POST['fechadesde']) && $_POST['fechadesde']!='') {
    $fecha_desde = $_POST['fechadesde'];
    $result = mysqli_query($connString, "SELECT apellidoempleado,nombreempleado,fecha,totalhaber,totaldebe,pagototal FROM detalleliquidacion
       INNER JOIN empleado on empleado_idempleado=idempleado
        where fecha >= '$fecha_desde'") or die("database error:". mysqli_error($connString));
  } else {
      if (isset($_POST['fechahasta']) && $_POST['fechahasta']!='') {
        $fecha_hasta = $_POST['fechahasta'];
        $result = mysqli_query($connString, "SELECT apellidoempleado,nombreempleado,fecha,totalhaber,totaldebe,pagototal FROM detalleliquidacion
           INNER JOIN empleado on empleado_idempleado=idempleado
            where fecha <= '$fecha_hasta'") or die("database error:". mysqli_error($connString));
      } else{
        $result = mysqli_query($connString, "SELECT apellidoempleado,nombreempleado,fechadeposito,totalhaber,totaldebe,pagototal, iddetalleliquidacion FROM detalleliquidacion
           INNER JOIN empleado on empleado_idempleado=idempleado") or die("database error:". mysqli_error($connString));

      }
  }
}
// $total = 0;
// while($row=mysqli_fetch_assoc($result))
//   {
//     $total = $total + $row['pagototal'];
//         echo $row['pagototal'];
//   }

$pdf = new PDF();
//header
$pdf->AddPage('L','A4',-90);
//foter page
$pdf->AliasNbPages();
$pdf->SetTextColor(39, 138, 226);
$pdf->SetFont('Arial','B',6);

$pdf->SetX(76);
$pdf->Cell(88,6,"Haberes",1,0,'C');
$pdf->Cell(88,6,"Debes",1,0,'C');
$pdf->Ln();

$pdf->Cell(22,6,"Apellido",1,0,'C');
$pdf->Cell(22,6,"Nombre",1,0,'C');
$pdf->Cell(22,6,"Fecha",1,0,'C');
$pdf->Cell(22,6,"Antiguedad",1,0,'C');
$pdf->Cell(22,6,"Asignacion por Hijo",1,0,'C');
$pdf->Cell(22,6,"Presentismo",1,0,'C');
$pdf->Cell(22,6,"Salario Familiar",1,0,'C');
$pdf->Cell(22,6,"Subsidio de Sepelio",1,0,'C');
$pdf->Cell(22,6,"Subsidio Familiar",1,0,'C');
$pdf->Cell(22,6,"Aporte Jubilatorio",1,0,'C');
$pdf->Cell(22,6,"Obra Social",1,0,'C');
$pdf->Cell(22,6,"Total",1,0,'C');


$total = 0;

while($row=mysqli_fetch_assoc($result))
  {
    $apellido= $row['apellidoempleado'];
    $nombre= $row['nombreempleado'];
    $fecha= $row['fechadeposito'];
    $totaldebe= $row['totaldebe'];
    $totalhaber= $row['totalhaber'];
    $pagototal= 0;
    if ($row['pagototal']!=''|| $row['pagototal']!=null) {
      $pagototal= $row['pagototal'];
    }

    $iddetalleliquidacion= $row['iddetalleliquidacion'];

    $total = $total + $row['pagototal'];

    $antiguedad= 0;
    $subsidio_sepelio = 0;
    $subsidio_familiar= 0;
    $salario_familiar = 0;
    $aporte_jubilatorio = 0;
    $obra_social = 0;
    $presentismo = 0;
    $aporte_pami=0;
    $asignacion_por_hijo= 0;

    $concepto_result = mysqli_query($connString, "SELECT concepto_idconcepto, subtotal, descripcionconcepto from detalleconcepto
      INNER JOIN concepto on concepto_idconcepto=idconcepto WHERE
      detalleliquidacion_iddetalleliquidacion = $iddetalleliquidacion ") or die("database error:". mysqli_error($connString));
      while($row_concepto=mysqli_fetch_assoc($concepto_result))
        {
          switch ($row_concepto['concepto_idconcepto']) {
            case 0:
                echo "i es igual a 0";
                break;
            case 1:
                echo "i es igual a 1";
                break;
            case 2:
                $antiguedad = $row_concepto['subtotal'];
                break;
            case 3:
                $subsidio_sepelio = $row_concepto['subtotal'];
                break;
            case 4:
                $subsidio_familiar= $row_concepto['subtotal'];
                break;
            case 5:
                $salario_familiar = $row_concepto['subtotal'];
                break;
            case 6:
                $aporte_jubilatorio= $row_concepto['subtotal'];
                break;
            case 7:
                $obra_social= $row_concepto['subtotal'];
                break;
            case 8:
                $aporte_pami= $row_concepto['subtotal'];
                break;
            case 9:
                $obra_social= $row_concepto['subtotal'];
                break;
            case 10:
              $aporte_pami= $row_concepto['subtotal'];
                break;
            case 11:
                $asignacion_por_hijo= $row_concepto['subtotal'];
                break;
            case 12:
                $presentismo= $row_concepto['subtotal'];
                break;
            case 13:
                $aporte_jubilatorio= $row_concepto['subtotal'];
                break;
              }
  }

        $pdf->Ln();
        $pdf->SetTextColor(100);
        $pdf->SetFont('Arial','',6);
        $pdf->Cell(22,6,$apellido,1,0,'C');
        $pdf->Cell(22,6,$nombre,1,0,'C');
        $pdf->Cell(22,6,$fecha,1,0,'C');
        $pdf->Cell(22,6,$antiguedad,1,0,'C');
        $pdf->Cell(22,6,$asignacion_por_hijo,1,0,'C');
        $pdf->Cell(22,6,$presentismo,1,0,'C');
        $pdf->Cell(22,6,$salario_familiar,1,0,'C');
        $pdf->Cell(22,6,$subsidio_sepelio,1,0,'C');
        $pdf->Cell(22,6,$subsidio_familiar,1,0,'C');
        $pdf->Cell(22,6,$aporte_jubilatorio,1,0,'C');
        $pdf->Cell(22,6,$obra_social,1,0,'C');
        $pdf->Cell(22,6,$pagototal,1,0,'C');


  }

$pdf->Ln();



$pdf->SetX(230);
$pdf->SetTextColor(208, 49, 53);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(22,8,'Total',1,0,'C');
$pdf->Cell(22,8,round($total, 2),1,0,'C');
$pdf->SetTextColor(100);

$pdf->Output('','LIBRO_SUELDO.pdf');
?>
