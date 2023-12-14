<?php
require_once('TCPDF/tcpdf.php');

// Función para generar el PDF
function generarPDF($data) {
    $pdf = new TCPDF();
    $pdf->AddPage();

    // Título
    $pdf->SetFont('times', 'B', 16);
    $pdf->Cell(0, 10, 'Receta Médica', 0, 1, 'C');

    // Datos de la consulta médica y tablas relacionadas
    foreach ($data as $key => $value) {
        $pdf->SetFont('times', '', 12);
        $pdf->Cell(0, 10, $key . ': ' . $value, 0, 1);
    }

    // Salida del PDF
    $pdf->Output('receta_medica.pdf', 'D');
}

// Establecer la conexión con la base de datos
$dbuser = "SYSTEM";
$dbpassword = "oracle";
$connectionString = "localhost/xe";

$conn = oci_connect($dbuser, $dbpassword, $connectionString);

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Consulta SQL
$query = "SELECT 
            em.consultaid,
            em.diagnostico,
            em.fecha_hora,
            em.nombre_Medico,
            em.a_patMedico,
            em.a_matMedico,
            esv.peso,
            esv.temperatura,
            esv.presionArterial,
            esv.altura,
            ep.nombre AS nombre_paciente,
            ep.a_pat AS a_pat_paciente,
            ep.a_mat AS a_mat_paciente,
            ep.fecha_nac AS fecha_nac_paciente,
            ep.genero,
            ep.telefono,
            ed.nombreDep AS nombre_departamento,
            eme.nombre AS nombre_medicamento,
            eme.marca AS marca_medicamento,
            eme.fecha_cad AS fecha_caducidad_medicamento,
            eme.dosis,
            epa.nombre AS nombre_padecimiento,
            epa.sintomas
         FROM 
            Enf_Consulta_Medica em
         LEFT JOIN 
            Enf_SignosVitales esv ON em.signosID = esv.signosID
         LEFT JOIN 
            Enf_Paciente ep ON em.pacienteID = ep.PacienteID
         LEFT JOIN 
            Enf_Departamento ed ON ep.departamentoID = ed.departamentoID
         LEFT JOIN 
            Enf_Medicamento eme ON em.medicamentoID = eme.medicamentoID
         LEFT JOIN 
            Enf_Padecimiento epa ON em.padecimientoID = epa.padecimientoID";

$stid = oci_parse($conn, $query);

oci_execute($stid);

// Obtener datos
$data = oci_fetch_assoc($stid);

// Generar PDF
generarPDF($data);

oci_free_statement($stid);
oci_close($conn);
?>
