<?php
require('fpdf.php');
require_once __DIR__ . '/../../../../controllers/Aulas.php'; 


use Letalandroid\controllers\Aulas;

class PDF extends FPDF {
    // Cabecera de página
    function Header() {
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(60);
        $this->Cell(70, 10, mb_convert_encoding('Reporte de Aulas', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $this->Ln(20);
    }

    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, mb_convert_encoding('Page ' . $this->PageNo() . '/{nb}', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
    }
}

$all_data = Aulas::getAulasDocentesAlumnos();

if (isset($all_data['error'])) {
    die('Error: ' . mb_convert_encoding($all_data['message'], 'ISO-8859-1', 'UTF-8'));
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
        $pdf->Cell(0, 10, mb_convert_encoding('Aula: ' . $currentAula, 'ISO-8859-1', 'UTF-8'), 0, 1);
        $pdf->Cell(0, 10, mb_convert_encoding('Docente a cargo: ' . ($data['docente'] ?? '[Docente no asignado]'), 'ISO-8859-1', 'UTF-8'), 0, 1);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 10, 'Nombre', 1);
        $pdf->Cell(40, 10, 'Apellidos', 1);
        $pdf->Cell(30, 10, 'DNI', 1);
        $pdf->Cell(80, 10, 'Apoderado', 1);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 10);
    }
    $pdf->Cell(40, 10, mb_convert_encoding($data['alumno_nombres'], 'ISO-8859-1', 'UTF-8'), 1);
    $pdf->Cell(40, 10, mb_convert_encoding($data['alumno_apellidos'], 'ISO-8859-1', 'UTF-8'), 1);
    $pdf->Cell(30, 10, mb_convert_encoding($data['alumno_dni'], 'ISO-8859-1', 'UTF-8'), 1);
    $pdf->Cell(80, 10, mb_convert_encoding($data['apoderado_nombres'] . ' ' . $data['apoderado_apellidos'], 'ISO-8859-1', 'UTF-8'), 1);
    $pdf->Ln();
}

$pdf->Output();
?>