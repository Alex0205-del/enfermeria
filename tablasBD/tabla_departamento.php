<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  <title>Departamento</title>
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
        <h2 class="formT">Ingresar datos de Departamento</h2>
        <form action="../funciones/fun_departamento/insercion_departamento.php" method="post">
            <!-- <label for="Departamentoid">ID del Departamento:</label><br> -->
            <!-- <input type="text" id="Departamentoid" name="Departamentoid"><br> --> 
            <label for="nombreDep">Nombre del Departamento:</label><br>
            <input type="text" id="nombreDep" name="nombreDep"><br>
            <label for="nombre_jefedep">Jefe de Departamento:</label><br>
            <input type="text" id="nombre_jefedep" name="nombre_jefedep"><br>
            <label for="a_pat_jefedep">Apellido Paterno del Jefe:</label><br>
            <input type="text" id="a_pat_jefedep" name="a_pat_jefedep"><br>
            <label for="a_mat_jefedep">Apellido Materno del Jefe:</label><br>
            <input type="text" id="a_mat_jefedep" name="a_mat_jefedep"><br><br>
            <input type="submit" value="Insertar Datos de Departamento">
        </form>
    </div>




<div class="forms">
    <h2 class="formT">Buscar Departamento por nombre</h2>
    <form action="../funciones/fun_departamento/busqueda_departamento.php" method="post">
        <label for="nombreDep">Nombre del Departamento:</label><br>
        <input type="text" id="nombreDep" name="nombreDep"><br><br>
        <input type="submit" value="Buscar Departamento">
    </form>
</div>

<div class="forms">
    <h2 class="formT">Eliminar Departamento</h2>
    <form action="../funciones/fun_departamento/eliminacion_departamento.php" method="post">
        <label for="departamentoID_eliminar">Departamento ID a Eliminar:</label><br>
        <input type="text" id="departamentoID_eliminar" name="departamentoID_eliminar"><br><br>
        <input type="submit" value="Eliminar Departamento">
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

$query = "SELECT * FROM Enf_Departamento";
$stid = oci_parse($conexion, $query);
oci_execute($stid);

echo "<h2>Tabla de  Departamentos:</h2>";
echo "<table border='1'>";
echo "<tr><th>departamento ID</th><th>Nombre Departamento</th><th>Jefe de Departamento</th><th>Apellido Paterno</th><th>Apellido Materno</th></tr>";

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