<?php

defined( '_JEXEC' ) or die( 'Restricted access' );
require_once( 'components' . DS . 'com_causa' . DS . 'helpers' . DS . 'pdf.helper.php');
// creamos el objeto FPDF

$pdf=new PDF('P','mm','boleta'); // vertical, milimetros y tama�o
$pdf->Open();
$pdf->AddPage(); // agregamos la pagina
$pdf->SetMargins(10,10,10); // definimos los margenes en este caso estan en milimetros
$pdf->Ln(10); // dejamos un peque�o espacio de 10 milimetros

$pdf->SetFont('Arial','B',18);

$pdf->Text(80,35,JText::_('COM_TECNMED_HEAD_BOLETA'),0, 'C', 0);



// listamos los datos con Cell
$pdf->SetFont('Arial','B',10);

for ($i=0, $n=count( $this->ficha ); $i < $n; $i++)
{
	$row = &$this->ficha[$i];
	$rutmedico = $row->rutmedico;
	$medico =$row->medico;
	
	$pdf->Cell(1,6,'Rut',0,0);
	$pdf->Cell(30);
	$pdf->Cell(1,6,':'.$row->rut,0,1);
	$pdf->Cell(1,6,'Nombre',0,0);
	$pdf->Cell(30);
	$pdf->Cell(1,6,':'.$row->nombre,0,1);
	
	$pdf->Cell(1,6,'Direccion',0,0);
	$pdf->Cell(30);
	$pdf->Cell(1,6,':'.$row->direcion,0,1);
	
	$pdf->Cell(1,6,'Medico',0,0);
	$pdf->Cell(30);
	$pdf->Cell(1,6,':'.$row->medico,0,1);
	
	
	/*$pdf->Cell(1,6,'Telefono',0,0);
	$pdf->Cell(30);
	$pdf->Cell(1,6,$row->telefono,0,1);
	$pdf->Ln(10);
*/
}


$pdf->Ln(10);
$pdf->SetFont('Arial','',8);
$pdf->SetWidths(array(100, 20));
$pdf->Row(array('Descripcion', 'Valor'));
$sumaPretacion = 0;
for ($i=0, $n=count( $this->ficha ); $i < $n; $i++)
{
	$row = &$this->ficha[$i];
	$pdf->Row(array('Atencion Medica','$'.$row->monto));
	$sumaPretacion = $sumaPretacion + $row->monto;
}
$pdf->Cell(100);
$pdf->SetWidths(array(20));
$pdf->Row(array('$'.$sumaPretacion));
$pdf->Ln(20);

$pdf->Ln(10);
//La ultima linea
ob_start();
$pdf->Output();
$output = ob_get_contents();
ob_end_clean();
echo $output;
exit;

?>