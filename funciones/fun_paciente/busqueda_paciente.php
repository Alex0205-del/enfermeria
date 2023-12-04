<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Búsqueda de Paciente</title>
    <link rel="stylesheet" href="CSS/Normalize.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans&family=PT+Sans:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../CSS/estilos.css">
</head>
<body>
<?php
// Establecer los parámetros de conexión
$dbuser = "SYSTEM";
$dbpassword = "oracle";
$connectionString = "localhost/xe";

// Establecer la conexión con la base de datos
$conn = oci_connect($dbuser, $dbpassword, $connectionString);

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Obtener el nombre del paciente del formulario de búsqueda
$nombrePaciente = $_POST['nombre']; // Cambiado de 'nombrePaciente' a 'nombre'

// Preparar la consulta de búsqueda
$query_buscar = "SELECT * FROM Enf_Paciente WHERE nombre = :nombrePaciente";
$stid_buscar = oci_parse($conn, $query_buscar);
oci_bind_by_name($stid_buscar, ":nombrePaciente", $nombrePaciente);

// Ejecutar la consulta de búsqueda
oci_execute($stid_buscar);

// Mostrar los resultados de la búsqueda
echo "<h2>Resultados de la Búsqueda:</h2>";
echo "<table border='1'>";
echo "<tr><th>PacienteID</th><th>nombre</th><th>a_pat</th><th>a_mat</th><th>fecha_nac</th><th>genero</th><th>telefono</th><th>departamentoID</th></tr>";
while ($row = oci_fetch_array($stid_buscar, OCI_ASSOC + OCI_RETURN_NULLS)) {
    echo "<tr>";
    foreach ($row as $item) {
        echo "<td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>";
    }
    echo "</tr>";
}
echo "</table>";

// Liberar recursos y cerrar la conexión
oci_free_statement($stid_buscar);
oci_close($conn);
?>
</body>
</html>
