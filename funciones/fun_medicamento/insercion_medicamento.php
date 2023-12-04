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
$nombre = $_POST['nombre'];
$marca = $_POST['marca'];
$fecha_cad = $_POST['fecha_cad'];
$dosis = $_POST['dosis'];

// Generar un medicamentoID aleatorio entre 1000 y 1999 que no esté ocupado
do {
    $medicamentoID = rand(1000, 1999);
    $query_check_id = "SELECT COUNT(*) AS count FROM Enf_Medicamento WHERE medicamentoID = :medicamentoID";
    $stid_check_id = oci_parse($conn, $query_check_id);
    oci_bind_by_name($stid_check_id, ":medicamentoID", $medicamentoID);
    oci_execute($stid_check_id);
    $row = oci_fetch_assoc($stid_check_id);
    $count = $row['COUNT'];
} while ($count > 0);

// Preparar la consulta de inserción con el medicamentoID generado aleatoriamente
$query = "INSERT INTO Enf_Medicamento (medicamentoID, nombre, marca, fecha_cad, dosis)
          VALUES (:medicamentoID, :nombre, :marca, TO_DATE(:fecha_cad, 'yyyy-mm-dd'), :dosis)";
$stid = oci_parse($conn, $query);
oci_bind_by_name($stid, ":medicamentoID", $medicamentoID);
oci_bind_by_name($stid, ":nombre", $nombre);
oci_bind_by_name($stid, ":marca", $marca);
oci_bind_by_name($stid, ":fecha_cad", $fecha_cad);
oci_bind_by_name($stid, ":dosis", $dosis);

// Ejecutar la consulta
$resultado = oci_execute($stid);

// Verificar si la inserción fue exitosa
if ($resultado) {
    echo "Datos insertados correctamente en la tabla Enf_Medicamento.";
    echo '<br><a href="../ruta_de_redireccion"><button>Volver a la página de destino</button></a>';
} else {
    $error = oci_error($stid);
    echo "Error al insertar datos: " . $error['message'];
}

// Liberar recursos y cerrar la conexión
oci_free_statement($stid);
oci_close($conn);
?>
