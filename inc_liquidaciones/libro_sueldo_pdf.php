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
        $result = mysqli_query($connString, "SELECT apellidoempleado,nombreempleado,fecha,totalhaber,totaldebe,pagototal, tipoliquidacion_idtipoliquidacion FROM detalleliquidacion
           INNER JOIN empleado on empleado_idempleado=idempleado
           INNER JOIN liquidacion on liquidacion_idliquidacion=idliquidacion") or die("database error:". mysqli_error($connString));

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
$pdf->Cell(25,6,"Apellido",1,0,'C');
$pdf->Cell(25,6,"Nombre",1,0,'C');
$pdf->Cell(25,6,"Fecha",1,0,'C');
$pdf->Cell(25,6,"Antiguedad",1,0,'C');
$pdf->Cell(25,6,"Subsidio de Sepelio",1,0,'C');
$pdf->Cell(25,6,"Subsidio Familiar",1,0,'C');
$pdf->Cell(25,6,"Salario Familiar",1,0,'C');
$pdf->Cell(25,6,"Aporte Jubilatorio",1,0,'C');
$pdf->Cell(25,6,"Obra Social",1,0,'C');
$pdf->Cell(25,6,"Presentismo",1,0,'C');
$pdf->Cell(25,6,"Asignacion por Hijo",1,0,'C');
$pdf->Cell(25,6,"Total",1,0,'C');

$total = 0;
$pdf->Ln();

while($row=mysqli_fetch_assoc($result))
  {
    $apellido= $row['apellidoempleado'];
    $nombre= $row['nombreempleado'];
    $fecha= $row['fecha'];
    $totaldebe= $row['totaldebe'];
    $totalhaber= $row['totalhaber'];
    $pagototal= $row['pagototal'];
    $id_tipoliquidacion= $row['tipoliquidacion_idtipoliquidacion'];

    $total = $total + $row['pagototal'];

    $antiguedad= 0;
    $subsidio_sepelio = 0;
    $subsidio_familiar= 0;
    $salario_familiar = 0;
    $aporte_jubilatorio = 0;
    $obra_social = 0;
    $presentismo = 0;
    $asignacion_por_hijo= 0;

    $concepto_result = mysqli_query($connString, "SELECT idconcepto, descripcionconcepto from tipoliquidacion_concepto
      INNER JOIN concepto on concepto_idconcepto=idconcepto WHERE tipoliquidacion_idtipoliquidacion = $id_tipoliquidacion ") or die("database error:". mysqli_error($connString));
      while($row_concepto=mysqli_fetch_assoc($concepto_result))
        {
          switch ($row_concepto['idconcepto']) {
            case 0:
                echo "i es igual a 0";
                break;
            case 1:
                echo "i es igual a 1";
                break;
            case 2:
                $antiguedad = $row_concepto['idconcepto'];
                break;
            case 3:
                echo "i es igual a 2";
                break;
            case 4:
                echo "i es igual a 2";
                break;
            case 5:
                echo "i es igual a 2";
                break;
            case 6:
                echo "i es igual a 2";
                break;
            case 7:
                echo "i es igual a 2";
                break;
            case 8:
                echo "i es igual a 2";
                break;  }
            case 9:
                echo "i es igual a 2";
                break;
            case 10:
                echo "i es igual a 2";
                break;
            case 11:
                echo "i es igual a 2";
                break;
            case 12:
                echo "i es igual a 2";
                break;
            case 13:
                echo "i es igual a 2";
                break;
              }
  }

        $pdf->Ln();
        $pdf->SetTextColor(100);
        $pdf->SetFont('Arial','',6);
        $pdf->Cell(25,6,"Apellido",1,0,'C');
        $pdf->Cell(25,6,"Nombre",1,0,'C');
        $pdf->Cell(25,6,"Fecha",1,0,'C');
        $pdf->Cell(25,6,"Antiguedad",1,0,'C');
        $pdf->Cell(25,6,"Subsidio de Sepelio",1,0,'C');
        $pdf->Cell(25,6,"Subsidio Familiar",1,0,'C');
        $pdf->Cell(25,6,"Salario Familiar",1,0,'C');
        $pdf->Cell(25,6,"Aporte Jubilatorio",1,0,'C');
        $pdf->Cell(25,6,"Obra Social",1,0,'C');
        $pdf->Cell(25,6,"Presentismo",1,0,'C');
        $pdf->Cell(25,6,"Asignacion por Hijo",1,0,'C');
        $pdf->Cell(25,6,"Total",1,0,'C');


  }
foreach($result as $row) {
  $pdf->SetTextColor(100);
  $pdf->SetFont('Arial','',9);
$pdf->Ln();
foreach($row as $column)
$pdf->Cell(40,8,$column,1,0,'C');
}
$pdf->Ln();



$pdf->SetX(170);
$pdf->SetTextColor(208, 49, 53);
$pdf->SetFont('Arial','B',9);
$pdf->Cell(40,8,'Total',1,0,'C');
$pdf->Cell(40,8,round($total, 2),1,0,'C');
$pdf->SetTextColor(100);

$pdf->Output('','LIBRO_SUELDO.pdf');
?>
