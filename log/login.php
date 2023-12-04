<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $dbuser = "SYSTEM";
    $dbpassword = "oracle";
    $connectionString = "localhost/xe";
    $conn = oci_connect($dbuser, $dbpassword, $connectionString);

    $username = $_POST['username'];
    $password = $_POST['password'];

    // Consulta para verificar la existencia del usuario y contraseña
    $query = "SELECT * FROM ENF_USUARIO WHERE USERNAME = :username AND PASSWORD = :password";
    $stmt = oci_parse($conn, $query);
    oci_bind_by_name($stmt, ":username", $username);
    oci_bind_by_name($stmt, ":password", $password);
    oci_execute($stmt);

    // Verificar si el usuario existe
    if ($row = oci_fetch_assoc($stmt)) {
        // Usuario válido, redirigir a la siguiente página
        $_SESSION['user_id'] = $row['ID_USUARIO'];
        header("Location: ../conexion.php");
        exit();
    } else {
        // Usuario inválido, redirigir a la página de inicio de sesión con un mensaje de error
        header("Location: index.php?error=1");
        exit();
    }

    oci_free_statement($stmt);
    oci_close($conn);
}
?>
