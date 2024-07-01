<?php
require('fpdf.php');
require_once __DIR__ . '/../../../../controllers/Docente.php'; 

use Letalandroid\controllers\Docente;

class PDF extends FPDF {
    
    function Header() {
        $this->Image('icon.png', 175, 4, 20); 
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 20, mb_convert_encoding('REPORTE DE DOCENTES', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C'); 
        $this->Ln(30);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(20, 10, mb_convert_encoding('DNI', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $this->Cell(50, 10, mb_convert_encoding('Nombres y apellidos', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $this->Cell(25, 10, mb_convert_encoding('Fecha Nac.', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $this->Cell(30, 10, mb_convert_encoding('Curso asig.', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $this->Cell(20, 10, mb_convert_encoding('Grado asig.', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $this->Cell(23, 10, mb_convert_encoding('Sección asig.', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $this->Cell(25, 10, mb_convert_encoding('Nivel asig.', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $this->Ln();
    }

    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 7);
        $this->Cell(0, 10, 'Página ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$docente_info = Docente::getDocenteInfo();

if (isset($docente_info['error'])) {
    http_response_code(500);
    echo 'Error en el servidor: ' . $docente_info['message'];
    exit();
}

$pdf = new PDF('P');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 9);
$pdf->SetY(50);

foreach ($docente_info as $row) {
    $pdf->Cell(20, 10, mb_convert_encoding($row['dni'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
    $pdf->Cell(50, 10, mb_convert_encoding($row['nombres']. ' ' .$row['apellidos'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
    $pdf->Cell(25, 10, mb_convert_encoding($row['fecha_nacimiento'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
    $pdf->Cell(30, 10, mb_convert_encoding($row['curso'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
    $pdf->Cell(20, 10, mb_convert_encoding($row['grado'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
    $pdf->Cell(23, 10, mb_convert_encoding($row['seccion'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
    $pdf->Cell(25, 10, mb_convert_encoding($row['nivel'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
    $pdf->Ln();
}

$pdf->Output();
?>
