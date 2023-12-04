<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
  <title>Consulta Departamento</title>
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <meta content="" name="keywords">
  <meta content="" name="description">

  <!-- Favicons -->
  <link href="img/favicon.png" rel="icon">
  <link href="img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,700,700i|Raleway:300,400,500,700,800|Montserrat:300,400,700" rel="stylesheet">

  <!-- Bootstrap CSS File -->
  <link href="lib/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!-- Libraries CSS Files -->
  <link href="../lib/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  <link href="../lib/animate/animate.min.css" rel="stylesheet">
  <link href="../lib/ionicons/css/ionicons.min.css" rel="stylesheet">
  <link href="../lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
  <link href="../lib/magnific-popup/magnific-popup.css" rel="stylesheet">
  <link href="../lib/ionicons/css/ionicons.min.css" rel="stylesheet">

  <!-- Main Stylesheet File -->
  <link href="../css/stylestablas.css" rel="stylesheet">
</head>
<body>
    <h1>Consulta Departamento</h1>

    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
        <label for="nombre_departamento">Nombre del Departamento:</label>
        <input type="text" name="nombre_departamento" id="nombre_departamento">
        <input type="submit" name="submit" value="Consultar">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
        // Conexión a la base de datos Oracle
        $dbuser = "SYSTEM";
        $dbpassword = "oracle";
        $connectionString = "localhost/xe";
        $conn = oci_connect($dbuser, $dbpassword, $connectionString);

        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // Obtiene el nombre del departamento ingresado por el usuario
        $nombre_departamento = $_POST["nombre_departamento"];

        // Realiza la consulta SQL
        $sql = "SELECT d.nombreDep AS NOMBRE, d.nombre_jefedep AS NOMBRE_JEFEDP, d.a_pat_jefedep AS A_PAT_JEFEDP, d.a_mat_jefedep AS A_MAT_JEFEDP, p.genero AS GENERO
                FROM Enf_Paciente p
                JOIN Enf_Departamento d ON p.departamentoID = d.departamentoID
                WHERE d.nombreDep = '$nombre_departamento' AND p.PacienteID IN (SELECT DISTINCT pacienteID FROM Enf_SignosVitales)";

        $stmt = oci_parse($conn, $sql);
        oci_execute($stmt);

        // Verifica si la consulta arrojó resultados
        if (oci_fetch($stmt)) {
            echo "<h2>Resultados de la Consulta</h2>";
            echo "<table border='1'>";
            echo "<tr><th>Nombre del Departamento</th><th>Nombre del Jefe del Departamento</th><th>Apellido Paterno del Jefe del Departamento</th><th>Apellido Materno del Jefe del Departamento</th><th>Género del Paciente</th></tr>";

            do {
                echo "<tr><td>" . oci_result($stmt, "NOMBRE") . "</td><td>" . oci_result($stmt, "NOMBRE_JEFEDP") . "</td><td>" . oci_result($stmt, "A_PAT_JEFEDP") . "</td><td>" . oci_result($stmt, "A_MAT_JEFEDP") . "</td><td>" . oci_result($stmt, "GENERO") . "</td></tr>";
            } while (oci_fetch($stmt));

            echo "</table>";
        } else {
            echo "<p>No se encontraron resultados para el departamento ingresado.</p>";
        }

        // Cierra la conexión a la base de datos
        oci_free_statement($stmt);
        oci_close($conn);
    }
    ?>

</body>
</html>
