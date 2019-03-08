<?php require_once('../Connections/conexion_compucentro.php'); ?>
<?php include('../sis_acceso_ok.php'); ?>
<?php include_once('../lib/pdf/fpdf.php');
$idempleado=$_POST['idempleado'];
$fecha_desde=$_POST['fechadesde'];
$fechadesde =substr ( $fecha_desde , 0,7 );

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

$pdf = new PDF();
//header
$pdf->AddPage('L','A4',0);
//foter page


$result = mysqli_query($connString, "SELECT t2.apellidoempleado,t2.nombreempleado,t3.fechaliquidacion,t1.totalhaber,t1.totaldebe,t1.pagototal, t1.iddetalleliquidacion, t3.descripcionliq
    FROM detalleliquidacion t1
   INNER JOIN empleado t2 on empleado_idempleado=idempleado
   INNER JOIN liquidacion t3 on liquidacion_idliquidacion=idliquidacion
   where t1.empleado_idempleado=$idempleado AND t3.desde like ('%$fechadesde%')
   order by t1.iddetalleliquidacion Desc
   ") or die("database error:". mysqli_error($connString));

   while($row=mysqli_fetch_assoc($result))
     {
   $apellido= $row['apellidoempleado'];
   $nombre= $row['nombreempleado'];
   $totaldebe= $row['totaldebe'];
   $totalhaber= $row['totalhaber'];
   // $descipcionliquidacion=$row['descripcionliq'];
   // $descipcionliquidacionSubstring =substr ( $descipcionliquidacion , 0,14  ).".";

   $q_salariobasico = mysqli_query($connString, "SELECT salariobasicocategoria from categoriaempleado WHERE idcategoriaempleado=$categoriaempleado_idcategoriaempleado") or die("database error:". mysqli_error($connString));
   $salario=mysqli_fetch_array($q_salariobasico)['salariobasicocategoria'];
   $pagototal= 0;
   if ($row['pagototal']!=''|| $row['pagototal']!=null) {
     $pagototal= $row['pagototal'];
   }

   $iddetalleliquidacion= $row['iddetalleliquidacion'];

   $total = $total + $row['pagototal'];

   $antiguedad= 0;
   $aguinaldo = 0;
   $aporte_jubilatorio = 0;
   $obra_social = 0;
   $presentismo = 0;
   $basico=0;
   $asignacion_por_hijo_discapacitado=0;
   $asignacion_por_hijo= 0;

   $concepto_result = mysqli_query($connString, "SELECT concepto_idconcepto, subtotal, descripcionconcepto from detalleconcepto
     INNER JOIN concepto on concepto_idconcepto=idconcepto WHERE
     detalleliquidacion_iddetalleliquidacion = $iddetalleliquidacion ") or die("database error:". mysqli_error($connString));
     while($row_concepto=mysqli_fetch_assoc($concepto_result)){
         switch ($row_concepto['concepto_idconcepto']) {

           case 2:
               $antiguedad = $row_concepto['subtotal'];
               break;
           case 9:
               $obra_social= $row_concepto['subtotal'];
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
           case 14:
                 $aguinaldo= $row_concepto['subtotal'];
               break;
           case 15:
            $asignacion_por_hijo_discapacitado= $row_concepto['subtotal'];
                break;
           case 16:
             $basico= $row_concepto['subtotal'];
                break;
         }
     }



}
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
