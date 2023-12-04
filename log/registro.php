
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

// Obtener datos del formulario
$username = $_POST['username'];
$password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash de la contraseña
$user_level = $_POST['user_level'];
$email = $_POST['email'];

// Generar un ID aleatorio que no exista previamente en la tabla
do {
    $id_usuario = rand(1000, 9999);
    $query_check_id = "SELECT COUNT(*) AS count FROM enf_USUARIO WHERE ID_USUARIO = :id_usuario";
    $stid_check_id = oci_parse($conn, $query_check_id);
    oci_bind_by_name($stid_check_id, ":id_usuario", $id_usuario);
    oci_execute($stid_check_id);
    $row = oci_fetch_assoc($stid_check_id);
    $count = $row['COUNT'];
} while ($count > 0);

// Insertar datos en la tabla enf_USUARIO
$query = "INSERT INTO enf_USUARIO (ID_USUARIO, USERNAME, PASSWORD, USER_LEVEL, EMAIL)
          VALUES (:id_usuario, :username, :password, :user_level, :email)";
$stid = oci_parse($conn, $query);

oci_bind_by_name($stid, ":id_usuario", $id_usuario);
oci_bind_by_name($stid, ":username", $username);
oci_bind_by_name($stid, ":password", $password);
oci_bind_by_name($stid, ":user_level", $user_level);
oci_bind_by_name($stid, ":email", $email);

// Ejecutar la consulta
$resultado = oci_execute($stid);

// Verificar si la inserción fue exitosa
if ($resultado) {
    echo "Usuario registrado correctamente en la tabla enf_USUARIO con ID: $id_usuario";
    echo '<br><a href="../ruta_de_redireccion"><button>Volver a la página de destino</button></a>';
} else {
    $error = oci_error($stid);
    echo "Error al registrar usuario: " . $error['message'];
}

// Liberar recursos y cerrar la conexión
oci_free_statement($stid);
oci_close($conn);
?>
