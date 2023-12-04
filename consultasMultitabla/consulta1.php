<!DOCTYPE html>
<html lang="en">
<head>
    

    <meta charset="utf-8">
  <title>Consulta de Promedio de Peso por Género</title>
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
    <h2>Consulta de Promedio de Peso por Género</h2>
    <p>Este código PHP realiza una consulta en una base de datos Oracle para calcular y mostrar el promedio de peso por género de pacientes cuyo peso es mayor que el valor ingresado por el usuario. </p>

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

        // Obtener el valor de peso ingresado por el usuario
        $peso = $_POST['peso'];

        // Preparar la consulta para obtener el promedio de peso por género
        $query = "SELECT P.genero, AVG(SV.peso) AS Promedio_Peso
                  FROM Enf_SignosVitales SV
                  INNER JOIN Enf_paciente P ON SV.pacienteID = P.PacienteID
                  WHERE SV.peso > :peso
                  GROUP BY P.genero
                  HAVING AVG(SV.peso) > :peso
                  ORDER BY Promedio_Peso DESC";
        $stid = oci_parse($conn, $query);
        oci_bind_by_name($stid, ":peso", $peso);

        // Ejecutar la consulta
        oci_execute($stid);

        // Mostrar los resultados
        echo "<h3>Resultados de la Consulta para Peso > $peso:</h3>";
        echo "<table border='1'>";
        echo "<tr><th>Género</th><th>Promedio de Peso</th></tr>";
        while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
            echo "<tr>";
            echo "<td>" . htmlentities($row['GENERO'], ENT_QUOTES) . "</td>";
            echo "<td>" . htmlentities($row['PROMEDIO_PESO'], ENT_QUOTES) . "</td>";
            echo "</tr>";
        }
        echo "</table>";

        // Cerrar la conexión
        oci_free_statement($stid);
        oci_close($conn);
    }
    ?>

    <form method="post">
        <label for="peso">Ingresar un valor de peso:</label>
        <input type="number" id="peso" name="peso" step="0.01" required>
        <input type="submit" value="Consultar">
    </form>
</body>
</html>
