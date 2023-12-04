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

// Obtener el nombre del padecimiento del formulario de búsqueda
$nombrePadecimiento = $_POST['nombrePadecimiento'];

// Preparar la consulta de búsqueda
$query_buscar = "SELECT * FROM Enf_Padecimiento WHERE nombre = :nombrePadecimiento";
$stid_buscar = oci_parse($conn, $query_buscar);
oci_bind_by_name($stid_buscar, ":nombrePadecimiento", $nombrePadecimiento);

// Ejecutar la consulta de búsqueda
oci_execute($stid_buscar);

// Mostrar los resultados de la búsqueda
echo "<h2>Resultados de la Búsqueda:</h2>";
echo "<table border='1'>";
echo "<tr><th>padecimientoID</th><th>nombre</th><th>sintomas</th><th>MedicamentoID</th></tr>";
while ($row = oci_fetch_array($stid_buscar, OCI_ASSOC + OCI_RETURN_NULLS)) {
    echo "<tr>";
    foreach ($row as $item) {
        echo "<td>";
        if ($item !== null) {
            // Verificar si $item es un OCILob
            if (is_a($item, 'OCILob')) {
                $clobContent = $item->read($item->size());
                echo htmlentities($clobContent, ENT_QUOTES);
            } else {
                echo htmlentities($item, ENT_QUOTES);
            }
        } else {
            echo "&nbsp;";
        }
        echo "</td>";
    }
    echo "</tr>";
}
echo "</table>";

// Liberar recursos y cerrar la conexión
oci_free_statement($stid_buscar);
oci_close($conn);
?>
