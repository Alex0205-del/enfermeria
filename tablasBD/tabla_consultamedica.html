<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
  <title>Consulta Medica</title>
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
  <style>
       
        /* Estilos adicionales para el botón y la tabla oculta */
            #tabla-consulta {
                display: none;
                margin-top: 20px;
                width: 80%; /* Ajusta el ancho de la tabla según tus necesidades */
                margin: 0 auto; /* Centra la tabla horizontalmente */
            }

            #toggle-tabla-btn, .button-54 {
                margin-top: 10px;
                padding: 10px;
                background-color: #4CAF50;
                color: white;
                cursor: pointer;
                border: none;
                border-radius: 5px;
                display: block;
                margin: 0 auto; /* Centra los botones horizontalmente */
            }
    </style>
</head>
<body>
<div class="container">
    <!-- Formulario para ingresar datos de Consulta Médica -->
    <div class="forms">
        <h2 class="formT">Ingresar datos de Consulta Médica</h2>
        <form action="../funciones/fun_consultamedica/insercion_consulta.php" method="post">
            <label for="diagnostico">Diagnóstico:</label><br>
            <textarea id="diagnostico" name="diagnostico"></textarea><br>
            <label for="fecha_hora">Fecha y Hora:</label><br>
            <input type="datetime-local" id="fecha_hora" name="fecha_hora">
            <label for="nombre_Medico">Nombre del Médico:</label><br>
            <input type="text" id="nombre_Medico" name="nombre_Medico"><br>
            <label for="a_patMedico">Apellido Paterno del Médico:</label><br>
            <input type="text" id="a_patMedico" name="a_patMedico"><br>
            <label for "a_matMedico">Apellido Materno del Médico:</label><br>
            <input type="text" id="a_matMedico" name="a_matMedico"><br>
            <label for="signosID">ID de Signos Vitales:</label><br>
            <input type="number" id="signosID" name="signosID"><br>
            <label for="pacienteID">ID del Paciente:</label><br>
            <input type="number" id="pacienteID" name="pacienteID"><br>
            <label for="medicamentoID">ID del Medicamento:</label><br>
            <input type="number" id="medicamentoID" name="medicamentoID"><br>
            <label for="padecimientoID">ID del Padecimiento:</label><br>
            <input type="number" id="padecimientoID" name="padecimientoID"><br><br>
            <input type="submit" value="Insertar Datos de Consulta Médica">
        </form>
    </div>

   <!-- Formulario para buscar Consulta Médica por ID de Consulta -->
<div class="forms">
    <h2 class="formT">Buscar Consulta Médica por ID de Consulta</h2>
    <form action="../funciones/fun_consultamedica/busqueda_consulta.php" method="post">
        <label for="consultaid">ID de Consulta Médica:</label><br>
        <input type="number" id="consultaid" name="consultaid"><br><br>
        <input type="submit" value="Buscar Consulta Médica">
    </form>
</div>

    <!-- Formulario para eliminar Consulta Médica por ID -->
    <div class="forms">
        <h2 class="formT">Eliminar Consulta Médica por ID</h2>
        <form action="../funciones/fun_consultamedica/eliminacion_consulta.php" method="post">
            <label for="consultaid_eliminar">ID de Consulta Médica a Eliminar:</label><br>
            <input type="number" id="consultaid_eliminar" name="consultaid_eliminar"><br><br>
            <input type="submit" value="Eliminar Consulta Médica">
        </form>
    </div>
</div>
  <!-- Muestra la tabla de Consultas Médicas -->
  <button id="toggle-tabla-btn" onclick="toggleTabla()">Mostrar/Ocultar Tabla</button>
        <div id="tabla-consulta">
            <?php
            // Código PHP existente para mostrar la tabla
            $conexion = oci_connect("SYSTEM", "oracle", "localhost/xe");
            if (!$conexion) {    
                $m = oci_error();    
                echo $m['message'], "\n";    
                exit;
            }

            $query = "SELECT * FROM Enf_Consulta_Medica";
            $stid = oci_parse($conexion, $query);
            oci_execute($stid);

            echo "<h2>Tabla de Consultas Médicas:</h2>";
            echo "<table border='1'>";
            echo "<tr><th>ID de consulta</th><th>Diagnóstico</th><th>Fecha Hora</th><th>Nombre del Medico</th><th>Apellido Materno</th><th>Apellido Paterno</th><th>Signos ID</th><th>Paciente ID</th><th>Medicamento ID</th><th>Padecimiento ID</th></tr>";

            while ($row = oci_fetch_array($stid, OCI_ASSOC + OCI_RETURN_NULLS)) {
                echo "<tr>";
                foreach ($row as $item) {
                    if (is_object($item) && get_class($item) === 'OCI-Lob') {
                        // Si es un LOB, puedes leer su contenido
                        $lob_content = $item->read($item->size());
                        echo "<td>" . htmlentities($lob_content, ENT_QUOTES) . "</td>";
                    } else {
                        // Si no es un LOB, simplemente imprime el valor
                        echo "<td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>";
                    }
                }
                echo "</tr>";
            }

            echo "</table>";

            oci_free_statement($stid);
            oci_close($conexion);
            ?>
        </div>

        <!-- Enlace para volver al inicio -->
        <a class="button-54" href="../conexion.php">Ir al inicio</a>
    </div>

    <!-- Script JavaScript para controlar la visibilidad de la tabla -->
    <script>
        function toggleTabla() {
            var tablaConsulta = document.getElementById('tabla-consulta');
            tablaConsulta.style.display = (tablaConsulta.style.display === 'none' || tablaConsulta.style.display === '') ? 'block' : 'none';
        }
    </script>
</body>
</html>
