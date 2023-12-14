<?php
$dbuser = "SYSTEM";
$dbpassword = "oracle";
$connectionString = "localhost/xe";

// Establecer la conexión con la base de datos
$conn = oci_connect($dbuser, $dbpassword, $connectionString);

if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $consultaid = $_POST["consultaid"];

    $sql = "SELECT * FROM Enf_Consulta_Medica WHERE consultaid = $consultaid";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
?>
        <!-- Mostrar datos en un formulario -->
        <form action="generar_pdf.php" method="post">
            <label>ID de Consulta:</label>
            <p><?php echo $row["consultaid"]; ?></p>
            <label>Diagnóstico:</label>
            <p><?php echo $row["diagnostico"]; ?></p>
            <!-- Agregar otros campos según sea necesario -->

            <!-- Agregar un botón para generar el PDF -->
            <input type="hidden" name="pdf_data" value='<?php echo json_encode($row); ?>'>
            <button type="submit">Generar PDF</button>
        </form>
<?php
    } else {
        echo "No se encontró ninguna consulta con ese ID.";
    }
}

oci_close($conn);
?>
