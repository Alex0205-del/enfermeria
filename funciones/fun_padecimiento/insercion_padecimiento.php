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

// Obtener los datos del formulario
$nombrePadecimiento = $_POST['nombrePadecimiento'];
$sintomas = $_POST['sintomas'];
$medicamentoID = $_POST['medicamentoID']; // Asegúrate de que esto coincida con el nombre del campo en tu formulario

// Generar un padecimientoID aleatorio entre 500 y 699 que no esté ocupado
do {
    $padecimientoID = rand(500, 699);
    $query_check_id = "SELECT COUNT(*) AS count FROM Enf_Padecimiento WHERE padecimientoID = :padecimientoID";
    $stid_check_id = oci_parse($conn, $query_check_id);
    oci_bind_by_name($stid_check_id, ":padecimientoID", $padecimientoID);
    oci_execute($stid_check_id);
    $row = oci_fetch_assoc($stid_check_id);
    $count = $row['COUNT'];
} while ($count > 0);

// Preparar la consulta de inserción con el padecimientoID generado aleatoriamente
$query = "INSERT INTO Enf_Padecimiento (padecimientoID, nombre, sintomas, MedicamentoID)
          VALUES (:padecimientoID, :nombrePadecimiento, :sintomas, :medicamentoID)";
$stid = oci_parse($conn, $query);
oci_bind_by_name($stid, ":padecimientoID", $padecimientoID);
oci_bind_by_name($stid, ":nombrePadecimiento", $nombrePadecimiento);
oci_bind_by_name($stid, ":sintomas", $sintomas);
oci_bind_by_name($stid, ":medicamentoID", $medicamentoID);

// Ejecutar la consulta
$resultado = oci_execute($stid);

// Verificar si la inserción fue exitosa
if ($resultado) {
    echo "Datos insertados correctamente en la tabla Enf_Padecimiento.";
    echo '<br><a href="../ruta_de_redireccion"><button>Volver a la página de destino</button></a>';
} else {
    $error = oci_error($stid);
    echo "Error al insertar datos: " . $error['message'];
}

// Liberar recursos y cerrar la conexión
oci_free_statement($stid);
oci_close($conn);
?>
