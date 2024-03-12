<?php
session_start();
include '../../conexion.php';

error_reporting(E_ERROR | E_PARSE | E_NOTICE);

if (!isset($_SESSION['usuario'])) {
    header("Location: ../../inicio.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Productos para Mascotas</title>
    <link rel="stylesheet" type="text/css" href="../../css/productos.css">
    <link rel="stylesheet" type="text/css" href="../../css/dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>
<div class="navbar">
       <div class="logo">
            <h1><i class="fas fa-dog"></i>M&A</h1>
        </div>
    <a href="../clientes/clientes.php"><i class="fas fa-user"></i> Clientes</a>
    <a href="../mascotas/mascotas.php"><i class="fas fa-dog"></i> Mascotas</a>
    <a href="#"><i class="fas fa-box-open"></i> Productos</a>
    <a class="logout" href="../../dashboard.php"><i class="fas fa-sign-out-alt"></i>Atras</a>
</div>
    <header>
        <h1>Productos para Mascotas</h1>
    </header>
 
    <div class="container">
    <?php
    $productos = mysqli_query($conn, "SELECT * FROM tblproducto");
    while ($producto = mysqli_fetch_array($productos)) {
        ?>
        <div class="producto">
            <input type="checkbox" class="chk-producto" data-id="<?php echo $producto['idProducto']; ?>" data-nombre="<?php echo $producto['nombre']; ?>" data-precio="<?php echo $producto['precio']; ?>" data-descripcion="<?php echo $producto['descripcion']; ?>">
            <img src="<?php echo $producto['imagen']; ?>" alt="<?php echo $producto['nombre']; ?>">
            <h2><?php echo $producto['nombre']; ?></h2>
            <p>Precio: $<?php echo $producto['precio']; ?></p>
            <button class="btn-comprar" data-id="<?php echo $producto['idProducto']; ?>" onclick="redirectToCompras(<?php echo $producto['idProducto']; ?>)">Comprar</button>
        </div>
    <?php }
    ?>
</div>
    <div class="acciones-producto">
    <button class="btn-agregar" onclick="document.getElementById('agregarProductoModal').style.display='block'"> <i class="fas fa-plus"></i> Agregar Producto</button>
    <button type="button" id="btn-editar" disabled onclick="editarProducto('editarProductoModal')"><i class="fas fa-edit"></i> Editar</button>
<button type="button" id="btn-eliminar" disabled onclick="eliminarProducto()"><i class="fas fa-trash"></i> Eliminar</button>
    </div>
    
    <div class="agregar-producto-modal" id="agregarProductoModal">
        <div class="modal-content">
            <span class="close" onclick="document.getElementById('agregarProductoModal').style.display='none'">&times;</span>
            <h2>Agregar Producto</h2>
            <form action="accionesProducto.php" method="POST" enctype="multipart/form-data">
                 <input type="text" placeholder="Nombre del Producto" name="nombreProducto" required>
                <input type="number" placeholder="Precio" name="precioProducto" required>
                <textarea placeholder="Descripción" name="descripcionProducto" required></textarea>
                <input type="file" name="imgProducto" required>
                <button type="submit" name="btnAgregarProducto"><i class="fas fa-plus"></i> Agregar </button>
            </form>
        </div>
    </div>

    <div class="editar-producto-modal" id="editarProductoModal">
    <div class="modal-content">
        <span class="close" onclick="cerrarFormularioEditar()">&times;</span>
        <h2>Editar Producto</h2>
        <form action="accionesProducto.php" method="POST" enctype="multipart/form-data">
            <input type="hidden" id="idProductoEditar" name="idProductoEditar">
            <input type="text" placeholder="Nombre del Producto" name="nombreProducto" required>
            <input type="number" placeholder="Precio" name="precioProducto" required>
            <textarea placeholder="Descripción" name="descripcionProducto" required></textarea>
            <input type="file" name="imgProducto" required>
            <button type="submit" name="btnEditarProducto" id="btnEditarProducto" style="display: none;"><i class="fas fa-pencil-alt"></i>Guardar</button>
        </form>
    </div>
    </div>
  

    <script type="text/javascript" src='productos.js'></script>
</body>
</html>

<script>
    function redirectToCompras(idProducto) {
        // Redireccionar a la página de compras con el ID del producto seleccionado
        window.location.href = "../compras/compras.php?idProducto=" + idProducto;
    }
</script>

