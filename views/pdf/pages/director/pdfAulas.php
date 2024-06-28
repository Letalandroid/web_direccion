<?php
require('fpdf.php');
require_once __DIR__ . '/../../../../controllers/Aulas.php'; 


use Letalandroid\controllers\Cursos;

class PDF extends FPDF {
    // Cabecera de página
    function Header() {
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(60);
        $this->Cell(70, 10, utf8_decode('Reporte de Aulas'), 1, 0, 'C');
        $this->Ln(20);
    }

    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$all_data = Cursos::getAulasDocentesAlumnos();

if (isset($all_data['error'])) {
    die('Error: ' . utf8_decode($all_data['message']));
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

$currentAula = '';
foreach ($all_data as $data) {
    if ($currentAula !==  $data['grado']. 'º ' . $data['seccion'] . ' de ' . $data['nivel']) {
        if ($currentAula !== '') {
            $pdf->Ln(10); // Space between different aulas
        }
        $currentAula = $data['grado'] . 'º ' . $data['seccion'] . ' de ' . $data['nivel'] ;
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 10, utf8_decode('Aula: ' . $currentAula), 0, 1);
        $pdf->Cell(0, 10, utf8_decode('Docente a cargo: ' . ($data['docente'] ?? '[Docente no asignado]')), 0, 1);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 10, 'Nombre', 1);
        $pdf->Cell(40, 10, 'Apellidos', 1);
        $pdf->Cell(30, 10, 'DNI', 1);
        $pdf->Cell(80, 10, 'Apoderado', 1);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 10);
    }
    $pdf->Cell(40, 10, utf8_decode($data['alumno_nombres']), 1);
    $pdf->Cell(40, 10, utf8_decode($data['alumno_apellidos']), 1);
    $pdf->Cell(30, 10, utf8_decode($data['alumno_dni']), 1);
    $pdf->Cell(80, 10, utf8_decode($data['apoderado_nombres'] . ' ' . $data['apoderado_apellidos']), 1);
    $pdf->Ln();
}

$pdf->Output();
?>
