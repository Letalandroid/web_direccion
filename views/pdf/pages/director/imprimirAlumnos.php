<?php
require('fpdf.php');
require_once __DIR__ . '/../../../../controllers/Alumnos.php'; 

use Letalandroid\controllers\Alumnos;

class PDF extends FPDF {
    
    function Header() {

        $this->Image('icon.png', 250, 4, 30); 
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(60);
        $this->Cell(120, 20, mb_convert_encoding('REPORTE DE ALUMNOS', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
        $this->Ln(30);
        $this->SetFont('Arial', 'B', 9);

        $this->Cell(20, 10, mb_convert_encoding('DNI', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $this->Cell(55, 10, mb_convert_encoding('Nombre Alumno', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $this->Cell(25, 10, mb_convert_encoding('F. Nacimiento', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $this->Cell(22, 10, mb_convert_encoding('Aula', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $this->Cell(53, 10, mb_convert_encoding('Nombre Apoderado', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $this->Cell(30, 10, mb_convert_encoding('Nac. Apoderado', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $this->Cell(25, 10, mb_convert_encoding('Teléfono', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $this->Cell(48, 10, mb_convert_encoding('Correo Apoderado', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $this->Ln();
    }

    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 7);
        
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$alumnos_apoderados = Alumnos::getReporteAlumnos();

if (isset($alumnos_apoderados['error'])) {
    http_response_code(500);
    echo 'Error en el servidor: ' . $alumnos_apoderados['message'];
    exit();
}


$pdf = new PDF('L');
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 9);
$pdf->SetY(50);

foreach ($alumnos_apoderados as $row) {
    $pdf->Cell(20, 10, mb_convert_encoding($row['alumno_dni'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
    $pdf->Cell(55, 10, mb_convert_encoding($row['alumno_nombres'] . ' ' . $row['alumno_apellidos'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
    $pdf->Cell(25, 10, mb_convert_encoding($row['alumno_fecha_nacimiento'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
    $pdf->Cell(22, 10, mb_convert_encoding($row['grado_y_seccion'] . ' ' .$row['nivel'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
    $pdf->Cell(53, 10, mb_convert_encoding($row['apoderado_nombres'] . ' ' . $row['apoderado_apellidos'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
    $pdf->Cell(30, 10, mb_convert_encoding($row['apoderado_nacionalidad'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
    $pdf->Cell(25, 10, mb_convert_encoding($row['apoderado_telefono'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
    $pdf->Cell(48, 10, mb_convert_encoding($row['apoderado_correo'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
    $pdf->Ln();
}

$pdf->Output();
?>
    