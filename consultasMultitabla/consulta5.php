<!DOCTYPE html>
<html>
<head>
    <title>Consulta de Datos</title>
    <meta charset="utf-8">
  
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
    <h1>Consulta de Datos</h1>
    <h1>Consulta 5: Datos de Pacientes</h1>
    <p>Esta consulta une las tablas "Enf_Paciente," "Enf_Departamento," y "Enf_Consulta_Medica" para obtener el nombre del paciente, el nombre del departamento al que pertenece el paciente y la temperatura registrada en la última consulta médica del paciente.</p>


    <table border="1">
        <tr>
            <th>Nombre del Paciente</th>
            <th>Nombre del Departamento</th>
            <th>Temperatura</th>
        </tr>

        <?php
        // Establecer la conexión a la base de datos
        $dbuser = "SYSTEM";
        $dbpassword = "oracle";
        $connectionString = "localhost/xe";
        $conn = oci_connect($dbuser, $dbpassword, $connectionString);

        if (!$conn) {
            $e = oci_error();
            trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
        }

        // Realizar la consulta
        $query = "
            SELECT p.nombre AS Nombre_Paciente, d.nombreDep AS Nombre_Departamento,
             s.temperatura AS Temperatura
            FROM Enf_Paciente p
            JOIN Enf_Departamento d ON p.departamentoID = d.departamentoID
            JOIN Enf_SignosVitales s ON p.PacienteID = s.pacienteID
            WHERE s.signosID = (
                SELECT MAX(signosID) FROM Enf_SignosVitales WHERE pacienteID = p.PacienteID
            )
        ";

        $stid = oci_parse($conn, $query);
        oci_execute($stid);

        // Mostrar los resultados
        while ($row = oci_fetch_assoc($stid)) {
            echo "<tr>";
            echo "<td>" . $row['NOMBRE_PACIENTE'] . "</td>";
            echo "<td>" . $row['NOMBRE_DEPARTAMENTO'] . "</td>";
            echo "<td>" . $row['TEMPERATURA'] . "</td>";
            echo "</tr>";
        }

        // Cerrar la conexión a la base de datos
        oci_free_statement($stid);
        oci_close($conn);
        ?>
    </table>
</body>
</html>
