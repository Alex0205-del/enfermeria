<?php
require_once('../tcpdf/tcpdf.php');

// Verificar si se ha enviado el formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Obtener el ID de la consulta desde el formulario
    $consultaID = isset($_POST['consultaID']) ? $_POST['consultaID'] : null;

    // Validar que el ID de la consulta no esté vacío y sea un número
    if (!empty($consultaID) && is_numeric($consultaID)) {
        // Crear instancia de TCPDF
        $pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

        // Establecer información del documento
        $pdf->SetCreator('TESJO-ENFERMERIA');
        $pdf->SetAuthor('Alex');
        $pdf->SetTitle('Receta Médica');
        $pdf->SetHeaderData('', 0, 'Receta Médica', '');

        // Agregar página
        $pdf->AddPage();

        // Agregar imagen de logo en la esquina superior derecha
        $imageFile = '../img/logo.jpeg'; // Ruta de la imagen
        $pdf->Image($imageFile, 150, 10, 40, '', 'jpeg');

        // Realizar la conexión y consulta a la base de datos
        $conexion = oci_connect("SYSTEM", "oracle", "localhost/xe");

        if (!$conexion) {
            $m = oci_error();
            echo $m["message"] . "n";
            exit;
        }

        // Realizar la consulta a la base de datos con las tablas proporcionadas
        $query = "SELECT 
                    em.consultaid,
                    em.diagnostico,
                    em.fecha_hora,
                    em.nombre_Medico,
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
                    Enf_Padecimiento epa ON em.padecimientoID = epa.padecimientoID
                 WHERE
                    em.consultaid = :consultaID";

        $statement = oci_parse($conexion, $query);
        oci_bind_by_name($statement, ':consultaID', $consultaID);
        oci_execute($statement);

        // Crear una variable para almacenar el contenido HTML con estilos
        $html = '
            <style>
                body {
                    font-family: Arial, sans-serif;
                }
                h1 {
                    color: #0066cc;
                    text-align: center;
                }
                p {
                    margin-bottom: 5px;
                }
                strong {
                    color: #0066cc;
                }
            </style>
            <h1>Receta Médica</h1>';

        // Agregar los datos de la consulta al HTML del PDF
        while ($row = oci_fetch_array($statement, OCI_ASSOC + OCI_RETURN_NULLS)) {
            // Construir el texto de la receta médica aquí con los datos de $row
            $html .= '<p>ID Consulta: ' . $row["CONSULTAID"] . '</p>';
            $html .= '<p>Diagnóstico: ' . $row["DIAGNOSTICO"] . '</p>';
            $html .= '<p>Fecha y Hora: ' . $row["FECHA_HORA"] . '</p>';
            $html .= '<p>Nombre Médico: ' . $row["NOMBRE_MEDICO"] . '</p>';
            
            $html .= '<p><strong>Información del Paciente:</strong></p>';
            $html .= '<p>Nombre: ' . $row["NOMBRE_PACIENTE"] . ' ' . $row["A_PAT_PACIENTE"] . ' ' . $row["A_MAT_PACIENTE"] . '</p>';
            $html .= '<p>Fecha de Nacimiento: ' . $row["FECHA_NAC_PACIENTE"] . '</p>';
            $html .= '<p>Género: ' . $row["GENERO"] . '</p>';
            $html .= '<p>Teléfono: ' . $row["TELEFONO"] . '</p>';
            
            $html .= '<p><strong>Signos Vitales:</strong></p>';
            $html .= '<p>Peso: ' . $row["PESO"] . '</p>';
            $html .= '<p>Temperatura: ' . $row["TEMPERATURA"] . '</p>';
            $html .= '<p>Presión Arterial: ' . $row["PRESIONARTERIAL"] . '</p>';
            $html .= '<p>Altura: ' . $row["ALTURA"] . '</p>';
            
            $html .= '<p><strong>Medicamento Recetado:</strong></p>';
            $html .= '<p>Nombre: ' . $row["NOMBRE_MEDICAMENTO"] . '</p>';
            $html .= '<p>Marca: ' . $row["MARCA_MEDICAMENTO"] . '</p>';
            $html .= '<p>Fecha de Caducidad: ' . $row["FECHA_CADUCIDAD_MEDICAMENTO"] . '</p>';
            $html .= '<p>Dosis: ' . $row["DOSIS"] . '</p>';
            
            $html .= '<p><strong>Padecimiento:</strong></p>';
            $html .= '<p>Nombre: ' . $row["NOMBRE_PADECIMIENTO"] . '</p>';
            $html .= '<p>Síntomas: ' . ($row["SINTOMAS"] ? $row["SINTOMAS"]->load() : "") . '</p>';
        }

        // Escribir el contenido HTML en el PDF
        $pdf->writeHTML($html);

        // Salida del PDF (descarga o visualización)
        $pdf->Output('receta_medica.pdf', 'D'); // 'D' descarga el PDF, 'I' lo muestra en el navegador
    } else {
        // Mostrar mensaje de error si el ID de consulta no es válido
        echo 'Ingrese un ID de consulta válido.';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Receta Médica</title>
    <link rel="stylesheet" href="../css/csspdf.css">
</head>
<body>
    <h1>Ingrese el ID de la Consulta Médica</h1>
    <form method="post" action="">
        <label>ID Consulta: </label>
        <input type="text" name="consultaID" required>
        <button type="submit">Generar Receta Médica</button>
    </form>
</body>
</html>
