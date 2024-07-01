<?php
require('fpdf.php');
require_once __DIR__ . '/../../../../controllers/Aulas.php'; 

use Letalandroid\controllers\Aulas;

class PDF extends FPDF {
    // Cabecera de página
    function Header() {
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(60);
        $this->Cell(70, 10, $this->convertToISO('Reporte de Aulas'), 1, 0, 'C');
        $this->Ln(20);
    }

    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Función para convertir cadenas a ISO-8859-1 si no son nulas
    function convertToISO($string) {
        return $string !== null ? mb_convert_encoding($string, 'ISO-8859-1', 'UTF-8') : '';
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
        $pdf->Cell(0, 10, $pdf->convertToISO('Aula: ' . $currentAula), 0, 1);
        $pdf->Cell(0, 10, $pdf->convertToISO('Docente a cargo: ' . ($data['docente'] ?? '[Docente no asignado]')), 0, 1);
        $pdf->Ln(5);
        $pdf->SetFont('Arial', 'B', 10);
        $pdf->Cell(40, 10, 'Nombre', 1);
        $pdf->Cell(40, 10, 'Apellidos', 1);
        $pdf->Cell(30, 10, 'DNI', 1);
        $pdf->Cell(80, 10, 'Apoderado', 1);
        $pdf->Ln();
        $pdf->SetFont('Arial', '', 10);
    }
    $pdf->Cell(40, 10, $pdf->convertToISO($data['alumno_nombres']), 1);
    $pdf->Cell(40, 10, $pdf->convertToISO($data['alumno_apellidos']), 1);
    $pdf->Cell(30, 10, $pdf->convertToISO($data['alumno_dni']), 1);
    $pdf->Cell(80, 10, $pdf->convertToISO($data['apoderado_nombres'] . ' ' . $data['apoderado_apellidos']), 1);
    $pdf->Ln();
}

// Asegurarse de que no haya salida antes de Output
ob_clean();
$pdf->Output();
?>
