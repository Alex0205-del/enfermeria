<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

    <title>Consulta Médica</title>
    
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
  <link href="../css/stylesconsultas.css" rel="stylesheet">
</head>
<body>
    <h1>Consulta Médica con Restricción de Edad</h1>
    <form method="POST">
        <label for="edad">Edad mínima (a partir de 18 años):</label>
        <input type="number" name="edad" id="edad" min="18" required>
        <input type="submit" value="Consultar">
    </form>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Establecer la conexión con la base de datos
        $dbuser = "SYSTEM";
        $dbpassword = "oracle";
        $connectionString = "localhost/xe";
        $conn = oci_connect($dbuser, $dbpassword, $connectionString);

        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // Obtener la edad ingresada por el usuario
        $edad = $_POST['edad'];

        // Realizar la consulta con la restricción de edad
        $sql = "SELECT
                    EP.nombre AS nombre_paciente,
                    EC.nombre_Medico AS nombre_medico,
                    EM.nombre AS nombre_medicamento
                FROM
                    Enf_Paciente EP
                JOIN
                    Enf_Consulta_Medica EC ON EP.PacienteID = EC.pacienteID
                JOIN
                    Enf_Medicamento EM ON EC.medicamentoID = EM.medicamentoID
                WHERE
                    MONTHS_BETWEEN(SYSDATE, EP.fecha_nac) / 12 >= :edad";

        $stmt = oci_parse($conn, $sql);
        oci_bind_by_name($stmt, ":edad", $edad);
        oci_execute($stmt);

        // Mostrar los resultados de la consulta
        echo "<h2>Resultados de la consulta:</h2>";
        echo "<table border='1'>";
        echo "<tr><th>Nombre del Paciente</th><th>Nombre del Médico</th><th>Nombre del Medicamento</th></tr>";
        
        while ($row = oci_fetch_assoc($stmt)) {
            echo "<tr>";
            echo "<td>" . $row['NOMBRE_PACIENTE'] . "</td>";
            echo "<td>" . $row['NOMBRE_MEDICO'] . "</td>";
            echo "<td>" . $row['NOMBRE_MEDICAMENTO'] . "</td>";
            echo "</tr>";
        }
        
        echo "</table>";

        oci_free_statement($stmt);
        oci_close($conn);
    }
    ?>
</body>
</html>
