<?php
require('fpdf.php');
require_once __DIR__ . '/../../../../controllers/Cursos.php'; 

use Letalandroid\controllers\Cursos;

class PDF extends FPDF {
    // Cabecera de página
    function Header() {
        $this->SetFont('Arial', 'B', 13);
        $this->Cell(60);
        $this->Cell(70, 10, 'Reporte de Alumnos por Aula', 1, 0, 'C');
        $this->Ln(20);
        $this->Cell(50, 10, 'Aula', 1, 0, 'C');
        $this->Cell(70, 10, 'Nombre del Alumno', 1, 0, 'C');
        $this->Cell(40, 10, 'DNI', 1, 0, 'C');
        $this->Ln();
    }

    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$alumnos_por_aula = Cursos::getAlumnosPorAula();

if (isset($alumnos_por_aula['error'])) {
    http_response_code(500);
    echo 'Error en el servidor: ' . $alumnos_por_aula['message'];
    exit();
}

$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 10);

foreach ($alumnos_por_aula as $row) {
    $aula = $row['nivel'] . ' ' . $row['grado'] . ' ' . $row['seccion'];
    $nombre_completo = $row['alumno_apellidos'] . ' ' . $row['alumno_nombre'];
    $pdf->Cell(50, 10, $aula, 1);
    $pdf->Cell(70, 10, $nombre_completo, 1);
    $pdf->Cell(40, 10, $row['dni'], 1);
    $pdf->Ln();
}

$pdf->Output();
?>