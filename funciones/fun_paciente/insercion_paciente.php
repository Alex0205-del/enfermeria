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
$a_pat = $_POST['a_pat'];
$a_mat = $_POST['a_mat'];
$fecha_nac = $_POST['fecha_nac'];
$genero = $_POST['genero'];
$telefono = $_POST['telefono'];
$departamentoID = $_POST['departamentoID'];

// Generar un PacienteID aleatorio entre 2000 y 2999 que no esté ocupado
do {
    $PacienteID = rand(2000, 2999);
    $query_check_id = "SELECT COUNT(*) AS count FROM Enf_Paciente WHERE PacienteID = :PacienteID";
    $stid_check_id = oci_parse($conn, $query_check_id);
    oci_bind_by_name($stid_check_id, ":PacienteID", $PacienteID);
    oci_execute($stid_check_id);
    $row = oci_fetch_assoc($stid_check_id);
    $count = $row['COUNT'];
} while ($count > 0);

// Preparar la consulta de inserción con el PacienteID generado aleatoriamente
$query = "INSERT INTO Enf_Paciente (PacienteID, nombre, a_pat, a_mat, fecha_nac, genero, telefono, departamentoID)
          VALUES (:PacienteID, :nombre, :a_pat, :a_mat, TO_DATE(:fecha_nac, 'yyyy-mm-dd'), :genero, :telefono, :departamentoID)";
$stid = oci_parse($conn, $query);
oci_bind_by_name($stid, ":PacienteID", $PacienteID);
oci_bind_by_name($stid, ":nombre", $nombre);
oci_bind_by_name($stid, ":a_pat", $a_pat);
oci_bind_by_name($stid, ":a_mat", $a_mat);
oci_bind_by_name($stid, ":fecha_nac", $fecha_nac);
oci_bind_by_name($stid, ":genero", $genero);
oci_bind_by_name($stid, ":telefono", $telefono);
oci_bind_by_name($stid, ":departamentoID", $departamentoID);

// Ejecutar la consulta
$resultado = oci_execute($stid);

// Verificar si la inserción fue exitosa
if ($resultado) {
    echo "Datos insertados correctamente en la tabla Enf_Paciente.";
    echo '<br><a href="../ruta_de_redireccion"><button>Volver a la página de destino</button></a>';
} else {
    $error = oci_error($stid);
    echo "Error al insertar datos: " . $error['message'];
}

// Liberar recursos y cerrar la conexión
oci_free_statement($stid);
oci_close($conn);
?>
