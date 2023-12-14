<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  <title>Signos Vitales</title>
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
<div class="container">
    <div class="forms">
        <h2 class="formT">Ingresar datos de Signos Vitales</h2>
        <form action="../funciones/fun_signos/insercion_signos.php" method="post">
            <!-- <label for="signosID">ID de Signos Vitales:</label><br>
            <input type="text" id="signosID" name="signosID"><br> -->
            <label for="peso">Peso:</label><br>
            <input type="number" step="0.01" id="peso" name="peso"><br>
            <label for="temperatura">Temperatura:</label><br>
            <input type="number" step="0.01" id="temperatura" name="temperatura"><br>
            <label for="presionArterial">Presión Arterial:</label><br>
            <input type="text" id="presionArterial" name="presionArterial"><br>
            <label for="altura">Altura:</label><br>
            <input type="number" step="0.01" id="altura" name="altura"><br>
            <label for="pacienteID">ID del Paciente:</label><br>
            <input type="number" id="pacienteID" name="pacienteID"><br><br>
            <input type="submit" value="Insertar Datos de Signos Vitales">
        </form>
    </div>

    <div class="forms">
        <h2 class="formT">Buscar Signos Vitales por ID de Paciente</h2>
        <form action="../funciones/fun_signos/busqueda_signos.php" method="post">
            <label for="pacienteID_buscar">ID del Paciente:</label><br>
            <input type="number" id="nombrePaciente" name="nombrePaciente"><br><br>
            <input type="submit" value="Buscar Signos Vitales">
        </form>
    </div>

    <div class="forms">
        <h2 class="formT">Eliminar Signos Vitales por ID</h2>
        <form action="../funciones/fun_signos/eliminacion_signos.php" method="post">
            <label for="signosID_eliminar">Signos Vitales ID a Eliminar:</label><br>
            <input type="number" id="signosID_eliminar" name="signosID_eliminar"><br><br>
            <input type="submit" value="Eliminar Signos Vitales">
        </form>
    </div>
</div>

<?php
$conexion = oci_connect("SYSTEM", "oracle", "localhost/xe");
if (!$conexion) {
    $m = oci_error();
    echo $m['message'], "\n";
    exit;
}

$query = "SELECT * FROM Enf_SignosVitales";
$stid = oci_parse($conexion, $query);
oci_execute($stid);

echo "<h2>Tabla de Signos Vitales:</h2>";
echo "<table border='1'>";
echo "<tr><th>Signos ID</th><th>Peso</th><th>Temperatura</th><th>Presion Arterial</th><th>Altura</th><th>PacienteID</th></tr>";

while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
    echo "<tr>";
    foreach ($row as $item) {
        echo "<td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>";
    }
    echo "</tr>";
}

echo "</table>";

oci_free_statement($stid);
oci_close($conexion);
?>

<a class="button-54" href="../conexion.php">Ir al inicio</a>
</body>
</html>
