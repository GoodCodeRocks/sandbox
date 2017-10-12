<?php
require( 'assets/fpdf/fpdf.php');
//use \FPDF;

class Kay extends CI_Controller {
	
	public function index() {
		$pdf = new FPDF();
		$pdf->AddPage();
		$pdf->SetFont('Arial','B',16);
		$pdf->Cell(40,10,'Hello World!');
		$pdf->Output();
	}
	
}


