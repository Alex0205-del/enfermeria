<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  <title>Medicamento</title>
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
    <!-- Formulario para ingresar datos de Medicamento -->
    <div class="forms">
        <h2 class="formT">Ingresar datos de Medicamento</h2>
        <form action="../funciones/fun_medicamento/insercion_medicamento.php" method="post">
            <label for="nombre">Nombre del Medicamento:</label><br>
            <input type="text" id="nombre" name="nombre"><br>
            <label for="marca">Marca del Medicamento:</label><br>
            <input type="text" id="marca" name="marca"><br>
            <label for="fecha_cad">Fecha de Caducidad:</label><br>
            <input type="date" id="fecha_cad" name="fecha_cad"><br>
            <label for="dosis">Dosis:</label><br>
            <input type="text" id="dosis" name="dosis"><br><br>
            <input type="submit" value="Insertar Datos de Medicamento">
        </form>
    </div>

    <!-- Formulario para buscar Medicamento por nombre -->
    <div class="forms">
        <h2 class="formT">Buscar Medicamento por nombre</h2>
        <form action="../funciones/fun_medicamento/busqueda_medicamento.php" method="post">
            <label for="nombreMedicamento">Nombre del Medicamento:</label><br>
            <input type="text" id="nombreMedicamento" name="nombreMedicamento"><br><br>
            <input type="submit" value="Buscar Medicamento">
        </form>
    </div>

    <!-- Formulario para eliminar Medicamento por ID -->
    <div class="forms">
        <h2 class "formT">Eliminar Medicamento</h2>
        <form action="../funciones/fun_medicamento/eliminacion_medicamento.php" method="post">
            <label for="medicamentoID_eliminar">Medicamento ID a Eliminar:</label><br>
            <input type="text" id="medicamentoID_eliminar" name="medicamentoID_eliminar"><br><br>
            <input type="submit" value="Eliminar Medicamento">
        </form>
    </div>
</div>

<!-- Muestra la tabla de Medicamentos -->
<?php
$conexion = oci_connect("SYSTEM", "oracle", "localhost/xe");
if (!$conexion) {    
    $m = oci_error();    
    echo $m['message'], "\n";    
    exit;
}

$query = "SELECT * FROM Enf_Medicamento";
$stid = oci_parse($conexion, $query);
oci_execute($stid);

echo "<h2>Tabla de Medicamentos:</h2>";
echo "<table border='1'>";
echo "<tr><th>Medicamento ID</th><th>Nombre</th><th>Marca</th><th>Fecha Caducidad</th><th>Dosis</th></tr>";

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

<!-- Enlace para volver al inicio -->
<a class="button-54" href="../conexion.php">Ir al inicio</a>
</body>
</html>
