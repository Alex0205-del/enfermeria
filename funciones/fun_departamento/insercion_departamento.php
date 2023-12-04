<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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

// Obtener los datos del formulario
$nombreDep = $_POST['nombreDep'];
$nombre_jefedep = $_POST['nombre_jefedep'];
$a_pat_jefedep = $_POST['a_pat_jefedep'];
$a_mat_jefedep = $_POST['a_mat_jefedep'];



// Generar un departamentoID aleatorio entre 361 y 499 que no esté ocupado
do {
    $departamentoID = rand(361, 499);
    $query_check_id = "SELECT COUNT(*) AS count FROM Enf_Departamento WHERE departamentoID = :departamentoID";
    $stid_check_id = oci_parse($conn, $query_check_id);
    oci_bind_by_name($stid_check_id, ":departamentoID", $departamentoID);
    oci_execute($stid_check_id);
    $row = oci_fetch_assoc($stid_check_id);
    $count = $row['COUNT'];
} while ($count > 0);

// Preparar la consulta de inserción con el departamentoID generado aleatoriamente
$query = "INSERT INTO Enf_Departamento (departamentoID, nombreDep, nombre_jefedep, a_pat_jefedep, a_mat_jefedep)
          VALUES (:departamentoID, :nombreDep, :nombre_jefedep, :a_pat_jefedep, :a_mat_jefedep)";
$stid = oci_parse($conn, $query);
oci_bind_by_name($stid, ":departamentoID", $departamentoID);
oci_bind_by_name($stid, ":nombreDep", $nombreDep);
oci_bind_by_name($stid, ":nombre_jefedep", $nombre_jefedep);
oci_bind_by_name($stid, ":a_pat_jefedep", $a_pat_jefedep);
oci_bind_by_name($stid, ":a_mat_jefedep", $a_mat_jefedep);

// Ejecutar la consulta
$resultado = oci_execute($stid);

// Verificar si la inserción fue exitosa
if ($resultado) {
    echo "Datos insertados correctamente en la tabla Enf_Departamento.";
    echo '<br><a href="../ruta_de_redireccion"><button>Volver a la página de destino</button></a>';
} else {
    $error = oci_error($stid);
    echo "Error al insertar datos: " . $error['message'];
}

// Liberar recursos y cerrar la conexión
oci_free_statement($stid);
oci_close($conn);

   