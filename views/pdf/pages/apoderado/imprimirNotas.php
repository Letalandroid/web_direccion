<?php
require('fpdf.php'); // Ajusta la ruta a FPDF según tu estructura

// Incluir la clase Notas
require_once __DIR__ . '/../../../../controllers/Notas.php'; // Ajusta la ruta según tu estructura
use Letalandroid\controllers\Notas; // Ajusta el namespace según tu aplicación

// Obtener parámetros (ejemplo)
$alumno_id = 1; // Ejemplo: ID del alumno

// Obtener datos del reporte de notas y conducta agrupado por bimestre
$data = Notas::mostrarNotasYConductaPorBimestre($alumno_id);

// Iniciar PDF en orientación vertical
$pdf = new FPDF('P', 'mm', 'A4'); // 'P' para orientación vertical
$pdf->AddPage();
$pdf->SetFont('Arial', '', 12);

// Título del reporte
$pdf->Cell(0, 10, 'Reporte de Notas y Conducta por Bimestre', 0, 1, 'C');
$pdf->Ln();

// Cabecera de la tabla
$pdf->Image('icon.png', 175, 4, 20);  // Logo de la empresa (ajustar posición según sea necesario)
$pdf->Cell(40, 10, 'Curso', 1, 0, 'C');
$pdf->Cell(30, 10, 'Participacion', 1, 0, 'C');
$pdf->Cell(20, 10, 'Practica', 1, 0, 'C');
$pdf->Cell(30, 10, 'Examen', 1, 0, 'C');
$pdf->Cell(40, 10, 'Conducta', 1, 0, 'C'); // Ancho ajustado para Conducta
$pdf->Cell(30, 10, 'Bimestre', 1, 1, 'C');

// Datos obtenidos de la base de datos
foreach ($data as $bimestre => $cursos) {
    foreach ($cursos as $curso => $valores) {
        $pdf->Cell(40, 10, $curso, 1, 0, 'L');
        $pdf->Cell(30, 10, $valores['participacion'], 1, 0, 'C');
        $pdf->Cell(20, 10, $valores['practica'], 1, 0, 'C');
        $pdf->Cell(30, 10, $valores['examen'], 1, 0, 'C');
        $pdf->MultiCell(40, 10, $valores['conducta'], 1, 0, 'C'); // Usar MultiCell para texto largo (Conducta)
        $pdf->Cell(30, 10, $bimestre, 1, 1, 'C');
        $pdf->SetX(10); // Volver a la posición inicial de la línea después de MultiCell
    }
}

// Salida del PDF
$pdf->Output();
?>
