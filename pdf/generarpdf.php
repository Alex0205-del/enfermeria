<?php
require_once('../tcpdf/tcpdf.php');

// Crear instancia de TCPDF
$pdf = new TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);

// Establecer información del documento
$pdf->SetCreator('LUCE-T');
$pdf->SetAuthor('Alexis');
$pdf->SetTitle('Carrito de Compras');
$pdf->SetHeaderData('', 0, 'Carrito de Compras', '');

// Agregar página
$pdf->AddPage();

// Realizar la conexión y consulta a la base de datos
$conexion = oci_connect("SYSTEM", "root", "localhost/xe");

if (!$conexion) {
    $m = oci_error();
    echo $m["message"] . "n";
    exit;
}

// Realizar la consulta a la base de datos
$query = "SELECT * FROM carrito_de_compras";
$statement = oci_parse($conexion, $query);
oci_execute($statement);

// Crear una variable para almacenar el contenido HTML
$html = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>LUCE-T</title>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #b0e0e6; /* Color de fondo azul cielo */
        margin: 0;
        padding: 0;
        text-align: center;
    }

    header {
        background-color: #ff69b4; /* Color rosa */
        color: #000; /* Texto negro */
        text-align: center;
        padding: 10px;
    }

    h1 {
        background-color: #ff69b4; /* Fondo rosa */
        color: #fff; /* Cambia el color de fuente a blanco */
        padding: 20px;
    }

    .welcome-section {
        text-align: center;
        padding: 40px;
        background-color:  #ffc0cb; /* Fondo rosa más claro */
    }

    .welcome-section h2 {
        color: #000; /* Texto negro */
        font-size: 28px;
    }

    a {
        text-decoration: none;
        background-color: #ff69b4;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        font-weight: bold;
        text-transform: uppercase;
    }

    table {
        width: 80%;
        margin: 20px auto;
        border-collapse: collapse;
    }

    th, td {
        border: 1px solid #000; /* Borde negro */
        padding: 10px;
    }

    th {
        background-color: #ff69b4; /* Color rosa */
        color: #fff;
    }

    tr:nth-child(even) {
        background-color: #fff; /* Fondo blanco para filas pares */
    }

    tr:nth-child(odd) {
        background-color: #f0f0f0; /* Fondo gris claro para filas impares */
    }
</style>
</head>
<body>
    <h1>CARRITO DE COMPRAS</h1>
    <table border="1">
        <tr>
            <th>Id_carrito</th>
            <th>Fecha</th>
            <th>Cantidad</th>
            <th>Total</th>
            <th>Id_producto</th>
            <th>Id_cliente</th>
        </tr>';


// Agregar los datos de la consulta al HTML del PDF
while ($row = oci_fetch_array($statement, OCI_ASSOC + OCI_RETURN_NULLS)) {
    $html .= '<tr>';
    $html .= '<td>' . ($row["ID_CARRITO"] !== null ? htmlentities($row["ID_CARRITO"], ENT_QUOTES) : "&nbsp;") . '</td>';
    $html .= '<td>' . ($row["FECHA"] !== null ? htmlentities($row["FECHA"], ENT_QUOTES) : "&nbsp; ") . '</td>';
    $html .= '<td>' . ($row["CANTIDAD"] !== null ? htmlentities($row["CANTIDAD"], ENT_QUOTES) : "&nbsp; ") . '</td>';
    $html .= '<td>' . ($row["TOTAL"] !== null ? htmlentities($row["TOTAL"], ENT_QUOTES) : " &nbsp;") . '</td>';
    $html .= '<td>' . ($row["ID_PRODUCTO"] !== null ? htmlentities($row["ID_PRODUCTO"], ENT_QUOTES) : "&nbsp; ") . '</td>';
    $html .= '<td>' . ($row["ID_CLIENTE"] !== null ? htmlentities($row["ID_CLIENTE"], ENT_QUOTES) : "&nbsp; ") . '</td>';
    $html .= '</tr>';
}

$html .= '
    </table>
</body>
</html>';

// Escribir el contenido HTML en el PDF
$pdf->writeHTML($html);

// Salida del PDF (descarga o visualización)
$pdf->Output('carrito_de_compras.pdf', 'D'); // 'D' descarga el PDF, 'I' lo muestra en el navegador

// No se necesita más salida HTML aquí ya que se está generando un PDF
?>
