<?php
require('fpdf.php');
require_once __DIR__ . '/../../../../controllers/Docente.php'; 

use Letalandroid\controllers\Docente;

class PDF extends FPDF {
    // Cabecera de página
    function Header() {
        $this->Image('icon.png', 175, 4, 20);  // Logo de la empresa (ajustar posición según sea necesario)
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 20, utf8_decode('REPORTE DE DOCENTES'), 0, 0, 'C'); // Celda con ancho 0 para que se ajuste al ancho de la página y centrado
        $this->Ln(30);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(20, 10, utf8_decode('DNI'), 1, 0, 'C');
        $this->Cell(50, 10, utf8_decode('Nombres y apellidos'), 1, 0, 'C');
        $this->Cell(25, 10, utf8_decode('Fecha Nac.'), 1, 0, 'C');
        $this->Cell(30, 10, utf8_decode('Curso asig.'), 1, 0, 'C');
        $this->Cell(20, 10, utf8_decode('Grado asig.'), 1, 0, 'C');
        $this->Cell(23, 10, utf8_decode('Sección asig.'), 1, 0, 'C');
        $this->Cell(25, 10, utf8_decode('Nivel asig.'), 1, 0, 'C');
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

$pdf = new PDF('P'); // 'L' indica orientación horizontal
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 9);
$pdf->SetY(50);

foreach ($docente_info as $row) {
    $pdf->Cell(20, 10, utf8_decode($row['dni']), 1, 0, 'C');
    $pdf->Cell(50, 10, utf8_decode($row['nombres']. ' ' .$row['apellidos']), 1, 0, 'C');
    $pdf->Cell(25, 10, utf8_decode($row['fecha_nacimiento']), 1, 0, 'C');
    $pdf->Cell(30, 10, utf8_decode($row['curso']), 1, 0, 'C');
    $pdf->Cell(20, 10, utf8_decode($row['grado']), 1, 0, 'C');
    $pdf->Cell(23, 10, utf8_decode($row['seccion']), 1, 0, 'C');
    $pdf->Cell(25, 10, utf8_decode($row['nivel']), 1, 0, 'C');
    $pdf->Ln();
}

$pdf->Output();
?>
