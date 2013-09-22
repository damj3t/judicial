<?php

defined( '_JEXEC' ) or die( 'Restricted access' );
//require_once('fpdf.php');
require_once( 'components' . DS . 'com_causa' . DS . 'helpers' . DS . 'pdf.helper.php');
// creamos el objeto FPDF
$pdf=new PDF(); // vertical, milimetros y tama�o
$pdf->Open();
$pdf->AddPage(); // agregamos la pagina
$pdf->SetMargins(10,10,10); // definimos los margenes en este caso estan en milimetros
$pdf->Ln(10); // dejamos un peque�o espacio de 10 milimetros



// listamos los datos con Cell
$pdf->SetFont('Arial','B',10);

for ($i=0, $n=count( $this->ficha ); $i < $n; $i++)
{
	$row = &$this->ficha[$i];
	$rutmedico = $row->rutmedico;
	$medico =$row->medico;
	
	$pdf->Cell(1,6,'Rut',0,0);
	$pdf->Cell(30);
	$pdf->Cell(1,6,$row->rut,0,1);
	$pdf->Cell(1,6,'Nombre',0,0);
	$pdf->Cell(30);
	$pdf->Cell(1,6,$row->nombre,0,1);
	$pdf->Cell(1,6,'Direccion',0,0);
	$pdf->Cell(30);
	$pdf->Cell(1,6,$row->direcion,0,1);
	$pdf->Cell(1,6,'Telefono',0,0);
	$pdf->Cell(30);
	$pdf->Cell(1,6,$row->telefono,0,1);
	$pdf->Ln(10);
	
	
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(10,6 ,'Evolucion' ,0,1);
	$pdf->Cell(20);
	$pdf->SetFont('Arial','',8);
	$pdf->multiCell(150,6 ,utf8_decode($row->evolucion));
	
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(10,6 ,'Signos Vitales' ,0,'',1);
	
	$pdf->Ln(10);
	$pdf->SetFont('Arial','',8);
	$pdf->SetWidths(array(20,20,10,30,10,10));
	$pdf->Row(array('Peso','Estatura','IMC','Temperatura', 'P.A.','F.C.'));
	$pdf->Row(array($row->peso,$row->estatura,$row->indice_masa_corporal,$row->temperatura,$row->precion_arterial,$row->frecuencia_cardiaca));
		
	$pdf->Ln(10);
	$pdf->SetFont('Arial','B',10);
	$pdf->Cell(10,6 ,'Diagnostico' ,0,1,1);
	$pdf->Cell(20);
	$pdf->SetFont('Arial','',8);
	$pdf->Cell(1,6,$row->diagnostico,0,1);
	
	
}

$pdf->Ln(10);
$pdf->SetFont('Arial','B',10);	
$pdf->Cell(10,6 ,'Recetas' ,0,'',1);

$pdf->Ln(10);
$pdf->SetFont('Arial','',8);
$pdf->SetWidths(array(50, 100));
$pdf->Row(array('Medicamento', 'Dosis'));

for ($i=0, $n=count( $this->Medicamentos ); $i < $n; $i++)
{
	$row = &$this->Medicamentos[$i];
	$pdf->Row(array($row->farmaco,$row->posologia));
}
$pdf->Ln(20);
$pdf->Cell(80);
$pdf->Cell(10,6 ,$medico ,0,1,1);
$pdf->Cell(80);
$pdf->Cell(10,6 ,$rutmedico,0,1,1);
//$pdf->Cell(50,6 ,'Medico: ' ,0,'',0);
//$pdf->Cell(80,6 ,'Rut   : ' ,0,'',0);
$pdf->Ln(10);
//La ultima linea
ob_start();
$pdf->Output();
$output = ob_get_contents();
ob_end_clean();
echo $output;
exit;

?>