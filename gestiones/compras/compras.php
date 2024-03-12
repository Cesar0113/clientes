<?php
session_start();
include '../../conexion.php';

// Asegúrate de incluir la librería de PHPMailer
require '../../PHPMailer/src/PHPMailer.php';
require '../../PHPMailer/src/Exception.php';
require '../../PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../inicio.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Procesar la compra
    if (isset($_POST['btnRealizarCompra'])) {
        $idProducto = $_POST['idProducto'] ?? null;
        $idCliente = $_POST['idCliente'] ?? null;
        $cantidad = $_POST['cantidad'] ?? 1; // Valor predeterminado a 1 si no se proporciona la cantidad
        $tipoPago = $_POST['tipoPago'] ?? null; // Nuevo campo tipoPago

        if ($idProducto && $idCliente && $tipoPago !== null) {
            // Obtener información del producto seleccionado
            $infoProducto = mysqli_query($conn, "SELECT * FROM tblproducto WHERE idProducto = $idProducto");
            $infoProducto = mysqli_fetch_assoc($infoProducto);

            // Calcular el precio total de la compra
            $precioTotal = $infoProducto['precio'] * $cantidad;

            // Insertar la compra en la base de datos
            $insertarCompra = mysqli_query($conn, "INSERT INTO tblcompra (idProducto, idCliente, cantidad, precio, tipoPago) VALUES ('$idProducto', '$idCliente', '$cantidad', '$precioTotal', '$tipoPago')");

            if ($insertarCompra) {
                // Éxito: Compra realizada con éxito.
            
                // Enviar correo electrónico con PHPMailer
                enviarCorreoCompra($idProducto, $idCliente, $cantidad, $precioTotal, $tipoPago);
            // Mostrar mensaje
       // Redirigir al usuario a la página de productos después de unos segundos
                 header("Refresh: 15; URL=../productos/productos.php");
            } else {
                // Error: Imprime el mensaje de error.
                echo '<div class="alert alert-error">Error al realizar la compra: ' . mysqli_error($conn) . '</div>';
            }
            
        } else {
            echo "Datos incompletos para realizar la compra.";
        }
        
    }
}

// Obtener la lista de productos disponibles
$productos = mysqli_query($conn, "SELECT * FROM tblproducto");

// Obtener la lista de clientes
$clientes = mysqli_query($conn, "SELECT * FROM tblcliente");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Compras</title>
    <!-- Agrega tus estilos CSS aquí -->
    <link rel="stylesheet" type="text/css" href="../../css/compras.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">

</head>
<body>
<div class="container">

<h1 class="titulo">Realizar Compra</h1>

<form action="compras.php" method="POST">
    <label for="idProducto">Producto Comprado:</label>
    <?php
    if (isset($_GET['idProducto'])) {
        $idProductoComprado = $_GET['idProducto'];
        $productoComprado = mysqli_query($conn, "SELECT nombre, imagen FROM tblproducto WHERE idProducto = $idProductoComprado");
        $productoComprado = mysqli_fetch_assoc($productoComprado);
        ?>
        <p><?php echo $productoComprado['nombre']; ?></p>
        <img src="../productos/<?php echo $productoComprado['imagen']; ?>" alt="Vista Previa">
        <!-- También puedes agregar estilos CSS para ajustar el tamaño y diseño de la imagen -->
        <input type="hidden" name="idProducto" value="<?php echo $idProductoComprado; ?>">
    <?php } else { ?>
        <p>No se ha seleccionado un producto para comprar.</p>
    <?php } ?>

    <label for="idCliente">Seleccionar Cliente:</label>
    <select name="idCliente" required>
        <?php while ($cliente = mysqli_fetch_assoc($clientes)) { ?>
            <option value="<?php echo $cliente['idCliente']; ?>"><?php echo $cliente['nombre1'] . ' ' . $cliente['apellido1']; ?></option>
        <?php } ?>
    </select>

    <label for="cantidad">Cantidad:</label>
    <input type="number" name="cantidad" value="1" min="1" required>

    <label for="tipoPago">Tipo de Pago:</label>
    <select name="tipoPago" required>
        <option value="efectivo">Efectivo</option>
        <option value="tarjeta">Tarjeta</option>
    </select>
    <a href="../productos/productos.php" class="btn-atras"><i class="fas fa-arrow-left"></i>Cancelar Compra</a>
    <button type="submit" name="btnRealizarCompra">Realizar Compra</button>
    <?php
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                // ... Lógica de procesamiento y alertas ...
                echo '<div class="alert alert-success">Compra realizada con éxito. Mira tu correo!!</div>';
            }
        ?>

</form>

   </div>
</body>
</html>

<?php
function enviarCorreoCompra($idProducto, $idCliente, $cantidad, $precioTotal, $tipoPago) {
    global $conn;

    // Obtener información del producto
    $infoProducto = mysqli_query($conn, "SELECT * FROM tblproducto WHERE idProducto = $idProducto");
    $infoProducto = mysqli_fetch_assoc($infoProducto);

    // Obtener información del cliente
    $infoCliente = mysqli_query($conn, "SELECT * FROM tblcliente WHERE idCliente = $idCliente");
    $infoCliente = mysqli_fetch_assoc($infoCliente);

    // Crear instancia de PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Configurar el servidor SMTP
        $mail = new PHPMailer(true);
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'richardzambrano403@gmail.com';
        $mail->Password = 'gflvgmnuflvjftwv';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Resto del código para enviar el correo
        $mail->setFrom('richardzambrano403@gmail.com', 'Mascotas & Alimentación');
        $mail->addAddress($infoCliente['email'], $infoCliente['nombre1'] . ' ' . $infoCliente['apellido1']); // Correo y nombre del cliente
     
        // Contenido del correo
        $mail->isHTML(true);
        $mail->Subject = 'Detalle de Compra';


        $imagenPath = "../productos/" . $infoProducto['imagen'];
$imagenBase64 = base64_encode(file_get_contents($imagenPath));

$imagenMimeType = mime_content_type($imagenPath);
$imagenBase64 = "data:{$imagenMimeType};base64,{$imagenBase64}";
$mail->Body = "
    <h2>Detalle de la Compra</h2>
    <p><strong>Producto:</strong> {$infoProducto['nombre']}</p>
    <p><strong>Cliente:</strong> {$infoCliente['nombre1']} {$infoCliente['apellido1']}</p>
    <p><strong>Cantidad:</strong> $cantidad</p>
    <p><strong>Precio Total:</strong> $$precioTotal</p>
    <p><strong>Tipo de Pago:</strong> $tipoPago</p>
    <img src='{$imagenBase64}' alt='Vista Previa' style='max-width: 100px;'>
";
        // Enviar correo
        $mail->send();
        // Generar y descargar el PDF
        generarPDF($infoProducto, $infoCliente, $cantidad, $precioTotal, $tipoPago);

    } catch (Exception $e) {
        echo "Error al enviar el correo: {$mail->ErrorInfo}";
    }
}
function generarPDF($infoProducto, $infoCliente, $cantidad, $precioTotal, $tipoPago) {
    require_once('../../tcpdf/tcpdf.php');

    // Crear nuevo documento PDF
    $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

    // Establecer información del documento
    $pdf->SetCreator(PDF_CREATOR);
    $pdf->SetAuthor('Mascotas & Alimentación');
    $pdf->SetTitle('Detalle de Compra');
    $pdf->SetSubject('Detalle de Compra');
    $pdf->SetKeywords('Compra, Producto, Cliente');

    // Agregar una página
    $pdf->AddPage();

    // Establecer el título
    $pdf->SetFont('helvetica', 'B', 20);
    $pdf->Cell(0, 10, 'Mascotas & Alimentos', 0, 1, 'C');
    $pdf->Ln(10);

    // Agregar la imagen del producto
    $imagenPath = "../productos/" . $infoProducto['imagen'];
    $pdf->Image($imagenPath, 50, 30, 50, 50, 'JPEG', '', 'T', false, 300, '', false, false, 0, false, false, false);

    // Crear el contenido del PDF
    $html = "
        <h2>Detalle de la Compra</h2>
        <p><strong>Producto:</strong> {$infoProducto['nombre']}</p>
        <p><strong>Cliente:</strong> {$infoCliente['nombre1']} {$infoCliente['apellido1']}</p>
        <p><strong>Cantidad:</strong> $cantidad</p>
        <p><strong>Precio Total:</strong> $$precioTotal</p>
        <p><strong>Tipo de Pago:</strong> $tipoPago</p>
    ";

    // Agregar el contenido al PDF
    $pdf->SetFont('helvetica', '', 12);
    $pdf->writeHTMLCell(0, 0, '', '', $html, 0, 1, 0, true, '', true);

    // Establecer el borde del contenido
    $pdf->lastPage();
    $pdf->Rect(10, 10, 190, 260);
    // Finalizar el documento y generar el PDF
    $pdf->Output(__DIR__ . 'detalle_compra.pdf', 'D');

    // Enviar el PDF al navegador para su descarg
}   

// Script JavaScript para descargar el PDF después de unos segundos

?>
