<?php
include '../../conexion.php';

if (isset($_GET['id'])) {
    $idProducto = $_GET['id'];

    // Realizar la consulta para obtener los datos del producto con el id proporcionado
    $resultado = mysqli_query($conn, "SELECT * FROM tblproducto WHERE idProducto = $idProducto");

    if ($resultado) {
        $producto = mysqli_fetch_assoc($resultado);

        // Devolver los datos del producto en formato JSON
        echo json_encode($producto);
    } else {
        echo "Error al obtener los datos del producto: " . mysqli_error($conn);
    }
} else {
    echo "ID de producto no proporcionado.";
}
?>
