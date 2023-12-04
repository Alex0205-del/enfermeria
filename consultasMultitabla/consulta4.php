<!DOCTYPE html>
<html>
<head>
    <title>Consulta de Padecimientos</title>
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
    <h2>Consulta de Padecimientos</h2>
    <form method="post" action="">
        <label for="padecimiento">Padecimiento:</label>
        <input type="text" name="padecimiento" id="padecimiento" required>
        <button type="submit">Consultar</button>
    </form>

    <?php
    // Realiza la conexión a la base de datos
    $dbuser = "SYSTEM";
    $dbpassword = "oracle";
    $connectionString = "localhost/xe";
    $conn = oci_connect($dbuser, $dbpassword, $connectionString);

    if (!$conn) {
        $e = oci_error();
        trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
    }

    // Procesa la consulta si se envió el formulario
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Obtiene el padecimiento ingresado por el usuario
        $padecimiento = $_POST['padecimiento'];

        // Consulta SQL para obtener la cantidad de pacientes y la dosis de medicamento asociada al padecimiento
        $sql = "SELECT p.nombre, COUNT(c.PacienteID) AS cantidad_pacientes, m.dosis
                FROM Enf_Padecimiento p
                JOIN Enf_Medicamento m ON p.MedicamentoID = m.medicamentoID
                JOIN Enf_Consulta_Medica c ON p.padecimientoID = c.padecimientoID
                WHERE p.nombre = :padecimiento
                GROUP BY p.nombre, m.dosis";

        // Prepara la consulta
        $stid = oci_parse($conn, $sql);

        // Enlaza el valor del padecimiento ingresado por el usuario
        oci_bind_by_name($stid, ":padecimiento", $padecimiento);

        // Ejecuta la consulta
        oci_execute($stid);

        // Muestra los resultados
        echo "<h3>Resultados para el padecimiento: $padecimiento</h3>";
        echo "<table border='1'>";
        echo "<tr><th>Padecimiento</th><th>Cantidad de Pacientes</th><th>Dosis de Medicamento</th></tr>";
        while ($row = oci_fetch_array($stid, OCI_ASSOC)) {
            echo "<tr>";
            echo "<td>" . $row['NOMBRE'] . "</td>";
            echo "<td>" . $row['CANTIDAD_PACIENTES'] . "</td>";
            echo "<td>" . $row['DOSIS'] . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        // Cierra la consulta
        oci_free_statement($stid);
    }

    // Cierra la conexión a la base de datos
    oci_close($conn);
    ?>
</body>
</html>
