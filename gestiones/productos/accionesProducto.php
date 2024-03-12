<?php
session_start();
include '../../conexion.php';

error_reporting(E_ERROR | E_PARSE | E_NOTICE);

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../inicio.php");
}

if (isset($_POST['btnAgregarProducto'])) {
    $nombreProducto = $_POST['nombreProducto'] ?? null;
    $precioProducto = $_POST['precioProducto'] ?? null;
    $descripcionProducto = $_POST['descripcionProducto'] ?? null;

    $imagenProducto = $_FILES['imgProducto'];
    $nombreImagen = $imagenProducto['name'];
    $tipoImagen = $imagenProducto['type'];
    $tamanioImagen = $imagenProducto['size'];
    $rutaImagen = "./imgProductos" . $nombreImagen;

    $formatosPermitidos = array("jpg", "jpeg", "png", "gif");
    $formatoImagen = strtolower(pathinfo($rutaImagen, PATHINFO_EXTENSION));

    if (in_array($formatoImagen, $formatosPermitidos)) {
        if (move_uploaded_file($imagenProducto['tmp_name'], $rutaImagen)) {
            $insertarProducto = mysqli_query($conn, "INSERT INTO tblproducto (nombre, precio, descripcion, imagen) VALUES ('$nombreProducto', '$precioProducto', '$descripcionProducto', '$rutaImagen')");

            if ($insertarProducto) {
                $idProductoInsertado = mysqli_insert_id($conn);
                echo "success|Producto agregado correctamente. ID del nuevo producto: " . $idProductoInsertado;
            } else {
                echo "error|Error al agregar el producto: " . mysqli_error($conn);
            }
        } else {
            echo "error|Error al subir la imagen.";
        }
    } else {
        echo "error|Formato de imagen no válido. Por favor, elige una imagen en formato JPG, JPEG, PNG o GIF.";
    }
} elseif (isset($_POST['btnEditarProducto']) && isset($_POST['idProductoEditar'])) {
    $idProducto = $_POST['idProductoEditar'] ?? null;
    $nombreProducto = $_POST['nombreProducto'] ?? null;
    $precioProducto = $_POST['precioProducto'] ?? null;
    $descripcionProducto = $_POST['descripcionProducto'] ?? null;

    $imagenProducto = $_FILES['imgProducto'];
    $nombreImagen = $imagenProducto['name'];
    $tipoImagen = $imagenProducto['type'];
    $tamanioImagen = $imagenProducto['size'];
    $rutaImagen = "./imgProductos" . $nombreImagen;

    $formatosPermitidos = array("jpg", "jpeg", "png", "gif");
    $formatoImagen = strtolower(pathinfo($rutaImagen, PATHINFO_EXTENSION));

    if (in_array($formatoImagen, $formatosPermitidos)) {
        if (move_uploaded_file($imagenProducto['tmp_name'], $rutaImagen)) {
            if ($idProducto) {
                $actualizarProducto = mysqli_query($conn, "UPDATE tblproducto SET nombre = '$nombreProducto', precio = '$precioProducto', descripcion = '$descripcionProducto', imagen = '$rutaImagen' WHERE idProducto = $idProducto");

                if ($actualizarProducto) {
                    echo "success|Producto actualizado correctamente.";
                } else {
                    echo "error|Error al actualizar el producto: " . mysqli_error($conn);
                }
            } else {
                $insertarProducto = mysqli_query($conn, "INSERT INTO tblproducto (nombre, precio, descripcion, imagen) VALUES ('$nombreProducto', '$precioProducto', '$descripcionProducto', '$rutaImagen')");

                if ($insertarProducto) {
                    $idProductoInsertado = mysqli_insert_id($conn);
                    echo "success|Producto agregado correctamente. ID del nuevo producto: " . $idProductoInsertado;
                } else {
                    echo "error|Error al agregar el producto: " . mysqli_error($conn);
                }
            }
        } else {
            echo "error|Error al subir la imagen.";
        }
    } else {
        echo "error|Formato de imagen no válido. Por favor, elige una imagen en formato JPG, JPEG, PNG o GIF.";
    }
} elseif (isset($_POST['btnEliminarProducto'])) {
    $idProducto = $_POST['idProducto'] ?? null;

    $eliminarProducto = mysqli_query($conn, "DELETE FROM tblproducto WHERE idProducto = $idProducto");

    if ($eliminarProducto) {
        echo "success|Producto eliminado correctamente.";
    } else {
        echo "error|Error al eliminar el producto: " . mysqli_error($conn);
    }
}
?>
