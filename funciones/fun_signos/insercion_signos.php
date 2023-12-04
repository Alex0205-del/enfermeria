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
$peso = $_POST['peso'];
$temperatura = $_POST['temperatura'];
$presionArterial = $_POST['presionArterial'];
$altura = $_POST['altura'];
$pacienteID = $_POST['pacienteID'];

// Generar un signosID aleatorio entre 1 y 9999 que no esté ocupado
do {
    $signosID = rand(1, 9999);
    $query_check_id = "SELECT COUNT(*) AS count FROM Enf_SignosVitales WHERE signosID = :signosID";
    $stid_check_id = oci_parse($conn, $query_check_id);
    oci_bind_by_name($stid_check_id, ":signosID", $signosID);
    oci_execute($stid_check_id);
    $row = oci_fetch_assoc($stid_check_id);
    $count = $row['COUNT'];
} while ($count > 0);

// Preparar la consulta de inserción con el signosID generado aleatoriamente
$query = "INSERT INTO Enf_SignosVitales (signosID, peso, temperatura, presionArterial, altura, pacienteID)
          VALUES (:signosID, :peso, :temperatura, :presionArterial, :altura, :pacienteID)";
$stid = oci_parse($conn, $query);
oci_bind_by_name($stid, ":signosID", $signosID);
oci_bind_by_name($stid, ":peso", $peso);
oci_bind_by_name($stid, ":temperatura", $temperatura);
oci_bind_by_name($stid, ":presionArterial", $presionArterial);
oci_bind_by_name($stid, ":altura", $altura);
oci_bind_by_name($stid, ":pacienteID", $pacienteID);

// Ejecutar la consulta
$resultado = oci_execute($stid);

// Verificar si la inserción fue exitosa
if ($resultado) {
    echo "Datos insertados correctamente en la tabla Enf_SignosVitales.";
    echo '<br><a href="../ruta_de_redireccion"><button>Volver a la página de destino</button></a>';
} else {
    $error = oci_error($stid);
    echo "Error al insertar datos: " . $error['message'];
}

// Liberar recursos y cerrar la conexión
oci_free_statement($stid);
oci_close($conn);
?>
