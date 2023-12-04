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

// Obtener el PacienteID a eliminar
$pacienteID_eliminar = $_POST['pacienteID_eliminar'];

// Preparar la consulta de eliminación
$query_eliminar = "DELETE FROM Enf_Paciente WHERE PacienteID = :pacienteID_eliminar";
$stid_eliminar = oci_parse($conn, $query_eliminar);
oci_bind_by_name($stid_eliminar, ":pacienteID_eliminar", $pacienteID_eliminar);

// Ejecutar la consulta de eliminación
$resultado_eliminar = oci_execute($stid_eliminar);

// Verificar si la eliminación fue exitosa
if ($resultado_eliminar) {
    echo "Datos eliminados correctamente de la tabla Enf_Paciente.";
    echo '<br><a href="../ruta_de_redireccion"><button>Volver a la página de destino</button></a>';
} else {
    $error_eliminar = oci_error($stid_eliminar);
    echo "Error al eliminar datos: " . $error_eliminar['message'];
}

// Liberar recursos
oci_free_statement($stid_eliminar);
oci_close($conn);
?>
