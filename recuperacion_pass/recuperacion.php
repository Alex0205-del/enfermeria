<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Configuración de la conexión a la base de datos (reemplaza con tus propios datos)
$dbuser = "SYSTEM";
$dbpassword = "oracle";
$connectionString = "localhost/xe";

// Establecer la conexión con la base de datos
$conn = oci_connect($dbuser, $dbpassword, $connectionString);

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Función para generar un token único (puedes ajustar según tus necesidades)
function generarToken() {
    return bin2hex(random_bytes(32));
}

// Obtener el correo electrónico enviado desde el formulario
$email = $_POST['email'];

// Verificar si el correo electrónico está en la base de datos
$consulta = oci_parse($conn, "SELECT * FROM USUARIO WHERE EMAIL = :email");
oci_bind_by_name($consulta, ":email", $email);
oci_execute($consulta);

if ($fila = oci_fetch_assoc($consulta)) {
    // El correo electrónico existe en la base de datos

    // Generar un token único
    $reset_token = generarToken();

    // Establecer la fecha de caducidad (por ejemplo, 1 hora desde ahora)
    $expiration_date = date('Y-m-d H:i:s', strtotime('+1 hour'));

    // Almacenar el token en la tabla PASSWORD_RESET
    $consulta_insertar = oci_parse($conn, "INSERT INTO PASSWORD_RESET (USER_ID, RESET_TOKEN, EXPIRATION_DATE) VALUES (:user_id, :reset_token, TO_TIMESTAMP(:expiration_date, 'YYYY-MM-DD HH24:MI:SS'))");
    oci_bind_by_name($consulta_insertar, ":user_id", $fila['ID_USUARIO']);
    oci_bind_by_name($consulta_insertar, ":reset_token", $reset_token);
    oci_bind_by_name($consulta_insertar, ":expiration_date", $expiration_date);
    oci_execute($consulta_insertar);

    // Configurar PHPMailer
    require 'path/to/PHPMailer/Exception.php';
    require 'path/to/PHPMailer/PHPMailer.php';
    require 'path/to/PHPMailer/SMTP.php';

    $mail = new PHPMailer(true);

    try {
        // Configuración del servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'tu_servidor_smtp';
        $mail->SMTPAuth = true;
        $mail->Username = 'tu_correo@dominio.com';
        $mail->Password = 'tu_contraseña';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Configuración del correo
        $mail->setFrom('tu_correo@dominio.com', 'Tu Nombre');
        $mail->addAddress($email, 'Usuario');
        $mail->isHTML(true);
        $mail->Subject = 'Recuperación de Contraseña';
        $mail->Body = "Haga clic en el siguiente enlace para restablecer su contraseña: \n\nhttp://tu_sitio/recuperacion_contraseña_confirmacion.php?token=$reset_token";

        // Enviar el correo electrónico
        $mail->send();

        echo "Se ha enviado un correo electrónico con las instrucciones de restablecimiento.";
    } catch (Exception $e) {
        echo "Error al enviar el correo electrónico: {$mail->ErrorInfo}";
    }
} else {
    echo "No se encontró ninguna cuenta asociada a ese correo electrónico.";
}

oci_close($conn);
?>
