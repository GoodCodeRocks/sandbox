<?php
require( 'assets/fpdf/fpdf.php');

class Pdf extends CI_Controller{
	function Header(){
		$this->Image('assets/img/usc_logo.png',10,6,30);
		$this->SetFont('Arial','B',15);
		$this->Cell(80);
		$this->Cell(30,10,'Requisition Invoice',1,0,'C');
		$this->Ln(20);
	}
	// 	function Chapter(){
	
	// 	}
	// 	function Mybody(){
	
	// 	}
	
	// 	function Footer(){
	// 		$this->SetY(-15);
	// 		$this->SetFont('Arial','I',8);
	// 		$this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
	// 	}
	
	public function index() {

		$pdf = new FPDF();
		$pdf->AliasNbPages();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		//$pdf->cell(0,10,);
		for($i=1;$i<=26;$i++){
			$pdf->Cell(0,10,'Printing line number '.$i,0,1);
		}
			$pdf->Output();
	}
	
	

}



?>