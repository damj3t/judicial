<?php
/**
 * @package Joomla
 * @subpackage Causa
 * @copyright (C) 2012 Alex Olave 
 */

defined( '_JEXEC' ) or die( 'Restricted access' );
// incluimos la libreria fpdf
require_once( 'components' . DS . 'com_causa' . DS . 'libraries' . DS . 'fpdf.php');
class PDF extends FPDF
{
	var $widths;
	var $aligns;

	public function SetWidths($w)
	{
		$this->widths=$w;
	}

	public function SetAligns($a)
	{
		$this->aligns=$a;
	}

	public function Row($data)
	{
		$nb=0;
		for($i=0;$i<count($data);$i++)
		$nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
		$h=6*$nb;
		$this->CheckPageBreak($h);
		for($i=0;$i<count($data);$i++)
		{
			$w=$this->widths[$i];
			$a=isset($this->aligns[$i]) ? $this->aligns[$i] : 'L';
			$x=$this->GetX();
			$y=$this->GetY();
			$this->Rect($x,$y,$w,$h);
			$this->MultiCell($w,6,$data[$i],0,$a);
			$this->SetXY($x+$w,$y);
		}
		$this->Ln($h);
	}

	public function CheckPageBreak($h)
	{
		if($this->GetY()+$h>$this->PageBreakTrigger)
		$this->AddPage($this->CurOrientation);
	}

	public function NbLines($w,$txt)
	{
		$cw=&$this->CurrentFont['cw'];
		if($w==0)
		$w=$this->w-$this->rMargin-$this->x;
		$wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
		$s=str_replace("\r",'',$txt);
		$nb=strlen($s);
		if($nb>0 and $s[$nb-1]=="\n")
		$nb--;
		$sep=-1;
		$i=0;
		$j=0;
		$l=0;
		$nl=1;
		while($i<$nb)
		{
			$c=$s[$i];
			if($c=="\n")
			{
				$i++;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
				continue;
			}
			if($c==' ')
			$sep=$i;
			$l+=$cw[$c];
			if($l>$wmax)
			{
				if($sep==-1)
				{
					if($i==$j)
					$i++;
				}
				else
				$i=$sep+1;
				$sep=-1;
				$j=$i;
				$l=0;
				$nl++;
			}
			else
			$i++;
		}
		return $nl;
	}

	public function Header()
	{
		$this->SetTextColor(102,102,102);
		$this->SetFont('Arial','',25);
		$this->Image('media/com_causa/images/logo.png' , 'PNG', 'http://www.alfazeta.cl');
		//$this->Text(80,35,JText::_('COM_TECNMED_HEAD_REPORTE'),0, 'C', 0);
		$this->Ln(30);
	}

	public function Footer()
	{
		$this->SetY(-15);
		$this->SetFont('Arial','B',8);
		$this->Cell(0,10, JText::_('COM_TECNMED_PIE_PAGINA_REPORTE'),0,0,'L');	
	}



	//Colored table
	function FancyTable($header,$data)
	{
		//Colors, line width and bold font
		$this->SetFillColor(0,70,70);
		$this->SetTextColor(255);
		$this->SetDrawColor(238,238,238);
		$this->SetLineWidth(.3);
		$this->SetFont('','B');

		//Header
		$w=array(40,100);

		for($i=0;$i<count($header);$i++)
		$this->Cell($w[$i],7,utf8_decode($header[$i]),1,0,'C',true);
		$this->Ln();

		//Color and font restoration
		$this->SetFillColor(230,237,224);
		$this->SetTextColor(98,98,98);
		$this->SetFont('','',12);

		//Data

		//NbLines is now applied to the table itself. Note that this time its value will be multiplied
		//by seven because that's the desirable line height here.

		//Note that NbLines will be applied to the column before the one where text is supposed to wrap,
		//so each line of the first column will match each MultiCell's height.

		//the function utf8_decode was applied here so latin characters would be correctly displayed.

		$fill=false;
		$is=0;

		foreach($data as $row)
		{
			$lines[]=$this->Nblines(100,$row[1]);

			$this->Cell($w[0],($lines[$is])*7,utf8_decode($row[0]),'LR',0,'L',$fill);
			$this->MultiCell($w[1],7,utf8_decode($row[1]),'LR','J',$fill);

			$is++;
			$fill=!$fill;
		}

		//Closure line
		$this->Cell(array_sum($w),0,'','T');

	}
}

?>
