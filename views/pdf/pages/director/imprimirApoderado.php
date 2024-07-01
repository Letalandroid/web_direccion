<?php
require('fpdf.php');
require_once __DIR__ . '/../../../../controllers/Apoderado.php'; 

use Letalandroid\controllers\Apoderado;

class PDF extends FPDF {
    // Cabecera de página
    function Header() {


        $this->Image('icon.png', 250, 4, 30); // Logo de la empresa, posición X, posición Y, tamaño de la imagen
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(60); // Mover a la derecha
        $this->Cell(120, 20, mb_convert_encoding('REPORTE DE APODERADOS', 'ISO-8859-1', 'UTF-8'), 0, 0, 'C');
        $this->Ln(30);
        $this->SetFont('Arial', 'B', 9);
        $this->Cell(20, 10, mb_convert_encoding('DNI', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $this->Cell(60, 10, mb_convert_encoding('Nombre Apoderado', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $this->Cell(25, 10, mb_convert_encoding('Nacionalidad', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $this->Cell(28, 10, mb_convert_encoding('Teléfono', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $this->Cell(50, 10, mb_convert_encoding('Correo', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C'); // Ajustado el tamaño para adaptarse al contenido
        $this->Cell(60, 10, mb_convert_encoding('Nombre Alumno', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $this->Cell(25, 10, mb_convert_encoding('Aula', 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
        $this->Ln();

    }

    // Pie de página
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 7);
        
        $this->Cell(0, 10, 'Page ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }
}

$apoderado_alumnos = Apoderado::getApoderadosConAlumnos();

if (isset($apoderado_alumnos['error'])) {
    http_response_code(500);
    echo 'Error en el servidor: ' . $apoderado_alumnos['message'];
    exit();
}

$pdf = new PDF('L'); // 'L' indica orientación horizontal
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', '', 9);
$pdf->SetY(50);

foreach ($apoderado_alumnos as $row) {
    $pdf->Cell(20, 10, mb_convert_encoding($row['apoderado_dni'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
    $pdf->Cell(60, 10, mb_convert_encoding($row['apoderado_nombres'] . ' ' . $row['apoderado_apellidos'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C'); // Nombre completo apoderado
    $pdf->Cell(25, 10, mb_convert_encoding($row['apoderado_nacionalidad'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
    $pdf->Cell(28, 10, mb_convert_encoding($row['apoderado_telefono'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
    $pdf->Cell(50, 10, mb_convert_encoding($row['apoderado_correo'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
    $pdf->Cell(60, 10, mb_convert_encoding($row['alumno_nombres'] . ' ' . $row['alumno_apellidos'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C'); // Nombre completo alumno
    $pdf->Cell(25, 10, mb_convert_encoding($row['grado_y_seccion'] . ' ' . $row['nivel'], 'ISO-8859-1', 'UTF-8'), 1, 0, 'C');
    $pdf->Ln();
}

$pdf->Output();
?>
