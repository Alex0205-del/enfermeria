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
$diagnostico = $_POST['diagnostico'];
$fecha_hora = $_POST['fecha_hora'];
$nombre_Medico = $_POST['nombre_Medico'];
$a_patMedico = $_POST['a_patMedico'];
$a_matMedico = $_POST['a_matMedico'];
$signosID = $_POST['signosID'];
$pacienteID = $_POST['pacienteID'];
$medicamentoID = $_POST['medicamentoID'];
$padecimientoID = $_POST['padecimientoID'];

// Generar un consultaid aleatorio entre 2000 y 2999 que no esté ocupado
do {
    $consultaid = rand(2000, 2999);
    $query_check_id = "SELECT COUNT(*) AS count FROM Enf_Consulta_Medica WHERE consultaid = :consultaid";
    $stid_check_id = oci_parse($conn, $query_check_id);
    oci_bind_by_name($stid_check_id, ":consultaid", $consultaid);
    oci_execute($stid_check_id);
    $row = oci_fetch_assoc($stid_check_id);
    $count = $row['COUNT'];
} while ($count > 0);

// Preparar la consulta de inserción con el consultaid generado aleatoriamente
$query = "INSERT INTO Enf_Consulta_Medica (consultaid, diagnostico, fecha_hora, nombre_Medico, a_patMedico, a_matMedico, signosID, pacienteID, medicamentoID, padecimientoID)
          VALUES (:consultaid, :diagnostico, TO_TIMESTAMP(:fecha_hora, 'yyyy-mm-dd hh24:mi:ss'), :nombre_Medico, :a_patMedico, :a_matMedico, :signosID, :pacienteID, :medicamentoID, :padecimientoID)";
$stid = oci_parse($conn, $query);
oci_bind_by_name($stid, ":consultaid", $consultaid);
oci_bind_by_name($stid, ":diagnostico", $diagnostico);
oci_bind_by_name($stid, ":fecha_hora", $fecha_hora);
oci_bind_by_name($stid, ":nombre_Medico", $nombre_Medico);
oci_bind_by_name($stid, ":a_patMedico", $a_patMedico);
oci_bind_by_name($stid, ":a_matMedico", $a_matMedico);
oci_bind_by_name($stid, ":signosID", $signosID);
oci_bind_by_name($stid, ":pacienteID", $pacienteID);
oci_bind_by_name($stid, ":medicamentoID", $medicamentoID);
oci_bind_by_name($stid, ":padecimientoID", $padecimientoID);

// Ejecutar la consulta
$resultado = oci_execute($stid);

// Verificar si la inserción fue exitosa
if ($resultado) {
    echo "Datos insertados correctamente en la tabla Enf_Consulta_Medica.";
    echo '<br><a href="../ruta_de_redireccion"><button>Volver a la página de destino</button></a>';
} else {
    $error = oci_error($stid);
    echo "Error al insertar datos: " . $error['message'];
}

// Liberar recursos y cerrar la conexión
oci_free_statement($stid);
oci_close($conn);
?>
