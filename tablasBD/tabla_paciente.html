<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  <title>Paciente</title>
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
        <h2 class="formT">Ingresar datos de Paciente</h2>
        <form action="../funciones/fun_paciente/insercion_paciente.php" method="post">
            <label for="nombre">Nombre del Paciente:</label><br>
            <input type="text" id="nombre" name="nombre"><br>
            <label for="a_pat">Apellido Paterno del Paciente:</label><br>
            <input type="text" id="a_pat" name="a_pat"><br>
            <label for="a_mat">Apellido Materno del Paciente:</label><br>
            <input type="text" id="a_mat" name="a_mat"><br>
            <label for="fecha_nac">Fecha de Nacimiento del Paciente:</label><br>
            <input type="date" id="fecha_nac" name="fecha_nac"><br>
            <label for="genero">Género del Paciente:</label><br>
            <input type="text" id="genero" name="genero"><br>
            <label for="telefono">Teléfono del Paciente:</label><br>
            <input type="text" id="telefono" name="telefono"><br>
            <label for="departamentoID">ID del Departamento:</label><br>
            <input type="number" id="departamentoID" name="departamentoID"><br><br>
            <input type="submit" value="Insertar Datos de Paciente">
        </form>
    </div>

    <div class="forms">
        <h2 class="formT">Buscar Paciente por nombre</h2>
        <form action="../funciones/fun_paciente/busqueda_paciente.php" method="post">
            <label for="nombre">Nombre del Paciente:</label><br>
            <input type="text" id="nombre" name="nombre"><br><br>
            <input type="submit" value="Buscar Paciente">
        </form>
    </div>

    <div class="forms">
        <h2 class="formT">Eliminar Paciente</h2>
        <form action="../funciones/fun_paciente/eliminacion_paciente.php" method="post">
            <label for="pacienteID_eliminar">Paciente ID a Eliminar:</label><br>
            <input type="number" id="pacienteID_eliminar" name="pacienteID_eliminar"><br><br>
            <input type="submit" value="Eliminar Paciente">
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

$query = "SELECT * FROM Enf_Paciente";
$stid = oci_parse($conexion, $query);
oci_execute($stid);

echo "<h2>Tabla de Pacientes:</h2>";
echo "<table border='1'>";
echo "<tr><th>Paciente ID</th><th>Nombre</th><th>Apellido Paterno</th><th>Apellido Materno</th><th>Fecha Nacimiento</th><th>Género</th><th>Telefono</th><th>Departamento ID</th></tr>";

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
