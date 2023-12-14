<?php
$dbuser = "SYSTEM";
$dbpassword = "oracle";
$connectionString = "localhost/xe";

$conn = oci_connect($dbuser, $dbpassword, $connectionString);

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID de consulta desde el formulario
    $consultaid = $_POST["consultaid"];

    // Realizar la consulta a la base de datos
    $sql = "SELECT * FROM Enf_Consulta_Medica WHERE consultaid = :consultaid";
    $stmt = oci_parse($conn, $sql);
    oci_bind_by_name($stmt, ":consultaid", $consultaid);
    oci_execute($stmt);

    // Obtener los datos de la consulta
    $consulta = oci_fetch_assoc($stmt);

    // Generar el PDF
    require('../tcpdf/tcpdf.php');
    $pdf = new TCPDF();
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 12);
    $pdf->Cell(0, 10, 'Datos de Consulta Médica', 0, 1, 'C');
    $pdf->Ln(10);
    
    foreach ($consulta as $campo => $valor) {
        $pdf->Cell(0, 10, ucfirst($campo) . ': ' . $valor, 0, 1);
    }

    // Descargar el PDF
    $pdf->Output('Consulta_Medica.pdf', 'D');
}

oci_close($conn);
?>
