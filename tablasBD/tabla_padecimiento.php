<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  <title>Padecimiento</title>
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
        <h2 class="formT">Ingresar datos de Padecimiento</h2>
        <form action="../funciones/fun_padecimiento/insercion_padecimiento.php" method="post">
            <!-- Genera un ID de padecimiento aleatorio -->
            <input type="hidden" name="padecimientoID" value="0">
            <label for="nombrePadecimiento">Nombre del Padecimiento:</label><br>
            <input type="text" id="nombrePadecimiento" name="nombrePadecimiento"><br>
            <label for="sintomas">Síntomas:</label><br>
            <textarea id="sintomas" name="sintomas" rows="4" cols="50"></textarea><br>
            <label for="medicamentoID">ID del Medicamento:</label><br>
            <input type="number" id="medicamentoID" name="medicamentoID"><br><br>
            <input type="submit" value="Insertar Datos de Padecimiento">
        </form>
    </div>

    <div class="forms">
        <h2 class="formT">Buscar Padecimiento por nombre</h2>
        <form action="../funciones/fun_padecimiento/busqueda_padecimiento.php" method="post">
            <label for="nombrePadecimiento">Nombre del Padecimiento:</label><br>
            <input type="text" id="nombrePadecimiento" name="nombrePadecimiento"><br><br>
            <input type="submit" value="Buscar Padecimiento">
        </form>
    </div>

    <div class="forms">
        <h2 class="formT">Eliminar Padecimiento</h2>
        <form action="../funciones/fun_padecimiento/eliminacion_padecimiento.php" method="post">
            <label for="padecimientoID_eliminar">Padecimiento ID a Eliminar:</label><br>
            <input type="number" id="padecimientoID_eliminar" name="padecimientoID_eliminar"><br><br>
            <input type="submit" value="Eliminar Padecimiento">
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

$query = "SELECT * FROM Enf_Padecimiento";
$stid = oci_parse($conexion, $query);
oci_execute($stid);

echo "<h2>Tabla Enf_Padecimiento:</h2>";
echo "<table border='1'>";
echo "<tr><th>padecimientoID</th><th>nombre</th><th>sintomas</th><th>MedicamentoID</th></tr>";

while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
    echo "<tr>";
    foreach ($row as $item) {
        echo "<td>";
        if ($item !== null) {
            // Verificar si $item es un OCILob
            if (is_a($item, 'OCILob')) {
                $clobContent = $item->read($item->size());
                echo htmlentities($clobContent, ENT_QUOTES);
            } else {
                echo htmlentities($item, ENT_QUOTES);
            }
        } else {
            echo "&nbsp;";
        }
        echo "</td>";
    }
    
}

echo "</table>";

oci_free_statement($stid);
oci_close($conexion);
?>

<a class="button-54" href="../conexion.php">Ir al inicio</a>
</body>
</html>
